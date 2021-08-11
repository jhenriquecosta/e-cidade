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


class Contribuinte_Form_RequisicaoAidof extends Twitter_Bootstrap_Form_Horizontal {
  
  public function init() {
    
    $this->setMethod('post');
    
    $oElm = $this->createElement('select', 'cgm_grafica');
    $oElm->setLabel('Gráfica:');
    $oElm->setAttrib('class', 'input');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);
    
    self::setGrafica();
    
    $oElm = $this->createElement('select', 'tipo_documento');
    $oElm->setLabel('Tipo de Documento:');
    $oElm->setAttrib('class', 'input');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'quantidade');
    $oElm->setLabel('Quantidade:');
    $oElm->setAttrib('class', 'input-small mask-numero');
    $oElm->setAttrib('maxlength', 5);
    $oElm->addValidator(new Zend_Validate_Callback(function($value){ return $value > 0; }));
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);
      
    $this->addElement('submit', 'submit', array(
      'label'      => 'Enviar',
      'buttonType' => Twitter_Bootstrap_Form_Element_Submit::BUTTON_SUCCESS)
    );
    
    $this->addDisplayGroup(
      array('cgm_grafica', 'tipo_documento', 'quantidade', 'submit'), 
      'fieldset_requisicao', 
      array('legend' => 'Enviar Requisição')
    );
    
    return $this;
  }
  
  public function setGrafica($sCgmGrafica = NULL) {
    
    $aGraficas = Administrativo_Model_Grafica::listarEmArray();
    
    $this->cgm_grafica->addMultiOptions($aGraficas);
    $this->cgm_grafica->setValue($sCgmGrafica);
  }
  
  public function preenche($aDados = NULL) {
    
    if (!is_array($aDados)) {
      return $this;
    }
    
    if (is_object($this->tipo_documento) && isset($aDados['tipo_documento'])) {
      $this->tipo_documento->setValue($aDados['tipo_documento']);
    }
    
    if (is_object($this->cgm_grafica) && isset($aDados['cgm_grafica'])) {
      self::setGrafica($aDados['cgm_grafica']);
    }
    
    if (is_object($this->quantidade) && isset($aDados['quantidade'])) {
      $this->quantidade->setValue($aDados['quantidade']);
    }
    
    return $this;
  }
}