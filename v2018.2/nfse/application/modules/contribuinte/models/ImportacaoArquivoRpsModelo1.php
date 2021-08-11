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
 * Controle Preparação Dados para Importação (Modelo RPS 1.0 Abrasf)
 *
 * @package  Contribuinte/Model
 * @tutorial Modelo responsável por manipular o arquivo de importacao e retornar os dados necessários para processamento
 * @author   Everton Catto Heckler <everton.heckler@dbseller.com.br>
 */
class Contribuinte_Model_ImportacaoArquivoRpsModelo1 {

  /**
   * Mensagens de Erro do modelo de Importação
   *
   * @var array
   */
  private $aMensagensErroManual;

  /**
   * Variavel que define se ocorreu algum erro na importação
   * @var Boolean
   */
  private $bError = FALSE;

  /**
   * Mensagens de Erro encontradas na validação
   *
   * @var array
   */
  public $aMensagensErroValidacao = NULL;

  /**
   * Localização e nome do arquivo
   *
   * @var string
   */
  private $sArquivoXml;

  /**
   * Objeto para manipulação do XML
   *
   * @var SimpleXMLElement
   */
  private $oXml;

  /**
   * Objeto montado com as informações para importação da RPS
   *
   * @todo Para novas versões/modelos deve ser criada uma interface para padronizar o objeto de retorno
   * @var stdClass
   */
  private $oArquivoXmlRetorno;

  /**
   * Define o arquivo para processamento
   *
   * @param string $sArquivoProcessar
   */
  public function setArquivoCarregado($sArquivoXml) {
    $this->sArquivoXml = $sArquivoXml;
  }

  /**
   * Retorna se existe algum erro na validação do arquivo
   * @return boolean
   */
  public function getErro(){
    return $this->bError;
  }

  public function __construct() {
    $this->aMensagensErroManual = Administrativo_Model_ImportacaoRpsErros::getMensagensPorModelo(1);
  }

  /**
   * Valida a estrutura do arquivo
   *
   * @throws Exception
   * @return boolean
   */
  public function validarEstrutura() {

    if (empty($this->sArquivoXml)) {
      throw new Exception ('Informe o arquivo para validar.');
    }

    $oXml = new DOMDocument("1.0", "UTF-8");
    $oXml->load($this->sArquivoXml);

    $oXmlEnviarLoteResposta = $oXml->getElementsByTagName("EnviarLoteRpsEnvio")->item(0);

    /**
     * Verifica se existe o atributo 'xmlns' no arquivo XML
     */
    if ($oXmlEnviarLoteResposta && !$oXmlEnviarLoteResposta->getAttribute('xmlns')) {

      $oXmlEnviarLoteResposta->setAttribute("xmlns", "http://www.abrasf.org.br/ABRASF/arquivos/nfse.xsd");
      $oXml->appendChild($oXmlEnviarLoteResposta);
      $oXml->saveXML();
      $oXml->save($this->sArquivoXml);
    }

    $sSchemaValidacao = PUBLIC_PATH . '/webservice/xsdValidations/modelo1.xsd';
    $oValidate        = new DBSeller_Validator_XmlEstrutura($sSchemaValidacao);

    if (!$oValidate->isValid($this->sArquivoXml)) {

      $this->setMensagemErro('E160', implode(",", $oValidate->getErrors()));
      return FALSE;
    }

    return TRUE;
  }

  /**
   * Responsável por carregar o arquivo em memória
   *
   * @throws Exception
   * @return DOMDocument
   */
  public function carregar() {

    if (self::validarEstrutura()) {

      $this->oXml = simplexml_load_file($this->sArquivoXml);

      // remove arquivo XML
      unlink($this->sArquivoXml);

      // Seta o objeto de retorno com os dados do cabeçalho do arquivo
      self::carregarCabecalho();

      // Seta o objeto de retorno com a lista de RPS do arquivo
      self::carregarListaRps();

      // Retorna o objeto montado para importação
      return $this->oArquivoXmlRetorno;
    } else {

      //$this->setMensagemErro('E160');
      return NULL;
    }
  }

