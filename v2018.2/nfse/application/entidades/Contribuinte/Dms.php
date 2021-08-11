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
 * Arquivo de definicao da Entidade da DMS
 * @author dbseller
 * @package Entidades
 * @subpackage Contribuinte
 */
namespace Contribuinte;

use \Doctrine\Common\Collections\ArrayCollection;

/**
 * Entidade de referencia da tabela DMS
 *
 * @Entity
 * @Table(name="dms")
 */
class Dms {
  
  /**
   * @var int @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id = null;
  
  /**
   * @Column(type="integer")
   */
  protected $codigo_planilha = null;
  
  /**
   *
   * @Column(type="integer")
   */
  protected $id_contribuinte = null;
  
  /**
   *
   * @Column(type="integer")
   */
  protected $id_usuario = null;
  
  /**
   * @Column(type="date")
   */
  protected $data_operacao = null;
  
  /**
   * @Column(type="integer")
   */
  protected $ano_comp = null;
  
  /**
   * @Column(type="integer")
   */
  protected $mes_comp = null;

  /**
  * @Column(type="string")
  */
  protected $status = null;
  
  /**
   * @Column(type="string")
   */
  protected $operacao = null;
  
  /**
   * @var Doctrine\Common\Collections\ArrayCollection
   * @OneToMany(targetEntity="DmsNota", mappedBy="dms",cascade={"persist", "remove"})
   */
  protected $oDmsNotas = null;
  
  /**
   * Instancia a Entidade
   */
  public function __construct() {
    $this->oDmsNotas = new ArrayCollection();
  }
  
  /**
   * Retorna o ID da gerado para o registro
   * @return integer codigo da DMS
   */
  public function getId() {
    return $this->id;
  }
  
  /**
   * Define o id do registro
   * @param integer $id Codigo da DMS
   */
  public function setId($id) {
    $this->id = $id;
  }
  
  /**
   * Retorna o codigo da planilha gerada para a DMS
   * @return integer
   */
  public function getCodigoPlanilha() {
    return $this->codigo_planilha;
  }
  
  /**
   * Define o codigo da Planilha gerada no Ecidade
   * @param integer $codigo_planilha Codigo da Planilha do Ecidade
   */
  public function setCodigoPlanilha($codigo_planilha) {
    $this->codigo_planilha = $codigo_planilha;
  }
  
  /**
   * Retorna o Codigo do usuario que incluiu a DMS
   * @return integer
   */
  public function getIdUsuario() {
    return $this->id_usuario;
  }
  
  /**
   * Define o usuario que realizou a inclusao da DMS
   * @param integer $iIdUsuario Codigo do Usuario
   */
  public function setIdUsuario($iIdUsuario) {
    $this->id_usuario = $iIdUsuario;
  }
  
  /**
   * Retorna o codigo do contribuinte
   * @return integer
   */
  public function getIdContribuinte() {
    return $this->id_contribuinte;
  }
  
  /**
   * Define o codigo do contribuinte
   * @param integer $iIdContribuinte codigo do contribuinte
   */
  public function setIdContribuinte($iIdContribuinte) {
    $this->id_contribuinte = $iIdContribuinte;
  }
  
  /**
   * Retorna a data da operacao
   * @return string
   */
  public function getDataOperacao() {
    return $this->data_operacao;
  }
  
  /**
   * Define a data da operacao
   * @param string $data_operacao data da operacao
   */
  public function setDataOperacao($data_operacao) {
    $this->data_operacao = $data_operacao;
  }
  
  /**
   * Competencia
   */
  public function getAnoCompetencia() {
    return $this->ano_comp;
  }
  
  /**
   * Competencia
   * @param integer $ano_comp ano da DMS
   */
  public function setAnoCompetencia($ano_comp) {
    $this->ano_comp = $ano_comp;
  }
  
  /**
   * Mes da competencia
   */
  public function getMesCompetencia() {
    return $this->mes_comp;
  }
  
  /**
   * Mes da Competencia
   * @param integer $mes_comp mes da competencia
   */
  public function setMesCompetencia($mes_comp) {
    $this->mes_comp = $mes_comp;
  }
  
  /**
   * Estatus da DMS
   */
  public function getStatus() {
    return $this->status;
  }
  
  /**
   * Status da DMS
   * @param string $status estatus da DMS
   */
  public function setStatus($status) {
    $this->status = $status;
  }
  
  /**
   * Operacao da DMS
   * @return string
   */
  public function getOperacao() {
    return $this->operacao;
  }
  
  /**
   * Operacao da DMS
   *
   * @param string $operacao Operacao da dms
   */
  public function setOperacao($operacao) {
    $this->operacao = $operacao;
  }
  
  /**
   * Retorna as Notas da DMS
   * @return \Doctrine\Common\Collections\ArrayCollection
   */
  public function getDmsNotas() {
    return $this->oDmsNotas;
  }
  
  /**
   * Adiciona uma nota a DMS
   * @param \Contribuinte\DmsNota $oDmsNota  Entidade da DMS
   */
  public function addDmsNotas(\Contribuinte\DmsNota $oDmsNota) {
    $this->oDmsNotas->add($oDmsNota);
  }
}

?>