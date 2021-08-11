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
 * Formulário para nota
 *
 * @package Contribuinte/Forms
 * @see     Twitter_Bootstrap_Form_Horizontal
 * @author Luiz Marcelo Schmitt <luiz.marcelo@dbseller.com.br>
 */

class Contribuinte_Form_NfseEmissao extends Twitter_Bootstrap_Form_Horizontal {

  /**
   * @var object
   */
  private $oBaseUrlHelper;

  /**
   * @var object
   */
  private $oValidacaoFloat;

  /**
   * Cria Formulário
   *
   * @see Zend_Form::init()
   */
  public function init() {

    $this->oBaseUrlHelper  = new Zend_View_Helper_BaseUrl();
    $this->oValidacaoFloat = new Zend_Validate_Float(array('locale' => 'br'));

    $this->setName('form-nota');
    $this->setMethod(Zend_form::METHOD_POST);
    $this->setAction($this->oBaseUrlHelper->baseUrl('/contribuinte/nfse/emitir'));

    /**
     * Campos ocultos
     */
    $this->adicionarCamposOculto();

    /**
     * Dados da Nota
     */
    $oElm = $this->createElement('select', 'dt_nota', array('divspan' => 8, 'multiOptions' => array()));
    $oElm->setLabel('Data:');
    $oElm->setAttrib('class', 'span2');
    $oElm->setAttrib('data-url', $this->oBaseUrlHelper->baseUrl('/contribuinte/nfse/verificar-contribuinte-optante-simples'));
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('checkbox', 'nota_substituta', array('divspan' => 4));
    $oElm->setLabel('Nota Substituta:');
    $oElm->setAttrib('class', 'span3');
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'nota_substituida', array('divspan' => 4));
    $oElm->setLabel('Nº da Nota Substituida:');
    $oElm->setAttrib('class', 'span3 mask-numero');
    $oElm->setAttrib('maxlength', 10);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    // Adiciona elementos ao grupo dos dados da nota
    $this->addDisplayGroup(
      array('dt_nota','nota_substituta','nota_substituida'), 'dados_nota', array('legend' => 'Dados da Nota')
    );

    /**
     * Dados do Tomador
     */
    $oElm = $this->createElement('select', 'substituto_tributario', array('divspan' => 10));
    $oElm->setLabel('Subst. Tributário:');
    $oElm->setAttrib('class', 'span3');
    $oElm->setAttrib('disabled', TRUE);
    $oElm->setAttrib('data-nao-e-do-municipio', FALSE);
    $oElm->removeDecorator('errors');
    $oElm->addMultiOptions(
      array(
        FALSE => 'Não',
        TRUE  => 'Sim'
      )
    );
    $this->addElement($oElm);

    $oElm = $this->createElement('select', 't_cooperado', array('divspan' => 10));
    $oElm->setLabel('Associado:');
    $oElm->setAttrib('class', 'span3');
    $oElm->removeDecorator('errors');
    $oElm->addMultiOptions(
      array(
        'false' => 'Não',
        'true'  => 'Sim'
      )
    );
    $this->addElement($oElm);

    $oElm = $this->createElement('button', 'buscador', array(
      'label'        => '',
      'icon'         => 'search',
      'iconPosition' => Twitter_Bootstrap_Form_Element_Button::ICON_POSITION_LEFT
    ));