  /**
   * Seta o objeto de retorno com os dados do cabeçalho do arquivo
   */
  private function carregarCabecalho() {

    // Informações do Lote de RPS
    $this->oArquivoXmlRetorno->lote->numero              = (string) $this->oXml->LoteRps->NumeroLote;
    $this->oArquivoXmlRetorno->lote->cnpj                = (string) $this->oXml->LoteRps->Cnpj;
    $this->oArquivoXmlRetorno->lote->inscricao_municipal = (string) $this->oXml->LoteRps->InscricaoMunicipal;
    $this->oArquivoXmlRetorno->lote->quantidade_rps      = (int)    $this->oXml->LoteRps->QuantidadeRps;
  }

  /**
   * Seta o objeto de retorno com a lista de RPS
   */
  private function carregarListaRps() {

    // Varre os RPS do arquivo
    foreach ($this->oXml->LoteRps[0]->ListaRps[0] as $oXmlRps) {

      $oRps = new stdClass();

      self::carregarListaRpsIdentificao($oRps, $oXmlRps);
      self::carregarListaRpsPrestador($oRps, $oXmlRps);
      self::carregarListaTomador($oRps, $oXmlRps);
      self::carregarListaServico($oRps, $oXmlRps);
      self::carregarListaConstrucaoCivil($oRps, $oXmlRps);

      // Adiciona o RPS na lista do objeto de retorno
      $this->oArquivoXmlRetorno->rps[] = $oRps;
    }
  }

  /**
   * Seta a lista de RPS do objeto de retorno com as informações de indentificação do RPS
   *
   * @param stdClass $oRps
   * @param SimpleXMLElement $oXmlRps
   */
  private function carregarListaRpsIdentificao(stdClass &$oRps, SimpleXMLElement $oXmlRps) {

    // Identificação
    $oXmlRps                          = $oXmlRps->InfRps;
    $oRps->numero                     = (string) $oXmlRps->IdentificacaoRps->Numero;
    $oRps->serie                      = (string) $oXmlRps->IdentificacaoRps->Serie;
    $oRps->tipo                       = (string) $oXmlRps->IdentificacaoRps->Tipo;
    $oRps->data_emissao               = new DateTime((string) $oXmlRps->DataEmissao);
    $oRps->natureza_operacao          = (string) $oXmlRps->NaturezaOperacao;
    $oRps->regime_especial_tributacao = (string) $oXmlRps->RegimeEspecialTributacao;
    $oRps->optante_simples_nacional   = (string) $oXmlRps->OptanteSimplesNacional;
    $oRps->incentivador_cultural      = (string) $oXmlRps->IncentivadorCultural;
    $oRps->status                     = (string) $oXmlRps->Status;
  }

  /**
   * Seta a lista de RPS do objeto de retorno com as informações do prestador
   *
   * @param stdClass $oRps
   * @param SimpleXMLElement $oXmlRps
   */
  private function carregarListaRpsPrestador(stdClass &$oRps, SimpleXMLElement $oXmlRps) {

    // Prestador
    $oPrestador                           = $oXmlRps->InfRps->Prestador;
    $oRps->prestador->cnpj                = (string) $oPrestador->Cnpj;
    $oRps->prestador->inscricao_municipal = (string) $oPrestador->InscricaoMunicipal;
  }

  /**
   * Seta a lista de RPS do objeto de retorno com as informações do tomador
   *
   * @param stdClass $oRps
   * @param SimpleXMLElement $oXmlRps
   */
  private function carregarListaTomador(stdClass &$oRps, SimpleXMLElement $oXmlRps) {

    $oTomador                    = $oXmlRps->InfRps->Tomador;

    $oRps->tomador->razao_social = (string) $oTomador->RazaoSocial;

    if (isset($oTomador->IdentificacaoTomador->CpfCnpj->Cpf)) {
      $oRps->tomador->cpf_cnpj = (string) $oTomador->IdentificacaoTomador->CpfCnpj->Cpf;
    } else {
      $oRps->tomador->cpf_cnpj = (string) $oTomador->IdentificacaoTomador->CpfCnpj->Cnpj;
    }

    $oRps->tomador->im = (string) $oTomador->IdentificacaoTomador->InscricaoMunicipal;

    $oTomadorEndereco                        = $oTomador->Endereco;
    $oRps->tomador->endereco->descricao      = (string) $oTomadorEndereco->Endereco;
    $oRps->tomador->endereco->numero         = (string) $oTomadorEndereco->Numero;
    $oRps->tomador->endereco->complemento    = (string) $oTomadorEndereco->Complemento;
    $oRps->tomador->endereco->bairro         = (string) $oTomadorEndereco->Bairro;
    $oRps->tomador->endereco->ibge_municipio = (string) $oTomadorEndereco->CodigoMunicipio;
    $oRps->tomador->endereco->uf             = (string) $oTomadorEndereco->Uf;
    $oRps->tomador->endereco->cep            = (string) $oTomadorEndereco->Cep;

    $oTomadorContato                         = $oTomador->Contato;
    $oRps->tomador->contato->telefone        = (string) $oTomadorContato->Telefone;
    $oRps->tomador->contato->email           = (string) $oTomadorContato->Email;
  }

