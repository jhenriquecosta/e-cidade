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
 * Parametro Prefeitura
 * @author Roberto Carneiro <roberto@dbseller.com.br>
 */
namespace Administrativo;

/**
 * @Entity
 * @Table(name="parametrosprefeitura")
 */
class ParametroPrefeitura {

 /**
  * @var int
  * @Id
  * @Column(type="integer")
  */
 protected $id = NULL;

  /**
   * @var int
   * @Column(type="string")
   */
  protected $ibge = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $nome = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $nome_relatorio = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $cnpj = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $endereco = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $numero = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $complemento = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $bairro = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $municipio = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $uf = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $cep = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $telefone = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $fax = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $email = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $url = NULL;

  /**
   * @var integer
   * @Column(type="integer")
   */
  protected $modelo_impressao_nfse = 0;

  /**
   * @var string
   * @Column(type="text")
   */
  protected $informacoes_complementares_nfse = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $controle_aidof = NULL;

  /**
   * @var integer
   * @Column(type="integer")
   */
  protected $avisofim_emissao_nota = 0;

  /**
   * @var integer
   * @Column(type="integer")
   */
  protected $nota_retroativa = 0;

  /**
   * @var boolean
   * @Column(type="boolean")
   */
  protected $verifica_autocadastro = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $modelo_importacao_rps = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $setor = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $secretaria = NULL;

  /**
   * @var boolean
   * @Column(type="boolean")
   */
  protected $solicita_cancelamento = NULL;

  /**
   * @var boolean
   * @Column(type="boolean")
   */
  protected $reter_pessoa_fisica = NULL;

  /**
   * @var integer
   * @Column(type="integer")
   */
  protected $tempo_bloqueio = NULL;

  /**
   * @var boolean
   * @Column(type="boolean")
   */
  protected $requisicao_nfse = FALSE;

  /**
   * Retorna o código IBGE do município da prefeitura
   *
   * @return integer
   */
  public function getIbge() {
    return $this->ibge;
  }

  /**
   * Define o código IBGE do município da prefeitura
   *
   * @param integer $iIbge
   */
  public function setIbge($iIbge) {
    $this->ibge = $iIbge;
  }

  /**
   * Retorna o nome da prefeitura
   *
   * @return string
   */
  public function getNome() {
    return $this->nome;
  }

  /**
   * Define o nome da prefeitura
   *
   * @param string $sNome
   */
  public function setNome($sNome) {
    $this->nome = $sNome;
  }

  /**
   * @return string
   */
  public function getControleAidof() {
    return $this->controle_aidof;
  }

  /**
   * @param string $sControle_Aidof
   */
  public function setControleAidof($sControle_Aidof) {
    $this->controle_aidof = $sControle_Aidof;
  }

  /**
   * Retorna a quantidade de dias retroativas configurado para emissão de NFSe
   *
   * @return integer
   */
  public function getNotaRetroativa() {
    return $this->nota_retroativa;
  }

  /**
   * Define a quantidade de dias retroativas configurado para emissão de NFSe
   *
   * @param integer $nota_retroativa
   */
  public function setNotaRetroativa($nota_retroativa) {
    $this->nota_retroativa = $nota_retroativa;
  }

  /**
   * Retorma a quantidade de AIDOFs configurada para avisar na emissão de documentos
   *
   * @return number
   */
  public function getQuantidadeAvisoFimEmissao() {
    return $this->avisofim_emissao_nota;
  }

  /**
   * Define a quantidade de AIDOFs configurada para avisar na emissão de documentos
   *
   * @param integer $iQuantidadeEmissao
   */
  public function setQuantidadeAvisoFimEmissao($iQuantidadeEmissao) {
    $this->avisofim_emissao_nota = $iQuantidadeEmissao;
  }

  /**
   * Retorna se o fiscal deve ou não verificar os auto cadastros
   *
   * @return boolean
   */
  public function getVerificaAutocadastro() {
    return $this->verifica_autocadastro;
  }

