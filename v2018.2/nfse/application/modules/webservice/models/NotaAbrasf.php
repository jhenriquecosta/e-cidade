<?php
/**
 * E-cidade Software Publico para Gestão Municipal
 *   Copyright (C) 2014 DBSeller Serviços de Informática Ltda
 *                          www.dbseller.com.br
 *                          e-cidade@dbseller.com.br
 *   Este programa é software livre; você pode redistribuí-lo e/ou
 *   modificá-lo sob os termos da Licença Pública Geral GNU, conforme
 *   publicada pela Free Software Foundation; tanto a versão 2 da
 *   Licença como (a seu critério) qualquer versão mais nova.
 *   Este programa e distribuído na expectativa de ser útil, mas SEM
 *   QUALQUER GARANTIA; sem mesmo a garantia implícita de
 *   COMERCIALIZAÇÃO ou de ADEQUAÇÃO A QUALQUER PROPÓSITO EM
 *   PARTICULAR. Consulte a Licença Pública Geral GNU para obter mais
 *   detalhes.
 *   Você deve ter recebido uma cópia da Licença Pública Geral GNU
 *   junto com este programa; se não, escreva para a Free Software
 *   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *   02111-1307, USA.
 *   Cópia da licença no diretório licenca/licenca_en.txt
 *                                 licenca/licenca_pt.txt
 */



class WebService_Model_NotaAbrasf {

  /**
   * Nota fiscal que devera ser Convertida para a Abrasf
   * @var Contribuinte_Model_Nota
   */
  private $oNotaFiscal = null;

  private $sNameSpace = 'ii:';

  /**
   * Instanca do DOMDocument
   * @var DOMDocument
   */
  private $oDomDocument;

  /**
   * Elemento Pincipal da nota
   * @var DOMElement
   */
  private $oNodeNota;

  /**
   *Instancia uma nova nota no padrao Abrasf
   */
  public function __construct(Contribuinte_Model_Nota $oNota) {

    $this->oNotaFiscal  = $oNota;
    $this->oDomDocument = new DOMDocument();
    $this->oNodeNota    = $this->oDomDocument->createElement("{$this->sNameSpace}InfNfse");
  }

  protected function escreverDadosIdentificacao() {

    $sDataEmissao = $this->oNotaFiscal->getDt_nota()->format('Y-m-d');
    $sHoraEmissao = $this->oNotaFiscal->formatedHora();

    $sDataNota = "{$sDataEmissao}T{$sHoraEmissao}";
    /* Dados da Nota */
    $oXmlInfNfseNumero            = $this->oDomDocument->createElement("ii:Numero", $this->formatarNumeroNota($this->oNotaFiscal));
    $oXmlInfNfseCodigoVerificacao = $this->oDomDocument->createElement("ii:CodigoVerificacao", $this->oNotaFiscal->getCod_verificacao());
    $oXmlInfNfseDataEmissao       = $this->oDomDocument->createElement("ii:DataEmissao", $sDataNota);
    $this->oNodeNota->appendChild($oXmlInfNfseNumero);
    $this->oNodeNota->appendChild($oXmlInfNfseCodigoVerificacao);
    $this->oNodeNota->appendChild($oXmlInfNfseDataEmissao);

  }

  /**
   * Cria os nos de identificacao do RPS
   */
  protected function escreverDadosRps() {
    /* Identificação da RPs */

    $oXmlInfNfseIdentificacaoRps  = $this->oDomDocument->createElement("ii:IdentificacaoRps");

    $oXmlInfNfseIdentificacaoRpsNumero = $this->oDomDocument->createElement("ii:Numero", $this->oNotaFiscal->getN_rps());
    $oXmlInfNfseIdentificacaoRpsSerie  = $this->oDomDocument->createElement("ii:Serie", '');
    $oXmlInfNfseIdentificacaoRpsTipo   = $this->oDomDocument->createElement("ii:Tipo", '1');

    $sDataEmissaoRPS = '';
    if ($this->oNotaFiscal->getData_rps() != '') {
      $sDataEmissaoRPS = $this->oNotaFiscal->getData_rps()->format('Y-m-d');
    }
    $oXmlInfNfseIdentificacaoRpsDataEmissao = $this->oDomDocument->createElement("ii:DataEmissaoRps", $sDataEmissaoRPS);
    $oXmlInfNfseIdentificacaoRps->appendChild($oXmlInfNfseIdentificacaoRpsNumero);
    $oXmlInfNfseIdentificacaoRps->appendChild($oXmlInfNfseIdentificacaoRpsSerie);
    $oXmlInfNfseIdentificacaoRps->appendChild($oXmlInfNfseIdentificacaoRpsTipo);
    $this->oNodeNota->appendChild($oXmlInfNfseIdentificacaoRps);
    $this->oNodeNota->appendChild($oXmlInfNfseIdentificacaoRpsDataEmissao);

  }

