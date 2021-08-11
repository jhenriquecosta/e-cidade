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
 * Entidade da tabela 'parametroscontribuinte_tributos'
 * @author Luiz Marcelo Schmitt <luiz.marcelo@dbseller.com.br>
 */
namespace Contribuinte;

/**
 * @Entity
 * @Table(name="parametroscontribuinte_tributos")
 */
class ParametroContribuinteTributos {

  /**
   * @var int
   * @Id
   * @OneToMany(targetEntity="ParametroContribuinteTributos", mappedBy="parent")
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id = NULL;

  /**
   * @var \Administrativo\UsuarioContribuinte
   * @OneToOne(targetEntity="\Administrativo\UsuarioContribuinte")
   * @JoinColumn(name="id_contribuinte", referencedColumnName="id")
   */
  protected $contribuinte = NULL;

  /**
   * @Column(type="integer")
   */
  protected $ano = NULL;

  /**
   * @Column(type="float")
   */
  protected $percentual_tributos = NULL;

  /**
   * @Column(type="string")
   */
  protected $fonte_tributacao = NULL;

  /**
   * Método construtor
   */
  public function __construct() {
    $this->id = new \Doctrine\Common\Collections\ArrayCollection();
  }

  /**
   * @param integer $iId
   */
  public function setId($iId) {
    $this->id = $iId;
  }

  /**
   * @return integer
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @return \Administrativo\UsuarioContribuinte
   */
  public function getContribuinte() {
    return $this->contribuinte;
  }

  /**
   * @param \Administrativo\UsuarioContribuinte $oContribuinte
   */
  public function setContribuinte(\Administrativo\UsuarioContribuinte $oContribuinte) {

    $this->contribuinte = $oContribuinte;
  }

  /**
   * @return mixed
   */
  public function getAno() {

    return $this->ano;
  }

  /**
   * @param mixed $ano
   */
  public function setAno($ano) {

    $this->ano = $ano;
  }

  /**
   * @return mixed
   */
  public function getPercentualTributos() {

    return $this->percentual_tributos;
  }

  /**
   * @param mixed $percentual_tributos
   */
  public function setPercentualTributos($percentual_tributos) {

    $this->percentual_tributos = $percentual_tributos;
  }

  /**
   * @return mixed
   */
  public function getFonteTributacao() {

    return $this->fonte_tributacao;
  }

  /**
   * @param mixed $fonte_tributacao
   */
  public function setFonteTributacao($fonte_tributacao) {

    $this->fonte_tributacao = $fonte_tributacao;
  }
}