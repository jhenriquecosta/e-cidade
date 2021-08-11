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

use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="usuarios")
 */
class Usuario {

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
    protected $login = null;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $senha = null;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $nome = null;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $fone = null;

    /**
     * @var string
     * @Column(type="string", unique=true)
     */
    protected $email = null;

    /**
     * @var boolean
     * @Column(type="boolean")
     */
    protected $habilitado = null;

    /**
     * @var boolean
     * @Column(type="boolean")
     */
    protected $administrativo = null;

    /**
     * @var Doctrine\Common\Collections\ArrayCollection
     * @OneToMany(targetEntity="UsuarioContribuinte", mappedBy="usuario",cascade={"persist", "remove"})
     */
    protected $usuarios_contribuintes = null;

    /**
     * @var Doctrine\Common\Collections\ArrayCollection
     * @OneToMany(targetEntity="UsuarioAcao", mappedBy="usuario",cascade={"persist", "remove"})
     */
    protected $usuarios_acoes = null;

    /**
     *
     * @var Doctrine\Common\Collections\ArrayCollection
     * @ManyToMany(targetEntity="Acao")
     * @JoinTable(name="usuarios_acoes",
     *      joinColumns={@JoinColumn(name="id_usuario", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="id_acao", referencedColumnName="id")}
     *      )
     */
    protected $acoes = null;

    /**
     * @var \Adminstrativo\Perfil
     * @ManyToOne(targetEntity="Perfil")
     * @JoinColumn(name="id_perfil", referencedColumnName="id")
     **/
    protected $perfil = null;

    /**
     * @var integer
     * @Column(type="integer")
     **/
    protected $tipo = null;

    /**
     * @var integer
     * @Column(type="integer")
     **/
    protected $cgm = null;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $cnpj = null;

    /**
     * @var boolean
     * @Column(type="boolean")
     */
    protected $principal = null;

    /**
     * @var integer
     * @Column(type="integer")
     */
    protected $tentativa = null;

    /**
     * Data ultima tentativa
     * @var string
     * @Column(type="datetime")
     */
    protected $data_tentativa = null;


    public function __construct() {
        $this->acoes = new ArrayCollection();
        $this->usuarios_contribuintes = new ArrayCollection();
    }

    /**
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param string $l
     * @return void
     */
    public function setLogin($l) {
        $this->login = $l;
    }

    /**
     * @return string
     */
    public function getLogin() {
        return $this->login;
    }

    /**
     * @param string $s
     */
    public function setSenha($s) {
        $this->senha = $s;
    }

    /**
     * @return string
     */
    public function getSenha() {
        return $this->senha;
    }

    /**
     * @return string
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome) {
        $this->nome = $nome;
    }

    /**
     *
     * @return string
     */
    public function getTelefone() {
        return $this->fone;
    }

    /**
     *
     * @param string $telefone
     */
    public function setTelefone($telefone) {
        $this->fone = $telefone;
    }

    /**
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     *
     * @param string $email
     */
    public function setEmail($email) {
      $this->email = $email;
    }

    /**
     *
     * @return boolean
     */
    public function getHabilitado() {
        return $this->habilitado;
    }

    /**
     *
     * @param boolean $habilitado
     */
    public function setHabilitado($habilitado) {
        $this->habilitado = $habilitado;
    }

    /**
     *
     * @return boolean
     */
    public function getAdministrativo() {
        return $this->administrativo;
    }

    /**
     *
     * @param boolean $administrativo
     */
    public function setAdministrativo($administrativo) {
        $this->administrativo = $administrativo;
    }


    /**
     *
     * @return Administrativo\UsuarioContribuinte[]
     */
    public function getUsuariosContribuintes() {
        return $this->usuarios_contribuintes;
    }

    public function addUsuariosContribuintes(UsuarioContribuinte $uc) {
        $this->usuarios_contribuintes->add($uc);
    }

    public function getAcoes() {
        return $this->acoes;
    }

    public function addAcao(Acao $acao) {
        $this->acoes[] = $acao;
    }

    public function delAcao(Acao $acao) {
        $this->acoes->removeElement($acao);
    }

    public function getPerfil() {
        return $this->perfil;
    }

    public function setPerfil(Perfil $perfil) {
        $this->perfil = $perfil;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getCgm() {
        return $this->cgm;
    }

    public function setCgm($cgm) {
        $this->cgm = $cgm;
    }

    public function getUsuarios_acoes() {
        return $this->usuarios_acoes;
    }

    public function setUsuarios_acoes(\Doctrine\Common\Collections\ArrayCollection $usuarios_acoes) {
        $this->usuarios_acoes = $usuarios_acoes;
    }

    public function getCnpj() {
        return $this->cnpj;
    }

    public function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    public function getPrincipal() {
        return $this->principal;
    }

    public function setPrincipal($principal) {
        $this->principal = $principal;
    }

    public function getTentativa() {
        return $this->tentativa;
    }

    public function setTentativa($iTentativa) {
        $this->tentativa = $iTentativa;
    }

    public function getDataTentativa() {
        return $this->data_tentativa;
    }

    public function setDataTentativa($sDataTentativa) {
        $this->data_tentativa = $sDataTentativa;
    }
}