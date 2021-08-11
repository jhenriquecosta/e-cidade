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
 * @author Everton Catto Heckler <everton.heckler@dbseller.com.br>
 */

class Contribuinte_Form_RpsEmissao extends Twitter_Bootstrap_Form_Horizontal {

  /**
   * Url para ação do formulário
   *
   * @var string
   */
  private $sAction = '/contribuinte/nfse/index';

  /**
   * Código de verificação do documento
   *
   * @var bool|string
   */
  private $sCodigoVerificacao = FALSE;

  /**
   * Define se o documento é um RPS
   *
   * @var bool
   */
  private $lRps = FALSE;

  /**
   * Menor dia para emissão do documento
   *
   * @var DateTime|null
   */
  private $dMenorDiaEmissao = NULL;

  /**
   * Construtor
   *
   * @param string   $sCodigoVerificacao Codigo de verificacao
   * @param DateTime $dMenorDiaEmissao   Menor dia possivel para emissao da nota
   * @param string   $sAction            Acao do formulario
   * @param bool     $lRps               TRUE se for emissao de RPS
   */
  public function __construct($sCodigoVerificacao, $dMenorDiaEmissao, $sAction = '/contribuinte/nfse/index',
                              $lRps = FALSE) {

    $this->sAction            = $sAction;
    $this->sCodigoVerificacao = $sCodigoVerificacao;
    $this->lRps               = $lRps;
    $this->dMenorDiaEmissao   = $dMenorDiaEmissao;

    parent::__construct(array('addDecorator' => array(array('Wrapper'))));
  }

  /**
   * Método construtor
   *
   * @return $this|void
   */
  public function init() {

    // informações do sistema
    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();
    $oTradutor      = $this->getTranslator();

    // Configurações do Formulário
    $this->setAction($oBaseUrlHelper->baseUrl($this->sAction));
    $this->setMethod(Zend_Form::METHOD_POST);
    $this->setAttrib('id', 'nota');

    // Vetor com os dias em que a nota pode ser emitida
    $aDiasEmissao = array();
    $oDia         = new DateTime();

    do {

      $aDiasEmissao[$oDia->format('Y-m-d')] = $oDia->format('d/m/Y');
      $oDia                                 = $oDia->sub(new DateInterval('P1D'));
    } while ($oDia->format('Ymd') >= $this->dMenorDiaEmissao->format('Ymd'));

    // Validador para campos de valores do documento
    $oValidacaoFloat = new Zend_Validate_Float(array('locale' => 'br'));

    // Reter Pessoa física é um parametro da prefeitura
    $oElm = $this->createElement('hidden', 'reter_pessoa_fisica');
    $oParametrosPrefeitura = Administrativo_Model_ParametroPrefeitura::getAll();
    $oElm->setValue($oParametrosPrefeitura[0]->getReterPessoaFisica());
    $this->addElement($oElm);

    /**
     * Dados da Nota
     */
    $oElm = $this->createElement('select', 'dt_nota', array('divspan' => 4, 'multiOptions' => $aDiasEmissao));
    $oElm->setLabel('Data:');
    $oElm->setAttrib('class', 'span2');
    $oElm->setAttrib('data-url', $oBaseUrlHelper->baseUrl('/contribuinte/nfse/verificar-contribuinte-optante-simples'));
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('select', 'natureza_operacao', array('divspan' => 5));
    $oElm->setLabel('Natureza da Operação:');
    $oElm->setAttrib('class', 'span3');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    // Popula as naturezas de operacao
    self::setNaturezaOperacao();

    // Grupo da nota (o tipo padrão é o da NFSe)
    $oElm = $this->createElement('hidden', 'grupo_nota');
    $oElm->setValue(Contribuinte_Model_Nota::GRUPO_NOTA_NFSE);
    $this->addElement($oElm);

    $aGrupoElementosDadosNota = array('dt_nota', 'natureza_operacao');

    if (!$this->lRps) {

      $oElm = $this->createElement('checkbox', 'nota_substituta', array('divspan' => 4));
      $oElm->setLabel('Nota Substituta:');
      $oElm->setAttrib('class', 'span3');
      $oElm->removeDecorator('errors');
      $this->addElement($oElm);

      $oElm = $this->createElement('text', 'nota_substituida', array('divspan' => 5));
      $oElm->setLabel('Nº da Nota Substituida:');
      $oElm->setAttrib('class', 'span3 mask-numero');
      $oElm->setAttrib('maxlength', 10);
      $oElm->removeDecorator('errors');
      $this->addElement($oElm);

      $aGrupoElementosDadosNota[] = 'nota_substituta';
      $aGrupoElementosDadosNota[] = 'nota_substituida';
    }

    // Adiciona elementos ao grupo dos dados da nota
    $this->addDisplayGroup($aGrupoElementosDadosNota, 'dados_nota', array('legend' => 'Dados da Nota'));

    /**
     * RPS
     */
    if ($this->lRps) {

      // Seta o grupo de nota para o tipo RPS
      $this->getElement('grupo_nota')->setValue(Contribuinte_Model_Nota::GRUPO_NOTA_RPS);

      $oElm = $this->createElement('select', 'tipo_nota', array('divspan' => 10));
      $oElm->setLabel('Tipo de Documento:');
      $oElm->setAttrib('class', 'span6');
      $oElm->setRequired(TRUE);
      $oElm->removeDecorator('errors');
      $this->addElement($oElm);

      // Popula os tipos de documento
      self::setTiposDocumento();

      // Data de emissão do RPS
      $oElm = $this->createElement('text', 'data_rps', array('divspan' => 4));
      $oElm->setLabel('Data do RPS:');
      $oElm->setAttrib('class', 'span2');
      $oElm->addValidator(new Zend_Validate_Date(array('format' => 'dd/mm/yyyy')));
      $oElm->setRequired(TRUE);
      $oElm->removeDecorator('errors');
      $this->addElement($oElm);

      // Número do RPS
      $oElm = $this->createElement('text', 'n_rps', array('divspan' => 2));
      $oElm->setLabel('Número do RPS:');
      $oElm->setAttrib('class', 'span2 mask-numero');
      $oElm->setAttrib('maxlength', '5');
      $this->addElement($oElm);

      // Adiciona os elementos ao grupo de dados do RPS
      $this->addDisplayGroup(array('tipo_nota', 'data_rps', 'n_rps'), 'dados_rps', array('legend' => 'RPS'));
    }

    /**
     * Dados do Tomador
     */
    $oElm = $this->createElement('checkbox', 's_dados_iss_retido', array('divspan' => 10));
    $oElm->setLabel('Subst. Tributário (Retido):');
    $oElm->setAttrib('style', 'width:18px');
    $oElm->setAttrib('checked', FALSE);
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
    $oElm->setAttrib('url', $oBaseUrlHelper->baseUrl('/contribuinte/empresa/dados-cgm'));
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
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 't_ie', array('divspan' => 5));
    $oElm->setLabel('Inscrição Estadual:');
    $oElm->setAttrib('class', 'span4 pessoa_juridica');
    $oElm->setAttrib('campo-ref', 'inscr_est');
    $this->addElement($oElm);

