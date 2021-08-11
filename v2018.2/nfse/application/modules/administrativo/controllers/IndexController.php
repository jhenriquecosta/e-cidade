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
 * Classe para controle administrativo
 * 
 * @package Administrativo/controllers
 */

/**
 * @package Administrativo/controllers
 */
class Administrativo_IndexController extends Administrativo_Lib_Controller_AbstractController {
  
  /**
   * Tela inicial do módulo administrativo
   * 
   * @return void
   */
  public function indexAction() {
    $this->view->oculta_breadcrumbs = TRUE;
  }
  
  /**
   * Tela para escolha do contribuinte
   * 
   * @return void
   */
  public function contribuinteAction() {
    
    $this->view->contribuintes = $this->view->user->getContribuintes();
    
    if (count($this->view->contribuintes) == 1) {
      
      $aContribuinte = each($this->view->contribuintes);
      $oContribuinte = $aContribuinte['value'];
      $this->_redirector->gotoSimple(
        'set-contribuinte', 
        'index', 
        'administrativo', 
        array('id' => $oContribuinte->inscricao)
      );
    }
  }
  
  /**
   * Seta o contribuinte na sessão
   * 
   * @return void
   */
  public function setContribuinteAction() {
    
    $iId           = $this->getRequest()->getParam('id');
    $aContribuinte = Administrativo_Model_Contribuinte::getByIm($iId);
    $oContribuinte = $aContribuinte[0];
    
    $this->_session->im   = $oContribuinte->inscricao;
    $this->_session->nome = $oContribuinte->nome;
    
    $this->_redirector->gotoSimple('index');
  }
}