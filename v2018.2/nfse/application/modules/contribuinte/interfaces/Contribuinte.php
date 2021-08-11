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
 * Interface para o Contribuinte
 */

/**
 * @package Contribuinte\Interfaces\Contribuinte
 * @author Gilton Guma <gilton@dbseller.com.br>
 */
interface Contribuinte_Interface_Contribuinte {
  
  /**
   * Retorna o contribuinte pelo ID (identificador)
   *
   * @return object
   */
  public static function getById($iCodigo);
  
  /**
   * Retorna o contribuinte pela inscrição municipal
   *
   * @return object
   */
  public static function getByInscricaoMunicipal($iInscricaoMunicipal);
  
  /**
   * Retorna o contribuinte pelo CPF (Cadastro de Pessoa Física) ou CNPJ (Cadastro Nacional de Pessoa Jurídica)
   *
   * @return object
   */
  public static function getByCpfCnpj($cpfcnpj);
  
  /**
   * Retorna o Identificador
   * @return integer
   */
  public function getIdUsuarioContribuinte();
  
  /**
   * Define o Identificador
   * @param integer $iIdContribuinte
   */
  public function setIdUsuarioContribuinte($iIdContribuinte = NULL);
  
  /**
   * Retorna a razão social
   * @return string
   */
  public function getRazaoSocial();
  
  /**
   * Define a razão social
   * @param string $sRazaoSocial
   */
  public function setRazaoSocial($sRazaoSocial = NULL);
  
  /**
   * Retorna o código da empresa
   * @return string
   */
  public function getCodigoEmpresa();
  
  /**
   * Retorna o CNPJ
   * @return string
   */
  public function getCnpj();
  
  /**
   * Define o CNPJ
   * @param string $sCnpj
   */
  public function setCnpj($sCnpj = NULL);
  
  /**
   * Retorna o endereço
   * @return string
   */
  public function getEndereco();
  
  /**
   * Define o endereço
   * @param string $sEndereco
   */
  public function setEndereco($sEndereco = NULL);
  
  /**
   * Define o CGM
   * @param string
   */
  public function getCgm();
  
  /**
   * Define o CGM
   * @param string $sCgm
   */
  public function setCgm($sCgm = NULL);
  
  /**
   * Retorna o Tipo de Pessoa
   * @return string
   */
  public function getTipoPessoa();
  
  /**
   * Define o Tipo de Pessoa
   * @param string $sTipoPessoa
   */
  public function setTipoPessoa($sTipoPessoa = NULL);
  
  /**
   * Retorna o CPF/CNPJ
   * @return string
   */
  public function getCgcCpf();
  
  /**
   * Define o CGC / CPF
   * @param string sCgcCpf
   */
  public function setCgcCpf($sCgcCpf = NULL);
  
  /**
   * Retorna o Nome
   * @return string
   */
  public function getNome();
  
  /**
   * Define o Nome
   * @param string $sNome
   */
  public function setNome($sNome = NULL);
  
  /**
   * Retorna o Nome Fantasia
   * @return string
   */
  public function getNomeFantasia();
  
  /**
   * Define o Nome Fantasia
   * @param string $sNomeFantasia
   */
  public function setNomeFantasia($sNomeFantasia = NULL);
  
  /**
   * Retorna a Identidade
   * @return string
   */
  public function getIdentidade();
  
  /**
   * Define a Identidade
   * @param string $sIdentidade
   */
  public function setIdentidade($sIdentidade = NULL);
  
  /**
   * Retorna a Inscrição Estadual
   * @return integer
   */
  public function getInscricaoEstadual();
  
  /**
   * Define a Inscrição Estadual
   * @param integer $iInscricaoEstadual
   */
  public function setInscricaoEstadual($iInscricaoEstadual = NULL);
  
  /**
   * Retorna o Tipo de Logradouro
   * @return string
   */
  public function getTipoLogradouro();
  
  /**
   * Define o Tipo de Logradouro
   * @param string $sTipoLogradouro
   */
  public function setTipoLogradouro($sTipoLogradouro = NULL);
  
  /**
   * Retorna a Descrição do Logradouro
   * @return string
   */
  public function getDescricaoLogradouro();
  
  /**
   * Define a Descrição do Logradouro
   * @param string $sDescricaoLogradouro
   */
  public function setDescricaoLogradouro($sDescricaoLogradouro = NULL);
  