  /**
   * Cria os nos referentes aos dados complementares da nota
   */
  protected  function escreverInformacoesComplementares() {

    $oXml        = $this->oDomDocument;
    $oXmlInfNfse = $this->oNodeNota;

    $oXmlNaturezaOperacao         = $oXml->createElement("ii:NaturezaOperacao", $this->oNotaFiscal->getNatureza_operacao());
    $oXmlRegimeEspecialTributacao = $oXml->createElement("ii:RegimeEspecialTributacao", '');
    $oXmlOptanteSimplesNacional   = $oXml->createElement("ii:OptanteSimplesNacional", $this->oNotaFiscal->getS_dec_simples_nacional());
    $oXmlIncentivadorCultural     = $oXml->createElement("ii:IncentivadorCultural", '2');
    $oXmlCompetencia              = $oXml->createElement("ii:Competencia", $this->oNotaFiscal->getDt_nota()->format('Y-m-d'));

    $sOutrasInformacoes    = $this->oNotaFiscal->getS_informacoes_complementares();
    $oXmlOutrasInformacoes = $oXml->createElement("ii:OutrasInformacoes", $sOutrasInformacoes);

    $oXmlInfNfse->appendChild($oXmlNaturezaOperacao);
    $oXmlInfNfse->appendChild($oXmlRegimeEspecialTributacao);

    $oXmlInfNfse->appendChild($oXmlOptanteSimplesNacional);
    $oXmlInfNfse->appendChild($oXmlIncentivadorCultural);
    $oXmlInfNfse->appendChild($oXmlCompetencia);
    $oXmlInfNfse->appendChild($oXmlOutrasInformacoes);

  }

  /**
   * Cria os nos da descricao e valores dos servicos
   */
  protected function escreverServicos() {

    $oXml        = $this->oDomDocument;
    $oXmlInfNfse = $this->oNodeNota;

    $oXmlServico  = $oXml->createElement("ii:Servico");
    $oXmlValores  = $oXml->createElement("ii:Valores");

    $oXmlValorServicos          = $oXml->createElement("ii:ValorServicos", $this->oNotaFiscal->getS_vl_servicos());
    $oXmlValorDeducoes          = $oXml->createElement("ii:ValorDeducoes", $this->oNotaFiscal->getS_vl_deducoes());
    $oXmlValorPis               = $oXml->createElement("ii:ValorPis", $this->oNotaFiscal->getS_vl_pis());
    $oXmlValorCofins            = $oXml->createElement("ii:ValorCofins", $this->oNotaFiscal->getS_vl_cofins());
    $oXmlValorInss              = $oXml->createElement("ii:ValorInss", $this->oNotaFiscal->getS_vl_inss());
    $oXmlValorIr                = $oXml->createElement("ii:ValorIr", $this->oNotaFiscal->getS_vl_ir());
    $oXmlValorIss               = $oXml->createElement("ii:ValorIss", $this->oNotaFiscal->getS_vl_iss());
    $oXmlValorCsll              = $oXml->createElement("ii:ValorCsll", $this->oNotaFiscal->getS_vl_csll());
    $oXmlIssRetido              = $oXml->createElement("ii:IssRetido", ($this->oNotaFiscal->getS_dados_iss_retido() == 2)? 1 : 2);
    $oXmlValorIssRetido         = $oXml->createElement("ii:ValorIssRetido", $this->oNotaFiscal->getValorImpostoRetido());
    $oXmlOutrasRetencoes        = $oXml->createElement("ii:OutrasRetencoes", $this->oNotaFiscal->getS_vl_outras_retencoes());
    $oXmlBaseCalculo            = $oXml->createElement("ii:BaseCalculo", $this->oNotaFiscal->getServicoBaseCalculo());
    $oXmlAliquota               = $oXml->createElement("ii:Aliquota", $this->oNotaFiscal->getServicoAliquota());
    $oXmlValorLiquidoNfse       = $oXml->createElement("ii:ValorLiquidoNfse", $this->oNotaFiscal->getVl_liquido_nfse());
    $oXmlDescontoIncondicionado = $oXml->createElement("ii:DescontoIncondicionado", $this->oNotaFiscal->getS_vl_desc_incondicionado());
    $oXmlDescontoCondicionado   = $oXml->createElement("ii:DescontoCondicionado", $this->oNotaFiscal->getS_vl_condicionado());

    $oXmlValores->appendChild($oXmlValorServicos);
    $oXmlValores->appendChild($oXmlValorDeducoes);
    $oXmlValores->appendChild($oXmlValorPis);
    $oXmlValores->appendChild($oXmlValorCofins);
    $oXmlValores->appendChild($oXmlValorInss);
    $oXmlValores->appendChild($oXmlValorIr);
    $oXmlValores->appendChild($oXmlValorIss);
    $oXmlValores->appendChild($oXmlValorCsll);
    $oXmlValores->appendChild($oXmlIssRetido);
    $oXmlValores->appendChild($oXmlValorIssRetido);
    $oXmlValores->appendChild($oXmlOutrasRetencoes);
    $oXmlValores->appendChild($oXmlBaseCalculo);
    $oXmlValores->appendChild($oXmlAliquota);
    $oXmlValores->appendChild($oXmlValorLiquidoNfse);
    $oXmlValores->appendChild($oXmlDescontoIncondicionado);
    $oXmlValores->appendChild($oXmlDescontoCondicionado);

    $oXmlServico->appendChild($oXmlValores);
    $oXmlInfNfse->appendChild($oXmlServico);

    $this->escreverListaServico($oXmlServico);
  }


