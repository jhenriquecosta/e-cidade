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
 * Classe para controle do módulo do fiscal
 *
 * @package Fiscal/Controllers
 * @see Fiscal_Lib_Controller_AbstractController
 */

/**
 * @package Fiscal/Controllers
 * @see Fiscal_Lib_Controller_AbstractController
 */
class Fiscal_UsuarioAcessoController extends Fiscal_Lib_Controller_AbstractController {

  /**
   * Lista todos os usuarios do sistema para o fiscal
   * poder acessa-lo
   */
  public function listarCadastrosAction() {

    // retornar os contadores e contribuintes
    $aParametros = array (
      'habilitado' => true,
      'tipo'       => array(
         1, 2
      )
    );

    $aOrdem = array (
      'nome' => 'ASC'
    );

    $oUsuarios = Administrativo_Model_Usuario::getByAttributes($aParametros, $aOrdem);

    $this->view->aUsuarios = $oUsuarios;

  }


  public function setUsuarioAction() {

    $this->_session->iUsuarioEscolhido = $this->getRequest()->getParam('id');
    $this->_redirector->gotoSimple('contribuinte', 'index', 'contribuinte');
  }
}