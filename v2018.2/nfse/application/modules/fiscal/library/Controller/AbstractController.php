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
 * Classe para reunir os m�todos em comum no m�dulo fiscal
 *
 * @package Fiscal/Library
 */

/**
 * @package Fiscal/Library
 */
class Fiscal_Lib_Controller_AbstractController extends Global_Lib_Controller_AbstractController {

  /**
   * M�todo construtor
   */
  public function init() {
    
    parent::init();
    parent::checkIdentity();
    self::alteraUser();

  }

  public function alteraUser () {

    // retorna os dados do fiscal para o sistema.
    if (isset($this->_session->iUsuarioEscolhido)) {

      // Seta os dados do usuário logado no sistema
      $aLogin                     = Zend_Auth::getInstance()->getIdentity();

      $oUsuarioLogado             = Administrativo_Model_Usuario::getByAttribute('login', $aLogin['login']);
      $this->user                 = $oUsuarioLogado;
      $this->view->user           = $oUsuarioLogado;
      $this->view->layout()->user = $oUsuarioLogado;

      $this->_session->id           = NULL;
      $this->_session->contribuinte = NULL;

      unset($this->_session->iUsuarioEscolhido);

      // Reseta permissões
      new DBSeller_Acl_Setup(TRUE);
    }


  }
}