    $oElm = $this->createElement('hidden', 't_cod_pais');
    $oElm->setValue('01058'); //codigo_bacen do Brasil
    $this->addElement($oElm);

    // Lista de estados
    $aEstado = Default_Model_Cadenderestado::getEstados('01058');

    $oElm = $this->createElement('select', 't_uf', array('multiOptions' => $aEstado, 'divspan' => 5));
    $oElm->setLabel('Estado:');
    $oElm->setAttrib('class', 'select-estados span3 dados-tomador');
    $oElm->setAttrib('select-munic', 't_cod_municipio');
    $oElm->setAttrib('ajax-url', $oBaseUrlHelper->baseUrl('/endereco/get-municipios/'));
    $oElm->setAttrib('campo-ref', 'uf');
    $oElm->setAttrib('key', FALSE);
    $oElm->setRequired(FALSE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('select', 't_cod_municipio', array('divspan' => 3));
    $oElm->setLabel('Município:');
    $oElm->setAttrib('class', 'span4 dados-tomador');
    $oElm->setAttrib('campo-ref', 'cod_ibge');
    $oElm->setAttrib('key', TRUE);
    $oElm->removeDecorator('errors');
    $oElm->setRequired(FALSE);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 't_cep', array('divspan' => 10));
    $oElm->setLabel('CEP:');
    $oElm->setAttrib('class', 'span2 mask-cep dados-tomador');
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
                             's_dados_iss_retido',
                             't_cnpjcpf',
                             't_razao_social',
                             't_nome_fantasia',
                             't_im',
                             't_ie',
                             't_cod_pais',
                             't_uf',
                             't_cod_municipio',
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
    $oElm->setAttrib('url', $oBaseUrlHelper->baseUrl('/contribuinte/nfse/get-servico/'));
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('hidden', 's_dados_cod_pais');
    $oElm->setValue('01058'); //codigo_bacen do Brasil
    $this->addElement($oElm);

