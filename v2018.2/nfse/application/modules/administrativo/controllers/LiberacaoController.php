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


class Administrativo_LiberacaoController extends Administrativo_Lib_Controller_AbstractController {

  public function indexAction() {
    
    $im                         = $this->getRequest()->getParam('im');
    $req                        = $this->getRequest()->getParam('req');
    $config                     = Administrativo_Model_Prefeitura::getDadosPrefeituraBase();
    $sControleAidof             = $config->getControleAidof();
    $this->view->sControleAidof = $sControleAidof;
    
    if ($req !== null) {
      
      $requisicao = Administrativo_Model_Aidof::getById($req);
      $im = $requisicao->getIm();
      $contribuinte = $requisicao->getContribuinte();
      $liberacaoForm = $this->liberacaoForm($contribuinte, $requisicao, $sControleAidof);
      $this->view->liberacaoForm = $liberacaoForm;
    } else {
      
      $contribuinte = Administrativo_Model_Contribuinte::getByIm($im);
      $contribuinte = $contribuinte[0];
    }
    
    if ($contribuinte != null || !empty($contribuinte)) {
      
      $this->view->contribuinte_nome = $contribuinte->attr('nome');
      
      if ($this->getRequest()->isPost()) {
        
        if ($liberacaoForm->isValid($_POST)) {
          
          $dados = $this->getRequest()->getPost();
          
          if ((isset($dados['nota_limite']) && $dados['nota_limite'] != null) && 
              (isset($dados['data_limite']) && $dados['data_limite'] != null)) {
            
            $this->view->messages[] = array(
              'error' => 'Informe apenas um dos campos. Ou limite por nota, ou limite por data.'
            );
          } else {
            
            $liberacao = Administrativo_Model_Aidof::getById($req);
            
            if ($liberacao->getDataLiberacao() == null) {
              
              $liberacao->setDataLiberacao(new Datetime());
              $dados['situacao'] = 'l';
              
              if ($sControleAidof == 'data') {
                
                $auxData = str_replace('/', '-', $this->_getParam('data_liberada'));
                $auxData = new DateTime($auxData);
                $auxData->format('Y-m-d H:i:s');
                
                $dados['data_liberada'] = $auxData;
              }
              
              $liberacao->persist($dados);
              
              $this->view->messages[] = array('success' => 'Liberação cadastrada com sucesso.');
              $this->view->historico = Administrativo_Model_Aidof::getByAttribute('im', $im);
              
              $this->_redirector->gotoSimple('index', 'liberacao', 'administrativo', array('im' => $im));
            } else {
              $this->_redirector->gotoSimple('index', 'liberacao', 'administrativo');
            }
          }
        }
      }
    }
    
    $this->view->historico = Administrativo_Model_Aidof::getLiberacoes($im);
    $this->view->liberacao = $sControleAidof;
    $this->view->requisicoes = Administrativo_Model_Aidof::getRequisicoesPendentes();
  }
  
  public function rpsAction() {
    
    $im                          = $this->getRequest()->getParam('im');
    $req                         = $this->getRequest()->getParam('req');
    $requisicao                  = null;
    $config                      = Administrativo_Model_Prefeitura::getDadosPrefeituraBase();
    $sControleAidof              = $config->getControleAidof();
    $contribuinte                = Administrativo_Model_Contribuinte::getByIm($im);
    $this->view->sControleAidof  = $sControleAidof;
    
    if ($req !== null) {
      
      $requisicao                = Administrativo_Model_Aidof::getById($req);
      $im                        = $requisicao->getIm();
      $this->view->liberacaoForm = $this->liberacaoRpsForm($requisicao->getContribuinte(), $requisicao, $sControleAidof);
    }
    
    if ($contribuinte != null || !empty($contribuinte)) {
      
      $this->view->contribuinte_nome = $contribuinte[0]->attr('nome');
      $liberacaoForm = $this->liberacaoRpsForm($contribuinte, $requisicao, $sControleAidof);
      
      if ($this->getRequest()->isPost()) {
        
        if ($liberacaoForm->isValid($_POST)) {
          
          $dados = $this->getRequest()->getPost();
          
          if ((isset($dados['nota_limite']) && $dados['nota_limite'] != null) && 
              (isset($dados['data_limite']) && $dados['data_limite'] != null)) {
            
            $this->view->messages[] = array(
              'error' => 'Informe apenas um dos campos. Ou limite por rps, ou limite por data.'
            );
          } else {
            
            $liberacao = Administrativo_Model_Aidof::getById($req);
            
            if ($liberacao->getDataLiberacao() == null) {
              
              $liberacao->setDataLiberacao(new Datetime());
              $dados['situacao'] = 'l';
              
              if ($sControleAidof == 'data') {
                
                $auxData = str_replace('/', '-', $this->_getParam('data_liberada'));
                $auxData = new DateTime($auxData);
                $auxData->format('Y-m-d H:i:s');
                
                $dados['data_liberada'] = $auxData;
              }
              
              $liberacao->persist($dados);
              
              $this->view->messages[] = array('success' => 'Liberação cadastrada com sucesso.');
            } else {
              $this->_redirector->gotoSimple('rps', 'liberacao', 'administrativo');
            }
          }
        }
      }
      
      $this->view->historico = Administrativo_Model_Aidof::getRequisicoes($im, 'r');
    }

    $this->view->requisicoes = Administrativo_Model_Aidof::getRequisicoesPendentes(null, 'r');
  }