  /**
   * Seta a lista de RPS do objeto de retorno com as informações do serviço
   *
   * @param stdClass $oRps
   * @param SimpleXMLElement $oXmlRps
   */
  private function carregarListaServico(stdClass &$oRps, SimpleXMLElement $oXmlRps) {

    // Identificação do serviço
    $oServico                                        = $oXmlRps->InfRps->Servico;
    $oRps->servico->atividade                        = (string)  $oServico->ItemListaServico;
    $oRps->servico->codigo_cnae                      = (string)  $oServico->CodigoCnae;
    $oRps->servico->discriminacao                    = (string)  $oServico->Discriminacao;
    $oRps->servico->ibge_municipio                   = (string)  $oServico->CodigoMunicipio;

    // Valores do Serviço
    $oServicoValores                                 = $oServico->Valores;
    $oRps->servico->valores->valor_servicos          = (float)   $oServicoValores->ValorServicos;
    $oRps->servico->valores->valor_deducoes          = (float)   $oServicoValores->ValorDeducoes;
    $oRps->servico->valores->valor_pis               = (float)   $oServicoValores->ValorPis;
    $oRps->servico->valores->valor_cofins            = (float)   $oServicoValores->ValorCofins;
    $oRps->servico->valores->valor_inss              = (float)   $oServicoValores->ValorInss;
    $oRps->servico->valores->valor_ir                = (float)   $oServicoValores->ValorIr;
    $oRps->servico->valores->valor_csll              = (float)   $oServicoValores->ValorCsll;
    $oRps->servico->valores->iss_retido              = (integer) $oServicoValores->IssRetido;
    $oRps->servico->valores->valor_iss               = (float)   $oServicoValores->ValorIss;
    $oRps->servico->valores->valor_iss_retido        = (float)   $oServicoValores->ValorIssRetido;
    $oRps->servico->valores->outras_retencoes        = (float)   $oServicoValores->OutrasRetencoes;
    $oRps->servico->valores->base_calculo            = (float)   $oServicoValores->BaseCalculo;
    $oRps->servico->valores->aliquota                = (float)   $oServicoValores->Aliquota;
    $oRps->servico->valores->valor_liquido           = (float)   $oServicoValores->ValorLiquidoNfse;
    $oRps->servico->valores->desconto_incondicionado = (float)   $oServicoValores->DescontoIncondicionado;
    $oRps->servico->valores->desconto_condicionado   = (float)   $oServicoValores->DescontoCondicionado;
  }

  /**
   * Seta a lista de RPS do objeto de retorno com as informações da construção civil
   *
   * @param stdClass $oRps
   * @param SimpleXMLElement $oXmlRps
   */
  public function carregarListaConstrucaoCivil(stdClass &$oRps, SimpleXMLElement $oXmlRps) {

    // Identificação do serviço
    $oConstrucaoCivil                    = $oXmlRps->InfRps->ConstrucaoCivil;
    $oRps->construcao_civil->codigo_obra = (string) $oConstrucaoCivil->CodigoObra;
    $oRps->construcao_civil->art         = (string) $oConstrucaoCivil->Art;
  }


