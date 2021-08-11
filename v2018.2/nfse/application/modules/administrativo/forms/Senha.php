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
 * Formulario para alteracao da senha do usuario
 */
class Administrativo_Form_Senha extends Twitter_Bootstrap_Form_Horizontal {
  
  public function init() {
    
    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();
    
    $oElm = $this->createElement('password', 'senha_antiga');
    
    $oElm->setLabel('Senha Atual');
    $oElm->addValidator(new Zend_Validate_StringLength(array('min' => 6)));
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);
    
    $oElm = $this->createElement('password', 'senha');
    $oElm->setLabel('Nova Senha');
    $oElm->addValidator(new Zend_Validate_StringLength(array('min' => 6)));
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);
    
    $oElm = $this->createElement('password', 'senha_confirma');
    $oElm->setLabel('Confirme Nova Senha');
    $oElm->addValidator(new Zend_Validate_Identical('senha'));
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);
    
    $this->addElement('submit', 'submit', array(
      'label'      => 'Salvar',
      'buttonType' => Twitter_Bootstrap_Form_Element_Submit::BUTTON_SUCCESS
    ));
    
    $this->addDisplayGroup(
      array('senha_antiga', 'senha', 'senha_confirma', 'submit'),
      'fieldset-senha',
      array('legend' => 'Alterar Senha')
    );
    
    return $this;
  }
}