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
 * @author dbeverton.heckler
 */
class Administrativo_Form_ParametroContribuinte extends Twitter_Bootstrap_Form_Horizontal {

  public function __construct($aOptions = null) {
    parent::__construct($aOptions);        
  }

  public function init() {
    
    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();
    
    $oValidadores = array(
      0 => new Zend_Validate_Float(array('locale' => 'br')),
      1 => new Zend_Validate_LessThan(100),
      2 => new Zend_Validate_GreaterThan(-0.0000001)
    );
    
    $oElm = $this->createElement('hidden', 'im');
    $oElm->setRequired();
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'nome_contribuinte');
    $oElm->setLabel('Contribuinte:');
    $oElm->setAttrib('class','span6');
    $oElm->setAttrib('readonly', true);
    $oElm->setRequired();
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'max_deducao', array('append' => '%',
                                                            'description' => "'0' para desabilitar dedução"));
    $oElm->setLabel('Limite para dedução: ');
    $oElm->setValidators($oValidadores);
    $oElm->setAttrib('class', 'span1');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'pis', array('append' => '%'));
    $oElm->setLabel('PIS: ');
    $oElm->setValidators($oValidadores);
    $oElm->setAttrib('class', 'span1');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'cofins', array('append' => '%'));
    $oElm->setLabel('COFINS: ');
    $oElm->setValidators($oValidadores);
    $oElm->setAttrib('class', 'span1');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'inss', array('append' => '%'));
    $oElm->setLabel('INSS: ');
    $oElm->setValidators($oValidadores);
    $oElm->setAttrib('class', 'span1');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'ir', array('append' => '%'));
    $oElm->setLabel('IR: ');
    $oElm->setValidators($oValidadores);
    $oElm->setAttrib('class', 'span1');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'csll', array('append' => '%'));
    $oElm->setLabel('CSLL: ');
    $oElm->setValidators($oValidadores);
    $oElm->setAttrib('class', 'span1');
    $this->addElement($oElm);
    
    $this->addElement('submit', 'submit', array(
      'label' => 'Salvar',
      'buttonType' => Twitter_Bootstrap_Form_Element_Submit::BUTTON_SUCCESS
    ));
  }

  public function preenche($aDados) {
    
    if (isset($aDados['nome_contribuinte'])) {
      $this->getElement('nome_contribuinte')->setValue($aDados['nome_contribuinte']);
    }
    
    if (isset($aDados['max_deducao'])) {
      $this->getElement('max_deducao')->setValue($aDados['max_deducao']);
    }
    
    if (isset($aDados['pis'])) {
      $this->getElement('pis')->setValue($aDados['pis']);
    }
    
    if (isset($aDados['cofins'])) {
      $this->getElement('cofins')->setValue($aDados['cofins']);
    }
    
    if (isset($aDados['inss'])) {
      $this->getElement('inss')->setValue($aDados['inss']);
    }
    
    if (isset($aDados['ir'])) {
      $this->getElement('ir')->setValue($aDados['ir']);
    }

    if (isset($aDados['csll'])) {
      $this->getElement('csll')->setValue($aDados['csll']);
    }
  }
}