  /**
   * Retorna o Numero do Logradouro
   * @return string
   */
  public function getLogradouroNumero();
  
  /**
   * Define o Numero do Logradouro
   * @param string $sLogradouroNumero
   */
  public function setLogradouroNumero($sLogradouroNumero = NULL);
  
  /**
   * Retorna Complemento do Logradouro
   * @return string
   */
  public function getLogradouroComplemento();
  
  /**
   * Define Complemento do Logradouro
   * @param string $sLogradouroComplemento
   */
  public function setLogradouroComplemento($sLogradouroComplemento = NULL);
  
  /**
   * Retorna o Bairro do logradouro
   * @return string
   */
  public function getLogradouroBairro();
  
  /**
   * Define o Bairro do logradouro
   * @param string $sLogradouroBairro
   */
  public function setLogradouroBairro($sLogradouroBairro = NULL);
  
  /**
   * Retorna o Cep
   * @return string
   */
  public function getCep();
  
  /**
   * Define o Cep
   * @param string $sCep
   */
  public function setCep($sCep = NULL);
  
  /**
   * Retorna o Código IBGE do municipio
   * @return integer
   */
  public function getCodigoIbgeMunicipio();
  
  /**
   * Define o Código IBGE do municipio
   * @param integer $iCodigoIbge
   */
  public function setCodigoIbgeMunicipio($iCodigoIbge = NULL);
  
  /**
   * Retorna a Descrição do Municipio
   * @return string
   */
  public function getDescricaoMunicipio();
  
  /**
   * Define a Descrição do Municipio
   * @param string $sDescricaoMunicipio
   */
  public function setDescricaoMunicipio($sDescricaoMunicipio = NULL);
  
  /**
   * Retorna o Estado
   * @return string
   */
  public function getEstado();
  
  /**
   * Define o Estado
   * @param string $sEstado
   */
  public function setEstado($sEstado = NULL);
  
  /**
   * Retorna o Código do Pais
   * @return integer
   */
  public function getCodigoPais();
  
  /**
   * Define o Código do Pais
   * @param integer $iCodigoPais
   */
  public function setCodigoPais($iCodigoPais = NULL);
  
  
  /**
   * Retorna a Descrição do Pais
   * @return string
   */
  public function getDescricaoPais();
  
  /**
   * Define a Descrição do Pais
   * @param string $sPais
   */
  public function setDescricaoPais($sDescricaoPais = NULL);
  
  /**
   * Retorna o Telefone
   * @return string
   */
  public function getTelefone();
  
  /**
   * Define o Telefone
   * @param string $sTelefone
   */
  public function setTelefone($sTelefone = NULL);
  
  /**
   * Retorna o Fax
   * @return string
   */
  public function getFax();
  
  /**
   * Define o Fax
   * @param string $sFax
   */
  public function setFax($sFax = NULL);
  
  /**
   * Retorna o Celular
   * @return string
   */
  public function getCelular();
  
  /**
   * Define o Celular
   * @param string $sCelular
   */
  public function setCelular($sCelular = NULL);
  
  /**
   * Retorna o Email
   * @return string
   */
  public function getEmail();
  
  /**
   * Define o Email
   * @param string $sEmail
   */
  public function setEmail($sEmail = NULL);
  
  /**
   * Retorna a Inscrição Municipal
   * @return integer
   */
  public function getInscricaoMunicipal();
  
  /**
   * Define a Inscrição Municipal
   * @param integer $iInscricaoMunicipal
   */
  public function setInscricaoMunicipal($iInscricaoMunicipal = NULL);
  
  /**
   * Retorna a Data da Inscrição
   * @return Date
   */
  public function getDataInscricao();
  
  /**
   * Define a Data da Inscrição
   * @param Date $dDataInscricao
   */
  public function setDataInscricao(DateTime $dDataInscricao = NULL);
  
  /**
   * Retorna o Tipo de Classificação
   * @return integer
   */
  public function getTipoClassificacao();
  
  /**
   * Define o Tipo de Classificação
   * @param integer $iTipoClassificacao
   */
  public function setTipoClassificacao($iTipoClassificacao = NULL);
  
  /**
   * Retorna se é Optante do Simples
   * @return integer
   */
  public function getOptanteSimples();
  
  /**
   * Define se é Optante do Simples
   * @param integer $iOptanteSimples
   */
  public function setOptanteSimples($iOptanteSimples = NULL);
  
