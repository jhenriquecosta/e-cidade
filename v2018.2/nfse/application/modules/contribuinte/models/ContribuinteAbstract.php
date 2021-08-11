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
 * Classe Abstrata Responsável por manipular os Dados dos Contribuintes
 * @author Everton Catto Heckler <everton.heckler@dbseller.com.br>
 * @package Contribuinte\Model\Contribuinte
 */

class Contribuinte_Model_ContribuinteAbstract {

  /**
   * Tipo para Emissão de DMS
   * @var integer
   */
  const TIPO_EMISSAO_DMS = 11;

  /**
   * Tipo para Emissão de NFSE (Notas Fiscal de Serviço Eletrônica)
   * @var integer
   */
  const TIPO_EMISSAO_NOTA = 10;

  /**
   * Tipo de Optante Simples Nacional: Microempresa
   * @var integer
   */
  const OPTANTE_SIMPLES_TIPO_MICROEMPRESA = 1;

  /**
   * Tipo de Optante Simples Nacional: Empresa de pequeno porte
   * @var integer
   */
  const OPTANTE_SIMPLES_TIPO_PEQUENO_PORTE = 2;

  /**
   * Tipo de Optante Simples Nacional: MEI
   * @var integer
   */
  const OPTANTE_SIMPLES_TIPO_MEI = 3;

  /**
   * Tipo de Optante Simples Nacional: MEI
   * @var integer
   */
  const NAO_OPTANTE_SIMPLES = 0;

  /**
   * Tipo de Optante Simples Nacional Baixado
   * @var string
   */
  const OPTANTE_SIMPLES_NACIONAL_BAIXADO = "Sim";

  /**
   * Tipo de Regime tributário Sociedade de Profissionais
   * @var integer
   */
  const REGIME_TRIBUTARIO_SOCIEDADE_PROFISSIONAIS = 22;

  /**
   * Tipo de Regime tributário Fixado
   * @var integer
   */
  const REGIME_TRIBUTARIO_FIXADO = 18;

  /**
   * Tipo de Regime tributário MEI
   * @var integer
   */
  const REGIME_TRIBUTARIO_MEI = 20;

  /**
   * Tipo de Regime tributário Cooperativa
   * @var integer
   */
  const REGIME_TRIBUTARIO_COOPERATIVA = 15;

  /**
   * Tipo de Regime tributário Estimativa
   * @var integer
   */
  const REGIME_TRIBUTARIO_ESTIMATIVA = 17;

  /**
   * Tipo de exigibilidade Exigivel
   * @var integer
   */
  const EXIGIBILIDADE_EXIGIVEL = 23;

  /**
   * Tipo de exigibilidade Isento
   * @var integer
   */
  const EXIGIBILIDADE_ISENTO = 25;

  /**
   * Tipo de exigibilidade Imude
   * @var integer
   */
  const EXIGIBILIDADE_IMUNE = 27;

  /**
   * Identificador
   * @var integer
   */
  private $iIdUsuarioContribuinte;

  /**
   * Razão social
   * @var string
   */
  private $sRazaoSocial;

  /**
   * Código da empresa
   * @var integer
   */
  private $iCodigoEmpresa;

  /**
   * CNPJ
   * @var string
   */
  private $sCnpj;

  /**
   * Endereço
   * @var string
   */
  private $sEndereco;

  /**
   * CGM
   * @var string
   */
  private $sCgm;

  /**
   * Tipo de Pessoa
   * @var string
   */
  private $sTipoPessoa;

  /**
   * CPF/CNPJ
   * @var string
   */
  private $sCpfCnpj;

  /**
   * Nome da Pessoa
   * @var string
   */
  private $sNome;

  /**
   * Nome Fantasia
   * @var string
   */
  private $sNomeFantasia;

  /**
   * Identidade
   * @var string
   */
  private $sIdentidade;

  /**
   * Inscrição Estadual
   * @var integer
   */
  private $iInscricaoEstadual;

