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


use Symfony\Component\Console\Input\StringInput;
use Doctrine\DBAL\Types\ObjectType;

class Contribuinte_Model_Cgm {

  /**
   * Código do CGM
   * @var integer
   */
  protected $codigo_cgm = NULL;

  /**
   * CPF
   * @var string
   */
  protected $cpf = NULL;

  /**
   * CNPJ
   * @var string
   */
  protected $cnpj = NULL;

  /**
   * Nome da Pessoa
   * @var string
   */
  protected $nome = NULL;

  /**
   * Email da Pessoa
   * @var string
   */
  protected $email = NULL;

  /**
   * Código da Cidade (IBGE)
   * @var integer
   */
  protected $codigo_cidade_ibge  = NULL;

  /**
   * Descrição do Municipio
   * @var string
   */
  protected $descricao_municipio  = NULL;

  /**
   * Estádo da Pessoa
   * @var string
   */
  protected $uf = NULL;

  /**
   * Telefone da Pessoa
   * @var string
   */
  protected $telefone = NULL;

  /**
   * Cep da pessoa
   * @var string
   */
  protected $cep = NULL;

  /**
   * Código do Bairro(e-cidade) quando cidade for a mesma da prefeitura
   * @var integer
   */
  protected $codigo_bairro = NULL;

  /**
   * Código do Logradouro(e-cidade) quando cidade for a mesma da prefeitura
   * @var integer
   */
  protected $codigo_logradouro = NULL;

  /**
   * Boolean para retornar se o endereço é fora ou não
   * @var boolen
   */
  protected $endereco = NULL;

  /**
   * Descrição Bairro
   * @var string
   */
  protected $descricao_bairro = NULL;

  /**
   * Descrição Logradouro
   * @var string
   */
  protected $descricao_logradouro = NULL;

  /**
   * Numero do Logradouro
   * @var string
   */
  protected $numero_logradouro = NULL;

  /**
   * Complento do logradouro
   * @var string
   */
  protected $complemento  = NULL;

  /**
   * Definição se o retorno é referente a dados de uma empresa (juridico)
   * @var boolean
   */
  protected $ljuridico  = NULL;


  public function __construct(){}

  /**
   * Retorna o Codigo do CGM
   * @return integer
   */
  public function getCodigoCgm() {
    return $this->codigo_cgm;
  }

  /**
   * Define Codigo CGM
   * @param integer $iCodigoCgm
   */
  protected function setCodigoCgm($iCodigoCgm) {
    $this->codigo_cgm = $iCodigoCgm;
  }

  /**
   * Retorna o CPF
   * @return string
   */
  public function getCPF() {
    return $this->cpf;
  }

  /**
   * Define CPF
   * @param string $sCpf
   */
  public function setCPF($sCpf) {
    $this->cpf = DBSeller_Helper_Number_Format::unmaskCPF_CNPJ($sCpf);
  }

  /**
   * Retorna CNPJ
   * @return string
   */
  public function getCNPJ() {
    return $this->cnpj;
  }

  /**
   * Define CNPJ
   * @param string $sCnpj
   */
  public function setCNPJ($sCnpj) {
    $this->cnpj = DBSeller_Helper_Number_Format::unmaskCPF_CNPJ($sCnpj);
  }

  /**
   * Retorna Nome
   * @return string
   */
  public function getNome() {
    return $this->nome;
  }

  /**
   * Define Nome
   * @param string $sNome
   */
  public function setNome($sNome) {
    $this->nome = $sNome;
  }

  /**
   * Retorna Email
   * @return string
   */
  public function getEmail() {
    return $this->email;
  }

  /**
   * Define Email
   * @param string $sEmail
   */
  public function setEmail($sEmail) {
    $this->email = $sEmail;
  }

  /**
   * Retorna Codigo Ibge do municipio
   * @return integer
   */
  public function getCodigoIbgeCidade() {
    return $this->codigo_cidade_ibge;
  }

  /**
   * Retorna o Código Ibge do Municipio
   * @param integer $iCodigoIbgeCidade
   */
  public function setCodigoIbgeCidade($iCodigoIbgeCidade) {
    $this->codigo_cidade_ibge = $iCodigoIbgeCidade;
  }

  /**
   * Retorna Descricao do Municipio
   * @return string
   */
  public function getDescricaoMunicipio() {
    return $this->descricao_municipio;
  }