  /**
   *Escreve a lista de serviços da nota
   */
  protected function escreverListaServico(DOMElement $oNodeServico) {

    $oXml  = $this->oDomDocument;
    $oNota = $this->oNotaFiscal;

    $oXmlItemListaServico = $oXml->createElement("ii:ItemListaServico", $oNota->getS_dados_item_lista_servico());
    $oXmlCodigoCnae       = $oXml->createElement("ii:CodigoCnae", $oNota->getS_dados_cod_cnae());
    $oXmlDiscriminacao    = $oXml->createElement("ii:Discriminacao", htmlspecialchars($oNota->getDescricaoServico()));
    $oXmlCodigoMunicipio  = $oXml->createElement("ii:CodigoMunicipio", $oNota->getS_dados_cod_municipio());

    $oNodeServico->appendChild($oXmlItemListaServico);
    $oNodeServico->appendChild($oXmlCodigoCnae);
    $oNodeServico->appendChild($oXmlDiscriminacao);
    $oNodeServico->appendChild($oXmlCodigoMunicipio);

  }


  protected  function escreverPrestadorServico() {

    $oXml  = $this->oDomDocument;
    $oNota = $this->oNotaFiscal;

    $oXmlPrestadorServico   = $oXml->createElement("ii:PrestadorServico");

    $oXmlIdentificacaoPrestador = $oXml->createElement("ii:IdentificacaoPrestador");

    $oXmlCnpj               = $oXml->createElement("ii:Cnpj", $oNota->getPrestadorCpfCnpj());
    $oXmlInscricaoMunicipal = $oXml->createElement("ii:InscricaoMunicipal", $oNota->getPrestadorInscricaoMunicipal());
    $oXmlIdentificacaoPrestador->appendChild($oXmlCnpj);
    $oXmlIdentificacaoPrestador->appendChild($oXmlInscricaoMunicipal);

    $oXmlPrestadorServico->appendChild($oXmlIdentificacaoPrestador);

    $oXmlRazaoSocial  = $oXml->createElement("ii:RazaoSocial", htmlspecialchars($oNota->getPrestadorRazaoSocial()));
    $oXmlNomeFantasia = $oXml->createElement("ii:NomeFantasia", htmlspecialchars($oNota->getP_nome_fantasia()));
    $oXmlPrestadorServico->appendChild($oXmlRazaoSocial);
    $oXmlPrestadorServico->appendChild($oXmlNomeFantasia);

    $oXmlPrestadorServico->appendChild($oXmlRazaoSocial);
    $oXmlPrestadorServico->appendChild($oXmlNomeFantasia);

    /* Endereço do prestador */
    $oXmlEndereco = $oXml->createElement("ii:Endereco");

    $oXmlEnderecoDescricao = $oXml->createElement("ii:EnderecoDescricao", htmlspecialchars($oNota->getP_endereco()));
    $oXmlNumero            = $oXml->createElement("ii:Numero", $oNota->getP_endereco_numero());
    $oXmlComplemento       = $oXml->createElement("ii:Complemento", $oNota->getP_endereco_comp());
    $oXmlBairro            = $oXml->createElement("ii:Bairro", htmlspecialchars($oNota->getP_bairro()));
    $oXmlCodigoMunicipio   = $oXml->createElement("ii:CodigoMunicipio", $oNota->getP_cod_municipio());
    $oXmlUf                = $oXml->createElement("ii:Uf", $oNota->getP_uf());
    $oXmlCep               = $oXml->createElement("ii:Cep", $oNota->getP_cep());
    $oXmlEndereco->appendChild($oXmlEnderecoDescricao);
    $oXmlEndereco->appendChild($oXmlNumero);
    $oXmlEndereco->appendChild($oXmlComplemento);
    $oXmlEndereco->appendChild($oXmlBairro);
    $oXmlEndereco->appendChild($oXmlCodigoMunicipio);
    $oXmlEndereco->appendChild($oXmlUf);
    $oXmlEndereco->appendChild($oXmlCep);

    $oXmlPrestadorServico->appendChild($oXmlEndereco);

    /* Contato */
    $oXmlContato = $oXml->createElement("ii:Contato");
    $oXmlTelefone = $oXml->createElement("ii:Telefone", $oNota->getP_telefone());
    $oXmlEmail    = $oXml->createElement("ii:Email", $oNota->getP_email());

    $oXmlContato->appendChild($oXmlTelefone);
    $oXmlContato->appendChild($oXmlEmail);

    $oXmlPrestadorServico->appendChild($oXmlContato);

    /* Adiciona os dados do prestador na informação da nota */
    $this->oNodeNota->appendChild($oXmlPrestadorServico);

  }

