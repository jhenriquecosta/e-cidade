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
 * Plugin para controle de layout
 *
 * @package    DBSeller
 * @subpackage Layout
 */

/**
 * @package    DBSeller
 * @subpackage Layout
 * @author     Gilton Guma <gilton@dbseller.com.br>
 */
class DBSeller_Layout_Controller_Plugin_Layout extends Zend_Layout_Controller_Plugin_Layout {

  /**
   * Processamento do Layout
   *
   * @see Zend_Controller_Plugin_Abstract::preDispatch()
   */
  public function preDispatch(Zend_Controller_Request_Abstract $oRequest) {

    self::sessionControl($oRequest);
    self::setHead($oRequest);
    self::setNavigation($oRequest);
    self::setBreadcrumbs($oRequest);

    if (Zend_Registry::isRegistered('breadcrumbs')) {
      self::setBreadcrumbsParams($oRequest);
    }
  }

  /**
   * Controla o tempo de inatividade do usuário no sistema para expiração da sessão
   */
  public function sessionControl() {

    // Inicia a sessão
    if (!Zend_Session::isStarted()) {
      Zend_session::start();
    }

    $oSessao = new Zend_Session_Namespace('controle_sessao');

    // Tempo de invativade em segundos para encerramento da sessão
    $iTempoMaximoDeInatividadeEmSegundos = 1800; // 30 minutos

    // Horário da última atividade do usuário
    $iUltimaAtivade = isset($oSessao->ultima_atividade) ? $oSessao->ultima_atividade : FALSE;

    // Verifica se o usuário está logado
    $lUsuarioLogado = (Zend_Auth::getInstance()->getIdentity() != NULL);

    // Redireciona o usuário se o tempo de inatividade expirar
    if ($iUltimaAtivade && ((time() - $iUltimaAtivade) > $iTempoMaximoDeInatividadeEmSegundos) && $lUsuarioLogado) {

      Zend_Auth::getInstance()->clearIdentity();

      $oRedirector = Zend_Controller_Action_HelperBroker::getStaticHelper('Redirector');
      $oRedirector->gotoSimpleAndExit('index', 'logout', 'auth');
    }

    // Seta o horário da última ação do usuário
    $oSessao->ultima_atividade = time();
  }

  /**
   * Adiciona scripts css e javascript por modulo, controller ou action no head do layout
   *
   * @param Zend_Controller_Request_Abstract $oRequest
   */
  public function setHead(Zend_Controller_Request_Abstract $oRequest) {

    $sModule       = strtolower($oRequest->getModuleName()); // Nome do módulo
    $sController   = strtolower($oRequest->getControllerName()); // Nome do controller
    $sAction       = strtolower($oRequest->getActionName()); // Nome da action
    $oVersaoApp    = self::getVersaoApp(); // Versão da aplicação
    $oView         = Zend_Layout::getMvcInstance()->getView(); // Objeto View
    $oView->versao = $oVersaoApp; // Configura a versão para as views

    // Estilo por módulo
    if (is_file(APPLICATION_PATH . "/../public/{$sModule}/css/module.css")) {

      $sUrl = $oView->serverUrl("/{$sModule}/css/module.css?v={$oVersaoApp}");
      $oView->headLink()->offsetSetStylesheet(97, $sUrl);
    }

    // StyleSheet [Module]
    if (is_file(APPLICATION_PATH . "/../public/{$sModule}/css/{$sController}/controller.css")) {

      $sUrl = $oView->serverUrl("/{$sModule}/css/{$sController}/controller.css?v={$oVersaoApp}");
      $oView->headLink()->offsetSetStylesheet(98, $sUrl);
    }

    // StyleSheet [Controller]
    if (is_file(APPLICATION_PATH . "/../public/{$sModule}/css/{$sController}/{$sAction}.css")) {

      $sUrl = $oView->serverUrl("/{$sModule}/css/{$sController}/{$sAction}.css?v={$oVersaoApp}");
      $oView->headLink()->offsetSetStylesheet(99, $sUrl);
    }

    // JavaScript [Module]
    if (is_file(APPLICATION_PATH . "/../public/{$sModule}/js/module.js")) {

      $sUrl = $oView->serverUrl("/{$sModule}/js/module.js?v={$oVersaoApp}");
      $oView->headScript()->offsetSetFile(97, $sUrl);
    }

    // JavaScript [Controller]
    if (is_file(APPLICATION_PATH . "/../public/{$sModule}/js/{$sController}/controller.js")) {

      $sUrl = $oView->serverUrl("/{$sModule}/js/{$sController}/controller.js?v={$oVersaoApp}");
      $oView->headScript()->offsetSetFile(98, $sUrl);
    }

    // JavaScript [Action]
    if (is_file(APPLICATION_PATH . "/../public/{$sModule}/js/{$sController}/{$sAction}.js")) {

      $sUrl = $oView->serverUrl("/{$sModule}/js/{$sController}/{$sAction}.js?v={$oVersaoApp}");
      $oView->headScript()->offsetSetFile(99, $sUrl);
    }
  }

