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
 * Controller responsável pelos perfis de usuário
 *
 * Class Administrativo_PerfilController
 * @package Administrativo\Controllers\PerfilController
 * @author Everton Heckler <dbeverton.heckler>
 */
class Administrativo_PerfilController extends Administrativo_Lib_Controller_AbstractController {

  /**
   * Pesquisa inicial da rotina
   */
  public function indexAction() {
    
    $sBusca            = $this->getRequest()->getParam('busca');
    $oPaginatorAdapter = new E2Tecnologia_Controller_Paginator(
      Administrativo_Model_Perfil::getQuery(), 
     'Administrativo_Model_Perfil', 
     'Administrativo\Perfil'
    );
    
    $sWhere = '1 = 1 ';
    
    if ($sBusca != '') {
      $sWhere .= 'AND (upper(e.nome) ' . " LIKE '%" . strtoupper($sBusca) . "%')";
    }

    $oPaginatorAdapter->where($sWhere);
    
    $aPerfils = new Zend_Paginator($oPaginatorAdapter);
    $aPerfils->setItemCountPerPage(10);
    $aPerfils->setCurrentPageNumber($this->_request->getParam("page"));
    
    $this->view->perfils   = $aPerfils;
    $this->view->formBusca = $this->formBusca($sBusca);
    $this->view->busca     = $sBusca;
  }

  /**
   * Cadastro de novo perfil
   */
  public function novoAction() {
    
    $this->view->form = $this->formPerfil();

    if ($this->getRequest()->isPost()) {

      $aDados = $this->getRequest()->getPost();

      if ($this->view->form->isValid($aDados)) {

        $oPerfil      = new Administrativo_Model_Perfil();
        $check_perfil = Administrativo_Model_Perfil::getByAttribute('nome', $aDados['nome']);
        
        if ($check_perfil !== null) {
          
          $this->view->messages[] = array('error' => 'Perfil já cadastrado');
          return;
        }

        $oPerfil->persist($aDados);

        $this->_helper->getHelper('FlashMessenger')->addMessage(array('notice' => 'Perfil cadastrado com sucesso.'));
        $this->_redirector->gotoSimple('editar', 'perfil', 'administrativo', array('id' => $oPerfil->getId()));
      }
    }
  }

  /**
   * Exclui perfil informado
   */
  public function excluirAction() {
    
    $iIdPerfil = $this->getRequest()->getParam('id');
    $oPerfil   = Administrativo_Model_Perfil::getById($iIdPerfil);

    if ($oPerfil !== null) {
      
      try {

        $oPerfil->destroy();
        $this->_helper->getHelper('FlashMessenger')->addMessage(array('notice' => 'Perfil removido.'));
        $this->_redirector->gotoSimple('index', 'perfil', 'administrativo');
      } catch (Exception $oErro) {
      
        $this->_helper->getHelper('FlashMessenger')->addMessage(array('error' => 'Ocorreu um erro e não foi possível remover o Perfil.'));
        $this->_redirector->gotoSimple('index', 'perfil', 'administrativo');
      }
    } else {
      
      $this->_helper->getHelper('FlashMessenger')->addMessage(array('error' => 'Perfil não encontrado.'));
      $this->_redirector->gotoSimple('index', 'perfil', 'administrativo');
    }
  }

  /**
   * Atualiza os dados de um perfil informado
   */
  public function editarAction() {

    $iIdPerfil = $this->getRequest()->getParam('id');
    
    if ($iIdPerfil === null) {
      $this->_redirector->gotoSimple('index');
    }
    
    $oPerfil = Administrativo_Model_Perfil::getById($iIdPerfil);
    $oForm   = $this->formPerfil('editar', $iIdPerfil);

    if ($oPerfil === null) {
      
      $this->_helper->getHelper('FlashMessenger')->addMessage(array('notice' => 'Perfil inválido.'));
      $this->_redirector->gotoSimple('index');
    }

    if ($this->getRequest()->isPost()) {

      $aDados = $this->getRequest()->getPost();

      if (!$oForm->isValidPartial($aDados)) {
        $this->view->form = $oForm;
      } else {

        $oPerfil->persist($aDados);
        $this->_helper->getHelper('FlashMessenger')->addMessage(array('notice' => 'Perfil modificado.'));
        $this->_redirector->gotoSimple('editar', 'perfil', 'administrativo', array('id' => $oPerfil->getId()));
      }
    }  else {
      
      $aValues = array(
        'tipo'           => $oPerfil->getTipo(),
        'nome'           => $oPerfil->getNome(),
        'administrativo' => $oPerfil->getAdministrativo()
      );

      $this->view->form = $this->formPerfil('editar', $iIdPerfil, $aValues);
    }
    
    // busca permissões do perfil_perfis
    $aPerfilPerfis      = array();
    $oListaPerfilPerfis = $oPerfil->getPerfis();
    
    foreach ($oListaPerfilPerfis as $aPerfil) {
      $aPerfilPerfis[] = $aPerfil->getId();
    }
    
    // busca permissões do perfil_perfis
    $aPerfilAcoes      = array();
    $oListaPerfilAcoes = $oPerfil->getAcoes();
    
    foreach ($oListaPerfilAcoes as $aAcao) {
      $aPerfilAcoes[] = $aAcao->getId();
    }
    
    $this->view->aPerfis       = Administrativo_Model_Perfil::getAll();
    $this->view->aPerfilPerfis = $aPerfilPerfis;
    
    $this->view->modulosAdm   = Administrativo_Model_Modulo::getAll();
    $this->view->aPerfilAcoes = $aPerfilAcoes;
    $this->view->perfil       = $oPerfil;

  }

