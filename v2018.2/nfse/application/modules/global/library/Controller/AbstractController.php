<?php
/*
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
 * Classe para reunir os métodos em comum entre os módulos
 *
 * @package Global/Library
 */

/**
 * @package Global/Library
 */
class Global_Lib_Controller_AbstractController extends Zend_Controller_Action {

  /**
   * Nome do módulo
   *
   * @var string
   */
  protected $module;

  /**
   * Nome do controller
   *
   * @var string
   */
  protected $controller;

  /**
   * Nome da Action
   *
   * @var string
   */
  protected $action;

  /**
   * Configurações de ambiente do sistema (application.ini::APPLICATION_ENV)
   *
   * @var array
   */
  protected $aIniConfig;

  /**
   * Objeto auxiliar para tratamento de URL's
   *
   * @var Zend_View_Helper_Url
   */
  protected $zendHelperUrl;

  /**
   * Objeto para tradução do sistema
   *
   * @var Zend_Translate
   */
  protected $translate;

  /**
   * Objeto auxiliar para controle de redirecionamento de URL's no sistema
   *
   * @var Zend_Controller_Action_Helper_Redirector
   */
  protected $_redirector;

  /**
   * Objeto auxiliar para conteúdo em ajax
   *
   * @var Zend_Controller_Action_Helper_AjaxContext
   */
  protected $_ajaxContext;

  /**
   * Objeto da sessão com informações do sistema
   *
   * @var Zend_Session
   */
  protected $_session;

  /**
   * Método construtor, será executado para todos os módulos do sistema
   */
  public function init() {

    $this->aIniConfig = $this->getFrontController()->getParam('bootstrap')->getApplication()->getOptions();

    self::maintenance();

    $this->zendHelperUrl = new Zend_View_Helper_Url();

    // Seta os dados do módulo, controller, action para os controllers, views e layouts
    $this->module                     = $this->getRequest()->getModuleName();
    $this->controller                 = $this->getRequest()->getControllerName();
    $this->action                     = $this->getRequest()->getActionName();
    $this->view->moduleName           = $this->getRequest()->getModuleName();
    $this->view->controller           = $this->getRequest()->getControllerName();
    $this->view->action               = $this->getRequest()->getActionName();
    $this->view->layout()->module     = $this->getRequest()->getModuleName();
    $this->view->layout()->controller = $this->getRequest()->getControllerName();
    $this->view->layout()->action     = $this->getRequest()->getActionName();

    // Tradutor
    $this->translate                 = Zend_Registry::get('Zend_Translate');
    $this->view->translate           = $this->translate;
    $this->view->layout()->translate = $this->translate;

    // Ambiente
    $this->view->messages = $this->_helper->getHelper('FlashMessenger')->getMessages();
    $this->_redirector    = $this->_helper->getHelper('Redirector');
    $this->_ajaxContext   = $this->_helper->getHelper('AjaxContext');

    // Seta os dados do contribuinte para as views e layouts
    $this->_session                     = new Zend_Session_Namespace('nfse');
    $this->view->contribuinte           = $this->_session->contribuinte;
    $this->view->layout()->contribuinte = $this->_session->contribuinte;

    // Seta os dados da prefeitura nas views e layouts
    $oPrefeitura                       = self::getDadosPrefeitura();
    $this->oPrefeitura                 = $oPrefeitura;
    $this->view->oPrefeitura           = $oPrefeitura;
    $this->view->layout()->oPrefeitura = $oPrefeitura;

    // Dados do usuário logado (independente do perfil)
    $aLogin         = Zend_Auth::getInstance()->getIdentity();
    $oUsuarioLogado = Administrativo_Model_Usuario::getByAttribute('login', $aLogin['login']);

    $this->usuarioLogado                 = $oUsuarioLogado;
    $this->view->usuarioLogado           = $oUsuarioLogado;
    $this->view->layout()->usuarioLogado = $oUsuarioLogado;

    // Seta o usuário que irá utilizar o sistema (usuários escolhido pelo fiscal ou contador)
    if (isset($this->_session->iUsuarioEscolhido)) {

      $oUsuarioLogado = Administrativo_Model_Usuario::getByAttribute('id', $this->_session->iUsuarioEscolhido);

      $this->user                 = $oUsuarioLogado;
      $this->view->user           = $oUsuarioLogado;
      $this->view->layout()->user = $oUsuarioLogado;
    } else {

      // Seta os dados do usuário iguais aos do usuário logado no sistema
      $this->user                 = $oUsuarioLogado;
      $this->view->user           = $oUsuarioLogado;
      $this->view->layout()->user = $oUsuarioLogado;
    }
  }