  /**
   * Tipo de Logradouro
   * @var string
   */
  private $sTipoLogradouro;

  /**
   * Logradouro
   * @var string
   */
  private $sDescricaoLogradouro;

  /**
   * Logradouro Numero
   * @var string
   */
  private $sLogradouroNumero;

  /**
   * Logradouro Complemento
   * @var string
   */
  private $sLogradouroComplemento;

  /**
   * Logradouro Bairro
   * @var string
   */
  private $sLogradouroBairro;

  /**
   * Código Ibge do Municipio
   * @var integer
   */
  private $iCodigoIbge;

  /**
   * Descrição do Município
   * @var string
   */
  private $sDescricaoMunicipio;

  /**
   * Estado
   * @var string
   */
  private $sEstado;

  /**
   * Código do Pais
   * @var integer
   */
  private $iCodigoPais;

  /**
   * Descrição do País
   * @var string
   */
  private $sDescricaoPais;

  /**
   * Cep
   * @var string
   */
  private $sCep;

  /**
   * Telefone
   * @var string
   */
  private $sTelefone;

  /**
   * Fax
   * @var string
   */
  private $sFax;

  /**
   * Celular
   * @var string
   */
  private $sCelular;

  /**
   * Email
   * @var string
   */
  private $sEmail;

  /**
   * Inscrição Municipal
   * @var integer
   */
  private $iInscricaoMunicipal;

  /**
   * Data da Inscrição
   * @var Datetime
   */
  private $dDataInscricao;

  /**
   * Data da Inscrição Baixa
   * @var Datetime
   */
  private $dDataInscricaoBaixa;

  /**
   * Tipo de Classificação
   * @var integer
   */
  private $iTipoClassificacao;

  /**
   * Optante do Simples
   * @var integer
   */
  private $iOptanteSimples;

  /**
   * Optante do Simples Baixado
   * @var boolean
   */
  private $lOptanteSimplesBaixado;

  /**
   * Tipo de Emissão
   * @var integer
   */
  private $iTipoEmissao;

  /**
   * Exigibilidade
   * @var integer
   */
  private $iExigibilidade;

  /**
   * Substituição Tributária
   * @var integer
   */
  private $iSubstituicaoTributaria;

  /**
   * Regime Tributário
   * @var integer
   */
  private $iRegimeTributario;

  /**
   * Incentivo Fiscal
   * @var integer
   */
  private $iIncentivoFiscal;

  /**
   * Descrição da substituição tributária
   * @var string
   */
  private $sDescricaoSubstituicaoTributaria;

  /**
   * Exegibilidade
   * @var string
   */
  private $sDescricaoExigibilidade;

  /**
   * Incentivo fiscal
   * @var string
   */
  private $sDescricaoIncentivoFiscal;

  /**
   * Regime Tributario
   * @var string
   */
  private $sDescricaoRegimeTributario;

  /**
   * Tipo Classificação
   * @var string
   */
  private $sDescricaoTipoClassificacao;

  /**
   * Tipo de Emissão
   * @var string
   */
  private $sDescricaoTipoEmissao;

  /**
   * Optante Simples
   * @var string
   */
  private $sDescricaoOptanteSimples;

  /**
   * Código do Cgm
   * @var integer
   */
  private $iNumCgm;


  /**
   * Array contendo os Id's dos usuarios Contribuintes vinculados com determinado login
   * @var array
   */
  private $aUsuariosContribuintes = array();

  /**
   * Código Optante Simples
   * @var integer
   */
  private $iOptanteSimplesCategoria = 0;

  /**
   * Construtor da Classe
   */
  public function __construct() {
  }

  /**
   * Define qual usuario o contribuinte está ligado
   *
   * @param integer $iCodigoUsuario
   */
  public function setIdUsuarioContribuinte($iCodigoUsuario = null) {
    $this->iIdUsuarioContribuinte = $iCodigoUsuario;
  }

