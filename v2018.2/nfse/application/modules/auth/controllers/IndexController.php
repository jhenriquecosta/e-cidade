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
 * Controle das autenticações
 *
 * @package Auth/Controllers
 * @see Auth_Lib_Controller_AbstractController
 */

/**
 * @package Auth/Controllers
 * @see Auth_Lib_Controller_AbstractController
 */
class Auth_IndexController extends Auth_Lib_Controller_AbstractController {

  /**
   * Construtor da classe
   *
   * @see Auth_Lib_Controller_AbstractController::init()
   */
  public function init() {

    parent::init();
  }

  /**
   * Tela padrão para o módulo de autenticação
   */
  public function indexAction() {

    // Redireciona para a tela de login
    $this->redirect($this->view->baseUrl('/auth/login'));
  }
}