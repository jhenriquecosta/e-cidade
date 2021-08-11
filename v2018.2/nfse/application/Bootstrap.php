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

if (file_exists('../vendor/autoload.php')) {
  require_once '../vendor/autoload.php';
}

require_once APPLICATION_PATH . '/../library/Doctrine/Common/ClassLoader.php';
require_once APPLICATION_PATH . '/modules/webservice/library/Exception/Exception.php';

use Doctrine\Common\Cache\ApcCache as DoctrineApcCache;
use Doctrine\Common\Cache\ArrayCache as DoctrineArrayCache;
use Doctrine\Common\ClassLoader;
use Doctrine\Common\EventManager as DoctrineEventManager;
use Doctrine\ORM\Configuration as DoctrineConfiguration;
use Doctrine\ORM\EntityManager as DoctrineEntityManager;

/**
 * Responsável pelo inicialização da aplicação, todos os método desta classe serão executados em "TODOS" os módulos,
 * antes de qualquer controller e na ordem em que estão dispostos na classe.
 *
 * Class Bootstrap
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

  /**
   * Configura os módulos
   */
  protected function _initAutoload() {

    $oIniConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini');
    $aIniConfig = $oIniConfig->toArray();
    $aModules   = array();

    if (isset($aIniConfig['production']['app']['module'])) {
      $aModules = $aIniConfig['production']['app']['module'];
    }

    // Estancia os modulos
    foreach ($aModules as $sModule => $sNamespace) {

      $oModule = new Zend_Application_Module_Autoloader(array(
                                                          'namespace' => (String) ucfirst($sNamespace),
                                                          'basePath'  => APPLICATION_PATH . "/modules/{$sModule}"
                                                        ));
      $oModule->addResourceTypes(array(
                                   'library'   => array('path' => 'library/', 'namespace' => 'Lib'),
                                   'dao'       => array('path' => 'dao/', 'namespace' => 'Dao'),
                                   'form'      => array('path' => 'forms/', 'namespace' => 'Form'),
                                   'model'     => array('path' => 'models/', 'namespace' => 'Model'),
                                   'interface' => array('path' => 'interfaces/', 'namespace' => 'Interface')
                                 ));
    }
  }

  /**
   * Configura as bibliotecas externas
   */
  public function _initClassLoaders() {

    $oLoader = new ClassLoader('Doctrine\ORM');
    $oLoader->register();

    $oLoader = new ClassLoader('Doctrine\Common');
    $oLoader->register();

    $oLoader = new ClassLoader('Doctrine\DBAL');
    $oLoader->register();

    $oLoader = new ClassLoader('Symfony', 'Doctrine');
    $oLoader->register();

    $oLoader = new ClassLoader('Entity', APPLICATION_PATH . '/default/models');
    $oLoader->register();

    $oLoader = new ClassLoader('Administrativo', APPLICATION_PATH . '/entidades');
    $oLoader->register();

    $oLoader = new ClassLoader('Geral', APPLICATION_PATH . '/entidades');
    $oLoader->register();

    $oLoader = new ClassLoader('Contribuinte', APPLICATION_PATH . '/entidades');
    $oLoader->register();
  }

  /**
   * Configura os parâmetros do Doctrine
   *
   * @return DoctrineEntityManager
   */
  public function _initDoctrineEntityManager() {

    $this->bootstrap(array('classLoaders', 'doctrineCache'));

    $aZendConfig           = $this->getOptions();
    $aConnectionParameters = $aZendConfig['doctrine']['connectionParameters'];
    $oConfiguration        = new DoctrineConfiguration();
    $oConfiguration->setAutoGenerateProxyClasses($aZendConfig['doctrine']['autoGenerateProxyClasses']);
    $oConfiguration->setProxyDir($aZendConfig['doctrine']['proxyPath']);
    $oConfiguration->setProxyNamespace($aZendConfig['doctrine']['proxyNamespace']);

    $oDefaultAnnotationDriver = $oConfiguration->newDefaultAnnotationDriver($aZendConfig['doctrine']['entityPath']);
    $oConfiguration->setMetadataDriverImpl($oDefaultAnnotationDriver);

    $oEventManager  = new DoctrineEventManager();
    $oEntityManager = DoctrineEntityManager::create($aConnectionParameters, $oConfiguration, $oEventManager);

    Zend_Registry::set('em', $oEntityManager);

    return $oEntityManager;
  }

  /**
   * Configura o cache do Doctrine
   *
   * @return DoctrineApcCache|DoctrineArrayCache|null
   */
  public function _initDoctrineCache() {

    $oCache = NULL;

    if (APPLICATION_ENV === 'development') {
      $oCache = new DoctrineArrayCache();
    } else {
      $oCache = new DoctrineApcCache();
    }

    return $oCache;
  }

  /**
   * Configura o sistema
   *
   * @return Zend_Config
   */
  protected function _initConfig() {


    $oBaseUrl           = new Zend_View_Helper_BaseUrl();
    $aOpcaoConfiguracao = $this->getOptions();
    $sVersaoAtual       = Administrativo_Model_Versao::getVersaoAtual();

    $aOpcaoConfiguracao['ecidadeonline2']['versao']         = trim($sVersaoAtual);
    $aOpcaoConfiguracao['settings']['application']['cache'] = trim((int) str_replace('V', '', trim($sVersaoAtual)));

    $oConfig = new Zend_Config($aOpcaoConfiguracao, TRUE);

    Zend_Registry::set('config', $oConfig);

    /**
     * Mensagens de aviso das atualizações de versão
     */
    $sMensagem = "Informativo sobre Atualizações de Versão. <br/>";
    $sMensagem .= " <a href=". $oBaseUrl->baseUrl('/default/atualizacao/versao') ."> Ver </a>";

    DBSeller_Plugin_Notificacao::addAviso('AT001', $sMensagem);

    try {

      // Verifica se foi atualizado o sistema
      $sArquivoAtualizacao = APPLICATION_PATH . '/../versao.txt';
      if (file_exists($sArquivoAtualizacao)) {

        $sVersaoAtualizada = implode('', file($sArquivoAtualizacao));

        Administrativo_Model_Versao::atualizaVersaoNfse($sVersaoAtualizada, $sVersaoAtual);
      }

      if (file_exists(APPLICATION_PATH . '/configs/webservice-ecidade.ini')) {

        $webservice = new Zend_Config_Ini(APPLICATION_PATH . '/configs/webservice-ecidade.ini', null, array('allowModifications' => TRUE));

        Zend_Registry::set('webservice.ecidade', $webservice);
      } else {
        throw new WebService_Lib_Exception(null, null, 'W03');
      }
    } catch(WebService_Lib_Exception $oErro) {
      DBSeller_Plugin_Notificacao::addErro($oErro->getCode(), $oErro->getMessage());
    }

    return $oConfig;
  }

  /**
   * Configura o Log
   *
   * @return mixed|null
   */
  protected function _initLogger() {

    $this->bootstrap('log');

    // Verifica se a requisição veio por CLI PHP ou HTTP
    if (!IS_CLI_CALL) {

      $oLogger = $this->getResource('log');
      $oLogger->setEventItem('ip', $_SERVER['REMOTE_ADDR']);
      Zend_Registry::set('logger', $oLogger);

      return $oLogger;
    }

    return NULL;
  }

  /**
   * Configura a sessão do PHP
   */
  protected function _initSession() {

    // Verifica se a requisição veio por CLI PHP ou HTTP
    if (!IS_CLI_CALL) {

      if (!Zend_Session::isStarted()) {
        Zend_Session::start(TRUE);
      }
    }
  }

  /**
   * Configura as permissões ACL (Lista de Controle de Acesso)
   *
   * @return DBSeller_Acl_Setup|null
   */
  protected function _initAcl() {

    // Verifica se a requisição veio por CLI PHP ou HTTP
    if (!IS_CLI_CALL) {
      return new DBSeller_Acl_Setup();
    }

    return NULL;
  }

  /**
   * Configura o Log de traduções
   *
   * @return mixed|null
   */
  protected function _initLoggerTranslate() {

    // Somente em ambiente de desenvolvimento
    if (APPLICATION_ENV == 'development') {

      $oWriter    = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/../logs/translate.log', 'a');
      $oLog       = new Zend_Log($oWriter);
      $oResource  = $this->getPluginResource('translate');
      $oTranslate = $oResource->getTranslate();
      $oTranslate->setOptions(array('log' => $oLog, 'logUntranslated' => TRUE));

      return $oTranslate;
    }

    return NULL;
  }

  /**
   * Seta a base da url do servidor onde aponta o nota
   */
  protected function _initSetupBaseUrl() {

    /**
     * Monta a string do protocolo
     */
    if(isset($_SERVER['HTTPS'])){
      $sProtocolo = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    } else {
      $sProtocolo = 'http';
    }

    $sBaseUrl = $sProtocolo . "://" . $_SERVER['HTTP_HOST'];
    $front    = Zend_Controller_Front::getInstance();
    $front->setBaseUrl($sBaseUrl);
  }
}