  /**
   * Retorna o usuário vinculado ao contribuinte
   *
   * @return integer
   */
  public function getIdUsuarioContribuinte() {
    return $this->iIdUsuarioContribuinte;
  }

  /**
   * Retorna a razão social
   * @return string
   */
  public function getRazaoSocial() {
    return $this->sRazaoSocial;
  }

  /**
   * Define a razão social
   * @param string $sRazaoSocial
  */
  public function setRazaoSocial($sRazaoSocial = NULL) {
    $this->sRazaoSocial= $sRazaoSocial;
  }

  /**
   * Retorna o código da empresa
   * @return string
  */
  public function getCodigoEmpresa() {
    return $this->iCodigoEmpresa;
  }

  /**
   * Retorna o CNPJ
   * @return string
  */
  public function getCnpj() {
    return $this->sCnpj;
  }

  /**
   * Define o CNPJ
   * @param string $sCnpj
  */
  public function setCnpj($sCnpj = NULL) {
    $this->sCnpj = $sCnpj;
  }

  /**
   * Retorna o endereço
   * @return string
   */
  public function getEndereco() {
    return $this->sEndereco;
  }

  /**
   * Define o endereço
   * @param string $sEndereco
  */
  public function setEndereco($sEndereco = NULL) {
    $this->sEndereco = $sEndereco;
  }

  /**
   * Define o CGM
   *
   * @return string
   */
  public function getCgm() {
    return $this->sCgm;
  }

  /**
   * Define o CGM
   * @param string $sCgm
  */
  public function setCgm($sCgm = NULL) {
    $this->sCgm = $sCgm;
  }

  /**
   * Retorna o Tipo de Pessoa
   * @return string
   */
  public function getTipoPessoa() {
    return $this->sTipoPessoa;
  }

  /**
   * Retorna o CPF/CNPJ
   * @return string
   */
  public function getCgcCpf() {
    return $this->sCpfCnpj;
  }

  /**
   * Retorna o Nome
   * @return string
   */
  public function getNome() {
    return $this->sNome;
  }

  /**
   * Retorna o Nome Fantasia
   * @return string
   */
  public function getNomeFantasia() {
    return $this->sNomeFantasia;
  }

  /**
   * Retorna a Identidade
   * @return string
   */
  public function getIdentidade() {
    return $this->sIdentidade;
  }

  /**
   * Retorna a Inscrição Estadual
   * @return integer
   */
  public function getInscricaoEstadual() {
    return $this->iInscricaoEstadual;
  }

  /**
   * Retorna o Tipo de Logradouro
   * @return string
   */
  public function getTipoLogradouro() {
    return $this->sTipoLogradouro;
  }

  /**
   * Retorna a Descrição do Logradouro
   * @return string
   */
  public function getDescricaoLogradouro() {
    return $this->sDescricaoLogradouro;
  }

  /**
   * Retorna o Numero do Logradouro
   * @return string
   */
  public function getLogradouroNumero() {
    return $this->sLogradouroNumero;
  }

  /**
   * Retorna Complemento do Logradouro
   * @return string
   */
  public function getLogradouroComplemento() {
    return $this->sLogradouroComplemento;
  }

  /**
   * Retorna o Bairro do logradouro
   * @return string
   */
  public function getLogradouroBairro() {
    return $this->sLogradouroBairro;
  }

  /**
   * Retorna o Cep
   * @return string
   */
  public function getCep() {
    return $this->sCep;
  }

  /**
   * Retorna o Código IBGE do municipio
   * @return integer
   */
  public function getCodigoIbgeMunicipio() {
    return $this->iCodigoIbge;
  }

  /**
   * Retorna a Descrição do Municipio
   * @return string
   */
  public function getDescricaoMunicipio() {
    return $this->sDescricaoMunicipio;
  }

  /**
   * Retorna o Estado
   * @return string
   */
  public function getEstado() {
    return $this->sEstado;
  }