  /**
   * Escreve os dados referente ao tomador do serviço
   */
  protected function escreverTomadorServico() {

    $oXml  = $this->oDomDocument;
    $oNota = $this->oNotaFiscal;

    /* Dados do Tomador */
    $oXmlTomadorServico   = $oXml->createElement("ii:TomadorServico");

    $oXmlIdentificacaoTomador = $oXml->createElement("ii:IdentificacaoTomador");
    $oXmlCnpjCpf              = $oXml->createElement("ii:CpfCnpj");
    $oXmlCnpj                 = (strlen(DBSeller_Helper_Number_Format::unmaskCPF_CNPJ($oNota->getTomadorCpfCnpj())) != 14) ? $oXml->createElement("ii:Cpf", $oNota->getTomadorCpfCnpj()) : $oXml->createElement("ii:Cnpj", $oNota->getTomadorCpfCnpj());
    $oXmlInscricaoMunicipal   = $oXml->createElement("ii:InscricaoMunicipal", $oNota->getTomadorInscricaoMunicipal());

    $oXmlCnpjCpf->appendChild($oXmlCnpj);
    $oXmlIdentificacaoTomador->appendChild($oXmlCnpjCpf);
    $oXmlIdentificacaoTomador->appendChild($oXmlInscricaoMunicipal);

    $oXmlTomadorServico->appendChild($oXmlIdentificacaoTomador);

    $oXmlRazaoSocial  = $oXml->createElement("ii:RazaoSocial", htmlspecialchars($oNota->getTomadorRazaoSocial()));

    $oXmlTomadorServico->appendChild($oXmlRazaoSocial);

    /* Endereço do Tomador */
    $oXmlEndereco = $oXml->createElement("ii:Endereco");

    $oXmlEnderecoDescricao = $oXml->createElement("ii:EnderecoDescricao", htmlspecialchars($oNota->getT_endereco()));
    $oXmlNumero            = $oXml->createElement("ii:Numero",  $oNota->getT_endereco_numero());
    $oXmlComplemento       = $oXml->createElement("ii:Complemento", htmlspecialchars($oNota->getT_endereco_comp()));
    $oXmlBairro            = $oXml->createElement("ii:Bairro", htmlspecialchars($oNota->getT_bairro()));
    $oXmlCodigoMunicipio   = $oXml->createElement("ii:CodigoMunicipio", $oNota->getT_cod_municipio());
    $oXmlUf                = $oXml->createElement("ii:Uf", $oNota->getT_uf());
    $oXmlCep               = $oXml->createElement("ii:Cep", $oNota->getT_cep());

    $oXmlEndereco->appendChild($oXmlEnderecoDescricao);
    $oXmlEndereco->appendChild($oXmlNumero);
    $oXmlEndereco->appendChild($oXmlComplemento);
    $oXmlEndereco->appendChild($oXmlBairro);
    $oXmlEndereco->appendChild($oXmlCodigoMunicipio);
    $oXmlEndereco->appendChild($oXmlUf);
    $oXmlEndereco->appendChild($oXmlCep);

    $oXmlTomadorServico->appendChild($oXmlEndereco);

    /* Contato */
    $oXmlContato  = $oXml->createElement("ii:Contato");
    $oXmlTelefone = $oXml->createElement("ii:Telefone", $oNota->getT_telefone());
    $oXmlEmail    = $oXml->createElement("ii:Email", $oNota->getT_email());
    $oXmlContato->appendChild($oXmlTelefone);
    $oXmlContato->appendChild($oXmlEmail);

    $oXmlTomadorServico->appendChild($oXmlContato);
    $this->oNodeNota->appendChild($oXmlTomadorServico);
  }


