<?php
/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2016  DBSeller Servicos de Informatica
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

namespace Contribuinte;

/**
 * Classe que controla os registros das competências
 * @author Roberto Carneiro <roberto@dbseller.com.br>
 */

/**
 * @Entity
 * @Table(name="competencias")
 */
class Competencia{

  /**
   * @var int
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
  */
  protected $id = NULL;

  /**
   * @Column(type="integer")
   */
  protected $id_contribuinte = NULL;

  /**
   * @Column(type="integer")
   */
  protected $tipo = NULL;

  /**
   * @Column(type="integer")
   */
  protected $mes = NULL;

  /**
   * @Column(type="integer")
   */
  protected $ano = NULL;

  /**
   * @Column(type="integer")
   */
  protected $situacao = NULL;

  /**
   * @Column(type="date")
   */
  protected $data_fechamento = NULL;

  /**
   * @OneToMany(targetEntity="Guia", mappedBy="competencia")
   */
  protected $guias = NULL;

  function __construct()
  {
    $this->guias = new \Doctrine\Common\Collections\ArrayCollection();
  }

  /**
   * @return integer
   */
  public function getId(){
    return $this->id;
  }

  /**
   * @param integer $iId
   */
  public function setId( $iId ){
    $this->id = $iId;
  }

  /**
   * @return integer
   */
  public function getId_contribuinte(){
    return $this->id_contribuinte;
  }

  /**
   * @param integer $iIdContribuinte
   */
  public function setId_contribuinte($iIdContribuinte ){
    $this->id_contribuinte = $iIdContribuinte;
  }

   /**
   * @return integer
   */
  public function getTipo(){
    return $this->tipo;
  }

  /**
   * @param integer $iTipo
   */
  public function setTipo( $iTipo ){
    $this->tipo = $iTipo;
  }

   /**
   * @return integer
   */
  public function getMes(){
    return $this->mes;
  }

  /**
   * @param integer $iMes
   */
  public function setMes( $iMes ){
    $this->mes = $iMes;
  }

   /**
   * @return integer
   */
  public function getAno(){
    return $this->ano;
  }

  /**
   * @param integer $iAno
   */
  public function setAno( $iAno ){
    $this->ano = $iAno;
  }

  /**
   * @return integer
   */
  public function getSituacao(){
    return $this->situacao;
  }

  /**
   * @param integer $iSituacao
   */
  public function setSituacao( $iSituacao ){
    $this->situacao = $iSituacao;
  }

  /**
   * @return string
   */
  public function getData_fechamento(){
    return $this->data_fechamento;
  }

  /**
   * @param string $data_fechamento
   */
  public function setData_fechamento( $data_fechamento ){
    $this->data_fechamento = $data_fechamento;
  }

/**
   * Gets the value of guias.
   * @return \Doctrine\Common\Collections\ArrayCollection
   */
  public function getGuias()
  {
      return $this->guias;
  }

  /**
   * Sets the value of guias.
   * @param Contribuinte\Guia $guias the guias
   */
  protected function setGuias(Contribuinte\Guia $guias)
  {
      $this->guias = $guias;
  }
}