  /**
   * Retorna o Código do Pais
   * @return integer
   */
  public function getCodigoPais() {
    return $this->iCodigoPais;
  }

  /**
   * Retorna a Descrição do Pais
   * @return string
   */
  public function getDescricaoPais() {
    return $this->sDescricaoPais;
  }

  /**
   * Retorna o Telefone
   * @return string
   */
  public function getTelefone() {
    return $this->sTelefone;
  }

  /**
   * Retorna o Fax
   * @return string
   */
  public function getFax() {
    return $this->sFax;
  }

  /**
   * Retorna o Celular
   * @return string
   */
  public function getCelular() {
    return $this->sCelular;
  }

  /**
   * Retorna o Email
   * @return string
   */
  public function getEmail() {
    return $this->sEmail;
  }

  /**
   * Retorna a Inscrição Municipal
   * @return integer
   */
  public function getInscricaoMunicipal() {
    return $this->iInscricaoMunicipal;
  }

  /**
   * Retorna a Data da Inscrição
   * @return Datetime
   */
  public function getDataInscricao() {
    return $this->dDataInscricao;
  }

  /**
   * Retorna a Data de baixa da Inscrição
   * @return Datetime
   */
  public function getDataInscricaoBaixa() {
    return $this->dDataInscricaoBaixa;
  }

  /**
   * Retorna o Tipo de Classificação
   * @return integer
   */
  public function getTipoClassificacao() {
    return $this->iTipoClassificacao;
  }

  /**
   * Retorna se é Optante do Simples
   * @return integer
   */
  public function getOptanteSimples() {
    return $this->iOptanteSimples;
  }

  /**
   * Retorna se o Optante do Simples está baixado
   * @return boolean
   */
  public function getOptanteSimplesBaixado() {
    return $this->lOptanteSimplesBaixado;
  }

  /**
   * Retorna o Tipo de Emissão
   * @return integer
   */
  public function getTipoEmissao() {
    return $this->iTipoEmissao;
  }

  /**
   * Retorna a Exibilidade
   * @return integer
   */
  public function getExigibilidade() {
    return $this->iExigibilidade;
  }

  /**
   * Retorna se é Substituto Tributário
   * @return integer
   */
  public function getSubstituicaoTributaria() {
    return $this->iSubstituicaoTributaria;
  }

  /**
   * Retorna o Regime Tributário
   * @return integer
   */
  public function getRegimeTributario() {
    return $this->iRegimeTributario;
  }

  /**
   * Retorna o Incentivo Fiscal
   * @return integer
   */
  public function getIncentivoFiscal() {
    return $this->iIncentivoFiscal;
  }

  /**
   * Define o Tipo de Pessoa
   * @param string $sTipoPessoa
   */
  public function setTipoPessoa($sTipoPessoa = NULL) {
    $this->sTipoPessoa = $sTipoPessoa;
  }

  /**
   * Define o CGC / CPF
   *
   * @param string|null $sCgcCpf
   */
  public function setCgcCpf($sCgcCpf = NULL) {
    $this->sCpfCnpj = $sCgcCpf;
  }

  /**
   * Define o Nome
   * @param string $sNome
   */
  public function setNome($sNome = NULL) {
    $this->sNome = $sNome;
  }

  /**
   * Define o Nome Fantasia
   * @param string $sNomeFantasia
   */
  public function setNomeFantasia($sNomeFantasia = NULL) {
    $this->sNomeFantasia = $sNomeFantasia;
  }

  /**
   * Define a Identidade
   * @param string $sIdentidade
   */
  public function setIdentidade($sIdentidade = NULL) {
    $this->sIdentidade = $sIdentidade;
  }

  /**
   * Define a Inscrição Estadual
   * @param integer $iInscricaoEstadual
   */
  public function setInscricaoEstadual($iInscricaoEstadual = NULL) {
    $this->iInscricaoEstadual = $iInscricaoEstadual;
  }

