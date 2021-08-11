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
 * CLasse de formulário para a criação da Senha do usuário
 * 
 * @author Iuri Guntchnigg <iuri@dbseller.com.br>
 */
Class Default_Form_LiberacaoCadastro extends Twitter_Bootstrap_Form_Horizontal {
  
  /**
   * Construtor da classe, utilizado padrão HTML para uso do TwitterBootstrap
   *
   * @param string $aOptions
   * @see Twitter_Bootstrap_Form_Horizontal
   */
  public function __construct($aOptions = NULL) {
    parent::__construct($aOptions);
  }
  
  public function init() {
    
    $oTradutor      = $this->getTranslator();
    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();
    
    $this->setName('formLiberacaoUsuario');
    $this->setAction($oBaseUrlHelper->baseUrl('/default/cadastro-eventual/confirmar'));
    $this->setMethod('post');
    
    $oElm = $this->createElement('text', 'hash', array('divspan' => 9));
    $oElm->setLabel('Código Verificação:');
    $oElm->setAttrib('class', 'span7');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'cnpjcpf', array('divspan' => 9));
    $oElm->setLabel('CPF / CNPJ:');
    $oElm->setAttrib('class', 'span3 mask-cpf-cnpj');
    $oElm->setAttrib('maxlength', 18);
    $oElm->addValidator(new DBSeller_Validator_CpfCnpj());
    $oElm->addFilter(new Zend_Filter_Digits());
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oValidaTamanhoCampo = new Zend_Validate_StringLength();
    $oValidaTamanhoCampo->setMin('6');
    
    $sMensagemValidacao = $oTradutor->_(sprintf(
      'Os campos "<b>Senha</b>" e "<b>Confirme a Senha</b>" devem possuir no mínimo %s caracteres.',
      $oValidaTamanhoCampo->getMin()
    ));
    
    $oElm = $this->createElement('password', 'senha', array('divspan' => 9));
    $oElm->setLabel('Senha:');
    $oElm->setAttrib('minlength', $oValidaTamanhoCampo->getMin());
    $oElm->addValidator(new Zend_Validate_Identical('senharepetida'));
    $oElm->setAttrib('message-error', $sMensagemValidacao);
    $oElm->setAttrib('class', 'span3');
    $oElm->setRequired(TRUE);
    $oElm->addValidator($oValidaTamanhoCampo);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('password', 'senharepetida', array('divspan' => 10));
    $oElm->setLabel('Confirme a Senha:');
    $oElm->setAttrib('class', 'span3');
    $oElm->setAttrib('minlength', $oValidaTamanhoCampo->getMin());
    $oElm->addValidator(new Zend_Validate_Identical('senha'));
    $oElm->addValidator($oValidaTamanhoCampo);
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $this->addDisplayGroup(
      array('hash', 'cnpjcpf', 'senha', 'senharepetida'),
      'dados_liberacao',
      array('legend' => 'Confirme seu Cadastro')
     );
    
    $this->addElement('submit', 'confirmar', array(
      'label'       => 'Confirmar',
      'style'       => 'margin-left:30px',
      'buttonType'  => Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY
    ));
  }
}