    $oElm = $this->createElement('select', 'estado', array('multiOptions' => $aEstado, 'divspan' => 5));
    $oElm->setLabel('Estado:');
    $oElm->setAttrib('class', 'select-estados span3');
    $oElm->setAttrib('select-munic', 's_dados_municipio_incidencia');
    $oElm->setAttrib('ajax-url', $oBaseUrlHelper->baseUrl('/endereco/get-municipios/'));
    $oElm->setAttrib('key', FALSE);
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    // Lista de cidades
    $aCidade = array('0' => '');

    $oElm = $this->createElement('select', 's_dados_municipio_incidencia', array(
      'multiOptions' => $aCidade,
      'divspan'      => 5
    ));
    $oElm->setLabel('Município:');
    $oElm->setAttrib('class', 'span4');
    $oElm->setAttrib('key', TRUE);
    $oElm->removeDecorator('errors');
    $oElm->clearValidators();
    $oElm->setRequired(TRUE);
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
                             'descricao',
                             's_codigo_obra',
                             's_art',
                             's_informacoes_complementares'
                           ),
                           'grp_servico',
                           array('legend' => 'Dados do Serviço'));

    /**
     * Valores do servico
     */
    $oElm = $this->createElement('text', 's_vl_servicos', array('prepend' => 'R$', 'divspan' => 3));
    $oElm->setLabel('Valor do Serviço:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 11);
    $oElm->removeDecorator('errors');
    $oElm->addValidator($oValidacaoFloat);
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_deducoes', array('prepend' => 'R$', 'divspan' => 3));
    $oElm->setLabel('Dedução:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 11);
    $oElm->setAttrib('habilita_deducao', FALSE);
    $oElm->removeDecorator('errors');
    $oElm->addValidator($oValidacaoFloat);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_bc', array('prepend' => 'R$', 'divspan' => 3));
    $oElm->setLabel('Base de Cálculo:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 11);
    $oElm->setAttrib('readonly', TRUE);
    $oElm->removeDecorator('errors');
    $oElm->addValidator($oValidacaoFloat);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_aliquota', array('append' => '%', 'divspan' => 3));
    $oElm->setLabel('Alíquota:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 5);
    $oElm->removeDecorator('errors');
    $oElm->addValidator(new Zend_Validate_Between(array('min' => 0, 'max' => 9999, 'inclusive' => TRUE)));
    $oElm->setValue(0);
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_iss', array('prepend' => 'R$', 'divspan' => 3));
    $oElm->setLabel('ISS:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 11);
    $oElm->setAttrib('readonly', TRUE);
    $oElm->removeDecorator('errors');
    $oElm->addValidator($oValidacaoFloat);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_pis', array('prepend' => 'R$', 'divspan' => 3));
    $oElm->setLabel('PIS:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 11);
    $oElm->removeDecorator('errors');
    $oElm->addValidator($oValidacaoFloat);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_cofins', array('prepend' => 'R$', 'divspan' => 3));
    $oElm->setLabel('COFINS:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 11);
    $oElm->removeDecorator('errors');
    $oElm->addValidator($oValidacaoFloat);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_inss', array('prepend' => 'R$', 'divspan' => 3));
    $oElm->setLabel('INSS:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 11);
    $oElm->removeDecorator('errors');
    $oElm->addValidator($oValidacaoFloat);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_ir', array('prepend' => 'R$', 'divspan' => 3));
    $oElm->setLabel('IR:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 11);
    $oElm->removeDecorator('errors');
    $oElm->addValidator($oValidacaoFloat);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_csll', array('prepend' => 'R$', 'divspan' => 6));
    $oElm->setLabel('CSLL:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 11);
    $oElm->removeDecorator('errors');
    $oElm->addValidator($oValidacaoFloat);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_outras_retencoes', array('prepend' => 'R$', 'divspan' => 3));
    $oElm->setLabel('Outras Retenções:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 11);
    $oElm->removeDecorator('errors');
    $oElm->addValidator($oValidacaoFloat);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_condicionado', array('prepend' => 'R$', 'divspan' => 6));
    $oElm->setLabel('Desconto Condicional:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 11);
    $oElm->removeDecorator('errors');
    $oElm->addValidator($oValidacaoFloat);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_desc_incondicionado', array('prepend' => 'R$', 'divspan' => 3));
    $oElm->setLabel('Desconto Incondicional:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 11);
    $oElm->removeDecorator('errors');
    $oElm->addValidator($oValidacaoFloat);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_liquido', array('prepend' => 'R$', 'divspan' => 6));
    $oElm->setLabel('Valor Líquido:');
    $oElm->setAttrib('class', 'input-small mask-valores');
    $oElm->setAttrib('placeholder', '0,00');
    $oElm->setAttrib('maxlength', 11);
    $oElm->setAttrib('readonly', TRUE);
    $oElm->addValidator(new DBSeller_Validator_Between(array('min' => 0, 'max' => 99999999999, 'inclusive' => false)));
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('hidden', 's_tributacao_municipio');
    $oElm->setValue('f');
    $this->addElement($oElm);

    $oElm = $this->createElement('hidden', 's_dados_cod_tributacao_copia');
    $oElm->setValue(NULL);
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

    if ($this->sCodigoVerificacao == NULL) {

      $this->addElement('button', 'emitir', array(
        'label'             => 'Emitir',
        'type'              => 'submit',
        'buttonType'        => Twitter_Bootstrap_Form_Element_Button::BUTTON_SUCCESS,
        'data-loading-text' => $oTradutor->_('Aguarde...'),
        'class'             => 'span2'
      ));

      $this->addDisplayGroup(array('emitir'), 'actions', array(
        'disableLoadDefaultDecorators' => TRUE,
        'decorators'                   => array('Actions')
      ));
    } else {

      $this->addElement(new Twitter_Bootstrap_Form_Element_Button('nova', array(
        'label'      => 'Nova',
        'type'       => 'button',
        'url'        => $oBaseUrlHelper->baseUrl('/contribuinte/nfse/index/'),
        'buttonType' => Twitter_Bootstrap_Form_Element_Button::BUTTON_SUCCESS
      )));

      $this->addElement(new Twitter_Bootstrap_Form_Element_Button('imprimir', array(
        'label'      => 'Imprimir',
        'type'       => 'button',
        'url'        => $oBaseUrlHelper->baseUrl("/contribuinte/nfse/nota-impressa/cod/{$this->sCodigoVerificacao}"),
        'buttonType' => Twitter_Bootstrap_Form_Element_Button::BUTTON_SUCCESS
      )));

      $this->addDisplayGroup(array('imprimir', 'nova'), 'actions', array(
        'disableLoadDefaultDecorators' => TRUE,
        'decorators'                   => array('Actions')
      ));
    }

    return $this;
  }

  /**
   * Preenche o formulário com os dados infformados
   *
   * @param array $aDados
   * @return $this
   */
  public function preenche($aDados) {

    $aDados = $this->organizaDadosCopia($aDados);

    $this->preencheEmpresa($aDados)
         ->preencheDadosServico($aDados)
         ->preencheValores($aDados)
         ->preencheRps($aDados)
         ->populate($aDados);

    return $this;
  }

  /**
   * Popula Natureza da Operação
   *
   * @param integer $iNaturezaOperacao
   * @return $this
   */
  public function setNaturezaOperacao($iNaturezaOperacao = NULL) {

    $aNaturezaOperacao = array(
      '' => '- Selecione -',
      1  => 'Tributação no Município',
      2  => 'Tributação Fora do Município'
    );

    $this->natureza_operacao->addMultiOptions($aNaturezaOperacao);
    $this->natureza_operacao->setValue($iNaturezaOperacao);

    return $this;
  }

  /**
   * Popula o Tipo de Documento
   *
   * @param integer $iTipoDocumento
   * @return $this
   */
  public function setTiposDocumento($iTipoDocumento = NULL) {

    $aTipoDocumento = Contribuinte_Model_Nota::getTiposNota(Contribuinte_Model_Nota::GRUPO_NOTA_RPS);

    if (is_object($this->getElement('tipo_nota'))) {
      $this->getElement('tipo_nota')->addMultiOptions($aTipoDocumento)->setValue($iTipoDocumento);
    }

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
   * Seta todos os elementos do formulário como somente leitura
   *
   * @param boolean $lFlag
   * @return Contribuinte_Form_Nota
   */
  public function setReadOnly($lFlag = TRUE) {

    foreach ($this->getElements() as $oElm) {

      if ($oElm instanceof Zend_Form_Element_Text ||
        $oElm instanceof Zend_Form_Element_Textarea ||
        $oElm instanceof Zend_Form_Element_Password ||
        $oElm instanceof Zend_Form_Element_Select
      ) {
        $oElm->setAttrib('readonly', $lFlag);
      }
    }

    return $this;
  }

  /**
   * Preenche os dados referentes ao RPS
   *
   * @param array $aDados
   * @internal param array $aRps
   * @return Contribuinte_Form_Nota
   */
  public function preencheRps($aDados) {

    if ($this->lRps) {

      if (is_object($this->getElement('tipo_nota')) && isset($aDados['tipo_nota'])) {
        $this->getElement('tipo_nota')->setValue($aDados['tipo_nota']);
      }

      if (is_object($this->getElement('data_rps')) && isset($aDados['data_rps'])) {
        $this->getElement('data_rps')->setValue($aDados['data_rps']);
      }

      if (is_object($this->getElement('n_rps')) && isset($aDados['n_rps'])) {
        $this->getElement('n_rps')->setValue($aDados['n_rps']);
      }
    }

    return $this;
  }

  /**
   * Preenche os atributos dos campos referentes ao valores de impostos (estes itens serão enviados por ajax)
   *
   * @param Contribuinte_Model_ParametroContribuinte $oParametroContribuinte
   * @return Contribuinte_Form_Nota
   */
  public function preencheParametros(Contribuinte_Model_ParametroContribuinte $oParametroContribuinte) {

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
   * Preenche os dados referentes à empresa do tomador
   *
   * @param array $aDados
   * @return $this
   */
  public function preencheEmpresa($aDados) {

    if (isset($aDados['t_cgccpf'])) {
      $this->getElement('t_cnpjcpf')->setValue($aDados['t_cnpjcpf']);
    } elseif (isset($aDados['cpf'])) {
      $this->getElement('t_cnpjcpf')->setValue($aDados['cpf']);
    }

    if (isset($aDados['nome'])) {
      $this->getElement('t_razao_social')->setValue($aDados['nome']);
    } elseif (isset($aDados['t_razao_social'])) {
      $this->getElement('t_razao_social')->setValue($aDados['t_razao_social']);
    }

    if (isset($aDados['pais'])) {
      $this->getElement('t_cod_pais')->setValue($aDados['pais']);
    } elseif (isset($aDados['t_cod_pais'])) {
      $this->getElement('t_cod_pais')->setValue($aDados['t_cod_pais']);
    }

    // Busca lista de cidades do UF e preenche no select
    $aCidade = array('0' => '');

    if (isset($aDados['uf'])) {

      $aCidade = Default_Model_Cadendermunicipio::getByEstado($aDados['uf']);

      $this->getElement('t_cod_municipio')->setMultiOptions($aCidade);
    } elseif (isset($aDados['t_uf'])) {

      $this->getElement('t_uf')->setValue($aDados['t_uf']);

      $aCidade = Default_Model_Cadendermunicipio::getByEstado($aDados['t_uf']);

      $this->getElement('t_cod_municipio')->setMultiOptions($aCidade);
    }

    if (isset($aDados['t_cod_municipio'])) {

      $this->getElement('t_cod_municipio')->setMultiOptions($aCidade);
      $this->getElement('t_cod_municipio')->setValue($aDados['t_cod_municipio']);
    } elseif (isset($aDados['municipio'])) {

      $this->getElement('t_cod_municipio')->setMultiOptions($aCidade);
      $this->getElement('t_cod_municipio')->setValue($aDados['municipio']);
    }

    if (isset($aDados['t_cep'])) {
      $this->getElement('t_cep')->setValue($aDados['t_cep']);
    } elseif (isset($aDados['cep'])) {
      $this->getElement('t_cep')->setValue($aDados['cep']);
    }

    if (isset($aDados['t_bairro'])) {
      $this->getElement('t_bairro')->setValue($aDados['t_bairro']);
    } elseif (isset($aDados['bairro'])) {
      $this->getElement('t_bairro')->setValue($aDados['bairro']);
    }

    if (isset($aDados['t_endereco'])) {
      $this->getElement('t_endereco')->setValue($aDados['t_endereco']);
    } elseif (isset($aDados['logradouro'])) {
      $this->getElement('t_endereco')->setValue($aDados['logradouro']);
    }

    if (isset($aDados['t_endereco_numero'])) {
      $this->getElement('t_endereco_numero')->setValue($aDados['t_endereco_numero']);
    } elseif (isset($aDados['numero'])) {
      $this->getElement('t_endereco_numero')->setValue($aDados['numero']);
    }

    if (isset($aDados['t_endereco_comp'])) {
      $this->getElement('t_endereco_comp')->setValue($aDados['t_endereco_comp']);
    } elseif (isset($aDados['complemento'])) {
      $this->getElement('t_endereco_comp')->setValue($aDados['complemento']);
    }

    if (isset($aDados['t_telefone'])) {
      $this->getElement('t_telefone')->setValue($aDados['t_telefone']);
    } elseif (isset($aDados['telefone'])) {
      $this->getElement('t_telefone')->setValue($aDados['telefone']);
    }

    if (isset($aDados['t_email'])) {
      $this->getElement('t_email')->setValue($aDados['t_email']);
    } elseif (isset($aDados['email'])) {
      $this->getElement('t_email')->setValue($aDados['email']);
    }

    return $this;
  }

  /**
   * Preenche os dados referentes ao serviço
   *
   * @param array $aDados
   * @return $this
   */
  public function preencheDadosServico($aDados) {

    // Busca lista de cidades do UF e preenche no select */
    if (isset($aDados['estado'])) {

      $aCidade = Default_Model_Cadendermunicipio::getByEstado($aDados['estado']);

      $this->getElement('estado')->setValue($aDados['estado']);
      $this->getElement('s_dados_municipio_incidencia')->setMultiOptions($aCidade);

      if (isset($aDados['s_dados_municipio_incidencia'])) {
        $this->getElement('s_dados_municipio_incidencia')->setValue($aDados['s_dados_municipio_incidencia']);
      }
    }

    if (isset($aDados['s_dados_iss_retido'])) {

      $oElmentoForm = $this->getElement('s_dados_iss_retido');
      $oElmentoForm->setAttrib('checked', FALSE);

      if ($aDados['s_dados_iss_retido'] == 1) {
        $oElmentoForm->setAttrib('checked', TRUE);
      }
    }

    return $this;
  }

  /**
   * Preenche os dados referentes a valores do serviço
   *
   * @param array $aDados
   * @return $this
   */
  public function preencheValores($aDados) {

    if (isset($aDados['s_vl_aliquota'])) {
      $this->getElement('s_vl_aliquota')->setValue($aDados['s_vl_aliquota']);
    } elseif (isset($aDados['aliq'])) {
      $this->getElement('s_vl_aliquota')->setValue($aDados['aliq']);
    }

    return $this;
  }

  /**
   * Reorganiza o array com os dados copiados de uma nota, para preencher o form da emissão de nota
   *
   * @param array $aDados
   * @return array
   */
  public function organizaDadosCopia($aDados) {

    // Verifica se os dados são de uma nota copiada
    if (isset($aDados['id_copia_nota'])){

      $this->getElement('s_dados_cod_tributacao_copia')->setValue($aDados['s_dados_cod_tributacao']);

      // Ajusta os dados do Tomador/Empresa
      $aDados['logradouro']  = $aDados['t_endereco'];
      $aDados['telefone']    = $aDados['t_telefone'];
      $aDados['complemento'] = $aDados['t_endereco_comp'];
      $aDados['numero']      = $aDados['t_endereco_comp'];
      $aDados['email']       = $aDados['t_email'];
      $aDados['nome']        = $aDados['t_cod_municipio'];
      $aDados['bairro']      = $aDados['t_bairro'];
      $aDados['cep']         = $aDados['t_cep'];
      $aDados['logradouro']  = $aDados['t_endereco'];
      $aDados['estado']      = $aDados['t_uf'];
      $aDados['pais']        = $aDados['p_cod_pais'];

      // Ajusta os dados do Serviço
      $aDados['estado']        = $aDados['p_uf'];
      $aDados['descricao']     = $aDados['s_dados_discriminacao'];
      $aDados['s_vl_servicos'] = DBSeller_Helper_Number_Format::toFloat($aDados['s_vl_servicos']);

      if ($aDados['s_dados_iss_retido'] == 1) {
        $aDados['s_dados_iss_retido'] = '0';
      } else if($aDados['s_dados_iss_retido'] == 2){
        $aDados['s_dados_iss_retido'] = '1';
      }
    }

    return $aDados;
  }
}