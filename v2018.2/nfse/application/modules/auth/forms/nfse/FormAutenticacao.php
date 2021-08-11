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
 * Formulário para autenticação/verificação de NFSe
 *
 * @package Adminstrativo/Forms
 * @see     Twitter_Bootstrap_Form_Vertical
 */

/**
 * @package Adminstrativo/Forms
 * @see     Twitter_Bootstrap_Form_Vertical
 */
class Auth_form_nfse_FormAutenticacao extends Twitter_Bootstrap_Form_Vertical {

  /**
   * Construtor da classe
   *
   * @return $this|void
   */
  public function init() {

    $oTradutor      = $this->getTranslator();
    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();

    $this->setName('form_autenticacao')->setAction($oBaseUrlHelper->baseUrl('/auth/nfse/autenticar-post'));

    $oElm = $this->createElement('text', 'prestador_cnpjcpf');
    $oElm->setLabel('CPF / CNPJ Prestador');
    $oElm->setAttrib('class', 'span3 mask-cpf-cnpj');
    $oElm->setAttrib('autofocus', 'autofocus');
    $oElm->addFilter(new Zend_Filter_Digits());
    $oElm->addValidator(new DBSeller_Validator_CpfCnpj());
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'numero_rps');
    $oElm->setLabel('Número do RPS');
    $oElm->setAttrib('class', 'span3 mask-numero');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'codigo_verificacao');
    $oElm->setLabel('Código de Verificação');
    $oElm->setAttrib('class', 'span3');
    $this->addElement($oElm);

    $this->addElement('submit', 'btn_verificar', array(
      'label'             => 'Verificar NFSe',
      'class'             => 'pull-right',
      'data-loading-text' => $oTradutor->_('Aguarde...'),
      'buttonType'        => Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY
    ));

    $this->addDisplayGroup(
      array('prestador_cnpjcpf', 'numero_rps', 'codigo_verificacao', 'btn_verificar'),
      'verificacao_nfse',
      array('legend' => 'Verificação de NFSe')
    );

    return $this;
  }
}