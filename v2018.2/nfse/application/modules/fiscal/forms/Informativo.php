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
 * Classe genérica para criação de informativos do Fiscal para o Contribuinte
 * @author Roberto Carneiro <roberto@dbseller.com.br>
 * @package Fiscal
 */
class Fiscal_Form_Informativo extends Twitter_Bootstrap_Form_Horizontal {

  /**
   * Método construtor
   *
   * (non-PHPdoc)
   * @see Zend_Form::init()
   */
  public function init() {
    
    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();

    $this->setName('formInformativo');
    $this->setMethod(Zend_form::METHOD_POST);
    $this->setAction($oBaseUrlHelper->baseUrl('/fiscal/informativo/form-salvar'));
    
    $oElm = $this->createElement('textarea', 'descricao', array('divspan' => 10));
    $oElm->setLabel('Descrição do Informativo:');
    $oElm->setAttrib('class', 'span9 exibir-contador-maxlength');
    $oElm->setAttrib('rows', '15');
    $oElm->setAttrib('maxlength', 1600);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $this->addElement('button', 'btn_salvar', array(
      'divspan'     => 10,
      'label'       => 'Salvar',
      'class'       => 'span2',
      'msg-loading' => 'Aguarde...',
      'buttonType'  => Twitter_Bootstrap_Form_Element_Button::BUTTON_PRIMARY
    ));
    
    $this->addDisplayGroup(
       array(
           'descricao',
           'btn_salvar'
       ),
       'dados_informativo',
       array('legend' => 'Informativo')
    );

    return $this;
  }
}