  /**
   * Define a Descrição do Municipio
   * @param string $sDescricaoMunicipio
   */
  public function setDescricaoMunicipio($sDescricaoMunicipio) {
    $this->descricao_municipio = $sDescricaoMunicipio;
  }

  /**
   * Retorna Estado
   * @return string
   */
  public function getEstado() {
    return $this->uf;
  }

  /**
   * Define Estado
   * @param string $sUf
   */
  public function setEstado($sUf) {
    $this->uf = $sUf;
  }

  /**
   * Retorna Telefone
   * @return string
   */
  public function getTelefone() {
    return $this->telefone;
  }

  /**
   * Define Telefone
   * @param string $sTelefone
   */
  public function setTelefone($sTelefone) {
    $this->telefone = $sTelefone;
  }

  /**
   * Retorna CEP
   * @return string
   */
  public function getCep() {
    return $this->cep;
  }

  /**
   * Define Cep
   * @param string $sCep
   */
  public function setCep($sCep) {
    $this->cep = $sCep;
  }

  /**
   * Retorna Código do Bairro(e-cidade) quando cidade for a mesma da prefeitura
   * @return string
   */
  public function getCodigoBairro() {
    return $this->codigo_bairro;
  }

  /**
   * Define Código do Bairro(e-cidade) quando cidade for a mesma da prefeitura
   * @param string $iCodigoBairro
   */
  public function setCodigoBairro($iCodigoBairro) {
    $this->codigo_bairro = $iCodigoBairro;
  }

  /**
   * Retorna Código do Logradouro(e-cidade) quando cidade for a mesma da prefeitura
   * @return integer
   */
  public function getCodigoLogradouro() {
    return $this->codigo_logradouro;
  }

  /**
   * Define Código do Logradouro(e-cidade) quando cidade for a mesma da prefeitura
   * @param integer $iCodigoLogradouro
   */
  public function setCodigoLogradouro($iCodigoLogradouro) {
    $this->codigo_logradouro = $iCodigoLogradouro;
  }

  /**
   * retorna o Boolean responsavel por definir se o endereço é do ecidade ou não
   * @return boolean
   */
  public function IsEnderecoEcidade() {
    return $this->endereco;
  }

  /**
   * define o Boolean responsavel por definir se o endereço é do ecidade ou não
   * @param boolean $lEndereco
   */
  public function setEnderecoEcidade($lEndereco) {
    $this->endereco = $lEndereco;
  }

  /**
   * Retorna Descrição do Bairro
   * @return string
   */
  public function getDescricaoBairro() {
    return $this->descricao_bairro;
  }

  /**
   * Define Descrição do Bairro
   * @param string $sDescricaoBairro
   */
  public function setDescricaoBairro($sDescricaoBairro) {
    $this->descricao_bairro = $sDescricaoBairro;
  }

  /**
   * Retorna Descrição do Logradouro
   * @return string
   */
  public function getDescricaoLogradouro() {
    return $this->descricao_logradouro;
  }

  /**
   * Define Descrição do Bairro
   * @param string $sDescricaoLogradouro
   */
  public function setDescricaoLogradouro($sDescricaoLogradouro) {
    $this->descricao_logradouro = $sDescricaoLogradouro;
  }

  /**
   * Retorna Numero do Logradouro
   * @return string
   */
  public function getNumeroLogradouro() {
    return $this->numero_logradouro;
  }

  /**
   * Define Numero do Logradouro
   * @param string $sNumeroLogradouro
   */
  public function setNumeroLogradouro($sNumeroLogradouro) {
    $this->numero_logradouro = $sNumeroLogradouro;
  }

  /**
   * Retorna Complemento
   * @return string
   */
  public function getComplemento() {
    return $this->complemento;
  }

  /**
   * Define Complemento
   * @param string $sComplemento
   */
  public function setComplemento($sComplemento) {
    $this->complemento = $sComplemento;
  }

  /**
   * Retorna se é juridico
   * @return string
   */
  public function lJuridico() {
    return $this->ljuridico;
  }

  /**
   * Define se o registro é juridico
   * @param boolean $lJuridico
   */
  public function setJuridico($lJuridico) {
    $this->ljuridico = $lJuridico;
  }


