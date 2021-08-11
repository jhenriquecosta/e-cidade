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
 * Controle da sessão
 *
 * @package Auth/Controller
 */

/**
 * @package Auth/Controller
 */
class Auth_SessaoController extends Auth_Lib_Controller_AbstractController {

  /**
   * Construtor da classe
   *
   * @see Auth_Lib_Controller_AbstractController::init()
   */
  public function init() {

    parent::init();
  }
  
  /**
   * Retorna o status da sessao para verificacao de sessao via ajax
   */
  public function verificarAction() {
    
    $aRetornoJson['message'] = $this->translate->_('Sua sessão foi encerrada, efetue o login novamente.');
    $aRetornoJson['url']     = $this->view->baseUrl('/auth/login');
    
    try {
      
      $bAutenticado           = Zend_Auth::getInstance()->getIdentity();
      $aRetornoJson['status'] = $bAutenticado;
      
      if ($bAutenticado) {
        unset($aRetornoJson['message'], $aRetornoJson['url']);
      }
    } catch (Exception $e) {
      $aRetornoJson['status']  = FALSE;
    }
    
    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }
}