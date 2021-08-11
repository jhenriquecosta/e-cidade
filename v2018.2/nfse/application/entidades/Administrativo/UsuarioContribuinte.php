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
 * Entidade Doctrine para a tabela usuarios_contribuintes.
 *
 * Representa os emissores de ISS no sistema
 *
 * @Entity
 * @Table(name="usuarios_contribuintes")
 */
class UsuarioContribuinte {

  /**
   * @var int
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id = NULL;

  /**
   * @var int
   * @Column(type="integer")
   */
  protected $im = NULL;

  /**
   * @var boolean
   * @Column(type="boolean")
   */
  protected $habilitado = NULL;
  
  /**
   * @var \Adminstrativo\Usuario
   * @ManyToOne(targetEntity="Usuario", inversedBy="usuarios_contribuintes",cascade={"persist"})
   * @JoinColumn(name="id_usuario", referencedColumnName="id")
   **/
  protected $usuario = NULL;

  /**
   * @var \Adminstrativo\UsuarioContribuinteAcao[]
   * @OneToMany(targetEntity="UsuarioContribuinteAcao", mappedBy="usuario_contribuinte",cascade={"persist","remove"})
   */
  protected $usuario_contribuinte_acoes = NULL;

  /**
   * tipo do contribuinte
   *
   * Pr default, todos os
   * @var integer
   * @Column(type="integer")
   */
  protected $tipo_contribuinte = 1;

  /**
   * CNPJ/CPF do contribuinte
   * @var string
   * @Column(type="string")
   */
  protected $cnpj_cpf = NULL;

  /**
   * CGM do contribuinte
   *
   * @var integer
   * @Column(type="integer")
   */
  protected $cgm;

  /**
   * Código do tipo de emissão do contribuinte
   *
   * @tutorial
   *  Opcões:
   *    9: Tomador
   *    10: NFSe
   *    11: DMS
   * @var integer|NULL
   * @Column(type="integer")
   */
  protected $tipo_emissao = NULL;

  /**
   * Cria uma nova instancia da entidade;
   */
  public function __construct() {

      $this->acoes                      = new \Doctrine\Common\Collections\ArrayCollection();
      $this->usuario_contribuinte_acoes = new \Doctrine\Common\Collections\ArrayCollection();
  }

  /**
   * Define do ID do contribuinte
   * @return integer
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Retorna a inscricao municipal do contribuinte
   * @return integer
   */
  public function getIm() {
    return $this->im;
  }

  /**
   * Define a inscricao municipal do contribuinte
   * @param integer $im numero da inscricao municipal
   */
  public function setIm($im) {
    $this->im = $im;
  }

  /**
   * Retorna se o contribuinte está habilitado
   * @return boolean
   */
  public function getHabilitado() {
    return $this->habilitado;
  }

  /**
   * habilita ou desabilita o contribuinte
   * @param boolean $habilitado true para habilitado, false para desabilitar
   */
  public function setHabilitado($habilitado) {
    $this->habilitado = $habilitado;
  }

  /**
   * Retorna a Entidade do usuario vinculado ao contribuinte
   * @return \Administrativo\Usuario
   */
  public function getUsuario() {
    return $this->usuario;
  }

  /**
   * Define a entidade do usuario
   * @param \Administrativo\Usuario $usuario Instancia da entidade Administrativo\Usuario
   */
  public function setUsuario(\Administrativo\Usuario $usuario) {
    $this->usuario = $usuario;
  }
  
  /**
   * Retorna as acoes permitidas aos usuarios
   * @return Administrativo\UsuarioContribuinteAcao[]
   */
  public function getUsuarioContribuinteAcoes() {
    return $this->usuario_contribuinte_acoes;
  }

  /**
   * Adiciona uma acao ao contribuinte
   * @param \Administrativo\UsuarioContribuinteAcao $a Acao que o usuario pode efetuar
   */
  public function addUsuarioContribuinteAcao(\Administrativo\UsuarioContribuinteAcao $a) {
      $this->usuario_contribuinte_acoes[] = $a;
  }

  /**
   * Define do tipo do contribuinte
   * @param integer $tipocontribuinte tipo do contribuinte
   */
  public function setTipoContribuinte($tipocontribuinte) {
    $this->tipo_contribuinte = $tipocontribuinte;
  }
    
  /**
   * Retorna o tipo do contribuinte
   * @return number tipo do contribuinte
   */
  public function getTipoContribuinte() {
    return $this->tipo_contribuinte;
  }
  
  /**
   * Define o numero do cgm do contribuinte
   * @param integer $cgm numero do cgm do contribuinte
   */
  public function setCGM($cgm) {
    $this->cgm = $cgm;
  }
  
  /**
   * Retorna o numero do cgm criado para o usuario
   * @return integer numero do CGM
   */
  public function getCGM() {
    return $this->cgm;
  }
  
  /**
   * Define o numero do CNPJ ou CPF do contribuinte
   * @param string $cnpj_cpf numero do CNPJ/CPF do contribuinte
   */
  public function setCnpjCpf($sCnpjCpf) {
    $this->cnpj_cpf = $sCnpjCpf;
  }
  
  /**
   * Retorna o numero do CNPJ ou CPF do contribuinte
   * @return string numero do CNPJ/CPF
   */
  public function getCnpjCpf() {
    return $this->cnpj_cpf;
  }

  /**
   * Define o código para o tipo de emissão do contribuinte (NFSe, DMS, Tomador)
   *
   * @param $iTipoEmissao
   */
  public function setTipoEmissao($iTipoEmissao) {
    $this->tipo_emissao = $iTipoEmissao;
  }

  /**
   * Retorna o código do tipo de emissão do contribuinte (NFSe, DMS, Tomador)
   *
   * @return int|NULL
   */
  public function getTipoEmissao() {
    return $this->tipo_emissao;
  }
}