  /**
   * Define o Tipo de Logradouro
   * @param string $sTipoLogradouro
   */
  public function setTipoLogradouro($sTipoLogradouro = NULL) {
    $this->sTipoLogradouro = $sTipoLogradouro;
  }

  /**
   * Define a Descrição do Logradouro
   * @param string $sDescricaoLogradouro
   */
  public function setDescricaoLogradouro($sDescricaoLogradouro = NULL) {
    $this->sDescricaoLogradouro = $sDescricaoLogradouro;
  }

  /**
   * Define o Numero do Logradouro
   * @param string $sLogradouroNumero
   */
  public function setLogradouroNumero($sLogradouroNumero = NULL) {
    $this->sLogradouroNumero = $sLogradouroNumero;
  }

  /**
   * Define Complemento do Logradouro
   * @param string $sLogradouroComplemento
   */
  public function setLogradouroComplemento($sLogradouroComplemento = NULL) {
    $this->sLogradouroComplemento = $sLogradouroComplemento;
  }

  /**
   * Define o Bairro do logradouro
   * @param string $sLogradouroBairro
   */
  public function setLogradouroBairro($sLogradouroBairro = NULL) {
    $this->sLogradouroBairro = $sLogradouroBairro;
  }

  /**
   * Define o Cep
   * @param string $sCep
   */
  public function setCep($sCep = NULL) {
    $this->sCep = $sCep;
  }

  /**
   * Define o Código IBGE do municipio
   * @param integer $iCodigoIbge
   */
  public function setCodigoIbgeMunicipio($iCodigoIbge = NULL) {
    $this->iCodigoIbge = $iCodigoIbge;
  }

  /**
   * Define a Descrição do Municipio
   * @param string $sDescricaoMunicipio
   */
  public function setDescricaoMunicipio($sDescricaoMunicipio = NULL) {
    $this->sDescricaoMunicipio = $sDescricaoMunicipio;
  }

  /**
   * Define o Estado
   * @param string $sEstado
   */
  public function setEstado($sEstado = NULL) {
    $this->sEstado = $sEstado;
  }

  /**
   * Define o Código do Pais
   * @param integer $iCodigoPais
   */
  public function setCodigoPais($iCodigoPais = NULL) {
    $this->iCodigoPais = $iCodigoPais;
  }

  /**
   * Define a Descrição do Pais
   *
   * @param string $sDescricaoPais
   */
  public function setDescricaoPais($sDescricaoPais = NULL) {
    $this->sDescricaoPais = $sDescricaoPais;
  }

  /**
   * Define o Telefone
   * @param string $sTelefone
   */
  public function setTelefone($sTelefone = NULL) {
    $this->sTelefone = $sTelefone;
  }

  /**
   * Define o Fax
   * @param string $sFax
   */
  public function setFax($sFax = NULL) {
    $this->sFax = $sFax;
  }

  /**
   * Define o Celular
   * @param string $sCelular
   */
  public function setCelular($sCelular = NULL) {
    $this->sCelular = $sCelular;
  }

  /**
   * Define o Email
   * @param string $sEmail
   */
  public function setEmail($sEmail = NULL) {
    $this->sEmail = $sEmail;
  }

  /**
   * Define a Inscrição Municipal
   * @param integer $iInscricaoMunicipal
   */
  public function setInscricaoMunicipal($iInscricaoMunicipal = NULL) {
    $this->iInscricaoMunicipal = $iInscricaoMunicipal;
  }

  /**
   * Define a Data da Inscrição
   * @param DateTime $dDataInscricao
   */
  public function setDataInscricao(DateTime $dDataInscricao = NULL) {
    $this->dDataInscricao = $dDataInscricao;
  }

  /**
   * Define a Data de baixa da Inscrição
   * @param DateTime $dDataInscricaoBaixa
   */
  public function setDataInscricaoBaixa(DateTime $dDataInscricaoBaixa = NULL) {
    $this->dDataInscricaoBaixa = $dDataInscricaoBaixa;
  }