  /**
   * Classe responsável por gerar o Cgm na base do e-cidade
   * Retorna status e o numero do cgm criado ou não.
   * @return Object
   */
  public function persist() {

    $aDados = array();

    if ($this->getCNPJ() == NULL && $this->getCPF() == NULL) {
      throw new Exception('CPF/CNPJ são obrigatórios');
    }

    if ($this->getCodigoIbgeCidade() == NULL) {
      throw new Exception('Código IBGE do município é obrigatório');
    }

    if ($this->getEmail() == NULL) {
      throw new Exception('Email é campo obrigatório');
    }

    if (strlen($this->getCNPJ()) == 14) {
      $aDados['cnpj'] = $this->getCNPJ();
    } else {
      $aDados['cpf']  = $this->getCPF();
    }

    $aDados['nome']                   = $this->getNome();
    $aDados['numero_logradouro']      = $this->getNumeroLogradouro();
    $aDados['complemento']            = $this->getComplemento();
    $aDados['codigo_cidade_ibge']     = $this->getCodigoIbgeCidade();
    $aDados['uf']                     = $this->getEstado();
    $aDados['email']                  = $this->getEmail();
    $aDados['telefone']               = $this->getTelefone();
    $aDados['cep']                    = $this->getCep();

    if ($this->IsEnderecoEcidade()) {

      if ($this->getCodigoLogradouro() == NULL || $this->getCodigoBairro() == NULL) {
        throw new Exception('Codigo Logradouro/Bairro são obrigatórios');
      }

      $aDados['codigo_logradouro']    = $this->getCodigoLogradouro();
      $aDados['codigo_bairro']        = $this->getCodigoBairro();
      $aDados['endereco']             = '1'; //true
    } else {
      $aDados['endereco']             = '0';
    }

    $aDados['descricao_logradouro']   = $this->getDescricaoLogradouro();
    $aDados['descricao_bairro']       = $this->getDescricaoBairro();

    return WebService_Model_Ecidade::processar('gerarCgmExterno', $aDados);
  }

  /**
   * Retorna os dados do CGM vindos atravez do webservice
   * @param $sCpfCnpj
   * @return object
   */
  public static function getDadosCgm ($sCpfCnpj) {

    if (empty($sCpfCnpj)) {
      throw new Exception('CPF/CNPJ não informado.');
    }

    $oRetornoCgm = WebService_Model_Ecidade::processar('pesquisaCgmByCpfCnpj',
                                                                 array('cpfcnpj' => $sCpfCnpj)
                                                               );

    if ($oRetornoCgm == NULL) {
      return NULL;
    }

    $oCgm = new Contribuinte_Model_Cgm();

    $oCgm->setCodigoCgm($oRetornoCgm->iCodigoCgm);
    $oCgm->setNome($oRetornoCgm->sNome);
    $oCgm->setJuridico($oRetornoCgm->lJuridico);
    $oCgm->setCNPJ                (isset($oRetornoCgm->iCnpj) ? $oRetornoCgm->iCnpj : NULL);
    $oCgm->setCPF                 (isset($oRetornoCgm->iCpf)  ? $oRetornoCgm->iCpf  : NULL);
    $oCgm->setNumeroLogradouro    ($oRetornoCgm->sNumero);
    $oCgm->setComplemento         ($oRetornoCgm->sComplemento);
    $oCgm->setDescricaoMunicipio  ($oRetornoCgm->sMunicipio);
    $oCgm->setEstado              ($oRetornoCgm->sUf);
    $oCgm->setEmail               ($oRetornoCgm->sEmail);
    $oCgm->setCep                 ($oRetornoCgm->sCep);
    $oCgm->setDescricaoLogradouro ($oRetornoCgm->sLogradouro);
    $oCgm->setDescricaoBairro     ($oRetornoCgm->sBairro);

    return $oCgm;
  }

  /**
   * Classe responsável por remover o cgm
   * @param integer $iCodigoCgm
   * @throws Exception
   */
  public static function removerCgm ($iCodigoCgm) {

    if ($iCodigoCgm == NULL) {
      throw new Exception('Código do Cgm não informado.');
    }

    $aDados = array('codigo_cgm' => $iCodigoCgm);

    return WebService_Model_Ecidade::processar('excluirCgm', $aDados);
  }

}