  public function getContribuinteAction() {

    $this->setAjaxContext('getContribuinte');
    
    $term   = $this->getRequest()->getParam('term');
    $dados  = Administrativo_Model_Contribuinte::getByIm($term);
    
    if ($dados == null || empty($dados)) {
      echo json_encode(null);
    } else {
      echo json_encode($dados[0]->toArray());
    }
  }

  /**
   * @param array $contribuinte
   * @return \Twitter_Bootstrap_Form_Vertical
   */
  private function liberacaoForm($contribuinte, $requisicao, $liberacao) {
    
    $oForm = new Twitter_Bootstrap_Form_Vertical(array('addDecorator' => array(array('Wrapper'))));

    if (is_array($contribuinte) && !empty($contribuinte)) {
      $contribuinte = $contribuinte[0];
    }
    
    if (!is_object($contribuinte)) {
      throw new Zend_Exception("Contribuinte não informado");
    }
    
    $oForm->setAction($this->view->baseUrl('/administrativo/liberacao/index/im/' . $contribuinte->attr('inscricao')));
    
    if ($requisicao !== null) {
      
      $oElm = $oForm->createElement('hidden', 'req');
      $oElm->setValue($requisicao->getId());
      $oForm->addElement($oElm);
    }

    $oElm = $oForm->createElement('hidden', 'im');
    $oElm->setValue($contribuinte->attr('inscricao'));
    $oElm->setRequired();
    $oForm->addElement($oElm);

    $oElm = $oForm->createElement('text', 'nome_contribuinte', array('divspan' => 4));
    $oElm->setLabel('Contribuinte: ');
    $oElm->setValue($contribuinte->attr('nome'));
    $oElm->setAttrib('class', 'span4');
    $oElm->setAttrib('readonly', true);
    $oElm->setRequired();
    $oForm->addElement($oElm);
    
    if ($liberacao == 'quantidade') {
      
      $oElm = $oForm->createElement('text', 'qtd_liberada', array('divspan' => 2));
      $oElm->setLabel('Limite de notas: ');
      $oElm->setValidators(array(new Zend_Validate_Int()));
      
      if ($requisicao !== null) {
        $oElm->setValue($requisicao->getQtdRequerida());
      }
      
      $oElm->setAttrib('class', 'span2');
      $oForm->addElement($oElm);
    } else {
      
      $oElm = $oForm->createElement('text', 'data_liberada', array('divspan' => 2));
      $oElm->setLabel('Limite por data: ');
      $oElm->setValidators(array(new Zend_Validate_Date(array('format' => 'dd/mm/yyyy'))));
      
      if ($requisicao !== null) {
        $oElm->setValue($requisicao->getDataRequeridaString());
      }
      
      $oElm->setAttrib('class', 'span2 mask-data');
      $oForm->addElement($oElm);
    }
    
    $oForm->addElement('submit', 'submit', array(
      'label'      => 'Salvar',
      'style'      => 'margin-top:25px',
      'divspan'    => 3,
      'buttonType' => Twitter_Bootstrap_Form_Element_Submit::BUTTON_SUCCESS
    ));
    
    return $oForm;
  }
    
  private function liberacaoRpsForm($contribuinte, $requisicao, $liberacao) {
    
    $oForm = new Twitter_Bootstrap_Form_Vertical(array('addDecorator' => array(array('Wrapper'))));
      
    if (is_array($contribuinte) && !empty($contribuinte)) {
      $contribuinte = $contribuinte[0];
    }
    
    $oForm->setAction($this->view->baseUrl('/administrativo/liberacao/rps/im/' . $contribuinte->attr('inscricao')));
    
    if ($requisicao !== null) {
      
      $oElm = $oForm->createElement('hidden', 'req');
      $oElm->setValue($requisicao->getId());
      $oForm->addElement($oElm);
    }
    
    $oElm = $oForm->createElement('hidden', 'im');
    $oElm->setValue($contribuinte->attr('inscricao'));
    $oElm->setRequired();
    $oForm->addElement($oElm);
    
    $oElm = $oForm->createElement('text', 'nome_contribuinte', array('divspan' => 4));
    $oElm->setLabel('Contribuinte: ');
    $oElm->setValue($contribuinte->attr('nome'));
    $oElm->setAttrib('class', 'span4');
    $oElm->setAttrib('readonly', true);
    $oElm->setRequired();
    $oForm->addElement($oElm);
    
    if ($liberacao == 'quantidade') {
      
      $oElm = $oForm->createElement('text', 'qtd_liberada', array('divspan' => 2));
      $oElm->setLabel('Limite de notas: ');
      $oElm->setValidators(array(new Zend_Validate_Int()));
      
      if ($requisicao !== null) {
        $oElm->setValue($requisicao->getQtdRequerida());
      }
      
      $oElm->setAttrib('class', 'span2');
      $oForm->addElement($oElm);
    } else {
      
      $oElm = $oForm->createElement('text', 'data_liberada', array('divspan' => 2));
      $oElm->setLabel('Limite por data: ');
      $oElm->setValidators(array(new Zend_Validate_Date(array('format' => 'dd/mm/yyyy'))));
      
      if ($requisicao !== null) {
       $oElm->setValue($requisicao->getDataRequeridaString());
      }
      
      $oElm->setAttrib('class', 'span2 mask-data');
      $oForm->addElement($oElm);
    }
    
    $oForm->addElement('submit', 'submit', array(
      'label'      => 'Salvar',
      'style'      => 'margin-top:25px',
      'divspan'    => 3,
      'buttonType' => Twitter_Bootstrap_Form_Element_Submit::BUTTON_SUCCESS
    ));
    
    return $oForm;
  }
}