  /**
   * Ativa o modo de manutencao
   */
  public function maintenance() {

    $aAllowedIps = array('*');

    if (isset($this->aIniConfig['ecidadeonline2']['ip'])) {

      $aAllowedIps = array('127.0.0.1');
      $aAllowedIps = array_merge($aAllowedIps, $this->aIniConfig['ecidadeonline2']['ip']['allow']);
    }

    if (in_array('*', $aAllowedIps)) {
      return FALSE;
    }

    $sUrl       = "{$this->_request->getModuleName()}/{$this->_request->getControllerName()}";
    $sIpAddress = DBSeller_Helper_Ip_IpAddress::getIpAddress();

    if (!in_array($sIpAddress, $aAllowedIps) && $sUrl != 'default/manutencao') {
      $this->redirect('/manutencao');
    }
  }

  /**
   * Verifica se o usuário está logado no sistema
   *
   * @return boolean
   */
  protected function checkIdentity() {

    // Ignora a checagem quando for a instalação do sistema
    if ($this->getRequest()->getControllerName() == 'instalacao') {
      return FALSE;
    }

    // Verifica se o usuário está logado no sistema
    if (!Zend_Auth::getInstance()->hasIdentity() || !is_object($this->view->user->getEntity())) {

      $this->_helper->getHelper('FlashMessenger')
                    ->addMessage(array('error' => 'Você precisa estar logado para acessar essa página'));

      $this->_redirector->gotoSimple('index', 'login', 'auth');
    }

    return TRUE;
  }

  /**
   * Gerar PDF através do HTML informado
   *
   * @param string $sHtml
   * @param string $sFilename
   * @param array  $aOptions
   *                 $aOptions['margins']['left']   = 15;
   *                 $aOptions['margins']['right']  = 15;
   *                 $aOptions['margins']['top']    = 15;
   *                 $aOptions['margins']['bottom'] = 15;
   *                 $aOptions['margins']['header'] = 15;
   *                 $aOptions['margins']['footer'] = 15;
   *                 $aOptions['format']            = 'A4-L';
   *                 $aOptions['output']            = 'D'; // 'D' = Download | 'F' = Salva o arquivo
   */
  protected function renderPdf($sHtml, $sFilename, $aOptions) {

    self::noLayout();

    $aOptions['margins']['left']   = isset($aOptions['margins']['left']) ? $aOptions['margins']['left'] : 15;
    $aOptions['margins']['right']  = isset($aOptions['margins']['right']) ? $aOptions['margins']['right'] : 15;
    $aOptions['margins']['top']    = isset($aOptions['margins']['top']) ? $aOptions['margins']['top'] : 15;
    $aOptions['margins']['bottom'] = isset($aOptions['margins']['bottom']) ? $aOptions['margins']['bottom'] : 15;
    $aOptions['margins']['header'] = isset($aOptions['margins']['header']) ? $aOptions['margins']['header'] : 15;
    $aOptions['margins']['footer'] = isset($aOptions['margins']['footer']) ? $aOptions['margins']['footer'] : 15;
    $aOptions['format']            = isset($aOptions['format']) ? $aOptions['format'] : 'A4-L';
    $aOptions['output']            = isset($aOptions['output']) ? $aOptions['output'] : 'D';

    define('_MPDF_URI', LIBRARY_PATH . '/MPDF54/');
    define('_MPDF_TEMP_PATH', TEMP_PATH . '/');

    require_once(LIBRARY_PATH . '/MPDF54/mpdf.php');

    $oMpdf = new mPDF('utf-8',
                      $aOptions['format'],
                      0,
                      '',
                      $aOptions['margins']['left'],
                      $aOptions['margins']['right'],
                      $aOptions['margins']['top'],
                      $aOptions['margins']['bottom'],
                      $aOptions['margins']['header'],
                      $aOptions['margins']['footer']);

    $oMpdf->ignore_invalid_utf8 = TRUE;
    $oMpdf->charset_in          = 'utf-8';
    $oMpdf->SetDisplayMode('fullpage', 'two');
    $oMpdf->WriteHTML($oMpdf->purify_utf8($sHtml));
    $oMpdf->Output("{$sFilename}.pdf", $aOptions['output']);

    exit();
  }