  /**
   * Valida a importação de arquivo do tipo RPS modelo 1 (ABRASF 1.0)
   */
  public function validaArquivoCarregado() {

    $oSessao = new Zend_Session_Namespace('nfse');

    if (empty($this->oDadosPrefeitura)) {

      $aParametrosPrefeitura = Administrativo_Model_ParametroPrefeitura::getAll(0, 1);

      if (count($aParametrosPrefeitura) == 0) {
        throw new Exception('Parâmetros da prefeitura não configurados. Processamento Abortado');
      }

      $this->oDadosPrefeitura = $aParametrosPrefeitura[0];
    }

    if (empty($this->oArquivoXmlRetorno->lote->numero)) {
      $this->setMensagemErro('E88');
    }

    if (empty($this->oArquivoXmlRetorno->lote->cnpj)) {
      $this->setMensagemErro('E46');
    }

    $oContribuinte = Contribuinte_Model_Contribuinte::getByCpfCnpj($this->oArquivoXmlRetorno->lote->cnpj);

    if (empty($oContribuinte)) {
      $this->setMensagemErro('E45', 'Contribuinte: ' . $this->oArquivoXmlRetorno->lote->cnpj);
    } else {

      if ($oContribuinte->getCgcCpf() != $oSessao->contribuinte->getCgcCpf()) {
        $this->setMensagemErro('E156', '', true);
      }
    }

    if ($this->oArquivoXmlRetorno->lote->quantidade_rps != count($this->oArquivoXmlRetorno->rps)) {
      $this->setMensagemErro('E69');
    }

    if (strlen($this->oArquivoXmlRetorno->lote->quantidade_rps) > 4) {
      $this->setMensagemErro('E72');
    }

    $aNumeracaoRPS = array();

    foreach ($this->oArquivoXmlRetorno->rps as $oRps) {

      if ($this->oArquivoXmlRetorno->lote->inscricao_municipal != $oRps->prestador->inscricao_municipal) {
        $this->setMensagemErro('E70', 'RPS: ' . $oRps->numero);
      }

      if (empty($oRps->numero)) {
        $this->setMensagemErro('E11');
      } else {

        if (is_int($oRps->numero) && strlen($oRps->numero) > 15) {
          $this->setMensagemErro('E96', 'RPS: ' . $oRps->numero);
        }

        if (in_array($oRps->numero, $aNumeracaoRPS)) {
          $this->setMensagemErro('E71', 'RPS: ' . $oRps->numero);
        }

        $aNumeracaoRPS[$oRps->numero] = NULL;
      }

      if (strlen($oRps->serie) > 5) {
        $this->setMensagemErro('E97', 'RPS: ' . $oRps->numero);
      }

      if (empty($oRps->tipo)) {
        $this->setMensagemErro('E12', 'RPS: ' . $oRps->numero);
      }

      if (empty($oRps->natureza_operacao)) {
        $this->setMensagemErro('E3', 'RPS: ' . $oRps->numero);
      } else {

        if (!in_array($oRps->natureza_operacao, array(1,2,3,4,5,6))) {
          $this->setMensagemErro('E144', 'RPS: ' . $oRps->numero);
        }
      }

      if (empty($oRps->optante_simples_nacional)) {
        $this->setMensagemErro('E8', 'RPS: ' . $oRps->numero);
      } else {

        if (!in_array($oRps->optante_simples_nacional, array(1,2))) {
          $this->setMensagemErro('E146', 'RPS: ' . $oRps->numero);
        }
      }

      if (empty($oRps->incentivador_cultural)) {
        $this->setMensagemErro('E9', 'RPS: ' . $oRps->numero);
      } else {

        if (!in_array($oRps->incentivador_cultural, array(1,2))) {
          $this->setMensagemErro('E147', 'RPS: ' . $oRps->numero);
        }
      }

      if (empty($oRps->data_emissao)) {
        $this->setMensagemErro('E14', 'RPS: ' . $oRps->numero);
      }

      if (!in_array($oRps->status, array(1,2))) {
        $this->setMensagemErro('E68', 'RPS: ' . $oRps->numero);
      }

      if ($oRps->data_emissao->format('Ymd') > date('Ymd')) {
        $this->setMensagemErro('E16', 'RPS: ' . $oRps->numero);
      }

      if ($oRps->prestador->cnpj == $oRps->tomador->cpf_cnpj) {
        $this->setMensagemErro('E52', 'RPS: ' . $oRps->numero);
      }

      // validação dos valores se float
      $oNumeroFloat = new Zend_Validate_Float();

      if ($oRps->servico->valores->valor_servicos <= 0) {
        $this->setMensagemErro('E18', 'RPS: ' . $oRps->numero);
      }

      if (!$oNumeroFloat->isValid($oRps->servico->valores->valor_servicos)) {
        $this->setMensagemErro('E100', 'RPS: ' . $oRps->numero);
      }

      if ($oRps->servico->valores->valor_deducoes > $oRps->servico->valores->valor_servicos) {
        $this->setMensagemErro('E19', 'RPS: ' . $oRps->numero);
      }

      if ($oRps->servico->valores->valor_deducoes < 0) {
        $this->setMensagemErro('E20', 'RPS: ' . $oRps->numero);
      }

      if (!$oNumeroFloat->isValid($oRps->servico->valores->valor_deducoes)) {
        $this->setMensagemErro('E101', 'RPS: ' . $oRps->numero);
      }

      $fTotalDesconto = $oRps->servico->valores->desconto_incondicionado + $oRps->servico->valores->desconto_condicionado;

      if ($fTotalDesconto > $oRps->servico->valores->valor_servicos) {
        $this->setMensagemErro('E21', 'RPS: ' . $oRps->numero);
      }

      if ($fTotalDesconto < 0) {
        $this->setMensagemErro('E22', 'RPS: ' . $oRps->numero);
      }

      if (!$oNumeroFloat->isValid($fTotalDesconto)) {
        $this->setMensagemErro('E102', 'RPS: ' . $oRps->numero);
      }

      if ($oRps->servico->valores->valor_pis < 0) {
        $this->setMensagemErro('E23', 'RPS: ' . $oRps->numero);
      }

      if (!$oNumeroFloat->isValid($oRps->servico->valores->valor_pis)) {
        $this->setMensagemErro('E103', 'RPS: ' . $oRps->numero);
      }

      if ($oRps->servico->valores->valor_cofins < 0) {
        $this->setMensagemErro('E24', 'RPS: ' . $oRps->numero);
      }

      if (!$oNumeroFloat->isValid($oRps->servico->valores->valor_cofins)) {
        $this->setMensagemErro('E103', 'RPS: ' . $oRps->numero);
      }

      if ($oRps->servico->valores->valor_inss < 0) {
        $this->setMensagemErro('E25', 'RPS: ' . $oRps->numero);
      }

      if (!$oNumeroFloat->isValid($oRps->servico->valores->valor_inss)) {
        $this->setMensagemErro('E103', 'RPS: ' . $oRps->numero);
      }

      if ($oRps->servico->valores->valor_ir < 0) {
        $this->setMensagemErro('E26', 'RPS: ' . $oRps->numero);
      }

      if (!$oNumeroFloat->isValid($oRps->servico->valores->valor_ir)) {
        $this->setMensagemErro('E103', 'RPS: ' . $oRps->numero);
      }

      if ($oRps->servico->valores->valor_csll < 0) {
        $this->setMensagemErro('E27', 'RPS: ' . $oRps->numero);
      }

      if (!$oNumeroFloat->isValid($oRps->servico->valores->valor_csll)) {
        $this->setMensagemErro('E103', 'RPS: ' . $oRps->numero);
      }

      if (!in_array($oRps->servico->valores->iss_retido, array(1,2))) {
        $this->setMensagemErro('E36', 'RPS: ' . $oRps->numero);
      }

      if ($oRps->servico->valores->iss_retido == 1) {

        if ($oRps->servico->valores->valor_iss_retido <= 0) {
          $this->setMensagemErro('E40', 'RPS: ' . $oRps->numero);
        }

        if (!$oNumeroFloat->isValid($oRps->servico->valores->valor_iss_retido)) {
          $this->setMensagemErro('E153', 'RPS: ' . $oRps->numero);
        }

        if (strlen(DBSeller_Helper_Number_Format::unmaskCPF_CNPJ($oRps->tomador->cpf_cnpj)) != 14) {
          $this->setMensagemErro('E39', 'RPS: ' . $oRps->numero.". Serviços tomados por pessoa Física não pode reter iss");
        }
      }

      if ($oRps->servico->valores->iss_retido == 1
      && $oRps->servico->valores->valor_iss_retido > $oRps->servico->valores->valor_servicos) {
        $this->setMensagemErro('E99', 'RPS: ' . $oRps->numero);
      }

      if (empty($oRps->servico->discriminacao)) {
        $this->setMensagemErro('E41', 'RPS: ' . $oRps->numero);
      }

      if (!empty($oContribuinte)) {

        $oContribuinteEntity = $oContribuinte->getContribuinteByCnpjCpf($this->oArquivoXmlRetorno->lote->cnpj);

        $iInscricaoMunicipal = $oContribuinteEntity->getIm();
        $aServicos           = Contribuinte_Model_Servico::getByIm($iInscricaoMunicipal);

        // Valida se o prestador de serviço pode atuar no município
        if (empty($aServicos)) {
          $this->setMensagemErro('E17', 'RPS: ' . $oRps->numero);
        }

        // Valida se o prestador do serviço é emissor de NFSE
        $iTipoEmissaoNfse = Contribuinte_Model_ContribuinteAbstract::TIPO_EMISSAO_NOTA;

        if ($oContribuinteEntity->getTipoEmissao() != $iTipoEmissaoNfse) {
          $this->setMensagemErro('E138', 'RPS: ' . $oRps->numero);
        }

        // Valida a competência
        $oCompetencia = new Contribuinte_Model_Competencia(
            $oRps->data_emissao->format('Y'),
            $oRps->data_emissao->format('m'),
            $oContribuinte
        );

        if (empty($oCompetencia) || $oCompetencia->existeGuiaEmitida()) {
          $this->setMensagemErro(null, "A competência da RPS \"{$oRps->numero}\" é inválida, já existe Guia Emitida.");
        }
      }

      // Valida se a data é maior que a atual
      if ($oRps->data_emissao->format('Y-m') > date('Y-m')) {
        $this->setMensagemErro('E2', 'RPS: ' . $oRps->numero);
      }

      // Valida se já existe na base de dados
      $oTipoRps = Administrativo_Model_ParametroPrefeituraRps::getByTipoNfse($oRps->tipo);
      $iTipoRps = 0;

      // Valida o tipo de RPS
      if (is_object($oTipoRps)) {
        $iTipoRps = $oTipoRps->getEntity()->getTipoEcidade($oRps->tipo);
      }

      if ($iTipoRps == 0) {
        $this->setMensagemErro('E13', 'RPS: ' . $oRps->numero);
      }

      // Verifica se a numeração do AIDOF é válida
      $oAidof = new Administrativo_Model_Aidof();
      $lVerificaNumeracaoRps = $oAidof->verificarNumeracaoValidaParaEmissaoDocumento(
          $oSessao->contribuinte->getInscricaoMunicipal(),
          $oRps->numero,
          $iTipoRps
      );

      if ($lVerificaNumeracaoRps === FALSE) {
        $this->setMensagemErro('E90', 'RPS: ' . $oRps->numero);
      }

      $lExisteRps = Contribuinte_Model_Nota::existeRps($oSessao->contribuinte, $oRps->numero, $oRps->tipo);

      if ($lExisteRps) {
        $this->setMensagemErro('E10', 'RPS: ' . $oRps->numero);
      }

      if (empty($oRps->servico->atividade)) {
        $this->setMensagemErro('E31', 'RPS: ' . $oRps->numero);
      } else {

        if (strlen($oRps->servico->atividade) > 5) {
          $this->setMensagemErro('E104', 'RPS: ' . $oRps->numero);
        }

        // Valida Grupo de Serviço/Atividade
        // if (!empty($iInscricaoMunicipal)) {

        //   $oServico = Contribuinte_Model_Servico::getServicoPorAtividade($iInscricaoMunicipal, $oRps->servico->atividade);

        //   if (!$oServico) {
        //     $this->setMensagemErro('E30', 'RPS: ' . $oRps->numero);
        //   }
        // }

        // Valida Atividade/CNAE
        if (empty($oRps->servico->codigo_cnae)) {
          $this->setMensagemErro('E33', 'RPS: ' . $oRps->numero);
        } else {

          // $oServico = Contribuinte_Model_Servico::getServicoPorAtividade($iInscricaoMunicipal, $oRps->servico->atividade, TRUE, NULL, $oRps->servico->codigo_cnae);

          if (strlen($oRps->servico->codigo_cnae) > 7) {
            $this->setMensagemErro('E105', 'RPS: ' . $oRps->numero);
          }

          // if (!$oServico) {
          //   $this->setMensagemErro('E33', 'RPS: ' . $oRps->numero);
          // }
        }
      }

      if (!empty($oRps->servico->ibge_municipio)) {

        if (strlen($oRps->servico->ibge_municipio) > 7) {
          $this->setMensagemErro('E108', 'RPS: ' . $oRps->numero);
        }

        // 2 = fora do municipio
        if ($oRps->natureza_operacao == 2 && $oRps->servico->ibge_municipio == $this->oDadosPrefeitura->getIbge()) {
          $this->setMensagemErro('E110', 'RPS: ' . $oRps->numero);
        }

        // Validar IBGE de Prestação do serviço
        $oMunicipioPrestacaoServico = Default_Model_Cadendermunicipio::getByCodIBGE($oRps->servico->ibge_municipio);

        if (empty($oMunicipioPrestacaoServico)) {
          $this->setMensagemErro('E42', 'RPS: ' . $oRps->numero);
        }
      }

      if (strlen($oRps->construcao_civil->art) > 15) {
        $this->setMensagemErro('E130', 'RPS: ' . $oRps->numero);
      }

      if (strlen($oRps->construcao_civil->codigo_obra) > 15) {
        $this->setMensagemErro('E129', 'Rps: ' . $oRps->numero);
      }

      if (count($this->aMensagensErroValidacao) >= 50) {
        $this->setMensagemErro('E49', '',  TRUE);
      }
    }

    // Se existirem erros executa uma exceção com a lista de erros
    if (count($this->aMensagensErroValidacao) > 0) {
      return FALSE;
    }

    return TRUE;
  }


