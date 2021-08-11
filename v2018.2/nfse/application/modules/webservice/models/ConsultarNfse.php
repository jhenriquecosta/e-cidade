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
 * Modelo responsável pela consulta das notas
 * @author Luiz Marcelo Schmitt <luiz.marcelo@dbseller.com.br>
 */
class WebService_Model_ConsultarNfse {

  /**
   * Dados da nota
   * @var array
   */
  private $aNotas;

  /**
   * Array de filtros para consulta em banco
   * @var array
   */
  private $aFiltrosConsulta = NULL;

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

  public function __construct() {
    $this->aErrosManual = Administrativo_Model_ImportacaoRpsErros::getMensagensPorModelo(1);
  }

  /**
   * Valida a estrutura do XML informado
   * @param $sXml
   * @return mixed
   */
  private function validaXML($sXml) {

    $oXml = simplexml_load_string($sXml);

    /**
     * Verifica estrutura padrão do XML de envio
     */
    if (empty($oXml->ConsultarNfseEnvio)
     || empty($oXml->ConsultarNfseEnvio->Prestador)) {

      $this->adicionarInconsistencia('E160');
    } else {

      $oConsultarNfseEnvio = $oXml->ConsultarNfseEnvio;
      $oPeriodoEmissao     = $oConsultarNfseEnvio->PeriodoEmissao;

      /**
       * Verifica o periodo
       */
      if (!empty($oPeriodoEmissao) && (empty($oPeriodoEmissao->DataInicial) || empty($oPeriodoEmissao->DataInicial))) {
        $this->adicionarInconsistencia('E160');
      }

      /**
       * Verifica a tag do número da nota
       */
      if (!empty($oConsultarNfseEnvio->NumeroNfse)) {

        if (strlen($oConsultarNfseEnvio->NumeroNfse) != 15) {
          $this->adicionarInconsistencia('E160');
        }
      }
    }

    return $oXml;
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

    $oDadosXml = $this->validaXML($sParametroArquivo);

    /**
     * Verifica se existe inconsistencias
     */
    if (count($this->aInconsistencias) == 0) {

      $oConsultarNfseEnvio    = $oDadosXml->ConsultarNfseEnvio;
      $this->aFiltrosConsulta = array(
        'p_cnpjcpf' => (string) $oConsultarNfseEnvio->Prestador->Cnpj,
        'p_im'      => (int) $oConsultarNfseEnvio->Prestador->InscricaoMunicipal,
      );

      /**
       * Verifica o número da nota
       */
      if (!empty($oConsultarNfseEnvio->NumeroNfse)) {

        $iNumeroNota                     = (int) substr($oConsultarNfseEnvio->NumeroNfse,4, 11);
        $this->aFiltrosConsulta['nota'] = $iNumeroNota;
      }

      /**
       * Verifica o período de emissão da nota
       */
      if (!empty($oConsultarNfseEnvio->PeriodoEmissao)) {

        $this->aFiltrosConsulta['dt_nota_inicial'] = (string) $oConsultarNfseEnvio->PeriodoEmissao->DataInicial;
        $this->aFiltrosConsulta['dt_nota_final']   = (string) $oConsultarNfseEnvio->PeriodoEmissao->DataFinal;
      }

      /**
       * Verifica os dados do tomador
       */
      if (!empty($oConsultarNfseEnvio->Tomador)) {

        if (!empty($oConsultarNfseEnvio->Tomador->CpfCnpj)) {
          $this->aFiltrosConsulta['t_cnpjcpf'] = (string) $oConsultarNfseEnvio->Tomador->CpfCnpj;
        }

        if (!empty($oConsultarNfseEnvio->Tomador->InscricaoMunicipal)) {
          $this->aFiltrosConsulta['t_im'] = (int) $oConsultarNfseEnvio->Tomador->InscricaoMunicipal;
        }
      }
    }
  }

  /**
   * Consulta todas as notas de acordo parâmetros informados anteriormente no processaDados
   * @return string
   */
  public function processar() {

    try {

      /**
       * Cancela uma nota caso não tiver inconsistencias no processo
       */
      if (count($this->aInconsistencias) == 0) {

        /**
         * Retornar a entidade do array de notas
         */
        if (count($this->aFiltrosConsulta > 0)) {
          $this->aNotas = Contribuinte_Model_Nota::getNotaByConsultaNfse($this->aFiltrosConsulta);
        }
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

    $oXml                      = new DOMDocument("1.0", "UTF-8");
    $oXmlConsultarNfseResposta = $oXml->createElement("ii:ConsultarNfseResposta");
    $oXmlConsultarNfseResposta->setAttribute("xmlns:ii", "urn:DBSeller");

    /**
     * Verifica se encontrou erros
     */
    if (count($this->aInconsistencias) == 0) {

      $oNoListaNfse  = $oXml->createElement('ii:ListaNfse');

      if (count($this->aNotas) > 0) {

        foreach ($this->aNotas as $oNota) {

          $oNotaAbrasf = new WebService_Model_NotaAbrasf($oNota);
          $oNoListaNfse->appendChild($oXml->importNode($oNotaAbrasf->getNota(), true));
        }
      }

      $oXmlConsultarNfseResposta->appendChild($oNoListaNfse);
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

      $oXmlConsultarNfseResposta->appendChild($ListaMensagemRetorno);
    }

    $oXml->appendChild($oXmlConsultarNfseResposta);

    return $oXml->saveXML();
  }
}
