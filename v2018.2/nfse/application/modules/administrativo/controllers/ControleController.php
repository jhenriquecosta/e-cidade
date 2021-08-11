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
 * Description of ModuloController
 *
 * @author guilherme
 */

class Administrativo_ControleController extends Administrativo_Lib_Controller_AbstractController {

  public function novoAction() {
    
    parent::noTemplate();
    
    $modulo = $this->getRequest()->getParam('m');
    $modulo = Administrativo_Model_Modulo::getById($modulo);
    $this->view->modulo = $modulo;

    $oForm = $this->formControle($modulo->getId());
    
    if ($this->getRequest()->isPost()) {
      
      if (!$oForm->isValid($_POST)) {
        
        $this->view->form = $oForm;
        $this->getResponse()->setHttpResponseCode(406);
      } else {
        
        $dados = $this->getRequest()->getPost();
        
        /* salva novo controle */
        $controle = new Administrativo_Model_Controle();
        $controle->setNome($dados['nome']);
        $controle->setVisivel($dados['visivel']);
        $controle->setIdentidade($dados['identidade']);
        $controle->setModulo($modulo->getEntity());
        $modulo->addControle($controle->getEntity());
        $modulo->persist();
        $this->_helper->getHelper('FlashMessenger')->addMessage(array('notice' => 'Controle criado.'));
      }
    }
    $this->view->form = $oForm;
  }

  public function editaAction() {
      
    parent::noTemplate();
    
    $id = $this->getRequest()->getParam('id');
    $modulo = $this->getRequest()->getParam('m');

    $controle = Administrativo_Model_Controle::getById($id);
    $modulo = Administrativo_Model_Modulo::getById($modulo);

    $this->view->modulo = $modulo;
    $oForm = $this->formControle($modulo->getId(),
                                '/administrativo/controle/edita', 
                                $id,
                                array('nome' => $controle->getNome(),
                                       'identidade' => $controle->getIdentidade(),
                                       'visivel' => $controle->getVisivel()));
    if ($this->getRequest()->isPost()) {
      
      if (!$oForm->isValid($_POST)) {
        
        $this->view->form = $oForm;
        $this->getResponse()->setHttpResponseCode(406);
      } else {
        
        $dados = $this->getRequest()->getPost();
        /* salva módulo */
        $controle->persist($dados);
        $this->_helper->getHelper('FlashMessenger')->addMessage(array('notice' => 'Controle modificado.'));
      }
    }
    $this->view->form = $oForm;
  }

  public function removeAction() {
      
    $id = $this->getRequest()->getParam('id');
    $controle = Administrativo_Model_Controle::getById($id);

    $controle->destroy();
    $this->_helper->getHelper('FlashMessenger')->addMessage(array('notice' => 'Controle removido.'));
    $this->_redirector->gotoSimple('index','modulo');
  }

  /**
   * Formulário para criação de novo Módulo
   * @return \Zend_Form 
   */
  private function formControle($modulo, $action = '/administrativo/controle/novo', $id = null, $values = array()) {

    $oForm = new Twitter_Bootstrap_Form_Vertical();
    $oForm->setAction($this->view->baseUrl($action))->setMethod('post')->setAttrib('id', 'form-controle');
    
    if ($id !== NULL) {
      
      $oElm = $oForm->createElement('hidden', 'id');
      $oElm->setValue($id);
      $oElm->setRequired(TRUE);
      $oForm->addElement($oElm);
    }

    $oElm = $oForm->createElement('hidden', 'm');
    $oElm->setValue($modulo);
    $oElm->setRequired(TRUE);
    $oForm->addElement($oElm);

    $oElm = $oForm->createElement('text', 'nome');
    $oElm->setLabel('Nome');
    
    if (isset($values['nome'])) {
      $oElm->setValue($values['nome']);
    }
    
    $oElm->setRequired(TRUE);
    $oForm->addElement($oElm);

    $oElm = $oForm->createElement('text', 'identidade');
    $oElm->setLabel('Identidade');
    
    if (isset($values['identidade'])) {
      $oElm->setValue($values['identidade']);
    }
    
    $oElm->setRequired(TRUE);
    $oForm->addElement($oElm);
    
    $oElm = $oForm->createElement('checkbox', 'visivel');
    $oElm->setLabel('Visibilidade');
    
    if (isset($values['visivel'])) {
      $oElm->setValue($values['visivel']);
    }
    
    $oElm->setRequired(TRUE);
    $oForm->addElement($oElm);
    
    return $oForm;
  }
}