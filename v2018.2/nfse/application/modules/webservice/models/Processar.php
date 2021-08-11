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
 * Modelo responsável pelo processamento dos métodos solicitados pelo cliente SOAP
 * @author Everton Heckler <dbeverton.heckler>
 */
class WebService_Model_Processar {

  /**
   * Tratamento de retorno do processo executado com sucesso
   *
   * @param $oRetorno
   * @return mixed
   */
  protected static function retornoMensagemSucesso($oRetorno) {

    return $oRetorno;
  }

  /**
   * Tratamento de retorno dos erros encontrados
   *
   * @param $oErro
   * @return string
   */
  protected static function retornoMensagemErro($oErro) {

    $oXml = new DOMDocument("1.0", "UTF-8");
    $oXmlEnviarLoteResposta = $oXml->createElement("ii:ErroWebServiceResposta");
    $oXmlEnviarLoteResposta->setAttribute( "xmlns:ii", "urn:DBSeller" );

    $oXmlListaMensagemRetorno = $oXml->createElement("ii:ListaMensagemRetorno");
    $oXmlCodigoErro           = $oXml->createElement("ii:CodigoErro", "E{$oErro->getCode()}");
    $oXmlMensagemErro         = $oXml->createElement("ii:MensagemErro", $oErro->getMessage());

    $oXmlEnviarLoteResposta->appendChild($oXmlCodigoErro);
    $oXmlEnviarLoteResposta->appendChild($oXmlMensagemErro);

    $oXmlEnviarLoteResposta->appendChild($oXmlListaMensagemRetorno);
    $oXml->appendChild($oXmlEnviarLoteResposta);

    return $oXml->saveXML();
  }

  /**
   * Processa os dados de lotes RPS
   * 
   * @param object $oParametroArquivo
   * @throws Exception
   * @return string
   */
  public function RecepcionarLoteRps($oParametroArquivo) {
    
    try {

      $oWebserviceProcessamento = new WebService_Model_RecepcionarLoteRps();
      $oWebserviceProcessamento->preparaDados($oParametroArquivo);
      $oRetorno = $oWebserviceProcessamento->processamentoArquivo();

      return WebService_Model_Processar::retornoMensagemSucesso($oRetorno);
    } catch (Exception $oErro) {
      return WebService_Model_Processar::retornoMensagemErro($oErro);
    }
  }
  
  /**
   * Retorna situação do lote Rps
   *
   * @param object $oParametroArquivo
   * @throws Exception
   * @return string
   */
  public function ConsultarSituacaoLoteRps($oParametroArquivo) {

    try {

      $oWebserviceProcessamento = new WebService_Model_ConsultarSituacaoLoteRps();
      $oRetorno = $oWebserviceProcessamento->consultaDados($oParametroArquivo);

      return WebService_Model_Processar::retornoMensagemSucesso($oRetorno);
    } catch (Exception $oErro) {
      return WebService_Model_Processar::retornoMensagemErro($oErro);
    }
  }

  /**
   * Retorna os dados da nota com base na rps
   *
   * @param object $oParametroArquivo
   * @throws Exception
   * @return string
   */
  public function ConsultarNfsePorRps($oParametroArquivo) {

    try {

      $oWebserviceProcessamento = new WebService_Model_ConsultarNfsePorRps();
      $oRetorno = $oWebserviceProcessamento->consultaDados($oParametroArquivo);

      return WebService_Model_Processar::retornoMensagemSucesso($oRetorno);
    } catch (Exception $oErro) {
      return WebService_Model_Processar::retornoMensagemErro($oErro);
    }
  }

  /**
   * Retorna os dados do LoteRps
   *
   * @param $sParametroArquivo
   * @return string
   * @throws Exception
   */
  public function ConsultarLoteRps($sParametroArquivo) {

    try {

      $oConsultarLoteRps = new WebService_Model_ConsultarLoteRps($sParametroArquivo);
      $oRetorno          = $oConsultarLoteRps->processar($sParametroArquivo);

      return WebService_Model_Processar::retornoMensagemSucesso($oRetorno);
    } catch (Exception $oErro) {
      return WebService_Model_Processar::retornoMensagemErro($oErro);
    }
  }

  /**
   * Cancela uma nota conforme a IdentificacaoNfse
   *
   * @param $oParametroArquivo
   * @return string
   * @throws Exception
   */
  public function CancelarNfse($oParametroArquivo) {

    try {

      $oWebserviceProcessamento = new WebService_Model_CancelarNfse();
      $oWebserviceProcessamento->preparaDados($oParametroArquivo);
      $oRetorno = $oWebserviceProcessamento->processar();

      return WebService_Model_Processar::retornoMensagemSucesso($oRetorno);
    } catch (Exception $oErro) {
      return WebService_Model_Processar::retornoMensagemErro($oErro);
    }
  }

  /**
   * Consultar das notas
   *
   * @param $sParametroArquivo
   * @return string
   * @throws Exception
   */
  public function ConsultarNfse($sParametroArquivo) {

    try {

      $oConsultaNfse = new WebService_Model_ConsultarNfse();
      $oConsultaNfse->preparaDados($sParametroArquivo);
      $oRetorno = $oConsultaNfse->processar();

      return WebService_Model_Processar::retornoMensagemSucesso($oRetorno);
    } catch (Exception $oErro) {
      return WebService_Model_Processar::retornoMensagemErro($oErro);
    }
  }
}