  /**
   * Retorna se o Optante do Simples está baixado
   * @return boolean
   */
  public function getOptanteSimplesBaixado();
  
  /**
   * Define se o Optante do Simples está baixado
   * @param boolean $lOptanteSimplesBaixado
   */
  public function setOptanteSimplesBaixado($lOptanteSimplesBaixado = NULL);
  
  /**
   * Retorna o Tipo de Emissão
   * @return integer
   */
  public function getTipoEmissao();
  
  /**
   * Define o Tipo de Emissão
   * @param integer $iTipoEmissao
   */
  public function setTipoEmissao($iTipoEmissao = NULL);
  
  /**
   * Retorna a Exibilidade
   * @return integer
   */
  public function getExigibilidade();
  
  /**
   * Define a Exibilidade
   * @param integer $iExibilidade
   */
  public function setExigibilidade($iExibilidade = NULL);
  
  /**
   * Retorna se é Substituto Tributário
   * @return integer
   */
  public function getSubstituicaoTributaria();
  
  /**
   * Define se é Substituto Tributário
   * @param integer $iSubstituicaoTributaria
   */
  public function setSubstituicaoTributaria($iSubstituicaoTributaria = NULL);
  
  /**
   * Retorna o Regime Tributário
   * @return integer
   */
  public function getRegimeTributario();
  
  /**
   * Define o Regime Tributário
   * @param integer $iRegimeTributario
   */
  public function setRegimeTributario($iRegimeTributario = NULL);
  
  /**
   * Retorna o Incentivo Fiscal
   * @return integer
   */
  public function getIncentivoFiscal();
  
  /**
   * Define o Incentivo Fiscal
   * @param integer $iIncentivoFiscal
   */
  public function setIncentivoFiscal($iIncentivoFiscal = NULL);
  
  /**
   * Retorna a descrição para a substituição tributária
   *
   * @return string
   */
  public function getDescricaoSubstituicaoTributaria();
  
  /**
   * Define a descrição para a substituição tributária
   *
   * @param string $sDescricaoSubstituicaoTributaria
   */
  public function setDescricaoSubstituicaoTributaria($sDescricaoSubstituicaoTributaria = NULL);
  
  /**
   * Retorna a descrição para a exigibilidade
   *
   * @return string
   */
  public function getDescricaoExigibilidade();
  
  /**
   * Define a descrição para a exigibilidade
   *
   * @param string $sDescricaoExigibilidade
   */
  public function setDescricaoExigibilidade($sDescricaoExigibilidade = NULL);
  
  /**
   * Retorna a descrição para o incentivo fiscal
   *
   * @return string
   */
  public function getDescricaoIncentivoFiscal();
  
  /**
   * Define a descrição para o incentivo fiscal
   *
   * @param string $sDescricaoIncentivoFiscal
   */
  public function setDescricaoIncentivoFiscal($sDescricaoIncentivoFiscal = NULL);
  
  /**
   * Retorna a descrição para o regime tributário
   *
   * @return string
   */
  public function getDescricaoRegimeTributario();
  
  /**
   * Define a descrição para o regime tributário
   *
   * @param string $sDescricaoRegimeTributario
   */
  public function setDescricaoRegimeTributario($sDescricaoRegimeTributario = NULL);
  
  /**
   * Retorna a descrição para o tipo de classificação
   *
   * @return string
   */
  public function getDescricaoTipoClassificacao();
  
  /**
   * Define a descrição para o tipo de classificação
   *
   * @param string $sDescricaoTipoClassificacao
   */
  public function setDescricaoTipoClassificacao($sDescricaoTipoClassificacao = NULL);
  
  /**
   * Retorna a descrição para o tipo de emissão
   *
   * @return string
   */
  public function getDescricaoTipoEmissao();
  
  /**
   * Define a descrição para o tipo de emissão
   *
   * @param string $sDescricaoTipoEmissao
   */
  public function setDescricaoTipoEmissao($sDescricaoTipoEmissao = NULL);
  
  /**
   * Retorna a descrição para o optante pelo simples
   * @return string
   */
  public function getDescricaoOptanteSimples();
  
  /**
   * Define a descrição para o optante pelo simples
   * @param string $sDescricaoOptanteSimples
   */
  public function setDescricaoOptanteSimples($sDescricaoOptanteSimples = NULL);
}