  /**
   * Define se o fiscal deve ou não verificar os auto cadastros
   * @param boolean $bVerifica_autocadastro
   */
  public function setVerificaAutocadastro($bVerifica_autocadastro) {
    $this->verifica_autocadastro = $bVerifica_autocadastro;
  }

  /**
   * Retorna o nome da prefeitura para relatórios
   *
   * @return string
   */
  public function getNomeRelatorio() {
    return $this->nome_relatorio;
  }

  /**
   * Define o nome da prefeitura para relatórios
   *
   * @param string $sNomeRelatorio
   */
  public function setNomeRelatorio($sNomeRelatorio) {
    $this->nome_relatorio = $sNomeRelatorio;
  }

  /**
   * Retorna o CNPJ da prefeitura
   *
   * @return string
   */
  public function getCnpj() {
    return $this->cnpj;
  }

  /**
   * Define o CNPJ da prefeitura
   *
   * @param string $sCnpj
   */
  public function setCnpj($sCnpj) {
    $this->cnpj = $sCnpj;
  }

  /**
   * Retorna o endereço da prefeitura
   *
   * @return string
   */
  public function getEndereco() {
    return $this->endereco;
  }

  /**
   * Define o endereço da prefeitura
   *
   * @param string $sEndereco
   */
  public function setEndereco($sEndereco) {
    $this->endereco = $sEndereco;
  }

  /**
   * Retorna o número do endereço da prefeitura
   *
   * @return string
   */
  public function getNumero() {
    return $this->numero;
  }

  /**
   * Define o número do endereço da prefeitura
   *
   * @param string $sNumero
   */
  public function setNumero($sNumero) {
    $this->numero = $sNumero;
  }

  /**
   * Retorna o complemento do endereço da prefeitura
   *
   * @return string
   */
  public function getComplemento() {
    return $this->complemento;
  }

  /**
   * Define o complemento do endereço da prefeitura
   *
   * @param string $sComplemento
   */
  public function setComplemento($sComplemento) {
    $this->complemento = $sComplemento;
  }

  /**
   * Retorna o bairro da prefeitura
   *
   * @return string
   */
  public function getBairro() {
    return $this->bairro;
  }

  /**
   * Define o bairro da prefeitura
   *
   * @param string $sBairro
   */
  public function setBairro($sBairro) {
    $this->bairro = $sBairro;
  }

  /**
   * Retorna o município da prefeitura
   *
   * @return string
   */
  public function getMunicipio() {
    return $this->municipio;
  }

  /**
   * Define o município da prefeitura
   *
   * @param string $sMunicipio
   */
  public function setMunicipio($sMunicipio) {
    $this->municipio = $sMunicipio;
  }

  /**
   * Retorna a unidade federativa da prefeitura
   *
   * @return string
   */
  public function getUf() {
    return $this->uf;
  }

  /**
   * Define a unidade federativa da prefeitura
   *
   * @param string $sUf
   */
  public function setUf($sUf) {
    $this->uf = $sUf;
  }

  /**
   * Retorna o CEP da prefeitura
   *
   * @return string
   */
  public function getCep() {
    return $this->cep;
  }

  /**
   * Define o CEP da prefeitura
   *
   * @param string $sCep
   */
  public function setCep($sCep) {
    $this->cep = $sCep;
  }

  /**
   * Retorna o número do telefone da prefeitura
   *
   * @return string
   */
  public function getTelefone() {
    return $this->telefone;
  }

  /**
   * Define o número do telefone da prefeitura
   *
   * @param string $sTelefone
   */
  public function setTelefone($sTelefone) {
    $this->telefone = $sTelefone;
  }

  /**
   * Retorna o número do fax da prefeitura
   *
   * @return string
   */
  public function getFax() {
    return $this->fax;
  }

  /**
   * Define o número do fax da prefeitura
   *
   * @param string $sFax
   */
  public function setFax($sFax) {
    $this->fax = $sFax;
  }

  /**
   * Retorna o email da prefeitura
   *
   * @return string
   */
  public function getEmail() {
    return $this->email;
  }

  /**
   * Define o email da prefeitura
   *
   * @param string $sEmail
   */
  public function setEmail($sEmail) {
    $this->email = $sEmail;
  }