  /**
   * Adiciona as permissões de acesso do perfil
   */
  public function setPermissaoPerfilAction() {
    
    $iCodigoPerfil = $this->getRequest()->getParam('perfil');
    
    $aAcoes = $this->getRequest()->getParam('acao');
    
    $oPerfil = Administrativo_Model_Perfil::getById($iCodigoPerfil);
    
    $oPerfil->limparAcoes();
    
    $aPerfilAcao = array();
    
    foreach ($aAcoes as $id => $sAcao) {
      
      if ($sAcao === 'on') {
        
        $oAcao = Administrativo_Model_Acao::getById($id);
        $aPerfilAcao[] = $oAcao;
      }
    }
    
    if ($aPerfilAcao !== null) {
      
      $oPerfil->adicionaAcoes($aPerfilAcao);
      $iCodigoPerfil = $oPerfil->getId();
    }
  
    $this->_helper->getHelper('FlashMessenger')->addMessage(array('notice' => 'Permissões modificadas para o Perfil.'));
    $this->_redirector->gotoSimple('editar', 'perfil', 'administrativo', array('id' => $oPerfil->getId()));
  }

  /**
   * Adiciona permissões para o perfil
   */
  public function setPerfilPerfisAction() {
    
    $iCodigoPerfil = $this->getRequest()->getParam('id');
    $aPerfis       = $this->getRequest()->getParam('perfilperfis');
  
    $oPerfil = Administrativo_Model_Perfil::getById($iCodigoPerfil);
    $oPerfil->limparPerfis();
    
    $aPerfilPerfis = array();
     
    foreach ($aPerfis as $id => $sPerfil) {
      
      if ($sPerfil === 'on') {
        $aPerfilPerfis[] = Administrativo_Model_Perfil::getById($id);
      }
    }

    if ($aPerfilPerfis !== null) {
      
      $iCodigoPerfil = $oPerfil->getId();
      
      $oPerfil->adicionaPerfis($aPerfilPerfis);
    }
  
    $this->_helper->getHelper('FlashMessenger')->addMessage(array('notice' => 'Permissões para perfis modificadas para o Perfil.'));
    $this->_redirector->gotoSimple('editar', 'perfil', 'administrativo', array('id' => $oPerfil->getId()));
  }

  /**
   * Monta o formulário de cadastro de perfis
   *
   * @param string $sAction
   * @param null   $iId
   * @param array  $values
   * @return Twitter_Bootstrap_Form_Horizontal
   */
  private function formPerfil($sAction = 'novo', $iId = null, $values = array()) {
    
    $oForm          = new Twitter_Bootstrap_Form_Horizontal();
    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();

    if ($iId !== NULL) {
      $sAction .= "/id/{$iId}";
    }

    $oForm->setAction($oBaseUrlHelper->baseUrl('/administrativo/perfil/' . $sAction))->setMethod('post');

    if ($iId !== NULL) {

      $oElm = $oForm->createElement('hidden', 'id');
      $oElm->setValue($iId);
      $oForm->addElement($oElm);
    }


    $aTipos = Administrativo_Model_TipoUsuario::getLista();
    $oElm   = $oForm->createElement('select', 'tipo', array('multiOptions' => $aTipos));
    $oElm->setLabel('Tipo:');
    $oElm->setAttrib('ajax-url', $oBaseUrlHelper->baseUrl('/administrativo/usuario/get-contadores'));
    $oElm->setRequired(TRUE);

    if (isset($values['tipo'])) {
      $oElm->setValue($values['tipo']);
    }

    $oForm->addElement($oElm);

    $oElm = $oForm->createElement('text', 'nome');
    $oElm->setLabel('Nome');
    $oElm->setRequired();
    
    if (isset($values['nome'])) {
      $oElm->setValue($values['nome']);
    }
    
    $oForm->addElement($oElm);
    
    $oElm = $oForm->createElement('select', 'administrativo', array('multiOptions' => array('1' => 'Sim', '0'=>'Não')));
    $oElm->setLabel('Administrativo');

    if (isset($values['administrativo']) and ($values['administrativo'] == true)) {
      $oElm->setValue('1');
    } else {
      $oElm->setValue('0');
    }
    
    $oForm->addElement($oElm);
    $oForm->addElement('submit', 'submit', array(
      'label' => 'Salvar',
      'buttonType' => Twitter_Bootstrap_Form_Element_Submit::BUTTON_SUCCESS
    ));
    
    return $oForm;
  }

  /**
   * Busca os dados de um perfil
   *
   * @param string $sBusca
   * @return Twitter_Bootstrap_Form_Search
   */
  private function formBusca($sBusca = '') {
    
    return new Twitter_Bootstrap_Form_Search(array(
      'inputName'   => 'busca',
      'value'       => $sBusca,
      'submitLabel' => 'Buscar',
      'action'      => $this->view->baseUrl('administrativo/perfil/index')
    ));
  }
}