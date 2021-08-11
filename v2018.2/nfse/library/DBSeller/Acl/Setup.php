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

use Symfony\Component\Console\Application;

/**
 * Configuracao da Lista de Controle de Acesso
 *
 * @author Gilton
 * @package \DBSeller\Acl\Setup
 */
class DBSeller_Acl_Setup {

  /**
   * @var Zend_Acl
   */
  protected $_acl;

  /**
   *
   * @var Administrativo_Model_Acao
   */
  protected $oAcoes = null;

  /**
   * Construtor
   */
  public function __construct($lCria = FALSE) {

    $aSessao = Zend_session::namespaceGet('sessao');

    if ($lCria == FALSE) {

      if (!empty($aSessao['acl'])) {

        return;
      } else {
        $this->_acl = new Zend_Acl();
      }
    } else {
      $this->_acl = $aSessao['acl'];
    }

    $this->_setupResourcesPrivileges();
    $this->carregaMenus();

    if (Zend_Auth::getInstance()->hasIdentity()) {
      $this->_setupResourcesPrivilegesUserAuth();
    }

    $this->_saveAcl();
  }

  /**
   * Recursos / Previlegios
   */
  protected function _setupResourcesPrivilegesUserAuth() {

    $aDadosLogin   = Zend_Auth::getInstance()->getIdentity();

    $oUsuario      = Administrativo_Model_Usuario::getByAttribute('login', $aDadosLogin["login"]);
    $oContribuinte = new Zend_Session_Namespace('nfse');

    if (!isset($oContribuinte->contribuinte)) {

      $aUsuarioAcoes = $oUsuario->getAcoes();

      if (is_array($aUsuarioAcoes) && count($aUsuarioAcoes) > 0) {

        foreach ($aUsuarioAcoes as $oUsuarioAcao) {

          $sControle = $oUsuarioAcao->getControle()->getIdentidade();
          $sModulo   = $oUsuarioAcao->getControle()->getModulo()->getIdentidade();
          $oResource = new Zend_Acl_Resource("{$sModulo}:{$sControle}");

          if (!$this->_acl->has($oResource->getResourceId())) {

            $this->_acl->addResource($oResource);
          }

          $oAcoesExtra = explode(',', trim($oUsuarioAcao->getSubAcoes()));
          $aAcoesExtra = array_merge($oAcoesExtra, array($oUsuarioAcao->getAcaoAcl()));


          foreach ($aAcoesExtra as $sAcao) {

            if (empty($sAcao)) continue;

            $this->_acl->allow('Usuario', $oResource->getResourceId(), $sAcao);
          }
        }
      }
    }

    if (!empty($oContribuinte->contribuinte)) {

      $iCodigoUsuarioContribuinte = $oContribuinte->contribuinte->getIdUsuarioContribuinte();
      $oUsuarioContribuinte       = Administrativo_Model_UsuarioContribuinte::getById($iCodigoUsuarioContribuinte);

      foreach ($oUsuarioContribuinte->getUsuarioContribuinteAcoes() as $oPermissoes) {

        $oAcoesExtra = explode(',', trim($oPermissoes->getAcao()->getSubAcoes()));
        $aAcoesExtra = array_merge($oAcoesExtra, array($oPermissoes->getAcao()->getAcaoAcl()));

        $sModulo   = $oPermissoes->getAcao()->getControle()->getModulo()->getIdentidade();
        $sControle = $oPermissoes->getAcao()->getControle()->getIdentidade();

        $oResource = new Zend_Acl_Resource("{$sModulo}:{$sControle}");

        if (!$this->_acl->has($oResource->getResourceId())) {
          $this->_acl->addResource($oResource);
        }

        foreach ($aAcoesExtra as $sAcao) {

          if (empty($sAcao)) continue;

          $this->_acl->allow('Usuario', $oResource->getResourceId(), $sAcao);
        }

      }
    }
  }

  /**
   * Carrega todos os menus cadastrados no sistema negando o acesso
   */
  protected function carregaMenus () {

    $oAcoes = Administrativo_Model_Acao::getAll();

    foreach ($oAcoes as $oAcao) {

      $sModulo     = $oAcao->getControle()->getModulo()->getIdentidade();
      $sControle   = $oAcao->getControle()->getIdentidade();

      $oAcoesExtra = explode(',', trim($oAcao->getSubAcoes()));
      $aAcoesExtra = array_merge($oAcoesExtra, array($oAcao->getAcaoAcl()));

      $oResource = new Zend_Acl_Resource($sModulo . ":" . $sControle);

      if (!$this->_acl->has($oResource->getResourceId())) {

        $this->_acl->addResource($oResource->getResourceId());
      }

      foreach ($aAcoesExtra as $sAcao) {

        if (empty($sAcao)) continue;

        if (!$oAcao->getControle()->getVisivel()) {

          $this->_acl->allow('Usuario', $oResource->getResourceId(), $sAcao);

        } else {

          $this->_acl->deny('Usuario', $oResource->getResourceId(), $sAcao);
        }
      }
    }
  }

  /**
   * Roles (papeis)
   */
  protected function _setupResourcesPrivileges() {

    if (!$this->_acl->hasRole('Usuario')) {
      $this->_acl->addRole(new Zend_Acl_Role('Usuario'));
    }
  }

  /**
   * Grava na sessao a lista de acesso
   */
  protected function _saveAcl() {

    $oSessao = new Zend_Session_Namespace('sessao');
    $oSessao->acl = $this->_acl;
  }
}