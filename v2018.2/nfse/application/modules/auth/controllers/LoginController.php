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
 * Controle das autenticaçãos de usuários
 *
 * @package Auth/Controllers
 * @see Auth_Lib_Controller_AbstractController
 */

/**
 * @package Auth/Controllers
 * @see Auth_Lib_Controller_AbstractController
 */
class Auth_LoginController extends Auth_Lib_Controller_AbstractController {

  /**
   * Construtor da classe
   *
   * @see Auth_Lib_Controller_AbstractController::init()
   */
  public function init() {

    parent::init();
  }

  /**
   * Action Login
   */
  public function indexAction() {

    $bSistemaBloqueado = Zend_Registry::get('config')->ecidadeonline2->bloqueado;

    if ($bSistemaBloqueado) {
      $this->redirect($this->view->baseUrl('/default/manutencao/bloqueio'));
    }

    $bUsuarioAutenticado = DBSeller_Helper_Auth_Authentication::getAuthData();

    if ($bUsuarioAutenticado) {
      $this->redirect($this->view->baseUrl('/default/index/'));
    }

    $oSessao = new Zend_Session_Namespace('captcha');

    if (!isset($oSessao->errors)) {

      $oSessao->errors        = 0;
      $oSessao->captcha_Value = '';
    }

    $this->view->form = new Auth_Form_login_FormLogin();

  }