    $oElm = $this->createElement('text', 't_cnpjcpf', array('divspan' => 10, 'append' => $oElm));
    $oElm->setLabel('CPF / CNPJ:');
    $oElm->setAttrib('class', 'span3 mask-cpf-cnpj');
    $oElm->setAttrib('campo-ref', 'cpf');
    $oElm->setAttrib('maxlength', 18);
    $oElm->setAttrib('url', $this->oBaseUrlHelper->baseUrl('/contribuinte/empresa/dados-cgm'));
    $oElm->addValidator(new DBSeller_Validator_CpfCnpj());
    $oElm->addFilter(new Zend_Filter_Digits());
    $oElm->setRequired(FALSE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 't_razao_social', array('divspan' => 10));
    $oElm->setLabel('Nome / Razão Social:');
    $oElm->setAttrib('class', 'span9');
    $oElm->setAttrib('campo-ref', 'nome');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 't_nome_fantasia', array('divspan' => 10));
    $oElm->setLabel('Nome Fantasia:');
    $oElm->setAttrib('class', 'span4 pessoa_juridica');
    $oElm->setAttrib('campo-ref', 'nome_fanta');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 't_im', array('divspan' => 5));
    $oElm->setLabel('Inscrição Municipal:');
    $oElm->setAttrib('class', 'span3 pessoa_juridica');
    $oElm->setAttrib('campo-ref', 'inscricao');
    $oElm->setAttrib('maxlength', 20);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 't_ie', array('divspan' => 5));
    $oElm->setLabel('Inscrição Estadual:');
    $oElm->setAttrib('class', 'span4 pessoa_juridica');
    $oElm->setAttrib('campo-ref', 'inscr_est');
    $oElm->setAttrib('maxlength', 20);
    $this->addElement($oElm);


    // Pais Tomador
    $oElm = $this->createElement('select', 't_cod_pais', array('divspan' => 10));
    $oElm->setLabel('País:');
    $oElm->setAttrib('class', 'span3 dados-tomador');
    $oElm->setAttrib('campo-ref', 'cod_bacen');
    $oElm->setAttrib('key', TRUE);
    $oElm->removeDecorator('errors');
    $oElm->setRequired(FALSE);
    $this->addElement($oElm);

    // Lista de estados
    $aEstado = Default_Model_Cadenderestado::getEstados('01058');

    $oElm = $this->createElement('select', 't_uf', array('multiOptions' => $aEstado, 'divspan' => 5));
    $oElm->setLabel('Estado:');
    $oElm->setAttrib('class', 'select-estados span3 dados-tomador');
    $oElm->setAttrib('select-munic', 't_cod_municipio');
    $oElm->setAttrib('ajax-url', $this->oBaseUrlHelper->baseUrl('/endereco/get-municipios/'));
    $oElm->setAttrib('campo-ref', 'uf');
    $oElm->setAttrib('key', FALSE);
    $oElm->setAttrib('data-estado-origem', NULL);
    $oElm->setRequired(FALSE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('select', 't_cod_municipio', array('divspan' => 5));
    $oElm->setLabel('Município:');
    $oElm->setAttrib('class', 'span4 dados-tomador');
    $oElm->setAttrib('campo-ref', 'cod_ibge');
    $oElm->setAttrib('key', TRUE);
    $oElm->setAttrib('data-municipio-origem', NULL);
    $oElm->addMultiOptions(
      array(
        '0' => '- Selecione -'
      )
    );
    $oElm->removeDecorator('errors');
    $oElm->setRequired(FALSE);
    $this->addElement($oElm);

    // Endereço tomador fora do pais

    $oElm = $this->createElement('text', 't_cidade_estado', array('divspan' => 7));
    $oElm->setLabel('Cidade / Estado:');
    $oElm->setAttrib('class', 'span6 dados-tomador');
    $oElm->setAttrib('campo-ref', 'cidade_estado');
    $oElm->setAttrib('maxlength', 100);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 't_cep', array('divspan' => 10));
    $oElm->setLabel('CEP:');
    $oElm->setAttrib('class', 'span3 mask-cep dados-tomador');
    $oElm->setAttrib('campo-ref', 'cep');
    $oElm->setAttrib('maxlength', 8);
    $oElm->addFilter(new Zend_Filter_Digits());
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 't_endereco', array('divspan' => 7));
    $oElm->setLabel('Endereço:');
    $oElm->setAttrib('class', 'span6 dados-tomador');
    $oElm->setAttrib('campo-ref', 'logradouro');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 't_endereco_numero', array('divspan' => 4));
    $oElm->setLabel('Número:');
    $oElm->setAttrib('class', 'span2 numerico dados-tomador');
    $oElm->setAttrib('campo-ref', 'numero');
    $oElm->setAttrib('maxlength', 8);
    $oElm->setValidators(array('Int'));
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 't_endereco_comp', array('divspan' => 5));
    $oElm->setLabel('Complemento:');
    $oElm->setAttrib('class', 'span4 dados-tomador');
    $oElm->setAttrib('campo-ref', 'complemento');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 't_bairro', array('divspan' => 3));
    $oElm->setLabel('Bairro:');
    $oElm->setAttrib('class', 'span4 dados-tomador');
    $oElm->setAttrib('campo-ref', 'bairro');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 't_telefone', array('divspan' => 4));
    $oElm->setLabel('Telefone:');
    $oElm->setAttrib('class', 'span3 mask-fone');
    $oElm->setAttrib('campo-ref', 'telefone');
    $oElm->setAttrib('maxlength', 14);
    $oElm->addFilter(new Zend_Filter_Digits());
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 't_email', array('divspan' => 5));
    $oElm->setLabel('Email:');
    $oElm->setAttrib('class', 'span5');
    $oElm->setAttrib('campo-ref', 'email');
    $oElm->removeDecorator('errors');
    $oElm->addValidator('EmailAddress');
    $this->addElement($oElm);

    $this->addDisplayGroup(array(
                             'substituto_tributario',
                             't_cooperado',
                             't_cnpjcpf',
                             't_razao_social',
                             't_nome_fantasia',
                             't_im',
                             't_ie',
                             't_cod_pais',
                             't_uf',
                             't_cod_municipio',
                             't_cidade_estado',
                             't_cep',
                             't_endereco',
                             't_endereco_numero',
                             't_endereco_comp',
                             't_bairro',
                             't_telefone',
                             't_email'
                           ),
                           'tomador',
                           array('legend' => 'Tomador'));

    /**
     * Dados do servico
     */
    $oElm = $this->createElement('select', 's_dados_cod_tributacao', array('multiOptions' => array(), 'divspan' => 10));
    $oElm->setLabel('Serviço:');
    $oElm->setAttrib('class', 'span9');
    $oElm->setAttrib('url', $this->oBaseUrlHelper->baseUrl('/contribuinte/nfse/servico/'));
    $oElm->setRequired(TRUE);
    $oElm->addMultiOptions(
      array(
        '' => '- Escolha um Serviço -'
      )
    );
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    // Pais de incidencia do serviço
    $oElm = $this->createElement('select', 's_dados_cod_pais', array('divspan' => 10));
    $oElm->setLabel('País:');
    $oElm->setAttrib('class', 'span3 dados-tomador');
    $oElm->setAttrib('campo-ref', 'cod_bacen');
    $oElm->setAttrib('key', TRUE);
    $oElm->removeDecorator('errors');
    $oElm->setRequired(FALSE);
    $this->addElement($oElm);

    $oElm = $this->createElement('select', 'estado', array('multiOptions' => $aEstado, 'divspan' => 5));
    $oElm->setLabel('Estado:');
    $oElm->setAttrib('class', 'select-estados span3');
    $oElm->setAttrib('select-munic', 's_dados_municipio_incidencia');
    $oElm->setAttrib('ajax-url', $this->oBaseUrlHelper->baseUrl('/endereco/get-municipios/'));
    $oElm->setAttrib('key', FALSE);
    $oElm->setAttrib('data-estado-origem', NULL);
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    // Lista de cidades
    $aCidade = array('0' => '- Selecione -');

    $oElm = $this->createElement('select', 's_dados_municipio_incidencia', array(
      'multiOptions' => $aCidade,
      'divspan'      => 5
    ));
    $oElm->setLabel('Município:');
    $oElm->setAttrib('class', 'span4');
    $oElm->setAttrib('key', TRUE);
    $oElm->setAttrib('data-municipio-origem', NULL);
    $oElm->removeDecorator('errors');
    $oElm->clearValidators();
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    // Endereço de prestação fora do pais

    $oElm = $this->createElement('text', 's_dados_cidade_estado', array('divspan' => 7));
    $oElm->setLabel('Cidade / Estado:');
    $oElm->setAttrib('class', 'span6 dados-servico');
    $oElm->setAttrib('campo-ref', 'cidade_estado');
    $oElm->setAttrib('maxlength', 100);
    $this->addElement($oElm);


    $oElm = $this->createElement('textarea', 'descricao', array('divspan' => 10));
    $oElm->setLabel('Descrição do Serviço:');
    $oElm->setAttrib('class', 'span9 exibir-contador-maxlength');
    $oElm->setAttrib('rows', '6');
    $oElm->setAttrib('maxlength', 2000);
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_codigo_obra', array('divspan' => 5));
    $oElm->setLabel('Código da Obra:');
    $oElm->setAttrib('maxlength', 14);
    $oElm->setAttrib('class', 'span3');
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_art', array('divspan' => 5));
    $oElm->setLabel('ART:');
    $oElm->setAttrib('maxlength', 14);
    $oElm->setAttrib('class', 'span3');
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('textarea', 's_informacoes_complementares', array('divspan' => 10));
    $oElm->setLabel('Outras Informações:');
    $oElm->setAttrib('class', 'span9 exibir-contador-maxlength');
    $oElm->setAttrib('maxlength', 600);
    $oElm->setAttrib('rows', '6');
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $this->addDisplayGroup(array(
                             's_dados_cod_tributacao',
                             's_dados_cod_cnae',
                             's_dados_item_lista_servico',
                             'descricao_item_lista_servico',
                             's_dados_cod_pais',
                             'estado',
                             's_dados_municipio_incidencia',
                             's_dados_cidade_estado',
                             'descricao',
                             's_codigo_obra',
                             's_art',
                             's_informacoes_complementares'
                           ),
                           'grp_servico',
                           array('legend' => 'Dados do Serviço'));

    /**
     * Tributação
     */
    $oElm = $this->createElement('select', 'natureza_operacao', array('divspan' => 5));
    $oElm->setLabel('Natureza da Operação:');
    $oElm->setAttrib('class', 'span4');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $oElm->addMultiOptions(array(
                             '1' => 'Tributação no Município',
                             '2' => 'Tributação Fora do Município'
                           ));
    $this->addElement($oElm);

    $this->addElement(
        'text',
        'dummy',
        array(
            'required' => false,
            'ignore' => true,
            'autoInsertNotEmptyValidator' => false,
            'decorators' => array(
                array(
                    'HtmlTag', array(
                        'tag'  => 'div',
                        'class' => 'span1'
                    )
                )
            )
        )
    );
    $this->dummy->clearValidators();

    $oElm = $this->createElement('select', 's_iss_retido', array('divspan' => 5));
    $oElm->setLabel('Retido:');
    $oElm->setAttrib('class', 'span3');
    $oElm->removeDecorator('errors');
    $oElm->addMultiOptions(
      array(
        FALSE => 'Não',
        TRUE  => 'Sim'
      )
    );
    $this->addElement($oElm);

    // Serviço incide tributação quando fora do pais

    $oElm = $this->createElement('select', 's_dados_fora_incide', array('divspan' => 10));
    $oElm->setLabel('Incide:');
    $oElm->setAttrib('class', 'span4');
    $oElm->removeDecorator('errors');
    $oElm->addMultiOptions(
      array(
        FALSE => 'Não',
        TRUE  => 'Sim'
      )
    );
    $this->addElement($oElm);

    $this->addDisplayGroup(
      array('natureza_operacao', 'dummy', 's_iss_retido', 's_dados_fora_incide'), 'dados_tributacao', array(
        'legend' => 'Tributação'
      )
    );

    /**
     * Valores do servico
     */
    $oElm = $this->createElement('text', 's_vl_servicos', array('prepend' => 'R$', 'divspan' => 3));
    $oElm->setLabel('Valor do Serviço:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 11);
    $oElm->removeDecorator('errors');
    $oElm->addValidator($this->oValidacaoFloat);
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_deducoes', array('prepend' => 'R$', 'divspan' => 3));
    $oElm->setLabel('Dedução:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 11);
    $oElm->setAttrib('habilita_deducao', FALSE);
    $oElm->removeDecorator('errors');
    $oElm->addValidator($this->oValidacaoFloat);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_bc', array('prepend' => 'R$', 'divspan' => 3));
    $oElm->setLabel('Base de Cálculo:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 11);
    $oElm->setAttrib('readonly', TRUE);
    $oElm->removeDecorator('errors');
    $oElm->addValidator($this->oValidacaoFloat);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_aliquota', array('append' => '%', 'divspan' => 3));
    $oElm->setLabel('Alíquota:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 5);
    $oElm->removeDecorator('errors');
    $oElm->addValidator(new Zend_Validate_Between(array('min' => 0, 'max' => 9999, 'inclusive' => TRUE)));
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_iss', array('prepend' => 'R$', 'divspan' => 3));
    $oElm->setLabel('ISS:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 11);
    $oElm->setAttrib('readonly', TRUE);
    $oElm->removeDecorator('errors');
    $oElm->addValidator($this->oValidacaoFloat);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_pis', array('prepend' => 'R$', 'divspan' => 3));
    $oElm->setLabel('PIS:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 11);
    $oElm->removeDecorator('errors');
    $oElm->addValidator($this->oValidacaoFloat);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_cofins', array('prepend' => 'R$', 'divspan' => 3));
    $oElm->setLabel('COFINS:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 11);
    $oElm->removeDecorator('errors');
    $oElm->addValidator($this->oValidacaoFloat);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_inss', array('prepend' => 'R$', 'divspan' => 3));
    $oElm->setLabel('INSS:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 11);
    $oElm->removeDecorator('errors');
    $oElm->addValidator($this->oValidacaoFloat);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_ir', array('prepend' => 'R$', 'divspan' => 3));
    $oElm->setLabel('IR:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 11);
    $oElm->removeDecorator('errors');
    $oElm->addValidator($this->oValidacaoFloat);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_csll', array('prepend' => 'R$', 'divspan' => 6));
    $oElm->setLabel('CSLL:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 11);
    $oElm->removeDecorator('errors');
    $oElm->addValidator($this->oValidacaoFloat);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_outras_retencoes', array('prepend' => 'R$', 'divspan' => 3));
    $oElm->setLabel('Outras Retenções:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 11);
    $oElm->removeDecorator('errors');
    $oElm->addValidator($this->oValidacaoFloat);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_condicionado', array('prepend' => 'R$', 'divspan' => 6));
    $oElm->setLabel('Desconto Condicional:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 11);
    $oElm->removeDecorator('errors');
    $oElm->addValidator($this->oValidacaoFloat);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_desc_incondicionado', array('prepend' => 'R$', 'divspan' => 3));
    $oElm->setLabel('Desconto Incondicional:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 11);
    $oElm->removeDecorator('errors');
    $oElm->addValidator($this->oValidacaoFloat);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_liquido', array('prepend' => 'R$', 'divspan' => 6));
    $oElm->setLabel('Valor Líquido:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 11);
    $oElm->setAttrib('readonly', TRUE);
    $oElm->addValidator(new DBSeller_Validator_Between(array('min' => 0, 'max' => 99999999999, 'inclusive' => FALSE)));
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $this->addDisplayGroup(array(
                             's_vl_servicos',
                             's_vl_deducoes',
                             's_vl_bc',
                             's_vl_aliquota',
                             's_vl_iss',
                             's_vl_pis',
                             's_vl_cofins',
                             's_vl_cofins',
                             's_vl_inss',
                             's_vl_ir',
                             's_vl_csll',
                             's_vl_outras_retencoes',
                             's_vl_condicionado',
                             's_vl_desc_incondicionado',
                             's_vl_liquido',
                           ),
                           'valores',
                           array('legend' => 'Valores do Serviço'));


    $this->addElement('button', 'emitir', array(
      'label'             => 'Emitir',
      'type'              => 'button',
      'buttonType'        => Twitter_Bootstrap_Form_Element_Button::BUTTON_SUCCESS,
      'data-loading-text' => $this->getTranslator()->_('Aguarde...'),
      'class'             => 'span2'
    ));

    $this->addDisplayGroup(array('emitir'), 'actions', array(
      'disableLoadDefaultDecorators' => TRUE,
      'decorators'                   => array('Actions')
    ));

    return $this;
  }

  /**
   * Cria campos ocultos para armazenas dados das flags
   *
   * @return $this
   * @throws Zend_Form_Exception
   */
  private function adicionarCamposOculto() {

    // Reter Pessoa física é um parametro da prefeitura
    $oElm = $this->createElement('hidden', 'reter_pessoa_fisica');
    $this->addElement($oElm);

    $oElm = $this->createElement('hidden', 's_tributacao_municipio');
    $this->addElement($oElm);

    $oElm = $this->createElement('hidden', 's_dados_cod_tributacao_copia');
    $this->addElement($oElm);

    // Grupo da nota (o tipo padrão é o da NFSe)
    $oElm = $this->createElement('hidden', 'grupo_nota');
    $this->addElement($oElm);

    // $oElm = $this->createElement('hidden', 't_cod_pais');
    // $this->addElement($oElm);

    $oElm = $this->createElement('hidden', 's_dados_cod_pais');
    $this->addElement($oElm);

    $oElm = $this->createElement('hidden', 's_dados_iss_retido');
    $this->addElement($oElm);

    $oElm = $this->createElement('hidden', 'b_mei_sociedade_profissionais');
    $this->addElement($oElm);

    $oElm = $this->createElement('hidden', 's_nao_incide');
    $oElm->setValue(0);
    $this->addElement($oElm);

    $oElm = $this->createElement('hidden', 's_dados_exigibilidadeiss');
    $oElm->setValue(0);
    $this->addElement($oElm);

    $oElm = $this->createElement('hidden', 'p_categoria_simples_nacional');
    $oElm->setValue(0);
    $this->addElement($oElm);

    $oElm = $this->createElement('hidden', 'p_regime_tributario');
    $this->addElement($oElm);

    return $this;
  }

  /**
   * Popula a lista de serviços
   *
   * @param array :Contribuinte_Model_Servico $aLista Coleção de Serviços
   * @return Contribuinte_Form_Nota
   */
  public function setListaServicos($aLista) {

    $aValues = array('' => '- Escolha um Serviço -');

    foreach ($aLista as $oLista) {
      $aValues[$oLista->attr('cod_atividade')] = ucfirst(strtolower($oLista->attr('atividade')));
    }

    $this->getElement('s_dados_cod_tributacao')->setMultiOptions($aValues);

    return $this;
  }

  /**
   * Preenche os atributos dos campos referentes ao valores de impostos (estes itens serão enviados por ajax)
   *
   * @param Contribuinte_Model_ParametroContribuinte $oParametroContribuinte
   * @return Contribuinte_Form_Nota
   */
  public function preencheParametrosContribuinte(Contribuinte_Model_ParametroContribuinte $oParametroContribuinte) {

    if ($oParametroContribuinte === NULL) {
      return $this;
    }

    if ($oParametroContribuinte->getEntity()->getMaxDeducao() <= 0) {
      $this->getElement('s_vl_deducoes')->setAttrib('readonly', TRUE);
    }

    $this->s_vl_deducoes->setAttrib('perc', $oParametroContribuinte->getEntity()->getMaxDeducao());
    $this->s_vl_pis->setAttrib('perc', $oParametroContribuinte->getEntity()->getPis());
    $this->s_vl_cofins->setAttrib('perc', $oParametroContribuinte->getEntity()->getCofins());
    $this->s_vl_inss->setAttrib('perc', $oParametroContribuinte->getEntity()->getInss());
    $this->s_vl_ir->setAttrib('perc', $oParametroContribuinte->getEntity()->getIr());
    $this->s_vl_csll->setAttrib('perc', $oParametroContribuinte->getEntity()->getCsll());

    return $this;
  }

  /**
   * Metodo para aplicar regras que tem prioridade sobre as demais regras do formúlario
   * Regra de MEI, Sociedade de profissionais, ISENTO e IMUNE
   *
   */
  public function aplicaRegrasArbritarias($oContribuinte) {

    $this->getElement('s_dados_exigibilidadeiss')->setAttrib('readonly', 'readonly')->setValue($oContribuinte->getExigibilidade());

    if ($oContribuinte->getRegimeTributario() == Contribuinte_Model_ContribuinteAbstract::REGIME_TRIBUTARIO_SOCIEDADE_PROFISSIONAIS
     || $oContribuinte->isRegimeTributarioMei()
     || $oContribuinte->getExigibilidade() == Contribuinte_Model_ContribuinteAbstract::EXIGIBILIDADE_ISENTO
     || $oContribuinte->getExigibilidade() == Contribuinte_Model_ContribuinteAbstract::EXIGIBILIDADE_IMUNE) {

      $this->getElement('s_iss_retido')->setAttrib('readonly', 'readonly')->setValue(0);
      $this->getElement('s_vl_aliquota')->setAttrib('readonly', 'readonly')->setValue(0);
    }

    return $this;
  }

  /**
   * Seta valor ao hidden referente ao regime tributario do contribuinte.
   *
   * @param integer Valor a ser setado
   */
  public function setRegimeTributario($iRegimeTributario){

    $this->p_regime_tributario->setValue($iRegimeTributario);

    if($iRegimeTributario != Contribuinte_Model_ContribuinteAbstract::REGIME_TRIBUTARIO_COOPERATIVA){
      $this->removeElement('t_cooperado');
    }
  }
}