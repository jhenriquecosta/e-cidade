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
 * Entidade Responsável pela manupulação do banco
 * @author luccas
 */
namespace Contribuinte;

/**
 * @Entity
 * @Table(name="cadastro_pessoa")
 */
class CadastroPessoa {

  /**
   * @var int
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id = null;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $cpfcnpj = null;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $nome = null;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $nome_fantasia = null;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $estado = null;

  /**
   * @var integer
   * @Column(type="integer")
   */
  protected $cidade = null;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $cep = null;

  /**
   * @var bigint
   * @Column(type="bigint")
   */
  protected $cod_bairro = null;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $bairro = null;

  /**
   * @var bigint
   * @Column(type="bigint")
   */
  protected $cod_endereco = null;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $endereco = null;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $numero = 0;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $complemento = null;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $telefone = null;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $email = null;

  /**
   * @var smallint
   * @Column(type="smallint")
   */
  protected $status = null;

  /**
   * @var text
   * @Column(type="text")
   */
  protected $comentario = null;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $hash = null;

  /**
   * @var string
   * @Column(type="date")
   */
  protected $data_cadastro = null;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $recusa_justificativa = null;

  /**
   * @var \Adminstrativo\Perfil
   * @ManyToOne(targetEntity="\Administrativo\Perfil")
   * @JoinColumn(name="id_perfil", referencedColumnName="id")
   **/
  protected $perfil = null;

  /**
   * @var integer
   * @Column(type="integer")
   * @tutorial
   *   1 = Criar CGM/Usuario
   *   2 = Criar Usuário
   *   3 = Recusar Usuário
   */
  protected $tipo_liberacao  = null;


  public function getId() {
    return $this->id;
  }

  public function getCpfcnpj() {
    return $this->cpfcnpj;
  }

  public function setCpfcnpj($sCpfCnpj) {
    $this->cpfcnpj = $sCpfCnpj;
  }

  public function getLogin() {
    return $this->login;
  }

  public function getNome() {
    return $this->nome;
  }

  public function setNome($sNome) {
    $this->nome = $sNome;
  }

  public function getNomeFantasia() {
    return $this->nome_fantasia;
  }

  public function setNomeFantasia($sNomeFantasia) {
    $this->nome_fantasia = $sNomeFantasia;
  }

  public function getEstado() {
    return $this->estado;
  }

  public function setEstado($sEstado) {
    $this->estado = $sEstado;
  }

  public function getCidade() {
    return $this->cidade;
  }

  public function setCidade($sCidade) {
    $this->cidade = $sCidade;
  }

  public function getCep() {
    return $this->cep;
  }

  public function setCep($sCep) {
    $this->cep = $sCep;
  }

  public function getCodBairro() {
    return $this->cod_bairro;
  }

  public function setCodBairro($iCodigoBairro) {
    $this->cod_bairro = $iCodigoBairro;
  }

  public function getBairro() {
    return $this->bairro;
  }

  public function setBairro($sBairro) {
    $this->bairro = $sBairro;
  }

  public function getCodEndereco() {
    return $this->cod_endereco;
  }

  public function setCodEndereco($iCodigoEndereco) {
    $this->cod_endereco = $iCodigoEndereco;
  }

  public function getEndereco() {
    return $this->endereco;
  }

  public function setEndereco($sEndereco) {
    $this->endereco = $sEndereco;
  }

  public function getNumero() {
    return $this->numero;
  }

  public function setNumero($sNumero) {
    $this->numero = $sNumero;
  }

  public function getComplemento() {
    return $this->complemento;
  }

  public function setComplemento($sComplemento) {
    $this->complemento = $sComplemento;
  }

  public function getTelefone() {
    return $this->telefone;
  }

  public function setTelefone($sTelefone) {
    $this->telefone = $sTelefone;
  }

  public function getEmail() {
    return $this->email;
  }

  public function setEmail($sEmail) {
    $this->email = $sEmail;
  }

  public function getStatus() {
    return $this->status;
  }

  public function setStatus($iStatus) {
    $this->status = $iStatus;
  }

  public function getComentario() {
    return $this->comentario;
  }

  public function setComentario($sComentario) {
    $this->comentario = $sComentario;
  }

  public function getHash() {
    return $this->hash;
  }

  public function setHash($sHash) {
    $this->hash = $sHash;
  }

  public function getDataCadastro() {
    return $this->data_cadastro;
  }

  public function setDataCadastro($dDataCadastro) {
    $this->data_cadastro = $dDataCadastro;
  }

  public function getRecusaJustificatica() {
    return $this->recusa_justificativa;
  }

  public function setRecusaJustificativa($sRecusaJustificativa) {
    $this->recusa_justificativa = $sRecusaJustificativa;
  }

  public function getPerfil() {
    return $this->perfil;
  }

  public function setPerfil(\Administrativo\Perfil $oPerfil) {

    $this->perfil = $oPerfil;
  }

  public function getTipoLiberacao() {
    return $this->tipo_liberacao;
  }

  public function setTipoLiberacao($iTipoLiberacao) {
    $this->tipo_liberacao = $iTipoLiberacao;
  }
}

?>