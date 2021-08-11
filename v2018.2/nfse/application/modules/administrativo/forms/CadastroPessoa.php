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
 * Form Responsável pelo Cadastro de Pessoas (eventuais)
 */
class Administrativo_Form_CadastroPessoa extends Twitter_Bootstrap_Form_Horizontal {

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
   * Renderiza o formulário
   *
   * @see Zend_Form::init()
   * @return Zend_form
   */
  public function init() {

    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();

    $this->setName('formCadastroPessoa');
    $this->setAction($oBaseUrlHelper->baseUrl('/default/cadastro-eventual/salvar'));
    $this->setMethod('post');

    $oElm = $this->createElement('hidden', 'id');
    $this->addElement($oElm);

    $oElm = $this->createElement('select', 'id_perfil', array('divspan' => 10));
    $oElm->setLabel('Perfil:');
    $oElm->setAttrib('class', 'span3');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    // Carrega a lista de perfis no elemento id_perfil
    self::carregarPerfis();

    $oElm = $this->createElement('text', 'cnpjcpf', array('divspan' => 10));
    $oElm->setLabel('CNPJ:');
    $oElm->setAttrib('class', 'span3');
    $oElm->setAttrib('maxlength', 18);
    $oElm->addFilter(new Zend_Filter_Digits());
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'nome', array('divspan' => 10));
    $oElm->setLabel('Nome:');
    $oElm->setAttrib('class', 'span8');
    $oElm->setAttrib('campo-ref', 'nome');
    $oElm->setAttrib('maxlength', 39);
    $oElm->addFilter(new Zend_Filter_StringTrim());
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'nome_fantasia', array('divspan' => 10));
    $oElm->setLabel('Nome Fantasia:');
    $oElm->setAttrib('class', 'span8');
    $oElm->setAttrib('maxlength', 39);
    $oElm->addFilter(new Zend_Filter_StringTrim());
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'cep', array('divspan' => 10));
    $oElm->setLabel('CEP:');
    $oElm->setAttrib('class', 'span3 mask-cep');
    $oElm->setAttrib('maxlength', 9);
    $oElm->addFilter(new Zend_Filter_Digits());
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = new Zend_Form_Element_Hidden('pais');
    $oElm->setValue('01058');
    $this->addElement($oElm);

    $oElm = $this->createElement('select', 'estado', array('divspan' => 5));
    $oElm->setLabel('Estado:');
    $oElm->setAttrib('class', 'span3');
    $oElm->setAttrib('ajax-url', $oBaseUrlHelper->baseUrl('/endereco/get-municipios/'));
    $oElm->setAttrib('ajax-param', 'uf');
    $oElm->setAttrib('ajax-target', '#cidade');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    // Carrega a lista de estados no elemento estado
    self::carregarEstados();

    $oElm = $this->createElement('select', 'cidade', array('divspan' => 4));
    $oElm->setLabel('Cidade:');
    $oElm->setAttrib('class', 'span3');
    $oElm->setAttrib('ajax-url', $oBaseUrlHelper->baseUrl('/endereco/get-bairros/'));
    $oElm->setAttrib('ajax-param', 'municipio');
    $oElm->setAttrib('ajax-target', '#cod_bairro');
    $oElm->setRequired(TRUE);
    $oElm->addMultiOptions(array('' => '- Selecione -'));
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('select', 'cod_bairro', array('divspan' => 10));
    $oElm->setLabel('Bairro:');
    $oElm->setAttrib('class', 'span4 campo-oculto');
    $oElm->setAttrib('ajax_param', 'id');
    $oElm->setAttrib('ajax-url', $oBaseUrlHelper->baseUrl('/endereco/get-enderecos/'));
    $oElm->setAttrib('ajax-target', '#cod_endereco');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'bairro', array('divspan' => 10));
    $oElm->setLabel('Bairro:');
    $oElm->setAttrib('class', 'span8');
    $oElm->setAttrib('maxlength', 40);
    $oElm->addFilter(new Zend_Filter_StringTrim());
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('select', 'cod_endereco', array('divspan' => 5));
    $oElm->setLabel('Endereço:');
    $oElm->setAttrib('class', 'span3 campo-oculto');
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'endereco', array('divspan' => 5));
    $oElm->setLabel('Endereço:');
    $oElm->setAttrib('class', 'span3');
    $oElm->setAttrib('maxlength', 100);
    $oElm->addFilter(new Zend_Filter_StringTrim());
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'numero', array('divspan' => 3));
    $oElm->setLabel('Número:');
    $oElm->setAttrib('class', 'span3 mask-numero');
    $oElm->setAttrib('maxlength', 10);
    $oElm->addFilter(new Zend_Filter_Digits());
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'complemento', array('divspan' => 5));
    $oElm->setLabel('Complemento:');
    $oElm->setAttrib('class', 'span3');
    $oElm->setAttrib('maxlength', 50);
    $oElm->addFilter(new Zend_Filter_StringTrim());
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'telefone', array('divspan' => 3));
    $oElm->setLabel('Telefone:');
    $oElm->setAttrib('class', 'span3 mask-fone');
    $oElm->setAttrib('maxlength', 16);
    $oElm->addFilter(new Zend_Filter_Digits());
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'email', array('divspan' => 8));
    $oElm->setLabel('Email:');
    $oElm->setAttrib('class', 'span8');
    $oElm->setAttrib('maxlength', 100);
    $oElm->addValidator(new Zend_Validate_EmailAddress());
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $this->addDisplayGroup(
      array(
        'id_perfil',
        'cnpjcpf',
        'nome',
        'nome_fantasia',
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
      'dados_nota'
    );

    $this->addElement('submit', 'cadastrar', array(
      'label'       => 'Solicitar Cadastro',
      'style'       => 'margin-left:30px',
      'buttonType'  => Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY)
    );

    return $this;
  }

  /**
   * Carrega a lista de perfis no elemento, seta o valor do elemento se informado
   *
   * @param integer $iIdPerfil [Opcional]
   */
  public function carregarPerfis($iIdPerfil = NULL) {

    $aTipos = array(
      // 6 => 'Prestador de Serviços Eventuais',
      4 => 'Tomador de Serviços'
    );

    $this->id_perfil->addMultiOptions($aTipos);
    $this->id_perfil->setValue($iIdPerfil);
  }

  /**
   * Carrega a lista de estados no elemento, seta o valor do elemento se informado
   *
   * @param integer $iIdEstado [Opcional]
   */
  public function carregarEstados($iIdEstado = NULL) {

    $aEstados = Default_Model_Cadenderestado::getEstados($this->pais->getValue());

    $this->estado->addMultiOptions($aEstados);
    $this->estado->setValue($iIdEstado);
  }

  /**
   * Carrega a lista de cidades no elemento, seta o valor do elemento se informado
   *
   * @param integer $iIdEstado
   * @param integer $iIdCidade [opcional]
   */
  public function carregarCidades($iIdEstado, $iIdCidade = NULL) {

    $aCidades = Default_Model_Cadendermunicipio::getByEstado($iIdEstado);

    $this->cidade->addMultiOptions($aCidades);
    $this->cidade->setValue($iIdCidade);
  }

  /**
   * Carrega a lista de bairros no elemento, seta o bairro do elemento se informado
   *
   * @param integer $iIdMunicipio
   * @param integer $iIdBairro [opcional]
   */
  public function carregarBairros($iIdMunicipio, $iIdBairro = NULL) {

    $iCodigoIbge = Administrativo_Model_Prefeitura::getDadosPrefeituraBase()->getIbge();

    if ($iCodigoIbge == $iIdMunicipio) {

      $aBairros  = Default_Model_Cadenderbairro::getBairros($iIdMunicipio);

      $this->cod_bairro->addMultiOptions($aBairros);
    }

    $this->cod_bairro->setValue($iIdBairro);
  }

  /**
   * Carrega a lista de endereços no elemento, seta o endereço do elemento se informado
   *
   * @param $iIdBairro
   * @param $iIdEndereco [opcional]
   */
  public function carregarEnderecos($iIdBairro, $iIdEndereco = NULL) {

    $aEnderecos = Default_Model_Cadenderrua::getRuas($iIdBairro);

    $this->cod_endereco->addMultiOptions($aEnderecos);
    $this->cod_endereco->setValue($iIdEndereco);
  }
}