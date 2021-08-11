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
 * Classe para controle do módulo do contribuinte
 *
 * @package Contribuinte/Controllers
 * @see Contribuinte_Lib_Controller_AbstractController
 */

class Contribuinte_IndexController extends Contribuinte_Lib_Controller_AbstractController {

  /**
   * Metodo Responsável por direcionar o usuário
   */
  public function indexAction() {

    if (!$this->view->user->getAdministrativo()) {
      $this->_redirector->gotoSimple('contribuinte', 'index', 'contribuinte');
    }
  }

  /**
   * Metodo inicial quando o usuairo for contribuinte
   */
  public function contribuinteAction() {

    // Oculta breadcrumbs
    $this->view->oculta_breadcrumbs = TRUE;

    // Matar sessão quando acessado via menu
    if ($this->_getParam('alterar')) {

      $oSessao                  = new Zend_Session_Namespace('nfse');
      $oSessao->contribuinte    = NULL;
      $this->view->contribuinte = NULL;
      $this->_session->id       = NULL;
    }

    /* Se escolheu um contribuinte e o Usuario logado é um Fiscal*/
    if (!isset($this->_session->iUsuarioEscolhido) && $this->usuarioLogado->getPerfil()->getId() == 5) {
      $this->_redirector->gotoSimple('listar-cadastros', 'usuario-acesso', 'fiscal');
    }

    // Verifica se a lista de contribuinte e diferente da lista vinculada ao usuario
    if ($this->view->user->getTipo() == Administrativo_Model_TipoUsuario::$CONTADOR) {

      /* Obtem todas as empresas vinculadas ao contador no e-Cidade */
      $aContribuintes = Administrativo_Model_Empresa::getByCnpj(trim($this->view->user->getCnpj()));

      // atualiza a lista de contribuintes
      $this->view->user->atualizaListaContribuintes($aContribuintes);

    } else {
      /* Se o Usuario não for um Contador */

      $oContribuinte = $this->view->user->getUsuariosContribuintes();

      if (empty($oContribuinte)) {

        $this->_helper->getHelper('FlashMessenger')->addMessage(
          array('error' => 'Usuário não está ativado!')
        );

        $this->_redirector->gotoSimple('listar-cadastros', 'usuario-acesso', 'fiscal');
      } else {

        $oContribuinte = $oContribuinte[0];

        if ($oContribuinte->getIm()) {

          $aContribuintes[] = Contribuinte_Model_Contribuinte::getDadosContribuinteEcidade($oContribuinte->getIm());
          $aContribuintesInscricao = new Contribuinte_Model_Contribuinte();
        } else if ($oContribuinte->getCnpjCpf()) {

          $oContribuinteEventual = new Contribuinte_Model_ContribuinteEventual();
          $aContribuintes[] = $oContribuinteEventual->getByCpfCnpjWebService($oContribuinte->getCnpjCpf());
        }
      }
    }

    // atualiza o tipo de emissao e permissoes dos contribuintes
    Administrativo_Model_UsuarioContribuinte::atualizaTipoEmissao($aContribuintes);

    // Atualiza o nome do contribuinte no cadastro de Usuários
    //Administrativo_Model_UsuarioContribuinte::atualizaNomeUsuarioContribuinte($aContribuintes);

    $aContribuintes            = $this->view->user->getContribuintes();
    $this->view->contribuintes = $aContribuintes;

     //carrega informativo do fiscal
    $oInformativo = Administrativo_Model_Informativo::getByAttribute('id', 1);

    //Verifica se retorna algo da coluna informativo
    if (!empty($oInformativo)) {
      $this->view->descricao = $oInformativo->getDescricao();
    }


    if (count($this->view->contribuintes) == 1 && $this->_session->id == NULL) {

      $aContribuintes = each($this->view->contribuintes);
      $oContribuinte  = $aContribuintes['value'];

      self::setContribuinte($oContribuinte);
      $this->_redirector->gotoSimple('contribuinte', 'index', 'contribuinte');
    }

    // Reseta permissões
    new DBSeller_Acl_Setup(TRUE);
  }

  /**
   * Tela responsável por definir qual contribuinte será utilizado no módulo
   */
  public function setContribuinteAction() {

    parent::checkIdentity('index');

    $iIdContribuinte = $this->getRequest()->getParam('id');
    $aContribuintes  = $this->view->user->getContribuintes();

    // Checa se o usuário tem permissão para o contribuinte informado
    if (!isset($aContribuintes[$iIdContribuinte])) {

      $this->_helper->getHelper('FlashMessenger')->addMessage(
                    array('error' => 'Você não tem permissão para este contribuinte.'));
      $this->_redirector->gotoSimple('contribuinte', 'index', 'contribuinte');
    }

    self::setContribuinte($aContribuintes[$iIdContribuinte]);

    $this->_redirector->gotoSimple('contribuinte', 'index', 'contribuinte');
  }

  /**
   * Seta o contribuinte na sessão
   *
   * @param Contribuinte_Model_ContribuinteAbstract $oContribuinte
   * @internal param int $iInscricaoMunicipal
   */
  private function setContribuinte(Contribuinte_Model_ContribuinteAbstract $oContribuinte) {

    $this->_session->id           = $oContribuinte->getIdUsuarioContribuinte();
    $this->_session->contribuinte = $oContribuinte;

    new DBSeller_Acl_Setup(TRUE);
  }
}
