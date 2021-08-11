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


namespace Administrativo;

/**
 * @Entity
 * @Table(name="usuarios_contribuintes_complemento")
 */
class UsuarioContribuinteComplemento {

  /**
   * @var string
   * @Id
   * @Column(type="string")
   */
  protected $cnpjcpf = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $inscricao_municipal = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $inscricao_estadual = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $razao_social = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $nome_fantasia = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $endereco_descricao = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $endereco_numero = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $endereco_complemento = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $endereco_bairro = NULL;

  /**
   * @var string
   * @Column(type="integer")
   */
  protected $endereco_municipio_codigo = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $endereco_uf = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $endereco_pais_codigo = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $endereco_cep = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $contato_telefone = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $contato_email = NULL;

  /**
   * @param string $endereco_complemento
   */
  public function setEnderecoComplemento($endereco_complemento) {

    $this->endereco_complemento = $endereco_complemento;
  }

  /**
   * @return string
   */
  public function getEnderecoComplemento() {

    return $this->endereco_complemento;
  }

  /**
   * @param int $cnpjcpf
   */
  public function setCnpjcpf($cnpjcpf) {

    $this->cnpjcpf = $cnpjcpf;
  }

  /**
   * @return int
   */
  public function getCnpjcpf() {

    return $this->cnpjcpf;
  }

  /**
   * @param string $contato_email
   */
  public function setContatoEmail($contato_email) {

    $this->contato_email = $contato_email;
  }

  /**
   * @return string
   */
  public function getContatoEmail() {

    return $this->contato_email;
  }

  /**
   * @param string $contato_telefone
   */
  public function setContatoTelefone($contato_telefone) {

    $this->contato_telefone = $contato_telefone;
  }

  /**
   * @return string
   */
  public function getContatoTelefone() {

    return $this->contato_telefone;
  }

  /**
   * @param string $endereco_bairro
   */
  public function setEnderecoBairro($endereco_bairro) {

    $this->endereco_bairro = $endereco_bairro;
  }

  /**
   * @return string
   */
  public function getEnderecoBairro() {

    return $this->endereco_bairro;
  }

  /**
   * @param string $endereco_cep
   */
  public function setEnderecoCep($endereco_cep) {

    $this->endereco_cep = $endereco_cep;
  }

  /**
   * @return string
   */
  public function getEnderecoCep() {

    return $this->endereco_cep;
  }

  /**
   * @param string $endereco_descricao
   */
  public function setEnderecoDescricao($endereco_descricao) {

    $this->endereco_descricao = $endereco_descricao;
  }

  /**
   * @return string
   */
  public function getEnderecoDescricao() {

    return $this->endereco_descricao;
  }

  /**
   * @param string $endereco_municipio_codigo
   */
  public function setEnderecoMunicipioCodigo($endereco_municipio_codigo) {

    $this->endereco_municipio_codigo = $endereco_municipio_codigo;
  }

  /**
   * @return string
   */
  public function getEnderecoMunicipioCodigo() {

    return $this->endereco_municipio_codigo;
  }

  /**
   * @param string $endereco_numero
   */
  public function setEnderecoNumero($endereco_numero) {

    $this->endereco_numero = $endereco_numero;
  }

  /**
   * @return string
   */
  public function getEnderecoNumero() {

    return $this->endereco_numero;
  }

  /**
   * @param string $endereco_pais_codigo
   */
  public function setEnderecoPaisCodigo($endereco_pais_codigo = '01058') {

    $this->endereco_pais_codigo = $endereco_pais_codigo;
  }

  /**
   * @return string
   */
  public function getEnderecoPaisCodigo() {

    return $this->endereco_pais_codigo;
  }

  /**
   * @param string $endereco_uf
   */
  public function setEnderecoUf($endereco_uf) {

    $this->endereco_uf = $endereco_uf;
  }

  /**
   * @return string
   */
  public function getEnderecoUf() {

    return $this->endereco_uf;
  }

  /**
   * @param string $inscricao_estadual
   */
  public function setInscricaoEstadual($inscricao_estadual) {

    $this->inscricao_estadual = $inscricao_estadual;
  }

  /**
   * @return string
   */
  public function getInscricaoEstadual() {

    return $this->inscricao_estadual;
  }

  /**
   * @param string $inscricao_municipal
   */
  public function setInscricaoMunicipal($inscricao_municipal) {

    $this->inscricao_municipal = $inscricao_municipal;
  }

  /**
   * @return string
   */
  public function getInscricaoMunicipal() {

    return $this->inscricao_municipal;
  }

  /**
   * @param string $nome_fantasia
   */
  public function setNomeFantasia($nome_fantasia) {

    $this->nome_fantasia = $nome_fantasia;
  }

  /**
   * @return string
   */
  public function getNomeFantasia() {

    return $this->nome_fantasia;
  }

  /**
   * @param string $razao_social
   */
  public function setRazaoSocial($razao_social) {

    $this->razao_social = $razao_social;
  }

  /**
   * @return string
   */
  public function getRazaoSocial() {

    return $this->razao_social;
  }
}