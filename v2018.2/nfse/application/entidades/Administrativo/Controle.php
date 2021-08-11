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
 * @Table(name="controles")
 * @HasLifecycleCallbacks
 */
class Controle {
    
  /**
   * @var int
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id = null;

  /**
   * Nome do controle
   * @var string
   * @Column(type="string")
   */
  protected $controle = null;
  
  /**
   * @var \Adminstrativo\Modulo
   * @ManyToOne(targetEntity="Modulo", inversedBy="controles")
   * @JoinColumn(name="id_modulo", referencedColumnName="id")
   **/
  protected $modulo = null;
  
  /**
   * Identificador do controller para o acesso via acl
   * @var string
   * @Column(type="string")
   */
  protected $identidade = null;
  
  /**
   * @var \Adminstrativo\Acao[]
   * @OneToMany(targetEntity="Acao", mappedBy="controle", cascade={"persist","remove"})
   */
  protected $acoes = null;
  
  /**
   * identifica se o controller é visivel ao usuario
   * @var boolean
   * @Column(type="boolean")
   */
  protected $visivel = null;
  
  public function __construct() {
    $this->acoes = new ArrayCollection();
  }

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
    return $this->controle;
  }
  
  /**
   * @param string $controle 
   */
  public function setNome($controle) {
    $this->controle = $controle;
  }
  
  /**
   * @return \Adminstrativo\Modulo
   */
  public function getModulo() {
    return $this->modulo;
  }
  
  /**
   * @param \Adminstrativo\Modulo $modulo 
   */
  public function setModulo($modulo) {
    $this->modulo = $modulo;
  }

  /**
   * @return string $sIdentidade
   */
  public function getIdentidade() {
    return $this->identidade;
  }
  
  /**
   * @param string $sIdentidade
   */
  public function setIdentidade($sIdentidade) {
    $this->identidade = $sIdentidade;
  }
  
  /**
   * @return boolean $lVisivel
   */
  public function getVisivel() {
    return $this->visivel;
  }
  
  /**
   * @param string $sIdentidade
   */
  public function setVisivel($lVisivel) {
    $this->visivel = $lVisivel;
  }
  
  /**
   * @return \Adminstrativo\Acao[] 
   */
  public function getAcoes() {
    return $this->acoes;
  }
  
  public function addAcao(Acao $acao) {
    $this->acoes[] = $acao;
  }
}