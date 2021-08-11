<?php
/**
 * 
 *
 * @author guilherme
 */
namespace Administrativo;

/**
 * @Entity
 * @Table(name="cadastros") 
 */
class Cadastro {
    
  /**
   * @var int
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id = null;
  
  /**
   * @var tipo
   * @Column(type="integer")
   */
  protected $tipo = null;
  
  /**
   * @var string
   * @Column(type="string")
   */
  protected $cpfcnpj = null;
  
  /**
   * @var string
   * @Column(type="string")
   */
  protected $login = null;
  
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
  protected $senha = null;
  
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
  protected $numero = null;
  
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
  
  public function getId() {
    return $this->id;
  }

  public function getTipo() {
    return $this->tipo;
  }
  
  public function setTipo($tipo) {
    $this->tipo = $tipo;
  }
  
  public function getCpfcnpj() {
    return $this->cpfcnpj;
  }

  public function setCpfcnpj($cpfcnpj) {
    $this->cpfcnpj = $cpfcnpj;
  }

  public function getLogin() {
    return $this->login;
  }

  public function setLogin($login) {
    $this->login = $login;
  }

  public function getNome() {
    return $this->nome;
  }

  public function setNome($nome) {
    $this->nome = $nome;
  }

  public function getNomeFantasia() {
    return $this->nome_fantasia;
  }

  public function setNomeFantasia($nome_fantasia) {
    $this->nome_fantasia = $nome_fantasia;
  }

  public function getSenha() {
    return $this->senha;
  }

  public function setSenha($senha) {
    $this->senha = hash('sha1',$senha);
  }

  public function getEstado() {
    return $this->estado;
  }

  public function setEstado($estado) {
    $this->estado = $estado;
  }

  public function getCidade() {
    return $this->cidade;
  }

  public function setCidade($cidade) {
    $this->cidade = $cidade;
  }

  public function getCep() {
    return $this->cep;
  }

  public function setCep($cep) {
    $this->cep = $cep;
  }

  public function getCodBairro() {
    return $this->cod_bairro;
  }

  public function setCodBairro($cod_bairro) {
    $this->cod_bairro = $cod_bairro;
  }
  
  public function getBairro() {
    return $this->bairro;
  }
  
  public function setBairro($bairro) {
    $this->bairro = $bairro;
  }

  public function getCodEndereco() {
    return $this->cod_endereco;
  }

  public function setCodEndereco($cod_endereco) {
    $this->cod_endereco = $cod_endereco;
  }
  
  public function getEndereco() {
    return $this->endereco;
  }
  
  public function setEndereco($endereco) {
    $this->endereco = $endereco;
  }    

  public function getNumero() {
    return $this->numero;
  }

  public function setNumero($numero) {
    $this->numero = $numero;
  }

  public function getComplemento() {
    return $this->complemento;
  }

  public function setComplemento($complemento) {
    $this->complemento = $complemento;
  }

  public function getTelefone() {
    return $this->telefone;
  }

  public function setTelefone($telefone) {
    $this->telefone = $telefone;
  }

  public function getEmail() {
    return $this->email;
  }

  public function setEmail($email) {
    $this->email = $email;
  }
  
  public function getStatus() {
   return $this->status;
  }
  
  public function setStatus($status) {
   $this->status = $status;
  }
  
  public function getComentario() {
   return $this->comentario;
  }
  
  public function setComentario($comentario) {
   $this->comentario = $comentario;
  }
      
}

?>
