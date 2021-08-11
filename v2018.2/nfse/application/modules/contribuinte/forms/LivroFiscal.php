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
 * Formulário para Geração do Livro Fiscal
 * 
 * @package Contribuinte/Form
 */

/**
 * @package Contribuinte/Form
 */
class Contribuinte_Form_LivroFiscal extends Twitter_Bootstrap_Form_Horizontal {
  
  /**
   * (non-PHPdoc)
   * @see Zend_Form::init()
   */
  public function init() {
    
    $oBaseUrlHelper    = new Zend_View_Helper_BaseUrl();
    $oValidatorLength  = new Zend_Validate_StringLength(array('min' => 7, 'max' => 7));
    $oValidaData       = new Zend_Validate_Date(array('format' => 'MM/yyyy'));
    
    $this->setName('formLivroFiscal');
    $this->setMethod(Zend_form::METHOD_POST);
    $this->setAction($oBaseUrlHelper->baseUrl('/contribuinte/relatorio/livro-fiscal-gerar'));
    
    $oElm = $this->createElement('text', 'inscricao_municipal', array('divspan' => '4'));
    $oElm->setLabel('Inscrição Municipal:');
    $oElm->setAttrib('class', 'span2');
    $oElm->setAttrib('maxlength', '14');
    $oElm->setAttrib('data-url', $oBaseUrlHelper->baseUrl('/contribuinte/empresa/dados-cgm/'));
    $oElm->addFilter(new Zend_Filter_Digits());
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'razao_social', array('divspan' => '6'));
    $oElm->setLabel('Razão Social:');
    $oElm->setAttrib('class', 'span5');
    $oElm->setAttrib('disabled', 'true');
    $oElm->removeDecorator('errors');
    $oElm->setIgnore(TRUE);
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'data_competencia_inicial', array('divspan' => '4'));
    $oElm->setLabel('Competência Inicial:');
    $oElm->setAttrib('class', 'span2');
    $oElm->setAttrib('placeholder', 'Mês/Ano');
    $oElm->addValidators(array($oValidatorLength, $oValidaData));
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $oElm->setValue(date('m/Y'));
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'data_competencia_final', array('divspan' => '6'));
    $oElm->setLabel('Competência Final:');
    $oElm->setAttrib('class', 'span2');
    $oElm->setAttrib('placeholder', 'Mês/Ano');
    $oElm->addValidators(array($oValidatorLength, $oValidaData));
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $oElm->setValue(date('m/Y'));
    $this->addElement($oElm);
      
    $this->addElement('submit', 'btn_gerar', array(
      'divspan'     => 10,
      'label'       => 'Gerar Livro Fiscal',
      'class'       => 'span2',
      'msg-loading' => 'Aguarde...',
      'buttonType'  => Twitter_Bootstrap_Form_Element_Button::BUTTON_PRIMARY
    ));
    
    $this->addDisplayGroup(
      array(
        'inscricao_municipal',
        'razao_social',
        'data_competencia_inicial',
        'data_competencia_inicial_1',
        'data_competencia_final',
        'btn_gerar'
      ),
      'dados_consulta',
      array('legend' => 'Parâmetros')
    );
    
    return $this;
  }
}