  /**
   * Define o Tipo de Classificação
   * @param integer $iTipoClassificacao
   */
  public function setTipoClassificacao($iTipoClassificacao = NULL) {
    $this->iTipoClassificacao = $iTipoClassificacao;
  }

  /**
   * Define se é Optante do Simples
   * @param integer $iOptanteSimples
   */
  public function setOptanteSimples($iOptanteSimples = NULL) {
    $this->iOptanteSimples = $iOptanteSimples;
  }

  /**
   * Define se o Optante do Simples está baixado
   * @param boolean $lOptanteSimplesBaixado
   */
  public function setOptanteSimplesBaixado($lOptanteSimplesBaixado = NULL) {
    $this->lOptanteSimplesBaixado = $lOptanteSimplesBaixado;
  }

  /**
   * Define o Tipo de Emissão
   * @param integer $iTipoEmissao
   */
  public function setTipoEmissao($iTipoEmissao = NULL) {
    $this->iTipoEmissao = $iTipoEmissao;
  }

  /**
   * Define a Exibilidade
   * @param integer $iExibilidade
   */
  public function setExigibilidade($iExibilidade = NULL) {
    $this->iExigibilidade = $iExibilidade;
  }

  /**
   * Define se é Substituto Tributário
   * @param integer $iSubstituicaoTributaria
   */
  public function setSubstituicaoTributaria($iSubstituicaoTributaria = NULL) {
    $this->iSubstituicaoTributaria = $iSubstituicaoTributaria;
  }

  /**
   * Define o Regime Tributário
   * @param integer $iRegimeTributario
   */
  public function setRegimeTributario($iRegimeTributario = NULL) {
    $this->iRegimeTributario = $iRegimeTributario;
  }

  /**
   * Define o Incentivo Fiscal
   * @param integer $iIncentivoFiscal
   */
  public function setIncentivoFiscal($iIncentivoFiscal = NULL) {
    $this->iIncentivoFiscal = $iIncentivoFiscal;
  }

  /**
   * Retorna a descrição para a substituição tributária
   *
   * @return string
   */
  public function getDescricaoSubstituicaoTributaria() {
    return $this->sDescricaoSubstituicaoTributaria;
  }

  /**
   * Define a descrição para a substituição tributária
   *
   * @param string $sDescricaoSubstituicaoTributaria
  */
  public function setDescricaoSubstituicaoTributaria($sDescricaoSubstituicaoTributaria = NULL) {
    $this->sDescricaoSubstituicaoTributaria = $sDescricaoSubstituicaoTributaria;
  }

  /**
   * Define a descrição para a exigibilidade
   *
   * @return string
   */
  public function getDescricaoExigibilidade() {
    return $this->sDescricaoExigibilidade;
  }

  /**
   * Define a descrição para a exigibilidade
   *
   * @param string $sDescricaoExigibilidade
   */
  public function setDescricaoExigibilidade($sDescricaoExigibilidade = NULL) {
    $this->sDescricaoExigibilidade = $sDescricaoExigibilidade;
  }

  /**
   * Retorna a descrição para o incentivo fiscal
   *
   * @return string
  */
  public function getDescricaoIncentivoFiscal() {
    return $this->sDescricaoIncentivoFiscal;
  }

  /**
   * Define a descrição para o incentivo fiscal
   *
   * @param string $sDescricaoIncentivoFiscal
  */
  public function setDescricaoIncentivoFiscal($sDescricaoIncentivoFiscal = NULL) {
    $this->sDescricaoIncentivoFiscal = $sDescricaoIncentivoFiscal;
  }

  /**
   * Retorna a descrição para o regime tributário
   *
   * @return string
  */
  public function getDescricaoRegimeTributario() {
    return $this->sDescricaoRegimeTributario;
  }

