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
 * Classe auxiliar para autenticação de usuários validando com a ACL
 */
class DBSeller_Plugin_Auth extends Zend_Controller_Plugin_Abstract {

  /**
   * @var Zend_Acl
   */
  protected static $_acl = NULL;

  /**
   * @var Zend_Auth
   */
  protected $_auth = NULL;

  /**
   * @var
   */
  protected $oUsuarioAcoes = NULL;

  /**
   * @var array
   */
  protected $aUrlAcessoNegado = array('controller' => 'error', 'action' => 'forbidden', 'module' => 'default');

  /**
   * @var array
   */
  protected $aUrlErro = array('controller' => 'error', 'action' => 'error', 'module' => 'default');

  /**
   * Método construtor
   */
  public function __construct() {

    $oSessao = Zend_Session::namespaceGet('sessao');

    if (isset($oSessao['acl'])) {

      $this->_auth = Zend_Auth::getInstance();
      self::$_acl  = $oSessao['acl'];
    }
  }

  /**
   * Checa se usuário tem permissão em determinada ação
   *
   * @param string $sAcesso
   * @return bool
   * @throws Exception
   */
  public static function checkPermission($sAcesso) {

    if (is_string($sAcesso)) {

      $aAcesso     = array_reverse(explode('/', $sAcesso));
      $oRequest    = Zend_Controller_Front::getInstance()->getRequest();
      $sModule     = isset($aAcesso[2]) ? $aAcesso[2] : NULL;
      $sController = isset($aAcesso[1]) ? $aAcesso[1] : NULL;
      $sAction     = isset($aAcesso[0]) ? $aAcesso[0] : NULL;

      if ($sModule) {
        $oRequest->setModuleName($sModule);
      }

      if ($sController) {
        $oRequest->setControllerName($sController);
      }

      if ($sAction) {
        $oRequest->setActionName($sAction);
      }
    } else {
      throw new Exception ('Parametro informado é de tipo inválido');
    }

    if (self::_isAuthorized(Zend_Controller_Front::getInstance()->getRequest())) {
      return TRUE;
    }

    return FALSE;
  }

  /**
   * Validação das Acls a cada chamada de metodo
   *
   * @param $oRequest
   * @return boolean
   */
  protected function _isAuthorized(Zend_Controller_Request_Abstract $oRequest) {

    self::checkVersaoSistema();

    $sModule     = $oRequest->getModuleName();
    $sController = $oRequest->getControllerName();
    $sAction     = $oRequest->getActionName();
    $oAcl        = self::$_acl;

    $oResource = new Zend_Acl_Resource($sModule . ':' . $sController);

    if (!$oAcl->has($oResource->getResourceId())) {

      self::menuNaoCadastrado($oRequest);
      self::carregaAuditoria($oRequest);

      return TRUE;
    }

    if ($oAcl->has($oResource->getResourceId()) && $oAcl->isAllowed('Usuario', $oResource->getResourceId(), $sAction)) {

      self::carregaAuditoria($oRequest);

      return TRUE;
    }

    return FALSE;
  }

  /**
   * Captura a versão do e-cidade e adiciona na sessão
   *
   * @return Zend_Session_Namespace
   */
  protected static function capturaSessaoVersaoEcidade() {

    $oSessao = new Zend_Session_Namespace('sessao');

    if (!isset($oSessao->versaoecidade)) {

      $aCampos     = array('ecidadeVersao');
      $oWebService = WebService_Model_Ecidade::consultar('getVersaoEcidade', array(array(), $aCampos));

      // Camptura a versão do e-cidade
      if (!empty($oWebService[0]->ecidadeversao)) {
        $oSessao->versaoecidade = $oWebService[0]->ecidadeversao;
      }
    }

    return $oSessao;
  }

  /**
   * Checa a versão do sistema compativel
   */
  public static function checkVersaoSistema() {

    try {

      $oSessao = self::capturaSessaoVersaoEcidade();

      $sConfigVersaoNfse         = Zend_Registry::get('config')->ecidadeonline2->versao;
      $oVersaoNfse               = Administrativo_Model_Versao::getByAttribute('ecidadeonline2', trim($sConfigVersaoNfse));
      $sVersaoSistemaAtualizacao = (is_object($oVersaoNfse)) ? $oVersaoNfse->getVersaoEcidade() : NULL;

      // Verifica se foi informado algum valor para comparação das versões
      if (empty($sVersaoSistemaAtualizacao) || empty($oSessao->versaoecidade)) {

        $sMensagemErro  = 'Versão do E-cidade e do NFS-e não foram configuradas corretamente.<br>';
        $sMensagemErro .= "Versão E-Cidade atual: {$oSessao->versaoecidade}<br>";
        $sMensagemErro .= "Versão E-Cidade compatível: {$sVersaoSistemaAtualizacao}";

        throw new Exception($sMensagemErro, 400);
      }

      // Verifica se a versão do nota informada é menor ou igual a primeira versão implantada
      if (version_compare($sVersaoSistemaAtualizacao, $oSessao->versaoecidade, '>')) {

        $sMensagemErro  = 'Versões do NFS-e e do E-cidade não são compatíveis.<br>';
        $sMensagemErro .= "Versão E-Cidade atual: {$oSessao->versaoecidade}<br>";
        $sMensagemErro .= "Versão E-Cidade compatível: {$sVersaoSistemaAtualizacao}";

        throw new Exception($sMensagemErro, 400);
      }
    } catch (Exception $oErro) {
      DBSeller_Plugin_Notificacao::addErro("W{$oErro->getCode()}", $oErro->getMessage());
    }
  }