  protected function escreverIntermediarioPeloServico() {

    $oXml                     = $this->oDomDocument;
    $oXmlIntermediarioServico = $oXml->createElement("ii:IntermediarioServico");
    $oXmlCpfCnpj              = $oXml->createElement("ii:CpfCnpj", '');
    $oXmlIntermediarioServico->appendChild($oXmlCpfCnpj);
    $this->oNodeNota->appendChild($oXmlIntermediarioServico);
  }

  /**
   * Escreve o orgao gerador
   */
  protected function escreverOrgaoGerador() {

    $oXml                = $this->oDomDocument;
    $oNota               = $this->oNotaFiscal;
    $oXmlOrgaoGerador    = $oXml->createElement("ii:OrgaoGerador");
    $oXmlCodigoMunicipio = $oXml->createElement("ii:CodigoMunicipio", $oNota->getS_dados_cod_municipio());
    $oXmlUf              = $oXml->createElement("ii:Uf", $oNota->getP_uf());
    $oXmlOrgaoGerador->appendChild($oXmlCodigoMunicipio);
    $oXmlOrgaoGerador->appendChild($oXmlUf);
    $this->oNodeNota->appendChild($oXmlOrgaoGerador);
  }

  /**
   * Escreve os dados da obra
   */
  protected function escreverDadosObra() {

    $oNota = $this->oNotaFiscal;
    $oXml  = $this->oDomDocument;

    $oXmlConstrucaoCivil = $oXml->createElement("ii:ConstrucaoCivil");
    $oXmlCodigoObra      = $oXml->createElement("ii:CodigoObra", $oNota->getS_codigo_obra());
    $oXmlUf              = $oXml->createElement("ii:Art", $oNota->getS_art());

    $oXmlConstrucaoCivil->appendChild($oXmlCodigoObra);
    $oXmlConstrucaoCivil->appendChild($oXmlUf);
    $this->oNodeNota->appendChild($oXmlConstrucaoCivil);
  }


  /**
   * retorna os dados do cancelamento da nota
   */
  public function getCancelamento($sNomeTagCancelamento = 'NfseCancelamento') {

    $oNota = $this->oNotaFiscal;
    $oXml  = $this->oDomDocument;
    if ($oNota->getCancelada()) {

      $oXmlCancelamento      = $oXml->createElement("ii:{$sNomeTagCancelamento}");
      $oXmlConfirmacao       = $oXml->createElement("ii:Confirmacao");
      $oXmlPedido            = $oXml->createElement("ii:Pedido");
      $oXmlPedidoInformacao  = $oXml->createElement("ii:InfPedidoCancelamento");


      $sDataCancelamento    = '';
      $iCodigoCancelamento = 9;
      $oCancelamentoNota   = $oNota->getCancelamento();
      if (!empty($oCancelamentoNota)) {

        $sDataCancelamento   = $oCancelamentoNota->getData()->format('Y-m-d')."T".$oCancelamentoNota->getHora()->format('H:i:s');
        $iCodigoCancelamento = $oCancelamentoNota->getMotivo();
      }
      $oXmlPedidoInformacao->appendChild($this->getIdentificacaoNota());
      $oXmlPedidoInformacao->appendChild($oXml->createElement('ii:CodigoCancelamento', $iCodigoCancelamento));
      $oXmlPedido->appendChild($oXmlPedidoInformacao);
      $oXmlConfirmacao->appendChild($oXmlPedido);
      $oXmlCancelamento->appendChild($oXmlConfirmacao);


      $oXmlInfConfirmacaoCancelamento = $oXml->createElement("ii:InfConfirmacaoCancelamento");
      $oXmlSucesso                    = $oXml->createElement('ii:Sucesso', '1');
      $oXmlDataCancelamento           = $oXml->createElement('ii:DataHora', $sDataCancelamento);

      $oXmlInfConfirmacaoCancelamento->appendChild($oXmlSucesso);
      $oXmlInfConfirmacaoCancelamento->appendChild($oXmlDataCancelamento);
      $oXmlConfirmacao->appendChild($oXmlInfConfirmacaoCancelamento);
      return $oXmlCancelamento;
    }
    return null;
  }