  /**
   * Efetua o login
   */
  public function postAction() {

    $oSessao = new Zend_Session_Namespace('captcha');
    $oForm   = new Auth_Form_login_FormLogin();
    $aDados  = $this->getRequest()->getParams();
    $sLogin  = $this->getRequest()->getParam('login', -1);
    $sSenha  = $this->getRequest()->getParam('senha', -1);

    if ($oForm->isValid($aDados)) {

      $oEntityManager = Zend_Registry::get('em');

      $oAuthAdapter   = new Doctrine_Auth_Adapter($oEntityManager, 'Administrativo\Usuario', 'login', 'senha');
      $oAuthAdapter->setIdentity($sLogin);
      $oAuthAdapter->setCredential($sSenha);

      $oAuth   = Zend_Auth::getInstance();
      $iStatus = $oAuth->authenticate($oAuthAdapter)->getCode();

      $oParametrosPrefeitura = Administrativo_Model_ParametroPrefeitura::getAll();

      switch ($iStatus) {

        case 1: // Autenticacao Ok

          $sLogin = $oAuth->getIdentity();
          $oUser  = Administrativo_Model_Usuario::getByAttribute('login', $sLogin);

          if ($oUser->isLoginBloqueado()) {

            $aRetornoJson['status']  = FALSE;
            $aRetornoJson['error'][] = $this->translate->_("Por motivos de segurança o login está bloqueado por {$oParametrosPrefeitura[0]->getTempoBloqueio()} minutos.\n Aguarde e tente novamente!");
            $aRetornoJson['bloqueado'] = true;
            $aRetornoJson['tempo_bloqueio'] = $oParametrosPrefeitura[0]->getTempoBloqueio();

          } else if ($oUser->getHabilitado()) {

            Zend_Auth::getInstance()->getStorage()->write(array('id' => $oUser->getId(), 'login' => $sLogin));

            $oUser->setTentativa(0);
            $oUser->setDataTentativa(null);
            $oUser->persist();
            $oTentativas = new Zend_Session_Namespace('tentativas');
            unset($oTentativas->ativo);
            unset($oTentativas->quantidade);

            $aRetornoJson['status'] = TRUE;
            $aRetornoJson['url']    = $this->view->baseUrl('/default/index');
            $oSessao = new Zend_Session_Namespace('captcha');
            $oSessao->unsetAll();
          } else {

            $aRetornoJson['status']  = FALSE;
            $aRetornoJson['error'][] = $this->translate->_('Usuário não habilitado para acessar o sistema.');
          }
          break;

        case -1: // Usuario invalido
        case -2: // Usuario repetido
        case -3: // Senha invalida

          $oSessao->errors++;
          $aRetornoJson['status']  = FALSE;

          $sRetornoMsg = 'Usuário ou senha não conferem.';

          // Se senha errada
          if ($iStatus == -3) {
            $oUsuario = Administrativo_Model_Usuario::getByAttribute('login', $sLogin);
            $aRetornoJson['bloqueado'] = $oUsuario->isLoginBloqueado();
            $aRetornoJson['tempo_bloqueio'] = $oParametrosPrefeitura[0]->getTempoBloqueio();
            $iTentativas = $oUsuario->getTentativa();
            $iTentativas++;
            $oUsuario->setTentativa($iTentativas);
            $oData = new DateTime();
            $oData->format('Y-m-d\TH:i:s');
            $oUsuario->setDataTentativa($oData);
            $oUsuario->persist();

            if ($iTentativas >= 3) {

              $oSessaoTentativas = new Zend_Session_Namespace('tentativas');
              $oSessaoTentativas->ativo = TRUE;
              $oSessaoTentativas->quantidade = $iTentativas;
              if ($iTentativas > 3) {
                $aRetornoJson['bloqueado'] = TRUE;
              }
              $sRetornoMsg = "Por motivos de segurança o login está bloqueado por {$oParametrosPrefeitura[0]->getTempoBloqueio()} minutos.\n Aguarde e tente novamente!";
              $aRetornoJson['captcha'] = $oSessaoTentativas->ativo;

            }
          }

          $aRetornoJson['error'][] = $this->translate->_($sRetornoMsg);
          break;

        default:

          $oSessao->errors++;
          $aRetornoJson['status']  = FALSE;
          $aRetornoJson['error'][] = $this->translate->_('Ocorreu um erro no sistema.');
      }
    } else {

      $oSessaoTentativas = new Zend_Session_Namespace('tentativas');
      $oSessao->errors++;

      if ($oSessaoTentativas->ativo) {
        $aRetornoJson['captcha'] = $oSessaoTentativas->ativo;
      }
      $aRetornoJson['fields'] = array_keys($oForm->getMessages());
      $aRetornoJson['error'][] = $this->translate->_('Preencha os dados corretamente.');
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Action Esqueci a Senha
   */
  public function esqueciMinhaSenhaAction() {

    $this->view->oForm = new Auth_Form_EsqueciMinhaSenha();
  }

  /**
   * Envia ao usuário um email contendo as informações necessárias para a recuperação da sua senha de acesso.
   * @throws Exception
   */
  public function esqueciMinhaSenhaPostAction() {

    $aDados = $this->getRequest()->getParams();
    $oForm  = new Auth_Form_EsqueciMinhaSenha();

    $aRetornoJson            = array();
    $aRetornoJson['status']  = TRUE;
    $aRetornoJson['message'] = '';

    try {

      if (!$oForm->isValid($aDados)) {
        throw new Exception($this->translate->_('Email informado não é válido.'));
      }

      /**
       * Buscamos o usuário pelo email
       */
      $oQueryAtivos = Administrativo_Model_Usuario::getQuery();
      $oQueryAtivos->select('e');
      $oQueryAtivos->from('\Administrativo\Usuario', 'e');
      $oQueryAtivos->where("e.email = '{$oForm->email->getValue()}' and e.habilitado = true");

      $aEntitiesUsuarios = $oQueryAtivos->getQuery()->getResult();

      if (count($aEntitiesUsuarios) != 1) {
        throw new Exception($this->translate->_('Email informado não é um cadastro válido.'));
      }

      $oUsuario = new Administrativo_Model_Usuario($aEntitiesUsuarios[0]);

      Administrativo_Model_Usuario::enviarEmailSenha($oUsuario);

      $aRetornoJson['success'] = $this->translate->_('Um email foi enviado para a sua conta com instruções.');
      $aRetornoJson['url']     = $this->view->baseUrl('/auth/login');
    } catch (Exception $eErro) {

      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['error'][] = $eErro->getMessage();
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Action Recuperação de Senha
   */
  public function recuperarSenhaAction() {

    $this->view->oForm = new Auth_Form_RecuperarSenha();
    $this->view->oForm->populate($this->getRequest()->getParams());
  }

  /**
   * Cria a Senha e Atualiza o os dados dado usuário
   */
  public function recuperarSenhaPostAction() {

    $oRequest                = $this->getRequest();
    $aRetornoJson            = array();
    $aRetornoJson['status']  = TRUE;
    $aRetornoJson['message'] = '';
    $oDoctrine               = Zend_Registry::get('em');

    try {

      $oDoctrine->getConnection()->beginTransaction();

      if ($oRequest->isPost() || $oRequest->isGet()) {

        $oForm = new Auth_Form_RecuperarSenha();

        if ($oRequest->senha != $oRequest->senharepetida) {

          $aRetornoJson['fields'] = array('senha', 'senharepetida');

          throw new Exception($this->translate->_('As senhas informadas não correspondem.'));
        }

        if (!$oForm->isValid($oRequest->getParams())) {

          $aRetornoJson['fields'] = array_keys($oForm->getMessages());

          throw new Exception($this->translate->_('Preencha os dados corretamente.'));
        }

        /**
         * Buscamos o usuário pelo email
         */
        $oQueryAtivos = Administrativo_Model_Usuario::getQuery();
        $oQueryAtivos->select('e');
        $oQueryAtivos->from('\Administrativo\Usuario', "e");
        $oQueryAtivos->where("e.email = '{$oForm->email->getValue()}' and e.habilitado = true");

        $aEntitiesUsuarios = $oQueryAtivos->getQuery()->getResult();

        if (count($aEntitiesUsuarios) != 1) {
          throw new Exception($this->translate->_('Email informado não é um cadastro válido.'));
        }

        $oUsuario = new Administrativo_Model_Usuario($aEntitiesUsuarios[0]);

        /**
         * Recriamos o hash do usuario. caso nao seja o mesmo enviado, negamos a troca de senha
         */
        $sHashUsuario = $oUsuario->criarHash();

        if ($sHashUsuario != $oRequest->getParam('hash')) {
          throw new Exception($this->translate->_('Código de verificação informado é inválido.'));
        }

        $oUsuario->setSenha($oRequest->getParam('senha'));
        $oUsuario->persist();
        $oDoctrine->getConnection()->commit();

        $aRetornoJson['success'] = $this->translate->_('Senha alterada com sucesso.');
        $aRetornoJson['login']   = $oUsuario->getLogin();
        $aRetornoJson['url']     = $this->view->baseUrl('/auth/login');
      }
    } catch (Exception $eErro) {

      $oDoctrine->getConnection()->rollback();

      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['error'][] = $eErro->getMessage();
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }
}