  /**
   * Mensagens de erro
   *
   * @param string $sCodigoErro
   * @param string $sAjuda
   */
  public function setMensagemErro($sCodigoErro, $sAjuda = '') {

    $oErro  = new stdClass();

    $oErro->sMensagem                = $this->aMensagensErroManual[$sCodigoErro]->sMensagem . ' ' . (!empty($sAjuda) ? '(' . $sAjuda . ')': '');
    $oErro->sCodigo                  = $sCodigoErro;
    $oErro->sSolucao                 = $this->aMensagensErroManual[$sCodigoErro]->sSolucao;
    $this->aMensagensErroValidacao[] = $oErro;
    $this->bError                    = TRUE;
  }

  /**
   * Prepara o Retorno de Sucesso do processamento no WebService
   * @param integer $iNumeroLote
   * @param object $oDadosImportacao
   */
  public function processaSucessoWebService($oDadosImportacao) {

    $oXml = new DOMDocument("1.0", "UTF-8");
    $oXmlEnviarLoteResposta = $oXml->createElement("ii:EnviarLoteRpsResposta");
    $oXmlEnviarLoteResposta->setAttribute("xmlns:ii", "urn:DBSeller");

    $sMensagem = 'RecepcionarLoteRps: Processamento concluído com sucesso';

    /**
     * Cria um protocolo para a operação executada
     */
    $oProtocolo = $this->adicionaProtocolo(Administrativo_Model_Protocolo::$TIPO_SUCESSO,
                                          $sMensagem,
                                          $oDadosImportacao->getNumeroLote(),
                                          $oDadosImportacao);

    $oXmlProtocolo            = $oXml->createElement("ii:Protocolo", $oProtocolo->getProtocolo());
    $oXmlDataRecebimento      = $oXml->createElement("ii:DataRecebimento", $oProtocolo->getDataProcessamento()->format('Y-m-d\TH:m:s'));
    $oXmlNumeroLote           = $oXml->createElement("ii:NumeroLote", $oDadosImportacao->getNumeroLote());
    $oXmlListaMensagemRetorno = $oXml->createElement("ii:ListaMensagemRetorno");

    $oXmlEnviarLoteResposta->appendChild($oXmlProtocolo);
    $oXmlEnviarLoteResposta->appendChild($oXmlDataRecebimento);
    $oXmlEnviarLoteResposta->appendChild($oXmlNumeroLote);
    $oXmlEnviarLoteResposta->appendChild($oXmlListaMensagemRetorno);
    $oXml->appendChild($oXmlEnviarLoteResposta);

    return $oXml->saveXML();
  }