  /**
   * Define a descrição para o regime tributário
   *
   * @param string $sDescricaoRegimeTributario
  */
  public function setDescricaoRegimeTributario($sDescricaoRegimeTributario = NULL) {
    $this->sDescricaoRegimeTributario = $sDescricaoRegimeTributario;
  }

  /**
   * Retorna a descrição para o tipo de classificação
   *
   * @return string
  */
  public function getDescricaoTipoClassificacao() {
    return $this->sDescricaoTipoClassificacao;
  }

  /**
   * Define a descrição para o tipo de classificação
   *
   * @param string $sDescricaoTipoClassificacao
  */
  public function setDescricaoTipoClassificacao($sDescricaoTipoClassificacao = NULL) {
    $this->sDescricaoTipoClassificacao = $sDescricaoTipoClassificacao;
  }

  /**
   * Retorna a descrição para o tipo de emissão
   *
   * @return string
  */
  public function getDescricaoTipoEmissao() {
    return $this->sDescricaoTipoEmissao;
  }

  /**
   * Define a descrição para o tipo de emissão
   *
   * @param string $sDescricaoTipoEmissao
  */
  public function setDescricaoTipoEmissao($sDescricaoTipoEmissao = NULL) {
    $this->sDescricaoTipoEmissao = $sDescricaoTipoEmissao;
  }

  /**
   * Retorna a descrição para o optante pelo simples
   * @return string
  */
  public function getDescricaoOptanteSimples() {
    return $this->sDescricaoOptanteSimples;
  }

  /**
   * Define a descrição para o optante pelo simples
   * @param string $sDescricaoOptanteSimples
  */
  public function setDescricaoOptanteSimples($sDescricaoOptanteSimples = NULL) {
    $this->sDescricaoOptanteSimples = $sDescricaoOptanteSimples;
  }

  /**
   * Retorna o codigo do cgm do contrbuinte eventual
   * @return integer codigo do cgm
   */
  public function getCodigoCgm() {
    return $this->iNumCgm;
  }

  /**
   * Retorna a lista de id's dos usuarios contribuintes vinculados a mesmo
   * @return array
   */
  public function getContribuintes() {

    if (count($this->aUsuariosContribuintes) == 0) {

      $aCamposPesquisa        = array('cnpj_cpf' => $this->getCgcCpf());
      $aUsuariosContribuintes = Administrativo_Model_UsuarioContribuinte::getByAttributes($aCamposPesquisa);
      foreach ($aUsuariosContribuintes as $oUsuarioContribuinte) {

        $this->aUsuariosContribuintes[] = $oUsuarioContribuinte->getId();
      }
    }
    return $this->aUsuariosContribuintes;
  }

  /**
   * Retorna o codigo da categoria do Optante Simples Nacional
   * @return integer
   */
  public function getOptanteSimplesCategoria() {
    return (!empty($this->iOptanteSimplesCategoria)) ? $this->iOptanteSimplesCategoria : 0;
  }

  /**
   * Define a categoria do Optante Simples Nacional
   * @param int $iOptanteSimplesCategoria
   */
  public function setOptanteSimplesCategoria($iOptanteSimplesCategoria) {
    $this->iOptanteSimplesCategoria = (int) $iOptanteSimplesCategoria;
  }

  /**
   * Retorna a descrição do tipo de exigibilidade do alvará pelo código informado
   * @param integer $iCodigo
   * @return string
   */
  public static function getExibilidadeByCodigo($iCodigo) {

    $aListaExibilidade = array(
      23 => 'Exigivel',
      24 => 'Não Incidente',
      25 => 'Isenção',
      26 => 'Exportação',
      27 => 'Imunidade',
      28 => 'Suspensa por Decisão Judicial',
      29 => 'Suspensa por Processo Administrativo'
    );

    $sRetorno = (isset($aListaExibilidade[$iCodigo])) ? $aListaExibilidade[$iCodigo] : 'Não Definido';

    return $sRetorno;
  }

