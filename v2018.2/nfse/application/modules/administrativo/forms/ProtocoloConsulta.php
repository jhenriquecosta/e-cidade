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
 * Formulário para Consulta dos Protocolos
 * 
 * @package Administrativo/Form
 * @author Luiz Marcelo Schmitt <luiz.marcelo@dbseller.com.br>
 */
class Administrativo_Form_ProtocoloConsulta extends Twitter_Bootstrap_Form_Horizontal {

  /**
   * Cria Formulário
   *
   * @see Zend_Form::init()
   */
  public function init() {

    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();

    $this->setName('formConsulta');
    $this->setMethod(Zend_form::METHOD_POST);
    $this->setAction($oBaseUrlHelper->baseUrl('/administrativo/protocolo/consulta-processar'));
    
    /**
     * Consulta usuários ativos
     */
    $aUsuarios   = Administrativo_Model_Usuario::getByAttributes(array (
      'habilitado' => true,
      'tipo'       => array(
         1, 2
      )
    ), array (
      'nome' => 'ASC'
    ));
    
    $aListaUsuarios = array('' => 'Selecione');

    foreach ($aUsuarios as $oUsuario) {
      $aListaUsuarios[$oUsuario->getId()] = trim(DBSeller_Helper_String_Format::wordsCap($oUsuario->getNome()));
    }
    
    $oElm = $this->createElement('select', 'usuario', array('multiOptions' => $aListaUsuarios, 'divspan' => '10'));
    $oElm->setLabel('Usuário/Contribuinte:');
    $oElm->setAttrib('class', 'input-xlarge span4');
    $oElm->setValue(NULL);
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'data_processamento_inicial', array('divspan' => '5'));
    $oElm->setLabel('Data Inicial:');
    $oElm->setAttrib('class', 'span2');
    $oElm->addValidator(new Zend_Validate_Date(array('locale' => 'pt-Br')));
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'data_processamento_final', array('divspan' => '5'));
    $oElm->setLabel('Data Final:');
    $oElm->setAttrib('class', 'span2');
    $oElm->addValidator(new Zend_Validate_Date(array('locale' => 'pt-Br')));
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('select', 'ordenacao', array('divspan' => '5'));
    $oElm->setLabel('Ordenação:');
    $oElm->setAttrib('class', 'span2');
    $oElm->addMultiOptions(array('asc' => 'Crescente', 'desc' => 'Decrescente'));
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'protocolo', array('divspan' => '5'));
    $oElm->setLabel('Número do Protocolo:');
    $oElm->setAttrib('class', 'span2');
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
        
    $this->addElement('submit', 'btn_consultar', array(
      'divspan'    => 2,
      'label'      => 'Consultar',
      'class'      => 'input-medium',
      'buttonType' => Twitter_Bootstrap_Form_Element_Button::BUTTON_PRIMARY,
    ));

    $this->addDisplayGroup(
      array(
        'usuario',
        'data_processamento_inicial',
        'data_processamento_final',
        'ordenacao',
        'protocolo',
        'btn_consultar'
      ),
      'dados_consulta',
      array('legend' => 'Parâmetros')
    );

    return $this;
  }
}