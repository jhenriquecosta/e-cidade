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
 * Classe para manipulação do formulário de importação de arquivo
 * 
 * @package Contribuinte/Forms
 */

/**
 * @package Contribuinte/Forms
 */
class Contribuinte_Form_ImportacaoArquivo extends Twitter_Bootstrap_Form_Horizontal {
  
  /**
   * (non-PHPdoc)
   * @see Zend_Form::init()
   */
  public function init() {
    
    $this->setName('form1');
    $this->setMethod(Zend_Form::METHOD_POST);
    
    $oElm = $this->createElement('submit', 'submit', array(
      'label'      => 'Processar',
      'buttonType' => Twitter_Bootstrap_Form_Element_Submit::BUTTON_SUCCESS)
    );
    
    $oElm->setOrder(100);
    $this->addElement($oElm);
    
    return $this;
  }
  
  /**
   * Renderiza os campos para importação de DMS
   * 
   * @return Contribuinte_Form_ImportacaoArquivo
   */
  public function renderizaCamposDms() {
    
    $oElm = $this->createElement('file', 'arquivo');
    $oElm->setLabel('Arquivo: ');
    $oElm->setAttrib('class', 'input');
    $oElm->setAttrib('accept', '*/*'); // Android
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);
    
    return $this;
  }
  
  /**
   * Renderiza os campos para importação de RPS
   * 
   * @return Contribuinte_Form_ImportacaoArquivo
   */ 
  public function renderizaCamposRPS() {
    
    // Validador do xml
    $oValidaXml = new Zend_Validate_File_MimeType(array('application/xml'));
    $oValidaXml->setMessages(array(
      Zend_Validate_File_MimeType::FALSE_TYPE   => 'O arquivo "%value%" não possui o formato "XML".',
      Zend_Validate_File_MimeType::NOT_DETECTED => 'O arquivo "%value%" é inválido ou está corrompido.'
    ));
    
    $oElm = $this->createElement('file', 'arquivo');
    $oElm->setLabel('Arquivo XML: ');
    $oElm->setAttrib('class', 'input');
    $oElm->setAttrib('accept', '*/*'); // Android
    $oElm->addValidator($oValidaXml);
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);  
    
    return $this;
  }
}