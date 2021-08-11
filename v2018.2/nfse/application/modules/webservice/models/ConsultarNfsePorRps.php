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
 * Modelo responsável pela consulta das notas pela rps
 * @author Everton Catto Heckler <everton.heckler@dbseller.com.br>
 */
class WebService_Model_ConsultarNfsePorRps {


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

  /**
   * Processa o arquivo Webservice
   */
  public function consultaDados($oParametros) {

    try {

      $sNomeTempArquivo = TEMP_PATH . "/ConsultarNfsePorRps-".time().".xml";

      /* gravo o xml enviado */
      $fp = fopen($sNomeTempArquivo, "w");
      fwrite($fp, $oParametros);
      fclose($fp);

      /* carrega o arquivo em memoria para manipulação */
      $oXml = simplexml_load_file($sNomeTempArquivo);

      $oArquivoIdentificacao  = $oXml->ConsultarNfseRpsEnvio->IdentificacaoRps;
      $oArquivoDadosPrestador = $oXml->ConsultarNfseRpsEnvio->Prestador;

      if (empty($oArquivoIdentificacao->Numero)) {
        $this->adicionarInconsistencia('E11');
      }

      if (empty($oArquivoDadosPrestador->Cnpj)) {
        $this->adicionarInconsistencia('E46');
      }

      $oNota = Contribuinte_Model_Nota::getByPrestadorAndNumeroRps($oArquivoDadosPrestador->Cnpj, $oArquivoIdentificacao->Numero);
      if (empty ($oNota)) {
        $this->adicionarInconsistencia('E4');
      }

      if (is_array($oNota)) {
        $oNota = $oNota[0];
      }

      return $this->processaRetornoWebService($oNota);

    } catch (Exception $oErro) {
      return $oErro->getMessage();
    }
  }


  /**
   * Prepara o Retorno de Sucesso do processamento no WebService
   *
   * @param Contribuinte_Model_Nota $oNota
   * @return string
   */
  public function processaRetornoWebService(Contribuinte_Model_Nota $oNota = null) {

    $oXml                      = new DOMDocument("1.0", "UTF-8");
    $oXmlConsultarSituacaoNota = $oXml->createElement("ii:ConsultarNfseRpsResposta");
    $oXmlConsultarSituacaoNota->setAttribute("xmlns:ii", "urn:DBSeller");

    if (count($this->aInconsistencias) == 0) {

      $oNotaAbrasf = new WebService_Model_NotaAbrasf($oNota);
      $oDadosNota  = $oXml->importNode($oNotaAbrasf->getNota(), true);

      $oXmlConsultarSituacaoNota->appendChild($oDadosNota);
    }
    /* Lista de Mensagens para retorno */
    $oXmlListaMensagemRetorno = $oXml->createElement("ii:ListaMensagemRetorno");
    foreach ($this->aInconsistencias as $sInconsistencia) {

      $oMensagemErro  = $oXml->createElement("ii:MensagemRetorno");
      $oCodigo    = $oXml->createElement("ii:Codigo", $sInconsistencia);
      $oMensagem  = $oXml->createElement("ii:Mensagem", $this->aErrosManual[$sInconsistencia]->sMensagem);
      $oCorrecao  = $oXml->createElement("ii:Correcao", $this->aErrosManual[$sInconsistencia]->sSolucao);
      $oMensagemErro->appendChild($oCodigo);
      $oMensagemErro->appendChild($oMensagem);
      $oMensagemErro->appendChild($oCorrecao);
      $oXmlListaMensagemRetorno->appendChild($oMensagemErro);
    }
    $oXmlConsultarSituacaoNota->appendChild($oXmlListaMensagemRetorno);
    $oXml->appendChild($oXmlConsultarSituacaoNota);

    return $oXml->saveXML();
  }

  /**
   * Adiciona um erro/inconsistencia no processamento da requisicao
   * @param $sCodigoErro codigo do erro
   */
  protected function adicionarInconsistencia($sCodigoErro) {

    $this->aInconsistencias[] = $sCodigoErro;
  }
}