  /**
   * Desabilita a exibicao e renderizacao do layout
   */
  public function noLayout() {

    $this->_helper->viewRenderer->setNoRender(TRUE);
    $this->_helper->layout()->disableLayout();
  }

  /**
   * Desabilita a renderizacao do layout
   */
  public function noTemplate() {

    $this->_helper->layout()->disableLayout();
  }

  /**
   * Forca download de arquivos
   *
   * @param string      $sFile
   * @param string|null $sPath
   */
  public function download($sFile, $sPath = NULL) {

    $sFile = TEMP_PATH . "/{$sFile}";

    if ($sPath) {
      $sFile = PUBLIC_PATH . "/{$sPath}/{$sFile}";
    }

    if (file_exists($sFile)) {

      $oResponse = $this->getResponse();
      $oResponse->setHeader('Content-Description', 'File Transfer', TRUE);
      $oResponse->setHeader('Content-Type', 'text/plain', TRUE);
      $oResponse->setHeader('Content-Disposition', 'attachment; filename=' . basename($sFile), TRUE);
      $oResponse->setHeader('Content-Transfer-Encoding', 'binary', TRUE);
      $oResponse->setHeader('Expires', '0', TRUE);
      $oResponse->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', TRUE);
      $oResponse->setHeader('Pragma', 'public', TRUE);
      $oResponse->setHeader('Content-Length: ', filesize($sFile), TRUE);
      $oResponse->setBody(file_get_contents($sFile));
    } else {

      echo '<script type="text/javascript">alert("Arquivo não encontrado ou inacessível!"); history.back()</script>';
      exit;
    }
  }

  /**
   * Exibe o PDF no navegador
   *
   * @param string      $sFile
   * @param string|null $sPath
   * @throws Exception
   */
  public function showPdf($sFile, $sPath = NULL) {

    $sFile = TEMP_PATH . "/{$sFile}";

    if ($sPath) {
      $sFile = PUBLIC_PATH . "/{$sPath}/{$sFile}";
    }

    if (file_exists($sFile)) {

      $oResponse = $this->getResponse();
      $oResponse->setHeader('Content-Description', 'File Transfer', TRUE);
      $oResponse->setHeader('Content-Type', 'application/pdf', TRUE);
      $oResponse->setHeader('Content-Disposition', 'inline; filename=' . basename($sFile), TRUE);
      $oResponse->setHeader('Content-Transfer-Encoding', 'binary', TRUE);
      $oResponse->setHeader('Expires', '0', TRUE);
      $oResponse->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', TRUE);
      $oResponse->setHeader('Pragma', 'public', TRUE);
      $oResponse->setHeader('Content-Length: ', filesize($sFile), TRUE);
      $oResponse->setBody(file_get_contents($sFile));
    } else {
      throw new Exception('Arquivo não encontrado!');
    }
  }

  /**
   * Retorna o objeto Zend_Log() para registro de eventos do sistema
   *
   * @see Zend_Log
   * @example
   *      $oLog = parent::log();
   *      $oLog->log('Mensagem', Zend_Log::ERR, print_r($aMeuArray, TRUE));
   * @return Zend_Log
   */
  public function log() {

    return Zend_Registry::get('logger');
  }

  /**
   * Retorna os parâmetros com ou sem criptografia
   *
   * @param string      $sParametro
   * @param string|null $sValorPadrao
   * @return mixed|null
   */
  public function getParam($sParametro, $sValorPadrao = NULL) {

    $aRequest = DBSeller_Helper_Url_Encrypt::decrypt();

    if (isset($aRequest[$sParametro])) {
      return $aRequest[$sParametro] ? : $sValorPadrao;
    }

    return $this->getRequest()->getParam($sParametro, $sValorPadrao);
  }

  /**
   * Retorna os dados da prefeitura
   *
   * @return mixed
   */
  public function getDadosPrefeitura() {

    try {
      $oPrefeitura = Administrativo_Model_Prefeitura::getDadosPrefeituraBase();
    } catch (Exception $oErro) {
      $oPrefeitura = NULL;
    }

    return $oPrefeitura;
  }

  /**
   * Retorna a versão da applicação
   *
   * @return string
   */
  public function getVersaoApp() {

    $sVersao = 'V100000';

    if (isset($this->aIniConfig['ecidadeonline2']['versao'])) {
      $sVersao = $this->aIniConfig['ecidadeonline2']['versao'];
    }

    return $sVersao;
  }
}