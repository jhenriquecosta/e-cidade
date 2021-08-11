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
 * Classe de formulário para recuperacao da senha do usuario
 *
 * @package Auth/Form
 */

/**
 * @package Auth/Form
 */
Class Auth_Form_EsqueciMinhaSenha extends Twitter_Bootstrap_Form_Vertical {
  
  /**
   * Construtor da classe, utilizado padrão HTML para uso do TwitterBootstrap
   *
   * @param string $aOptions
   * @see Twitter_Bootstrap_Form_Horizontal
   */
  public function __construct($aOptions = NULL) {

    parent::__construct($aOptions);
  }
  
  /**
   * Construtor da classe, utilizado padrão HTML para uso do TwitterBootstrap
   * 
   * @see Zend_Form::init()
   */
  public function init() {
    
    $oTradutor      = $this->getTranslator();
    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();
    
    $this->setName('formEsqueciSenha');
    $this->setAction($oBaseUrlHelper->baseUrl('/auth/login/esqueci-minha-senha-post'));
    $this->setMethod('post');
    
    $oElm = $this->createElement('text', 'email');
    $oElm->setLabel('Email:');
    $oElm->setAttrib('class', 'span3');
    $oElm->addValidator(new Zend_Validate_EmailAddress());
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $this->addElement('submit', 'submit', array(
      'label'             => 'Recuperar Senha',
      'class'             => 'pull-right',
      'data-loading-text' => $oTradutor->_('Aguarde...'),
      'buttonType'        => Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY
    ));
    
    return $this;
  }
}