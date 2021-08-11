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
 * Controller para importação e emissão Desif
 *
 * @package Contribuinte/Controllers
 * @author Roberto Carneiro <roberto@dbseller.com.br>
 */

class Contribuinte_DesifController extends Contribuinte_Lib_Controller_AbstractController {

  /**
   * (non-PHPdoc)
   * @see Contribuinte_Lib_Controller_AbstractController::init()
   */
  public function init() {
    parent::init();
  }

  /**
   * Action responsável pelo form
   */
  public function importacaoDesifAction() {

    $oFormDesif = new Contribuinte_Form_ImportacaoDesif();
    $oFormDesif->setAction($this->view->baseUrl('/contribuinte/desif/processar-importacao/'));
    $this->view->oForm      = $oFormDesif;
    $this->view->messages[] = array('alert' => 'A importação dos arquivos pode levar alguns minutos.');
  }

  /**
   * Action resposável pela importção da DES-IF
   */
  public function processarImportacaoAction() {

    parent::noLayout();

    try {
      
      $oForm = new Contribuinte_Form_ImportacaoDesif();

      if ($this->getRequest()->isPost() && $oForm->arquivoContas->isUploaded() && $oForm->arquivoReceita->isUploaded()) {

        $oArquivoUpload = new Zend_File_Transfer_Adapter_Http();

        if ($oArquivoUpload->receive()) {

          $aArquivos       = $oArquivoUpload->getFileName();
          $aArquivoContas  = file($aArquivos['arquivoContas']);
          $aArquivoReceita = file($aArquivos['arquivoReceita']);

          $oContribuinte    = $this->_session->contribuinte;
          $oImportacaoDesif = new Contribuinte_Model_Desif($oContribuinte, $aArquivoContas, $aArquivoReceita);

          $iImportacaoDesifId = $oImportacaoDesif->processarArquivo();

          //Gera protocolo e vincula com a importação
          $sMensagem  = 'Processamento efetuado com sucesso!';
          $oProtocolo = $this->adicionaProtocolo(2, $sMensagem);
          $oDesif     = Contribuinte_Model_ImportacaoDesif::getById($iImportacaoDesifId);
          $oDesif->setProtocolo($oProtocolo);
          $oDesif->persist();

          $aRetornoJson['status']    = TRUE;
          $aRetornoJson['success']   = $this->translate->_($sMensagem);
          $aRetornoJson['protocolo'] = $oProtocolo->getProtocolo();
        }

      } else {
        throw new Exception("Preencha os dados corretamente.");
      }
    } catch (Exception $oErro) {

      //Gera Protocolo
      $sMensagem  = $oErro->getMessage();
      $oProtocolo = $this->adicionaProtocolo(1, $sMensagem);

      $aRetornoJson['status']    = FALSE;
      $aRetornoJson['error'][]   =  $sMensagem;
      $aRetornoJson['protocolo'] = $oProtocolo->getProtocolo();
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Cria um protocolo para a importação do DES-IF
   *
   * @param integer $iTipo
   * @param string $sMensagem
   * @return object $oProtocoloCriado
   */
  public function adicionaProtocolo($iTipo, $sMensagem) {

    $oProtocolo       = new Contribuinte_Model_Protocolo();
    $oProtocoloCriado = $oProtocolo->criaProtocolo($iTipo,$sMensagem);

    return $oProtocoloCriado;
  }

  /**
   * Action responsável por listar as contas
   */
  public function listarContasAction() {

    parent::noTemplate();

    $aRecord = array();
    $iLimit  = $this->_request->getParam('rows');
    $iPage   = $this->_request->getParam('page');
    $sSord   = $this->_request->getParam('sord');

    $aParametrosBusca  = $this->_request->getParam('form');

    $oImportacaoDesif = Contribuinte_Model_ImportacaoDesif::getByAtributes($aAtributos);

    /**
     * Valores enviados para o controller
    */

    $oPaginatorAdapter = new DBSeller_Controller_Paginator(Contribuinte_Model_PlanoContaAbrasf::getQuery(),
        'Contribuinte_Model_ImportacaoDesifConta',
        'Contribuinte\ImportacaoDesifConta');

    $oPaginatorAdapter->where("1 = 1");

    /**
     * Ordena os registros
     */
    $oPaginatorAdapter->orderBy("e.id, e.conta", $sSord);

    /**
     * Monta a paginação do GridPanel
    */
    $oResultado = new Zend_Paginator($oPaginatorAdapter);
    $oResultado->setItemCountPerPage($iLimit);
    $oResultado->setCurrentPageNumber($iPage);

    $iTotal      = $oResultado->getTotalItemCount();
    $iTotalPages = ($iTotal > 0 && $iLimit > 0) ? ceil($iTotal/$iLimit) : 0;

    foreach ($oResultado as $oPlanoContaAbrasf) {

      $oDadosColuna = new StdClass();
      $oDadosColuna->id                   = $oPlanoContaAbrasf->getId();
      $oDadosColuna->conta_abrasf         = $oPlanoContaAbrasf->getContaAbrasf();
      $oDadosColuna->titulo_contabil_desc = $oPlanoContaAbrasf->getTituloContabilDesc();
      $oDadosColuna->tributavel           = $oPlanoContaAbrasf->getTributavel();
      $oDadosColuna->obrigatorio          = $oPlanoContaAbrasf->getObrigatorio();

      $aRecord[] = $oDadosColuna;
    }

    /**
     * Parametros de retorno do AJAX
     */
    $aRetornoJson = array(
        'total'   => $iTotalPages,
        'page'    => $iPage,
        'records' => $iTotal,
        'rows'    => $aRecord
    );

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Acition para para carregar o form de emissão de contas
   */
  public function emitirContasAction() {

    $oContribuinte        = $this->_session->contribuinte;
    $oUsuarioContribuinte = Administrativo_Model_UsuarioContribuinte::getByAttribute('id', $oContribuinte->getIdUsuarioContribuinte());
    $aImportacaoDesif     = Contribuinte_Model_ImportacaoDesif::getByAttribute('contribuinte', $oUsuarioContribuinte->getEntity());

    if (!empty($aImportacaoDesif)) {

      if (is_array($aImportacaoDesif)) {

        foreach ($aImportacaoDesif as $oImportacaoDesif) {
          $aComp                                     = array();
          $aComp[]                                   = substr($oImportacaoDesif->getCompetenciaInicial(), 0, 4);
          $aComp[]                                   = substr($oImportacaoDesif->getCompetenciaInicial(), 4);
          $aCompetencias[$oImportacaoDesif->getId()] = implode("/", $aComp);
        }
      } else {

        $aComp                                     = array();
        $aComp[]                                   = substr($aImportacaoDesif->getCompetenciaInicial(), 0, 4);
        $aComp[]                                   = substr($aImportacaoDesif->getCompetenciaInicial(), 4);
        $aCompetencias[$aImportacaoDesif->getId()] = implode("/", $aComp);
      }

      $oForm             = new Contribuinte_Form_EmitirContasDesif($aCompetencias);
      $this->view->oForm = $oForm;
    }
  }

  /**
   * Action que lista as contas a serem emitidas na jqgrid
   */
  public function listarContasEmissaoAction() {

    parent::noTemplate();

    $aRecord = array();
    $iLimit  = $this->_request->getParam('rows')? $this->_request->getParam('rows') : 10;
    $iPage   = $this->_request->getParam('page')? $this->_request->getParam('page') : 0;
    $sSord   = $this->_request->getParam('sord');

    $aParametrosBusca  = $this->_request->getPost();

    if (isset($aParametrosBusca['form']['competencia'])) {
      $aDadosConta = Contribuinte_Model_DesifContaGuia::getContasByCompetencia($aParametrosBusca['form']['competencia']);
    } else {
      $aDadosConta = array();
    }
    $oPaginatorAdapter = new DBSeller_Controller_PaginatorArray($aDadosConta);

    /**
     * Monta a paginação do GridPanel
     */
    $oResultado = new Zend_Paginator($oPaginatorAdapter);
    $oResultado->setItemCountPerPage($iLimit);
    $oResultado->setCurrentPageNumber($iPage);

    $iTotal      = $oResultado->getTotalItemCount();
    $iTotalPages = $oResultado->getPages()->pageCount;

    $aRecord = array();

    foreach ($oResultado as $oDesifConta) {
      $aRecord[] = $oDesifConta;
    }

    /**
     * Parametros de retorno do AJAX
     */
    $aRetornoJson = array(
      'total'   => $iTotalPages,
      'page'    => $iPage,
      'records' => $iTotal,
      'rows'    => $aRecord
    );

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Salva as contas selecionadas para emissão da Guia DES-IF
   */
  public function salvarEmissaoAction() {

    parent::noTemplate();

    $aParametro = $this->_request->getPost();

    if (!empty($aParametro['selecionados'])) {
      $aParametro['selecionados'] = array_unique($aParametro['selecionados']);
    } else {
      $aParametro['selecionados'] = array();
    }

    $oDesifContaGuia = new Contribuinte_Model_DesifContaGuia();
    $aRetornoJson    = $oDesifContaGuia->salvarEmissaoContas($aParametro);

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Carrega o form da listagem de importações DES-IF
   */
  public function consultaImportacaoAction() {

    $oForm = new Contribuinte_Form_ConsultaImportacaoDesif();
    $this->view->oForm = $oForm;
  }

  /**
   * Carrega as importações DES-IF na grid
   */
  public function listarImportacaoDesifAction() {

    parent::noLayout();

    $aParametro = $this->_request->getParam('form');
    $oForm      = new Contribuinte_Form_ConsultaImportacaoDesif();

    $iCompetenciaInicial = null;

    if (!empty($aParametro['competencia_inicial'])) {

      $aCompetenciaInicial = explode('/', $aParametro['competencia_inicial']);
      $iCompetenciaInicial = $aCompetenciaInicial[1] . $aCompetenciaInicial[0];
    }

    $iCompetenciaFinal = null;

    if (!empty($aParametro['competencia_final'])) {

      $aCompetenciaFinal   = explode('/', $aParametro['competencia_final']);
      $iCompetenciaFinal   = $aCompetenciaFinal[1] . $aCompetenciaFinal[0];
    }

    $aRecord           = array();
    $iLimit            = $this->_request->getParam('rows')? $this->_request->getParam('rows') : 10;
    $iPage             = $this->_request->getParam('page')? $this->_request->getParam('page') : 0;

    $oContribuinte     = $this->_session->contribuinte;
    $aIdContribuinte   = $oContribuinte->getContribuintes();

    $aImportacao       = Contribuinte_Model_ImportacaoDesif::getImportacaoPorCompetencia($aIdContribuinte,
                                                                                       $iCompetenciaInicial,
                                                                                       $iCompetenciaFinal);

    $oPaginatorAdapter = new DBSeller_Controller_PaginatorArray($aImportacao);

    /**
     * Monta a paginação do GridPanel
     */
    $oResultado = new Zend_Paginator($oPaginatorAdapter);
    $oResultado->setItemCountPerPage($iLimit);
    $oResultado->setCurrentPageNumber($iPage);

    $iTotal      = $oResultado->getTotalItemCount();
    $iTotalPages = $oResultado->getPages()->pageCount;

    $aRecord     = array();

    foreach ($oResultado as $oImportacaoDesif) {

      $sCompInicial  = substr($oImportacaoDesif->getCompetenciaInicial(), 4, 2) . "/";
      $sCompInicial .= substr($oImportacaoDesif->getCompetenciaInicial(), 0, 4);

      $sCompFinal    = substr($oImportacaoDesif->getCompetenciaFinal(), 4, 2) . "/";
      $sCompFinal   .= substr($oImportacaoDesif->getCompetenciaFinal(), 0, 4);

      $oImportacaoRetorno                      = new StdClass();
      $oImportacaoRetorno->id                  = $oImportacaoDesif->getId();
      $oImportacaoRetorno->competencia_inicial = $sCompInicial;
      $oImportacaoRetorno->competencia_final   = $sCompFinal;
      $oImportacaoRetorno->data_hora           = $oImportacaoDesif->getDataImportacao()->format('d/m/Y H:i:s');

      $aRecord[] = $oImportacaoRetorno;
    }

    /**
     * Parametros de retorno do AJAX
     */
    $aRetornoJson = array(
      'total'   => $iTotalPages,
      'page'    => $iPage,
      'records' => $iTotal,
      'rows'    => $aRecord
    );

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Método que gera o relatório e importações de desif
   */
  public function imprimeImportacaoAction() {

    parent::noLayout();

    $iIdImportacao    = $this->getRequest()->getParam('id');

    $sDataHoraGeracao = date('YmdHis');
    $sArquivoPdf      = "importacao_desif_{$sDataHoraGeracao}.pdf";
    $oContribuinte    = $this->_session->contribuinte;
    $oDadosPrefeitura = Administrativo_Model_Prefeitura::getDadosPrefeituraBase();

    $oImportacaoDesif = Contribuinte_Model_ImportacaoDesif::getById($iIdImportacao);

    $sCompInicial = $oImportacaoDesif->getCompetenciaInicial();
    $sCompFinal   = $oImportacaoDesif->getCompetenciaFinal();

    $aMes = array(
      'inicial' => substr($sCompInicial, 4),
      'final'   => substr($sCompFinal, 4)
    );

    $aAno = array(
      'inicial' => substr($sCompInicial, 0, 4),
      'final'   => substr($sCompFinal, 0, 4)
    );

    $aReceitas = Contribuinte_Model_ImportacaoDesifReceita::getReceitasContasByImportacao($iIdImportacao);

    $oPdf = new Contribuinte_Model_RelatorioReceitasDesif('l');
    $oPdf->setNomeArquivo($sArquivoPdf);
    $oPdf->setAmbiente(getenv('APPLICATION_ENV'));
    $oPdf->setPrefeitura($oDadosPrefeitura);
    $oPdf->openPdf();

    $oPdf->setDadosContribuinte($oContribuinte, $aMes, $aAno, FALSE);
    $oPdf->setDadosReceitas($aReceitas);
    $oPdf->Output();

    parent::download($oPdf->getNomeArquivo());
  }
}