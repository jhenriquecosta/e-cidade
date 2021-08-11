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
 * Description of Perfil
 *
 * @author guilherme
 */

namespace Administrativo;

use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="perfis")
 */
class Perfil {

  /**
   * @var int
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $nome = NULL;

  /**
   * @var bool
   * @Column(type="boolean")
   */
  protected $administrativo = NULL;

  /**
   *
   * @var Doctrine\Common\Collections\ArrayCollection
   * @ManyToMany(targetEntity="Acao")
   * @JoinTable(name="perfis_acoes",
   *      joinColumns={@JoinColumn(name="id_perfil", referencedColumnName="id")},
   *      inverseJoinColumns={@JoinColumn(name="id_acao", referencedColumnName="id")}
   *      )
   */
  protected $acoes = NULL;

  /**
   *
   * @var Doctrine\Common\Collections\ArrayCollection
   * @ManyToMany(targetEntity="Perfil")
   * @JoinTable(name="perfil_perfis",
   *      joinColumns={@JoinColumn(name="id_perfil", referencedColumnName="id")},
   *      inverseJoinColumns={@JoinColumn(name="id_perfilcad", referencedColumnName="id")}
   *      )
   */
  protected $perfis = NULL;

  /**
   * @var int
   * @Column(type="integer")
   */
  protected $tipo = NULL;

  public function __construct() {
      $this->acoes = new ArrayCollection();
      $this->perfis = new ArrayCollection();
  }

  public function getId() {
      return $this->id;
  }

  public function getNome() {
      return $this->nome;
  }

  public function setNome($nome) {
      $this->nome = $nome;
  }

  public function getAdministrativo() {
      return $this->administrativo;
  }

  public function setAdministrativo($administrativo) {
      $this->administrativo = $administrativo;
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

  public function getPerfis() {
      return $this->perfis;
  }

  public function addPerfis(Perfil $perfil) {
    $this->perfis[] = $perfil;
  }

  public function delPerfis(Perfil $perfil) {
    $this->perfis->removeElement($perfil);
  }

  public function getTipo() {
    return $this->tipo;
  }

  public function setTipo($iTipo) {
    $this->tipo = $iTipo;
  }
}