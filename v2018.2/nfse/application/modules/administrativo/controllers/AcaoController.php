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
   * Controller responsável pela manipulação das ações
   * @package Administrativo\Controllers\AcaoController
   * Class Administrativo_AcaoController
   */
class Administrativo_AcaoController extends Administrativo_Lib_Controller_AbstractController {
  
  /**
   * Metodo para cadastrar uma nova acao
   */
  public function novoAction() {
    
    parent::noTemplate();
    
    $iControle = $this->getRequest()->getParam('c');
    $oControle = Administrativo_Model_Controle::getById($iControle);
    
    $this->view->controle = $oControle;
    
    $oForm = $this->formAcao($oControle->getId());
    
    if ($this->getRequest()->isPost()) {
      
      if (!$oForm->isValid($_POST)) {
        
        $this->view->form = $oForm;
        $this->getResponse()->setHttpResponseCode(502);
      } else {
        
        $aDados = $this->getRequest()->getPost();
        
        // Salva novo action
        $oAcao = new Administrativo_Model_Acao();
        $oAcao->setNome($aDados['nome']);
        $oAcao->setAcaoAcl($aDados['acaoacl']);
        $oAcao->setSubAcoes($aDados['sub_acoes']);
        $oAcao->setGeradorDados($aDados['gerador_dados']);
        
        $oAcao->setControle($oControle->getEntity());
        $oControle->addAcao($oAcao->getEntity());
        $oControle->persist();
        
        $this->_helper->getHelper('FlashMessenger')->addMessage(array('success' => 'Ação criada com sucesso.'));
      }
    }
    
    $this->view->form = $oForm;
  }

  /**
   * metodo para editar as ações
   */
  public function editaAction() {
    
    parent::noTemplate();
    
    $iIdAcao              = $this->getRequest()->getParam('id');
    $iIdControle          = $this->getRequest()->getParam('c');
    $oControle            = Administrativo_Model_Controle::getById($iIdControle);
    $oAcao                = Administrativo_Model_Acao::getById($iIdAcao);
    $this->view->controle = $oControle;

    $oForm                = $this->formAcao($oControle->getId(),
                                            '/administrativo/acao/edita',
                                            $iIdAcao, 
                                            array('nome'         => $oAcao->getNome(),
                                                  'acaoacl'       => $oAcao->getAcaoAcl(),
                                                  'sub_acoes'     => $oAcao->getSubAcoes(),
                                                  'gerador_dados' => $oAcao->getGeradorDados()));

    if ($this->getRequest()->isPost()) {
      
      if (!$oForm->isValid($_POST)) {
        
        $this->view->form = $oForm;
        $this->getResponse()->setHttpResponseCode(406);
      } else {
        
        $aDados = $this->getRequest()->getPost();
       
        $oAcao->persist($aDados);
        $this->_helper->getHelper('FlashMessenger')->addMessage(array('notice' => 'Ação modificada.'));
      }
    }
    
    $this->view->form = $oForm;
  }
  
  /**
   * Metodo para remover uma acao
   */
  public function removeAction() {
    
    $iIdAcao = $this->getRequest()->getParam('id');
    $oAcao = Administrativo_Model_Acao::getById($iIdAcao);
    $oAcao->destroy();
    
    $this->_helper->getHelper('FlashMessenger')->addMessage(array('notice' => 'Ação removida.'));
    $this->_redirector->gotoSimple('index', 'modulo');
  }
  
  /**
   * Formulário para criação de nova acao
   *
   * @param        $sControle
   * @param string $sAction
   * @param null   $idAcao
   * @param array  $aDados
   *
   * @return Administrativo_Form_Acao
   */
  private function formAcao($sControle, $sAction = '/administrativo/acao/novo', $idAcao = null, $aDados = array()) {
    
    $oForm = new Administrativo_Form_Acao();
    $oForm->setAction($this->view->baseUrl($sAction));
    
    if ($idAcao) {
      $aDados['id'] = $idAcao;
    }
    
    if ($sControle) {
      $aDados['c']  = $sControle;
    }
    
    $oForm->preenche($aDados);
    
    return $oForm;
  }
}