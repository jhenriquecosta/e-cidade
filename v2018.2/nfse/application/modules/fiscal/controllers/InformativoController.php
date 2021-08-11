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
 * Classe para controle do informativo
 * @author Roberto Carneiro <roberto@dbseller.com.br>
 * @package Fiscal/Controllers
 */

class Fiscal_InformativoController extends Fiscal_Lib_Controller_AbstractController {

  /**
   * Tela para alteração do informativo já inserir, seja pelo fiscal ou pelo migration(padrão)
   */
  public function formAction () {
     
    $oForm        = new Fiscal_Form_Informativo();
    $oInformativo = Administrativo_Model_Informativo::getByAttribute('id', 1);

    if (!empty($oInformativo)) {
      
      $oForm->populate(array(
    	 'descricao' => $oInformativo->getDescricao()
      ));
    } else {

      $oInformativo = new Administrativo_Model_Informativo();
      $oInformativo->inserePadrao();
    }
    
    $this->view->form = $oForm;
    $this->render('view-compartilhada');
  }

  /**
   * Salva o informativo disponibilizado no textarea
   */
  public function formSalvarAction() {

    parent::noLayout();
    
    $aParametros  = $this->getRequest()->getParams();
    $oForm        = new Fiscal_Form_Informativo();
    $oForm->populate($aParametros);
    
    /**
     * Parametros de retorno do AJAX
    */
    $aRetornoJson = array(
        'success' => FALSE,
        'message' => NULL
    );
    
    if (!$oForm->isValid($aParametros)) {
    
      $aRetornoJson['fields']  = array_keys($oForm->getMessages());
      $aRetornoJson['error'][] = 'Preencha os dados corretamente.';
    } else {
    
      try {
    
        // salvar
        $oInformativo = new Administrativo_Model_Informativo();
        
        $oInformativo->salvarDescricao($aParametros['descricao']);
        
        $aRetornoJson['success'] = TRUE;
        $aRetornoJson['message'] = 'Informativo salvo com sucesso!';
        
      } catch (Exception $oErro) {
        $aRetornoJson['error'][] = $oErro->getMessage();
      }
    }
    
    echo $this->getHelper('json')->sendJson($aRetornoJson);    
  }
}