  /**
   * Retorna a url da prefeitura
   *
   * @return string
   */
  public function getUrl() {
    return $this->url;
  }

  /**
   * Define a url da prefeitura
   *
   * @param string $sUrl
   */
  public function setUrl($sUrl) {
    $this->url = $sUrl;
  }

  /**
   * Retorna o modelo de impressão de NFSe
   *
   * @return integer
   */
  public function getModeloImpressaoNfse() {
    return $this->modelo_impressao_nfse;
  }

  /**
   * Define o modelo de impressão de NFSe
   *
   * @param integer $iModeloImpressaoNfse
   */
  public function setModeloImpressaoNfse($iModeloImpressaoNfse) {
    $this->modelo_impressao_nfse = $iModeloImpressaoNfse;
  }

  /**
   * Retorna as informações complementares da NFSE configuradas
   *
   * @return string
   */
  public function getInformacoesComplementaresNfse() {
    return $this->informacoes_complementares_nfse;
  }

  /**
   * Define as informações complementares da NFSE configuradas
   *
   * @param $sInformacoesComplementaresNfse
   */
  public function setInformacoesComplementaresNfse($sInformacoesComplementaresNfse) {
    $this->informacoes_complementares_nfse = $sInformacoesComplementaresNfse;
  }

  /**
   * Retorna o modelo de importação de RPS
   *
   * @return string
   */
  public function getModeloImportacaoRps() {
    return $this->modelo_importacao_rps;
  }

  /**
   * Define o modelo de importação de RPS
   *
   * @param $sModeloImportacaoRps
   */
  public function setModeloImportacaoRps($sModeloImportacaoRps) {
    $this->modelo_importacao_rps = $sModeloImportacaoRps;
  }

  /**
   * Retorna o setor cadastrado
   *
   * @return string
   */
  public function getSetor() {
    return $this->setor;
  }

  /**
   * Define o setor para a prefeitura
   *
   * @param string $sSetor
   */
  public function setSetor($sSetor) {
    $this->setor = $sSetor;
  }

  /**
   * Retorna o secretaria cadastrado
   *
   * @return string
   */
  public function getSecretaria() {
    return $this->secretaria;
  }

  /**
   * Define o secretaria para a prefeitura
   *
   * @param string $sSecretaria
   */
  public function setSecretaria($sSecretaria) {
    $this->secretaria = $sSecretaria;
  }

  /**
   * Retorna o boolean de solicitação
   *
   * @return boolean
   */
  public function getSolicitaCancelamento() {
    return $this->solicita_cancelamento;
  }

  /**
   * Define se é necessário solicitar cancelmanto para o fiscal antes de cancelar
   *
   * @param boolean $lSolicitaCancelamento
   */
  public function setSolicitaCancelamento($lSolicitaCancelamento) {
    $this->solicita_cancelamento = $lSolicitaCancelamento;
  }

  /**
   * Retorna o boolean de reter para pessoa fisica
   *
   * @return boolean
   */
  public function getReterPessoaFisica() {
    return $this->reter_pessoa_fisica;
  }

  /**
   * Define se é necessário reter imposto para pessoa fisica na emissão
   *
   * @param boolean $lReterPessoaFisica
   */
  public function setReterPessoaFisica($lReterPessoaFisica) {
    $this->reter_pessoa_fisica = $lReterPessoaFisica;
  }

  /**
   * Retorna o tempo de bloqueio
   *
   * @return boolean
   */
  public function getTempoBloqueio() {
    return $this->tempo_bloqueio;
  }

  /**
   * Define o tempo de bloqueio
   *
   * @param boolean $iTempo
   */
  public function setTempoBloqueio($iTempo) {
    $this->tempo_bloqueio = $iTempo;
  }

  /**
   * @return boolean
   */
  public function getRequisicaoNfse() {
    return $this->requisicao_nfse;
  }

  /**
   * @param boolean $requisicaoNfse
   */
  public function setRequisicaoNfse($requisicaoNfse) {
    $this->requisicao_nfse = $requisicaoNfse;
  }
}