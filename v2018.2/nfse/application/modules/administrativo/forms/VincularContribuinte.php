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
 * Description of Cadastro
 *
 * @author guilherme
 */
class Administrativo_Form_VincularContribuinte extends Twitter_Bootstrap_Form_Inline {
  
  public function init() {
    
    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();
    
    $this->setAction($oBaseUrlHelper->baseUrl('/administrativo/usuario/vincular'));
    $this->setAttrib('name', 'vincula');
    $this->setMethod('post');
    
    $oElm = $this->createElement('hidden', 'usuario');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('hidden', 'contribuinte');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('button', 'buscador', array(
      'label'        => '',
      'icon'         => 'search',
      'iconPosition' => Twitter_Bootstrap_Form_Element_Button::ICON_POSITION_LEFT
    ));
    
    $oElm = $this->createElement('text', 'inscricao_municipal', array(
      'placeholder' => 'Inscrição Municipal',
      'append'      => $oElm,
      'class'       => 'numerico'
    ));
    
    $oElm->setAttrib('url-buscador', $oBaseUrlHelper->baseUrl('/administrativo/usuario/get-contribuinte'));
    $oElm->setLabel('Vincular Contribuinte');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'nome_contribuinte');
    $oElm->setAttrib('readonly', true);
    $oElm->setAttrib('class', 'span7');
    $this->addElement($oElm);
    
    $this->addElement('submit', 'submit', array(
      'label'      => 'Vincular',
      'buttonType' => Twitter_Bootstrap_Form_Element_Submit::BUTTON_SUCCESS
    ));
    
    return $this;
  }
}