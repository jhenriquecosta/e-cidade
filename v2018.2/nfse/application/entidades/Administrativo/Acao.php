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
 * @Table(name="acoes")
 * @HasLifecycleCallbacks
 */
class Acao {

  /**
   * @var int
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id = null;

  /**
   * Nome da ação
   * @var string
   * @Column(type="string")
   */
  protected $acao = null;

  /**
   * Controle a qual pertence a ação
   * @var \Adminstrativo\Controle
   * @ManyToOne(targetEntity="Controle", inversedBy="acoes")
   * @JoinColumn(name="id_controle", referencedColumnName="id")
   */
  protected $controle = null;

  /**
   * String formada pelos campos ModuloControleAcao
   * @var string
   * @Column(type="string")
   */
  protected $identidade = null;

  /**
   * @var \Adminstrativo\UsuarioAcao[]
   * @OneToMany(targetEntity="UsuarioAcao", mappedBy="acao", cascade={"remove"})
   */
  protected $usuario_acoes = null;

  /**
   * @var \Adminstrativo\UsuarioContribuinteAcao[]
   * @OneToMany(targetEntity="UsuarioContribuinteAcao", mappedBy="acao", cascade={"remove"})
   */
  protected $usuario_contribuinte_acoes = null;


  /**
   * String contendo a action usada na ACL
   * @var string
   * @Column(type="string")
   */
  protected $acaoacl = null;


  /**
   * Define as sub acoes que a acao(funcionalidade) necessita
   * @var string
   * @Column(type="string")
   */
  protected $sub_acoes = null;
  
  /**
   * Define se a acao é geradora de dados ou não
   * @var boolean
   * @Column(type="boolean")
   */
  protected $gerador_dados = false;
  
  /**
   * @return integer
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @return string
   */
  public function getNome() {
    return $this->acao;
  }

  /**
   * @return \Administrativo\Controle
   */
  public function getControle() {
    return $this->controle;
  }

  /**
   * @return string
   */
  public function getIdentidade() {
    return $this->identidade;
  }

  public function setControle(Controle $controle) {
    $this->controle = $controle;
  }

  public function setNome($nome) {
    $this->acao = $nome;
  }

  public function getUsuarioAcoes() {
    return $this->usuario_acoes;
  }

  public function addAcao(Acao $acao) {
    $this->usuario_acao[] = $acao;
  }

  /**
   * @return string
   */
  public function getAcaoAcl() {
    return $this->acaoacl;
  }
  
  /**
   * @param $sAcaoAcl
   */
  public function setAcaoAcl($sAcaoAcl) {
    $this->acaoacl = $sAcaoAcl;
  }

  /**
   * @return string
   */
  public function getSubAcoes() {
    return $this->sub_acoes;
  }
  
  /**
   * @param $sSubAcoes
   */
  public function setSubAcoes($sSubAcoes) {
    $this->sub_acoes = $sSubAcoes;
  }

  /**
   * @return boolean
   */
  public function getGeradorDados() {
    return $this->gerador_dados;
  }

  /**
   * @param $lGeradorDados
   */
  public function setGeradorDados($lGeradorDados) {
    $this->gerador_dados = $lGeradorDados;
  }

  /**
   * Retorna as acoes dos contribuintes vinculados a um usuario
   * @return |Adminstrativo|UsuarioContribuinteAcao[]
   */
  public function getUsuarioContribuinteAcoes() {
    return $this->usuario_contribuinte_acoes;
  }

  /**
   * Adiciona as acões aos contribuintes do usuario
   * @param UsuarioContribuinteAcao $usuario_contribuinte_acoes
   */
  public function addUsuarioContribuinteAcoes(UsuarioContribuinteAcao $usuario_contribuinte_acoes) {
    $this->usuario_contribuinte_acoes[] = $usuario_contribuinte_acoes;
  }
}