  /**
   * Retorna a descrição do regime tributário pelo código informado
   * @param integer $iCodigo
   * @return string
   */
  public static function getRegimeTributarioByCodigo($iCodigo) {

    $aListaRegimeTributario = array(
      14 => 'Normal',
      15 => 'Cooperativa',
      16 => 'Empresa de Pequeno Porte (EPP)',
      17 => 'Estimativa',
      18 => 'Fixado',
      19 => 'Microempresa Municipal',
      20 => 'Microempresa Individual (MEI)',
      21 => 'Microempresa (ME)',
      22 => 'Sociedade de Profissionais'
    );

    $sRetorno = (isset($aListaRegimeTributario[$iCodigo])) ? $aListaRegimeTributario[$iCodigo] : 'Não Definido';

    return $sRetorno;
  }

  /**
   * Retorna a descrição dda categoria do simples nacional
   * @param integer $iCodigo
   * @return string
   */
  public static function getCategoriaSimplesByCodigo($iCodigo) {

    $aListaCategoriaSimples = array(
      1 => 'Micro Empresa',
      2 => 'Empresa de Pequeno Porte',
      3 => 'MEI'
    );

    $sRetorno = (isset($aListaCategoriaSimples[$iCodigo])) ? $aListaCategoriaSimples[$iCodigo] : 'Normal';

    return $sRetorno;
  }

  /**
   * @param object $oContribuinte
   * @param string $sChaveTipo
   * @param null   $sPeriodo
   * @return mixed|null
   * @throws Exception
   */
  public static function getInformacaoContribuinteAtual($oContribuinte, $sChaveTipo='all', $sPeriodo=NULL) {

    if (empty($sPeriodo)) {

      $sPeriodo = new DateTime();
      $sPeriodo = $sPeriodo->format('Y-m-d');
    }

    $oDataSimples = new DateTime(DBSeller_Helper_Date_Date::invertDate($sPeriodo, '-'));

    if (!$oDataSimples instanceof DateTime) {
      throw new Exception('Data inválida!');
    }

    $oParametros = Contribuinte_Model_ParametroContribuinte::getById($oContribuinte->getIdUsuarioContribuinte());

    if (is_array($oContribuinte)) {
      $oContribuinte = reset($oContribuinte->getContribuintes());
    }

    $bIsOptanteSimples = $oContribuinte->isOptanteSimples($oDataSimples) ? TRUE : FALSE;

    // Verifica se é optante do simples adiciona o código da categoria do simples nacional, caso não for é normal ou pega do alvará
    if ($bIsOptanteSimples) {
      $iCategoriaSimples = $oContribuinte->getOptanteSimplesCategoria();
    } else {
      $iCategoriaSimples = 0;
    }

    $aRetorno['optante_simples_nacional']                  = $bIsOptanteSimples;
    $aRetorno['optante_simples_categoria']                 = $iCategoriaSimples;
    $aRetorno['optante_simples_categoria_desc']            = Contribuinte_Model_Contribuinte::getCategoriaSimplesByCodigo($iCategoriaSimples);
    $aRetorno['regime_tributario_mei']                     = $oContribuinte->isMEIAndOptanteSimples();
    $aRetorno['regime_tributario_sociedade_profissionais'] = $oContribuinte->isRegimeTributarioSociedadeProfissionais();
    $aRetorno['regime_tributario_fixado']                  = $oContribuinte->isRegimeTributarioFixado();

    if ($oParametros instanceof Contribuinte_Model_ParametroContribuinte) {

      $fAliquota = $oParametros->getEntity()->getValorIssFixo();
      $aRetorno['valor_iss_fixo'] = DBSeller_Helper_Number_Format::toMoney($fAliquota);
    }

    $mRetorno = ($sChaveTipo == 'all') ? $aRetorno : $aRetorno[$sChaveTipo];

    return $mRetorno;
  }
}