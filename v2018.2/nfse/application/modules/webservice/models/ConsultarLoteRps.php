<?php
/**
 * E-cidade Software Publico para Gestão Municipal
 *   Copyright (C) 2014 DBSeller Serviços de Informática Ltda
 *                          www.dbseller.com.br
 *                          e-cidade@dbseller.com.br
 *   Este programa é software livre; você pode redistribuí-lo e/ou
 *   modificá-lo sob os termos da Licença Pública Geral GNU, conforme
 *   publicada pela Free Software Foundation; tanto a versão 2 da
 *   Licença como (a seu critério) qualquer versão mais nova.
 *   Este programa e distribuído na expectativa de ser útil, mas SEM
 *   QUALQUER GARANTIA; sem mesmo a garantia implícita de
 *   COMERCIALIZAÇÃO ou de ADEQUAÇÃO A QUALQUER PROPÓSITO EM
 *   PARTICULAR. Consulte a Licença Pública Geral GNU para obter mais
 *   detalhes.
 *   Você deve ter recebido uma cópia da Licença Pública Geral GNU
 *   junto com este programa; se não, escreva para a Free Software
 *   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *   02111-1307, USA.
 *   Cópia da licença no diretório licenca/licenca_en.txt
 *                                 licenca/licenca_pt.txt
 */

/**
 * Classe responsavel pelo processamento das consultas de lote de RPS
 * Class WebService_Model_ConsultarLoteRps
 */
class WebService_Model_ConsultarLoteRps {


  /**
   * Requisição de Envio para consulta do lote
   * @var string
   */
  protected $sArquivo;


  /**
   * Notas fiscais processadas no lote
   * @var Contribuinte_Model_Nota[]
   */
  protected $aNotas;

  /**
   * Lista de Erros da Abrasf
   * @var array
   */
  protected $aErrosManual = array();


  /**
   * Dados da REquisicao, convertio para um SimpleXML
   * @var SimpleXMLElement
   */
  protected $oRequisicao;

  /**
   * Lista de inconsistencias encontradas no processamento da requisicao
   * @var array
   */
  protected $aInconsistencias = array();

  /**
   * Instancia uma nova Consulta de Lote de RPS
   */
  public function __construct() {
    $this->aErrosManual = Administrativo_Model_ImportacaoRpsErros::getMensagensPorModelo(1);
  }

  /**
   * Realiza a execução da pesquisa dos dados conforme arquivo de requisicao
   *
   * @param $sArquivo
   * @return string
   */
  public function processar($sArquivo) {

    if (empty($sArquivo)) {
      $this->adicionarInconsistencia('E160');
    }

    $sNomeTempArquivo = TEMP_PATH . "/ConsultarLoteRps-".time().".xml";

    /* gravo o xml enviado */
    $fp = fopen($sNomeTempArquivo, "w");
    fwrite($fp, $sArquivo);
    fclose($fp);
    $this->oRequisicao = simplexml_load_string($sArquivo);
    if (empty($this->oRequisicao)) {
      $this->adicionarInconsistencia('E160');
    }

    if (!$this->validarRequisicao()) {
      return $this->escreverRetorno();
    }

    $sCnpj                = $this->oRequisicao->Prestador->Cnpj;
    $sNumeroProtocolo     = $this->oRequisicao->Protocolo;
    $oUsuarioContribuinte = Administrativo_Model_UsuarioContribuinte::getByAttribute('cnpj_cpf', $sCnpj);
    if (empty($oUsuarioContribuinte)) {
      $this->adicionarInconsistencia('E45');
    }

    $oProtocolo = Administrativo_Model_Protocolo::getByAttribute('protocolo', $sNumeroProtocolo);

    if (empty($oProtocolo)) {

      $this->adicionarInconsistencia('E86');
      return $this->escreverRetorno();
    }

    $oProtocoloImportacao = Contribuinte_Model_ProtocoloImportacao::getByAttribute('protocolo', $oProtocolo->getId());

    if (!$oProtocoloImportacao->getImportacao()) {

      $this->adicionarInconsistencia('E86');
      return $this->escreverRetorno();
    }

    $this->aNotas = $oProtocoloImportacao->getNotasImportadas();
    return $this->escreverRetorno();
  }


  /**
   * Adiciona um erro/inconsistencia no processamento da requisicao
   * @param $sCodigoErro codigo do erro
   * @return Retorna a string da requisicao como XML
   */
  protected function adicionarInconsistencia($sCodigoErro) {
    $this->aInconsistencias[$sCodigoErro] = $sCodigoErro;
  }


  protected function escreverRetorno() {

    $oDomDocument = new DOMDocument();
    $oDomDocument->formatOutput = false;

    $oNodeConsultarLote = $oDomDocument->createElement("ii:ConsultarLoteRpsResposta");
    $oNodeConsultarLote->setAttribute("xmlns:ii", "urn:DBSeller");

    $oNoListaNfse  = $oDomDocument->createElement('ii:ListaNfse');
    if (count($this->aNotas) > 0) {

      foreach ($this->aNotas as $oNota) {

        $oNotaAbrasf = new WebService_Model_NotaAbrasf($oNota);
        $oNoListaNfse->appendChild($oDomDocument->importNode($oNotaAbrasf->getNota(), true));
      }
    }
    $oNoListaErros = $oDomDocument->createElement('ii:ListaMensagemRetorno');

    $oNodeConsultarLote->appendChild($oNoListaNfse);
    $oNodeConsultarLote->appendChild($oNoListaErros);

    foreach ($this->aInconsistencias as $sInconsistencia) {

      $oMensagemErro  = $oDomDocument->createElement("ii:MensagemRetorno");
      $oCodigo        = $oDomDocument->createElement("ii:Codigo", $sInconsistencia);
      $oMensagem      = $oDomDocument->createElement("ii:Mensagem", $this->aErrosManual[$sInconsistencia]->sMensagem);
      $oCorrecao      = $oDomDocument->createElement("ii:Correcao", $this->aErrosManual[$sInconsistencia]->sSolucao);
      $oMensagemErro->appendChild($oCodigo);
      $oMensagemErro->appendChild($oMensagem);
      $oMensagemErro->appendChild($oCorrecao);
      $oNoListaErros->appendChild($oMensagemErro);
    }

    $oDomDocument->appendChild($oNodeConsultarLote);
    return $oDomDocument->saveXML();
  }

  /**
   * Realiza a validacao dos dados da requisicao
   * @return boolean
   */
  protected function validarRequisicao() {

    $lRequisicaoValida = true;
    if (empty($this->oRequisicao->Prestador)) {

      $this->adicionarInconsistencia('E160');
      $lRequisicaoValida = false;
    }

    if (empty($this->oRequisicao->Prestador->Cnpj)) {

      $this->adicionarInconsistencia('E46');
      $lRequisicaoValida = false;
    }

    $oValidadorCNpj = new DBSeller_Validator_Cnpj();
    if (!$oValidadorCNpj->isValid($this->oRequisicao->Prestador->Cnpj)) {

      $this->adicionarInconsistencia('E44');
      $lRequisicaoValida = false;
    }

    if (empty($this->oRequisicao->Prestador->InscricaoMunicipal)) {

      $this->adicionarInconsistencia('E50');
      $lRequisicaoValida = false;
    }

    if (empty($this->oRequisicao->Protocolo)) {

      $this->adicionarInconsistencia('E86');
      $lRequisicaoValida = false;
    }

    return $lRequisicaoValida;
  }
} 