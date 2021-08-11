<?php

/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

/**
 * Modelo responsável pelo cancelamento das notas
 * @author Luiz Marcelo Schmitt <luiz.marcelo@dbseller.com.br>
 */
class WebService_Model_CancelarNfse {

  /**
   * Dados do contribuinte
   * @var Object
   */
  private $oContribuinte;

  /**
   * Dados da nota
   * @var Object
   */
  private $oNota;

  /**
   * Dados do XML passado para o webservice
   * @var array
   */
  private $oDadosXML = NULL;

  /**
   * Erros padroes da Abrasf V1
   * @var array
   */
  private $aErrosManual = array();

  /**
   * Erros encontrados
   * @var array
   */
  protected $aInconsistencias = array();

  protected $sLogin = NULL;

  /**
   * Dados do usuario do contribuinte
   * @var Object
   */
  private $oUsuario;

  public function __construct() {
    $this->aErrosManual = Administrativo_Model_ImportacaoRpsErros::getMensagensPorModelo(1);
  }

  /**
   * Valida a estrutura do XML informado
   * @param $sXml
   * @return mixed
   */
  private function validaXML($sXml) {


    $sNomeTempArquivo = TEMP_PATH . "/CancelarNfse-".time().".xml";

    /* gravo o xml enviado */
    $fp = fopen($sNomeTempArquivo, "w");
    fwrite($fp, $sXml);
    fclose($fp);

    $oXml               = simplexml_load_string($sXml);
    $oIdentificacaoNfse = NULL;

    /**
     * Verifica estrutura padrão do XML de envio
     */


    if (empty($oXml->CancelarNfseEnvio)
      || empty($oXml->CancelarNfseEnvio->Pedido)) {

      $this->adicionarInconsistencia('E160');
    } else {

      $oPedido            = $oXml->CancelarNfseEnvio->Pedido;
      $oIdentificacaoNfse = $oPedido->InfPedidoCancelamento;
      $oAssinatura        = $oPedido->Signature;

      /**
       * Verifica a tag do número da nota
       */
      if (empty($oIdentificacaoNfse->IdentificacaoNfse->Numero)) {
        $this->adicionarInconsistencia('E77');
      } else if(strlen($oIdentificacaoNfse->IdentificacaoNfse->Numero) != 15) {
        $this->adicionarInconsistencia('E160');
      }

      /**
       * Verifica a tag do CNPJ
       */
      if (empty($oIdentificacaoNfse->IdentificacaoNfse->Cnpj)) {
        $this->adicionarInconsistencia('E46');
      }

      /**
       * Verifica a tag da inscricao municipal
       */
      if (empty($oIdentificacaoNfse->IdentificacaoNfse->InscricaoMunicipal)) {
        $this->adicionarInconsistencia('E40');
      }

      /**
       * Verifica a tag do código municipal
       */
      if (empty($oIdentificacaoNfse->IdentificacaoNfse->CodigoMunicipio)) {
        $this->adicionarInconsistencia('E64');
      }

      /**
       * Verifica a tag do motido de cancelamento
       */
      if (empty($oIdentificacaoNfse->CodigoCancelamento)) {
        $this->adicionarInconsistencia('E160');
      }

      /**
       * Validação digital do arquivo
       */
      if (!empty($oAssinatura)) {

        $oValidacao = new DBSeller_Helper_Xml_AssinaturaDigital($sXml);

        if (!$oValidacao->validar()) {
          $this->adicionarInconsistencia('E1');
        }
      }
    }

    return $oIdentificacaoNfse;
  }

  /**
   * Adiciona um erro a lista de inconsistencias
   * @param $sCodigoErro
   */
  protected function adicionarInconsistencia($sCodigoErro) {

    $this->aInconsistencias[] = $sCodigoErro;
  }

  /**
   * Prepara os dados para o cancelamento da nota
   * @param string $sParametroArquivo
   */
  public function preparaDados($sParametroArquivo) {

    $this->oDadosXML = $this->validaXML($sParametroArquivo);

    /**
     * Verifica se existe inconsistencias
     */
    if (count($this->aInconsistencias) == 0) {

      $sCnpj               = (string) $this->oDadosXML->IdentificacaoNfse->Cnpj;
      $sNumero             = (string) $this->oDadosXML->IdentificacaoNfse->Numero;
      $iInscricaoMunicipal = (string) $this->oDadosXML->IdentificacaoNfse->InscricaoMunicipal;
      $iNumero             = (int) substr($sNumero,4, 11);

      $aAtributosContriobuinte = array(
        "cnpj_cpf" => $sCnpj,
        "im"       => $iInscricaoMunicipal
      );



      $sAmbiente = Zend_Controller_Front::getInstance()->getRequest()->getActionName();

      if (DBSeller_Plugin_Auth::checkPermissionWebservice($sCnpj, "webservice/{$sAmbiente}/recepcionar-lote-rps")) {

        //Obtem todos os UsuariosContribuintes do CNPJ
        $oEm = Zend_Registry::get('em');
        $oQueryBuilder = $oEm->createQueryBuilder();
        $oQueryBuilder->select('e');
        $oQueryBuilder->from('Administrativo\UsuarioContribuinte', 'e');
        $oQueryBuilder->where("e.cnpj_cpf = '{$aAtributosContriobuinte['cnpj_cpf']}'");
        $oQueryBuilder->andWhere("e.im = '{$aAtributosContriobuinte['im']}'");
        $aResultado = $oQueryBuilder->getQuery()->getResult();

		// Obtem o Usuario Principal do contribuinte
        $oContribuinte = new Administrativo_Model_UsuarioContribuinte();
        $this->oUsuario = $oContribuinte->getUsuarioPrincipal($sCnpj);

        foreach ($aResultado as $oContribuinte) {
          $aIdContribuinte[] = $oContribuinte->getId();
        }

        /**
         * Verifica se existe contribuinte com o CNPJ e Inscrição Municipal informado
         */
        if (empty($aIdContribuinte)) {

          $this->adicionarInconsistencia('E44');
          $this->adicionarInconsistencia('E50');
        } else {

          $aAtributosNota  = array(
            "id_contribuinte" => $aIdContribuinte,
            "nota"            => $iNumero
          );

          /**
           * Retornar a entidade do array de notas
           */
          $aNotas = Contribuinte_Model_Nota::getByAttributes($aAtributosNota);
          foreach ($aNotas as $oNota) {
            $this->oNota = $oNota;
          }

          /**
           * Verifica se existe nota
           */
          if (empty($this->oNota)) {
            $this->adicionarInconsistencia('E78');
          } else {

            $bNotaCancelada = $this->oNota->getCancelada();
            /**
             * Verifica se a nota já está cancelada
             */
            if ($bNotaCancelada) {
              $this->adicionarInconsistencia('E79');
            }
          }
        }
      } else {

        $this->adicionarInconsistencia('E157');
        $this->adicionarInconsistencia('Usuário sem permissão!');
      }
    }
  }