  /**
   * Carrega o navigation.xml do módulo, caso exista
   *
   * @param Zend_Controller_Request_Abstract $oRequest
   */
  public function setNavigation(Zend_Controller_Request_Abstract $oRequest) {

    $sModule = strtolower($oRequest->getModuleName());
    $sFile   = APPLICATION_PATH . "/modules/{$sModule}/views/scripts/layouts/menu/navigation.xml";

    if (file_exists($sFile)) {

      $oNavConfig  = new Zend_Config_Xml($sFile, 'nav');
      $oNavigation = new Zend_Navigation($oNavConfig);
      $oView       = Zend_Layout::getMvcInstance()->getView();
      $oView->navigation($oNavigation);

      Zend_Registry::set('nav', $oNavigation);
    }
  }

  /**
   * Carrega o breadcrumbs.xml do módulo, caso exista
   *
   * @param Zend_Controller_Request_Abstract $oRequest
   */
  public function setBreadcrumbs(Zend_Controller_Request_Abstract $oRequest) {

    $sModule = strtolower($oRequest->getModuleName());
    $sFile   = APPLICATION_PATH . "/modules/{$sModule}/views/scripts/layouts/breadcrumbs/navigation.xml";

    if (file_exists($sFile)) {

      $oNavConfig   = new Zend_Config_Xml($sFile, 'breadcrumbs');
      $oBreadcrumbs = new Zend_Navigation($oNavConfig);
      $oView        = Zend_Layout::getMvcInstance()->getView();
      $oView->navigation($oBreadcrumbs);

      Zend_Registry::set('breadcrumbs', $oBreadcrumbs);
    }
  }

  /**
   * Seta os últimos parâmetros acessados nos links dos breadcrumbs
   *
   * @param Zend_Controller_Request_Abstract $oRequest
   */
  public function setBreadcrumbsParams(Zend_Controller_Request_Abstract $oRequest) {

    $sCaminhoUrl = $oRequest->getModuleName() . '|' . $oRequest->getControllerName() . '|' . $oRequest->getActionName();
    $aParametros = $oRequest->getParams();

    // Exclui os parâmetros default do Zend Request
    unset($aParametros['module'], $aParametros['controller'], $aParametros['action']);

    // Altera somente as páginas que possuam parâmetros
    if (count($aParametros) == 0) {
      return;
    }

    $oContainer                         = Zend_Registry::get('breadcrumbs');
    $oSessao                            = new Zend_Session_Namespace('sessao');
    $oSessao->aParametros[$sCaminhoUrl] = $aParametros;

    // Varre as páginas e adiciona os parâmetros do request
    foreach ($oSessao->aParametros as $sCaminho => $aParametros) {

      $aAction = explode('|', $sCaminho);

      if (isset($aAction[2])) {

        $aPaginasNav = $oContainer->findOneBy('action', $aAction[2]);

        if (!empty($aPaginasNav)) {
          $aPaginasNav->setParams($aParametros);
        }
      }
    }
  }

  /**
   * Retorna a versão da applicação
   *
   * @return string
   */
  private function getVersaoApp() {

    $oIniConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini');
    $aIniConfig = $oIniConfig->toArray();
    $aIniConfig = $aIniConfig[APPLICATION_ENV];

    $sVersao = 'V100000';

    if (isset($aIniConfig['ecidadeonline2']['versao'])) {
      $sVersao = $aIniConfig['ecidadeonline2']['versao'];
    }

    return $sVersao;
  }
}