  /**
   * Retorna a nota fiscal no formato da Abrasf
   * @return DOMElement
   */
  public function getNota() {

    $this->escreverDadosIdentificacao();
    $this->escreverDadosRps();
    $this->escreverInformacoesComplementares();
    $this->escreverServicos();
    $this->escreverPrestadorServico();
    $this->escreverTomadorServico();
    $this->escreverIntermediarioPeloServico();
    $this->escreverOrgaoGerador();
    $this->escreverDadosObra();

    $oCompNfse = $this->oDomDocument->createElement('ii:CompNfse');
    $oNfse     = $this->oDomDocument->createElement('ii:Nfse');

    $oNfse->appendChild($this->oNodeNota);
    $oCompNfse->appendChild($oNfse);
    $oDadosCancelamento = $this->getCancelamento();
    if (!empty($oDadosCancelamento)) {
      $oCompNfse->appendChild($oDadosCancelamento);
    }
    $oDadosSubstituicao = $this->getNotaSubstituta();
    if (!empty($oDadosSubstituicao)) {
      $oCompNfse->appendChild($oDadosSubstituicao);
    }
    $this->oDomDocument->appendChild($oCompNfse);
    return $oCompNfse;
  }


  /**
   * Retorna os dados da Nota Substituta
   */
  public function getNotaSubstituta() {

    $oNota = $this->oNotaFiscal;
    $oXml  = $this->oDomDocument;

    if ($oNota->getIdNotaSubstituta() != '') {

      $oNotaSubstituta        = Contribuinte_Model_Nota::getById($oNota->getIdNotaSubstituta());
      if (empty($oNotaSubstituta)) {
        return null;
      }
      $oXmlDadosSubstituicao  = $oXml->createElement('ii:NfseSubstituicao');
      $oXmlDadosSubstituidora = $oXml->createElement('ii:NfseSubstituidora', $this->formatarNumeroNota($oNotaSubstituta));
      $oXmlDadosSubstituicao->appendChild($oXmlDadosSubstituidora);

      return $oXmlDadosSubstituicao;
    }
    return null;

  }


  /**
   * Retorna o Xml de identificacao do Municipio
   * @return DOMElement
   */
  public function getIdentificacaoNota() {

    $oNota = $this->oNotaFiscal;
    $oXml  = $this->oDomDocument;
    $oXmlIdentificacaoNfse = $oXml->createElement("ii:IdentificacaoNfse");

    $oXmlNfseNumero = $oXml->createElement('ii:Numero', $this->formatarNumeroNota($oNota));
    $oXmlNfseCnpj   = $oXml->createElement('ii:Cnpj', $oNota->getPrestadorCpfCnpj());

    $oXmlNfseInscricaoMunicipal = $oXml->createElement('ii:InscricaoMunicipal', $oNota->getPrestadorInscricaoMunicipal());
    $oXmlNfseMunicipio          = $oXml->createElement('ii:CodigoMunicipio', $oNota->getS_dados_cod_municipio());

    $oXmlIdentificacaoNfse->appendChild($oXmlNfseNumero);
    $oXmlIdentificacaoNfse->appendChild($oXmlNfseCnpj);
    $oXmlIdentificacaoNfse->appendChild($oXmlNfseInscricaoMunicipal);
    $oXmlIdentificacaoNfse->appendChild($oXmlNfseMunicipio);

    return $oXmlIdentificacaoNfse;
  }

  protected function formatarNumeroNota(Contribuinte_Model_Nota $oNota) {
    return $oNota->getCompetenciaAno().str_pad($oNota->getNotaNumero(), 11, '0', STR_PAD_LEFT);
  }
}