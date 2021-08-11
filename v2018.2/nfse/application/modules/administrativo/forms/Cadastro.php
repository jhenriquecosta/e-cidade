<?php

/**
 * Description of Cadastro
 */
class Administrativo_Form_Cadastro extends Twitter_Bootstrap_Form_Horizontal {
  
  private $confirmacao = NULL;
  
  public function __construct($lConfirmacao = FALSE, $aOptions = NULL) {
    
    $this->confirmacao = $lConfirmacao;
    
    parent::__construct($aOptions);
  }

  public function init() {
    
    $this->setAction('/default/index/cadastro')->setMethod('post');
    
    $oElm = $this->createElement('hidden', 'id');
    $this->addElement($oElm);
    
    $aTipos = array(
      1   => 'Contador',
      2   => 'Contribuinte Prestador',
      3   => 'Contribuinte Tomador',
      4   => 'Gráfica'
    );
    
    $oElm = $this->createElement('select', 'tipo', array('multiOptions' => $aTipos));
    $oElm->setLabel('Tipo:');
    $oElm->setAttrib('class', 'span3');
    $oElm->setOptions($aTipos);
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'cpfcnpj');
    $oElm->setLabel('CPF / CNPJ:');
    $oElm->setAttrib('class', 'span3 mask-cpf-cnpj');
    $oElm->setAttrib('maxlength', '14');
    $oElm->setRequired(TRUE);
    $oElm->addValidator(new E2Tecnologia_Validator_Cpf());
    $oElm->addValidator(new E2Tecnologia_Validator_Cnpj());
    $oElm->addFilter(new Zend_Filter_Digits());
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'nome');
    $oElm->setLabel('Nome / Razão Social:');
    $oElm->setAttrib('class', 'span3');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'nome_fantasia');
    $oElm->setLabel('Nome Fantasia:');
    $oElm->setAttrib('class', 'span3');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'login');
    $oElm->setLabel('Login:');
    $oElm->setAttrib('class', 'span3');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('password', 'senha');
    $oElm->setLabel('Senha:');
    $oElm->setAttrib('class', 'span3');
    $oElm->setRequired(TRUE);
    $oElm->addValidator(new Zend_Validate_StringLength(array('min' => 6)));
    $oElm->addValidator(new Zend_Validate_Identical('senha_confirma'));
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('password', 'senha_confirma');
    $oElm->setLabel('Confirme a Senha:');
    $oElm->setAttrib('class', 'span3');
    $oElm->setRequired(TRUE);
    $oElm->addValidator(new Zend_Validate_StringLength(array('min' => 6)));
    $oElm->addValidator(new Zend_Validate_Identical('senha'));
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'cep');
    $oElm->setLabel('CEP:');
    $oElm->setAttrib('class', 'span3 mask-cep');
    $oElm->setAttrib('campo-ref', 'cep');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oElm = new Zend_Form_Element_Hidden('pais');
    $oElm->setValue('01058');
    $this->addElement($oElm);
    
    $aEstados = Default_Model_Cadenderestado::getEstados($this->pais->getValue());
    
    $oElm = $this->createElement('select', 'estado', array('multiOptions' => $aEstados));
    $oElm->setLabel('Estado:');
    $oElm->setAttrib('class', 'span3 select-estados');
    $oElm->setAttrib('ajax-url', '/endereco/get-municipios/');
    $oElm->setAttrib('campo-ref', 'uf');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('select', 'cidade');
    $oElm->setAttrib('class', 'span3');
    $oElm->setAttrib('ajax-url', '/endereco/get-bairros/');
    $oElm->setAttrib('campo-ref', 'municipio');
    $oElm->setLabel('Cidade:');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('select', 'cod_bairro');
    $oElm->setLabel('Bairro:');
    $oElm->setAttrib('class', 'span3 campo-oculto');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'bairro');
    $oElm->setLabel('Bairro:');
    $oElm->setAttrib('class', 'span3');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('select', 'cod_endereco');
    $oElm->setLabel('Endereço:');
    $oElm->setAttrib('class', 'span3 campo-oculto');
    $oElm->setAttrib('campo-ref', 'logradouro');
    $oElm->setAttrib('ajax-url', '/endereco/get-enderecos/');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'endereco');
    $oElm->setLabel('Endereço:');
    $oElm->setAttrib('class', 'span3');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'numero');
    $oElm->setLabel('Número:');
    $oElm->setAttrib('class', 'span3');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $e = $this->createElement('text', 'complemento');
    $e->setLabel('Complemento:');
    $e->setAttrib('class', 'span3');
    $this->addElement($e);
    
    $oElm = $this->createElement('text', 'telefone');
    $oElm->setLabel('Telefone:');
    $oElm->setAttrib('class', 'span3 mask-fone');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'email');
    $oElm->setLabel('Email:');
    $oElm->setAttrib('class', 'span3');
    $oElm->addValidator(new Zend_Validate_EmailAddress());
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $this->addDisplayGroup(
      array(
        'tipo',
        'cpfcnpj',
        'nome',
        'nome_fantasia',
        'login',
        'senha',
        'senha_confirma',
        'cep',
        'estado',
        'cidade',
        'cod_bairro',
        'bairro',
        'cod_endereco',
        'endereco',
        'numero',
        'complemento',
        'telefone',
        'email',
      ), 
      'dados_nota', 
      array('legend' => 'Dados do Usuário')
    );
    
    if ($this->confirmacao) {
      
      // Carrega perfis tem que ver como vai ser controlado qual perfil pode vincular usuarios com quais perfis
      $aPerfis      = array('' => '');
      $aListaPerfis = Administrativo_Model_Perfil::getAll();
      
      foreach ($aListaPerfis as $oPerfil) {
        $aPerfis[$oPerfil->getId()] = $oPerfil->getNome();
      }
      
      $oElm = $this->createElement('select', 'id_perfil', array('multiOptions' => $aPerfis));
      $oElm->setLabel('Perfil:');
      $oElm->setRequired(TRUE);
      $oElm->setOrder(1);
      $this->addElement($oElm);
      
      $this->addElement('submit', 'submit', array(
        'label'       => 'Confirmar',
        'class'       => 'span2',
        'buttonType'  => Twitter_Bootstrap_Form_Element_Submit::BUTTON_SUCCESS)
      );
      
      $this->addElement('submit', 'cancel', array(
        'label'       => 'Recusar',
        'class'       => 'span2',
        'buttonType'  => Twitter_Bootstrap_Form_Element_Submit::BUTTON_DANGER)
      );
      
      $this->addDisplayGroup(
        array('submit', 'cancel'),
        'actions',
        array('disableLoadDefaultDecorators' => TRUE, 'decorators' => array('Actions'))
      );
      
    } else {
      
      $this->addElement('submit', 'submit', array(
        'label'       => 'Salvar',
        'class'       => 'span2',
        'buttonType'  => Twitter_Bootstrap_Form_Element_Submit::BUTTON_SUCCESS)
      );
      
      $this->addDisplayGroup(
        array('submit'),
        'actions',
        array('disableLoadDefaultDecorators' => TRUE, 'decorators' => array('Actions'))
      );
    }
  }
  
  public function preenche($aDados = NULL) {
    
    // Preenche campo cidade pelo estado
    if (isset($aDados['estado'])) {
      
      $aCidades  = Default_Model_Cadendermunicipio::getByEstado($aDados['estado']);
      $elmCidade = $this->getElement('cidade');
      
      if (is_array($aCidades)) {
        $elmCidade->setMultiOptions($aCidades);
      }
    }
    
    // Exibe/Oculta campos de bairro e endereco quando o codigo da cidade da prefeitura for igual ao escolhido
    $elmBairroTexto = $this->getElement('cod_bairro');
    $elmBairroTexto->setAttrib('class', 'campo-oculto');
    
    $elmEndTexto = $this->getElement('cod_endereco');
    $elmEndTexto->setAttrib('class', 'campo-oculto'); // Classe "campo-oculto" no javascript
    
    // Codigo da cidade da prefeitura
    $iCodigoIbge = Administrativo_Model_Prefeitura::getDadosPrefeituraBase()->getIbge();
    
    if (isset($aDados['cidade'])) {
      
      if ($iCodigoIbge == $aDados['cidade']) {
        
        $aDados['bairro'] = NULL;
        $elmBairroTexto   = $this->getElement('bairro');
        $elmBairroTexto->setAttrib('class', 'campo-oculto');
        $elmBairroTexto->clearValidators();
        $elmBairroTexto->setRequired(FALSE);
        
        $elmBairroCombo = $this->getElement('cod_bairro');
        $elmBairroCombo->setAttrib('class', '');
        
        $aBairros = Default_Model_Cadenderbairro::getBairros();
        
        if (is_array($aBairros)) {
          $elmBairroCombo->setMultiOptions($aBairros);
        }
        
        $aDados['endereco'] =  NULL;
        $elmEndTexto        = $this->getElement('endereco');
        $elmEndTexto->setAttrib('class', 'campo-oculto');
        $elmEndTexto->clearValidators();
        $elmEndTexto->setRequired(FALSE);
        
        $elmEndCombo = $this->getElement('cod_endereco');
        $elmEndCombo->setAttrib('class', '');
        
        $aEnderecos = Default_Model_Cadenderrua::getRuas();
        
        if (is_array($aEnderecos)) {
          $elmEndCombo->setMultiOptions($aEnderecos);
        }
      }
    }
    
    $this->populate($aDados);
    
    return $this;
  }
}