  /**
   * Verifica se o menu está cadastrado na base de dados
   *
   * @param $oRequest
   */
  protected function menuNaoCadastrado(Zend_Controller_Request_Abstract $oRequest) {

    $sCaminhoAcl = "{$oRequest->getModuleName()}:{$oRequest->getControllerName()}:{$oRequest->getActionName()}";
    $oLog        = Zend_Registry::get('logger');
    $oLog->log("Caminho da ACL não cadastrado: {$sCaminhoAcl}", Zend_Log::INFO, ' ');
  }

  /**
   * Inicia a sessão do usuário na base de dados
   *
   * @param Zend_Controller_Request_Abstract $oRequest
   */
  private static function carregaAuditoria(Zend_Controller_Request_Abstract $oRequest) {

    // Dados request
    $sModule     = $oRequest->getModuleName();
    $sController = $oRequest->getControllerName();
    $sAction     = $oRequest->getActionName();

    // Registra na base de dados o usuário logado
    $aDadosLogin            = Zend_Auth::getInstance()->getIdentity();
    $oDoctrineEntityManager = Zend_Registry::get('em');
    $oConexao               = $oDoctrineEntityManager->getConnection();
    $sSqlUsuario            = "select fc_putsession('DB_login', '{$aDadosLogin['login']}');";
    $oStatement             = $oConexao->prepare($sSqlUsuario);
    $oStatement->execute();

    // Registra na base de dados a URL acessada pelo usuário
    $sSqlAcessado = "select fc_putsession('DB_acessado', '{$sModule}/{$sController}/{$sAction}');";
    $oStatement   = $oConexao->prepare($sSqlAcessado);
    $oStatement->execute();
  }

  /**
   * Método executado antes de processar os controllers
   *
   * @param Zend_Controller_Request_Abstract $oRequest
   */
  public function preDispatch(Zend_Controller_Request_Abstract $oRequest) {

    if (!$this->_isAuthorized($oRequest)) {

      $oRequest->setActionName($this->aUrlAcessoNegado['action']);
      $oRequest->setControllerName($this->aUrlAcessoNegado['controller']);
      $oRequest->setModuleName($this->aUrlAcessoNegado['module']);
    }
  }

  /**
   * Método verificar a permissão do método pelo webservice
   *
   * @param string $sLogin Login do Usuário
   * @param string $sUrlRequest URL do método requisitado
   * @return boolean true|false
   */
  public static function checkPermissionWebservice($sLogin, $sUrlRequest) {

    $aAcesso     = array_reverse(explode('/', $sUrlRequest));
    $sController = isset($aAcesso[1]) ? $aAcesso[1] : NULL;
    $sAction     = isset($aAcesso[0]) ? $aAcesso[0] : NULL;

    $oDoctrine = Zend_Registry::get('em');
    $oQuery    = $oDoctrine->createQueryBuilder();
    $oQuery->select('u.id, u.login');
    $oQuery->from('Administrativo\Usuario', 'u');
    $oQuery->innerJoin('Administrativo\UsuarioContribuinte', 'uc', 'WITH', 'uc.usuario = u');
    $oQuery->innerJoin('Administrativo\UsuarioContribuinteAcao', 'ua', 'WITH', 'ua.usuario_contribuinte = uc');
    $oQuery->innerJoin('Administrativo\Controle', 'c', 'WITH', "c.identidade = '{$sController}' AND c.modulo = 8");
    $oQuery->innerJoin('Administrativo\Acao', 'a', 'WITH', 'a = ua.acao AND a.controle = c');
    $oQuery->where("u.login = '{$sLogin}'");
    $oQuery->andWhere("a.acaoacl = '{$sAction}'");
    $oQuery->andWhere('u.habilitado = true');
    $oQuery->andWhere('u.principal = true');
    $oResult = $oQuery->getQuery()->getResult();

    if (empty($oResult)) {
      return FALSE;
    }

    return TRUE;
  }
}