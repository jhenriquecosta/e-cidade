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
 * Modelo responsável pela consulta da situação do lote Rps
 * @author Everton Catto Heckler <everton.heckler@dbseller.com.br>
 */
class WebService_Model_ConsultarSituacaoLoteRps {

  /**
   * Erros padroes da Abrasf V1
   * @var array
   */
  private $aErrosManual = array();

  /**
   * Lista de inconsistencias na requisicao
   * @var array
   */
  protected $aInconsistencias = array();

  /**
   * Construtor da classe
   */
  public function __construct() {
    $this->aErrosManual = Administrativo_Model_ImportacaoRpsErros::getMensagensPorModelo(1);
  }

  private function validaXML($sXml) {

    try {

      $sNomeTempArquivo = TEMP_PATH . "/ConsultarSituacaoLoteRps-".time().".xml";

      /* gravo o xml enviado */
      $fp = fopen($sNomeTempArquivo, "w");
      fwrite($fp, $sXml);
      fclose($fp);

      /* carrega o arquivo em memoria para manipulação */
      $oXml = simplexml_load_file($sNomeTempArquivo);

      if(empty($oXml->ConsultarSituacaoLoteRpsEnvio)
      or empty($oXml->ConsultarSituacaoLoteRpsEnvio->Prestador)
      or empty($oXml->ConsultarSituacaoLoteRpsEnvio->Prestador->Cnpj)
      or empty($oXml->ConsultarSituacaoLoteRpsEnvio->Protocolo)
      ) {
        $this->adicionarInconsistencia('E160');

        return false;
      }

      return $oXml;
    } catch (Exception $oErro) {
      return $oErro->getMessage();
    }
  }

  /**
   * Processa o arquivo Webservice
   */
  public function consultaDados($oParametros) {

    try {

      $oRetorno              = new StdClass();
      $oRetorno->iNumeroLote = '';
      $oRetorno->iSituacao   = 1;

      $oXml = $this->validaXML($oParametros);

      if (!$oXml) {
        return $this->processaRetornoWebService($oRetorno);
      }

      $oParametrosArquivo = $oXml->ConsultarSituacaoLoteRpsEnvio;

      if (!$this->validarRequisicao($oParametrosArquivo)) {
        return $this->processaRetornoWebService($oRetorno);
      }

      /**
       * Busca usuário contribuinte pelo cnpj_cpf
       */
      $oUsuarioContribuinte = Administrativo_Model_UsuarioContribuinte::getByAttribute('cnpj_cpf', $oParametrosArquivo->Prestador->Cnpj);
      if (empty($oUsuarioContribuinte)) {

        $this->adicionarInconsistencia('E45');
        return $this->processaRetornoWebService($oRetorno);
      }

      $oProtocolo = Administrativo_Model_Protocolo::getByAttribute('protocolo', $oParametrosArquivo->Protocolo);
      if (!$oProtocolo) {

        // situação de não recebido
        $oRetorno->iNumeroLote = $oParametrosArquivo->Protocolo;
        $oRetorno->iSituacao   = 1;
        return $this->processaRetornoWebService($oRetorno);
      }

      $oProtocoloImportacao = Contribuinte_Model_ProtocoloImportacao::getByAttribute('protocolo', $oProtocolo->getId());

      if (!$oProtocoloImportacao->getImportacao()) {

        // situação de recebido mas processado com erro
        $oRetorno->iNumeroLote = $oProtocoloImportacao->getNumeroLote();
        $oRetorno->iSituacao   = 3;
        return $this->processaRetornoWebService($oRetorno);
      }

      // situação de recebido e processado com sucesso
      $oRetorno->iNumeroLote = $oProtocoloImportacao->getNumeroLote();
      $oRetorno->iSituacao   = 4;
      return $this->processaRetornoWebService($oRetorno);

    } catch (Exception $oErro) {
      return $oErro->getMessage();
    }
  }


  /**
   * Prepara o Retorno de Sucesso do processamento no WebService
   *
   * @param stdClass $oDadosConsulta
   * @return string
   */
  public function processaRetornoWebService(stdClass $oDadosConsulta) {

    $oXml = new DOMDocument("1.0", "UTF-8");
    $oXmlConsultarSituacaoLoteRps = $oXml->createElement("ii:ConsultarSituacaoLoteRpsResposta");
    $oXmlConsultarSituacaoLoteRps->setAttribute("xmlns:ii", "urn:DBSeller");

    $oXmlNumeroLote           = $oXml->createElement("ii:NumeroLote", $oDadosConsulta->iNumeroLote);
    $oXmlSituacao             = $oXml->createElement("ii:Situacao"  , $oDadosConsulta->iSituacao);
    $oXmlListaMensagemRetorno = $oXml->createElement("ii:ListaMensagemRetorno");

    foreach ($this->aInconsistencias as $sInconsistencia) {

      $oMensagemErro  = $oXml->createElement("ii:MensagemRetorno");
      $oCodigo   = $oXml->createElement("ii:Codigo", $sInconsistencia);
      $oMensagem = $oXml->createElement("ii:Mensagem", $this->aErrosManual[$sInconsistencia]->sMensagem);
      $oCorrecao = $oXml->createElement("ii:Correcao", $this->aErrosManual[$sInconsistencia]->sSolucao);
      $oMensagemErro->appendChild($oCodigo);
      $oMensagemErro->appendChild($oMensagem);
      $oMensagemErro->appendChild($oCorrecao);
      $oXmlListaMensagemRetorno->appendChild($oMensagemErro);
    }
    $oXmlConsultarSituacaoLoteRps->appendChild($oXmlNumeroLote);
    $oXmlConsultarSituacaoLoteRps->appendChild($oXmlSituacao);
    $oXmlConsultarSituacaoLoteRps->appendChild($oXmlListaMensagemRetorno);
    $oXml->appendChild($oXmlConsultarSituacaoLoteRps);

    return $oXml->saveXML();
  }


  /**
   * Adiciona um erro/inconsistencia no processamento da requisicao
   * @param $sCodigoErro codigo do erro
   */
  protected function adicionarInconsistencia($sCodigoErro) {

    $this->aInconsistencias[] = $sCodigoErro;
  }

  protected function validarRequisicao($oRequisicao) {

    $lRequisicaoValida = true;
    if (empty($oRequisicao->Protocolo)) {

      $this->adicionarInconsistencia('E88');
      $lRequisicaoValida = false;
    }

    /**
     * Validamos o CNPJ, caso seja vazio, abortamos a requisicao
     */
    if (empty($oRequisicao->Prestador->Cnpj)) {

      $this->adicionarInconsistencia('E46');
      return false;
    }
    return $lRequisicaoValida;
  }


  /**
   * @param $iCodigoImportacao codigo da importacao
   */
  protected function getNotasImportadasLote($iCodigoImportacao) {

  }
}
