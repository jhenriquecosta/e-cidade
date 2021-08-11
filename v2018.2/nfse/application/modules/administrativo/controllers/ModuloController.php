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
 * @package Administrativo\Controllers\ModuloController
 */
class Administrativo_ModuloController extends Administrativo_Lib_Controller_AbstractController {
  
  public function indexAction() {
    
    $this->view->modulos = Administrativo_Model_Modulo::getAll();
    $this->view->form = $this->formModulo();
  }
  
  public function novoAction() {
    
    parent::noTemplate();
    
    $oForm = $this->formModulo();
    
    if ($this->getRequest()->isPost()) {
      
      if (!$oForm->isValid($_POST)) {
        
        $this->view->formModulo = $oForm;
        $this->getResponse()->setHttpResponseCode(406);
      } else {
        
        $aDados = $this->getRequest()->getPost();
        
        // Salva novo módulo
        $oModulo = new Administrativo_Model_Modulo();
        $oModulo->persist($aDados);
        
        $this->_helper->getHelper('FlashMessenger')->addMessage(array('notice' => 'Módulo criado com sucesso.'));
      }
    }
    
    $this->view->formModulo = $oForm;
  }

  public function editaAction() {
    
    parent::noTemplate();
    
    $iIdModulo = $this->getRequest()->getParam('id');
    $oModulo   = Administrativo_Model_Modulo::getById($iIdModulo);
    $oForm     = $this->formModulo('/administrativo/modulo/edita', $iIdModulo, $oModulo);
    
    if ($this->getRequest()->isPost()) {
      
      if (!$oForm->isValid($_POST)) {
        
        $this->view->formModulo = $oForm;
        $this->getResponse()->setHttpResponseCode(406);
      } else {
        
        $aDados = $this->getRequest()->getPost();
        
        // Salva módulo
        $oModulo->persist($aDados);
        
        $this->_helper->getHelper('FlashMessenger')->addMessage(array('notice' => 'Módulo modificado com sucesso.'));
      }
    }
    
    $this->view->formModulo = $oForm;
  }
  
  public function removeAction() {
    
    $iIdModulo = $this->_getParam('id');
    $oModulo   = Administrativo_Model_Modulo::getById($iIdModulo);
    $oModulo->destroy();
    
    $this->_helper->getHelper('FlashMessenger')->addMessage(array('notice' => 'Módulo removido com sucesso.'));
    $this->_redirector->gotoSimple('index');
  }
  
  /**
   * Formulario para criacao de novo modulo
   * @return \Zend_Form 
   */
  private function formModulo($sAction = '/administrativo/modulo/novo', $iIdModulo = NULL, Administrativo_Model_Modulo $aDados = NULL) {
    
    $oForm = new Twitter_Bootstrap_Form_Vertical();
    $oForm->setAction($this->view->baseUrl($sAction))->setMethod('POST')->setAttrib('id', 'form-modulo');
    
    if ($iIdModulo) {
      
      $oElm = $oForm->createElement('hidden', 'id');
      $oElm->setValue($iIdModulo);
      $oElm->setRequired(TRUE);
      $oForm->addElement($oElm);
    }
    
    $oElm = $oForm->createElement('text', 'modulo');
    $oElm->setLabel('Nome');
    $oElm->setValue(($aDados != NULL && $aDados->getNome() != NULL ? $aDados->getNome() : NULL));
    $oElm->setRequired(TRUE);
    $oForm->addElement($oElm);
    
    $oElm = $oForm->createElement('text', 'identidade');
    $oElm->setLabel('Identidade');
    $oElm->setValue(($aDados != NULL && $aDados->getIdentidade() != NULL ? $aDados->getIdentidade() : NULL));
    $oElm->setRequired(TRUE);
    $oForm->addElement($oElm);
    
    $oElm = $oForm->createElement('checkbox', 'visivel');
    $oElm->setLabel('Visibilidade');
    $oElm->setValue(($aDados != NULL && $aDados->getVisivel() != NULL ? $aDados->getVisivel() : NULL));
    $oForm->addElement($oElm);
    
    return $oForm;
  }
}