  /**
   * Prepara o Retorno de Erro do processamento no WebService
   * @param integer $iNumeroLote
   */
  public function processaErroWebService($iNumeroLote) {

    $oXml = new DOMDocument("1.0", "UTF-8");
    $oXmlEnviarLoteResposta = $oXml->createElement("ii:EnviarLoteRpsResposta");
    $oXmlEnviarLoteResposta->setAttribute( "xmlns:ii", "urn:DBSeller" );

    $oXmlListaMensagemRetorno = $oXml->createElement("ii:ListaMensagemRetorno");
    $aCodigoMensagemProtocolo = array();

    foreach ($this->aMensagensErroValidacao as $oMensagem) {

      if (empty($oMensagem->sCodigo)) {
        $aCodigoMensagemProtocolo[] = 'E1';
      } else {
        $aCodigoMensagemProtocolo[] = $oMensagem->sCodigo;
      }

      $oXmlListaMensagemRetornoMensagem         = $oXml->createElement("ii:MensagemRetorno");
      $oXmlListaMensagemRetornoMensagemCodigo   = $oXml->createElement("ii:Codigo", $oMensagem->sCodigo);
      $oXmlListaMensagemRetornoMensagemMensagem = $oXml->createElement("ii:Mensagem", $oMensagem->sMensagem);
      $oXmlListaMensagemRetornoMensagemCorrecao = $oXml->createElement("ii:Correcao", $oMensagem->sSolucao);

      $oXmlListaMensagemRetornoMensagem->appendChild($oXmlListaMensagemRetornoMensagemCodigo);
      $oXmlListaMensagemRetornoMensagem->appendChild($oXmlListaMensagemRetornoMensagemMensagem);
      $oXmlListaMensagemRetornoMensagem->appendChild($oXmlListaMensagemRetornoMensagemCorrecao);

      $oXmlListaMensagemRetorno->appendChild($oXmlListaMensagemRetornoMensagem);
    }

    $sMensagem = 'RecepcionarLoteRps: Erros encontrados, Código(s): ' . implode(',', $aCodigoMensagemProtocolo);

    /**
     * Cria um protocolo para a operação executada
     */
    $oProtocolo = $this->adicionaProtocolo(Administrativo_Model_Protocolo::$TIPO_ERRO, $sMensagem, $iNumeroLote);

    $oXmlProtocolo       = $oXml->createElement("ii:Protocolo", $oProtocolo->getProtocolo());
    $oXmlDataRecebimento = $oXml->createElement("ii:DataRecebimento", $oProtocolo->getDataProcessamento()->format('Y-m-d\TH:m:s'));
    $oXmlNumeroLote      = $oXml->createElement("ii:NumeroLote", $iNumeroLote);

    $oXmlEnviarLoteResposta->appendChild($oXmlProtocolo);
    $oXmlEnviarLoteResposta->appendChild($oXmlDataRecebimento);
    $oXmlEnviarLoteResposta->appendChild($oXmlNumeroLote);

    $oXmlEnviarLoteResposta->appendChild($oXmlListaMensagemRetorno);
    $oXml->appendChild($oXmlEnviarLoteResposta);

    return $oXml->saveXML();
  }