  /**
   * Cancela a nota
   * @return string
   */
  public function processar() {

    try {

      /**
       * Cancela uma nota caso não tiver inconsistencias no processo
       */
      if (count($this->aInconsistencias) == 0) {

        $oDataCancelamento   = new DateTime;
        $iCodigoCancelamento = (int) $this->oDadosXML->CodigoCancelamento;

        /**
         * Verifica justificativa do cancelamento
         */
        switch ($iCodigoCancelamento) {

          case Contribuinte_Model_CancelamentoNota::CANCELAMENTO_ERRO_EMISSAO :

            $sJustificativa = "Cancelado via WebService. Motivo: Erro na emissão.";
            break;

          case Contribuinte_Model_CancelamentoNota::CANCELAMENTO_NOTA_DUPLICADA :

            $sJustificativa = "Cancelado via WebService. Motivo: Duplicidade da nota.";
            break;

          case Contribuinte_Model_CancelamentoNota::CANCELAMENTO_SERVICO_NAO_PRESTADO :

            $sJustificativa = "Cancelado via WebService. Motivo: Serviço não prestado.";
            break;

          default :

            $sJustificativa      = "Cancelado via WebService. Motivo: Outros.";
            $iCodigoCancelamento = 9;
            break;
        }

        $oCancelamentoNota = new Contribuinte_Model_CancelamentoNota();
        $oCancelamentoNota->setUsuarioCancelamento($this->oUsuario);
        $oCancelamentoNota->setNotaCancelada($this->oNota);
        $oCancelamentoNota->setJustificativa($sJustificativa);
        $oCancelamentoNota->setMotivoCancelmento($iCodigoCancelamento);
        $oCancelamentoNota->setDataHora($oDataCancelamento);
        $oCancelamentoNota->salvar();
      }
    } catch(Exception $e){
      $this->adicionarInconsistencia('E160');
    }

    return $this->retornoWebservice();
  }

  /**
   * Retorno XML do webservice
   * @return string
   */
  private function retornoWebservice() {

    $oXml                     = new DOMDocument("1.0", "UTF-8");
    $oXmlCancelarNfseResposta = $oXml->createElement("ii:CancelarNfseResposta");
    $oXmlCancelarNfseResposta->setAttribute("xmlns:ii", "urn:DBSeller");

    /**
     * Verifica se encontrou erros
     */
    if (count($this->aInconsistencias) == 0) {

      $oNotaAbrasf    = new WebService_Model_NotaAbrasf($this->oNota);
      $oXmlNotaAbrasf = $oNotaAbrasf->getCancelamento('Cancelamento');

      $oXmlCancelarNfseResposta->appendChild($oXml->importNode($oXmlNotaAbrasf, true));
    } else {

      /**
       * Lista de Mensagens
       */
      $ListaMensagemRetorno = $oXml->createElement("ii:ListaMensagemRetorno");

      foreach($this->aInconsistencias as $iCodErro) {

        $MensagemRetorno = $oXml->createElement("ii:MensagemRetorno");

        $Codigo   = $oXml->createElement("ii:Codigo", $iCodErro);
        $Mensagem = $oXml->createElement("ii:Mensagem", $this->aErrosManual[$iCodErro]->sMensagem);
        $Correcao = $oXml->createElement("ii:Correcao", $this->aErrosManual[$iCodErro]->sSolucao);

        $MensagemRetorno->appendChild($Codigo);
        $MensagemRetorno->appendChild($Mensagem);
        $MensagemRetorno->appendChild($Correcao);

        $ListaMensagemRetorno->appendChild($MensagemRetorno);
      }

      $oXmlCancelarNfseResposta->appendChild($ListaMensagemRetorno);
    }

    $oXml->appendChild($oXmlCancelarNfseResposta);

    return $oXml->saveXML();
  }
}