  /**
   * Prepara o Retorno de Erro do processamento no Sistema
   * @param integer $iNumeroLote
   */
  public function processaErroSistema() {

    $sMensagem = '';
    $iItemErro = 1;

    foreach ($this->aMensagensErroValidacao as $oMensagem) {

      $sMensagem .=  "<b>- {$iItemErro} Código</b>: {$oMensagem->sCodigo} - {$oMensagem->sMensagem}<br>";
      $iItemErro++;
    }

    return $sMensagem;
  }

  /**
   *
   * @param integer $iTipo
   * @param string $sMensagem
   * @param integer $iNumeroLote
   * @param object $oDadosImportacao
   * @return Contribuinte_Model_ProtocoloImportacao
   */
  public function adicionaProtocolo($iTipo, $sMensagem, $iNumeroLote, $oDadosImportacao = NULL) {

    /**
     * Cria um protocolo para a operação executada
     */
    $oProtocolo       = new Administrativo_Model_Protocolo();
    $oProtocoloCriado = $oProtocolo->criaProtocolo($iTipo, $sMensagem);

    /**
     * Cria o vinculo entre o protocolo e a importacao do arquivo
     */
    $oProtocoloImportacao = new Contribuinte_Model_ProtocoloImportacao();
    $oProtocoloImportacao->setProtocolo($oProtocoloCriado);

    if ($oDadosImportacao) {
      $oProtocoloImportacao->setImportacao($oDadosImportacao);
    }

    $oProtocoloImportacao->setNumeroLote($iNumeroLote);
    $oProtocoloImportacao->persist();

    return $oProtocolo;
  }
}
