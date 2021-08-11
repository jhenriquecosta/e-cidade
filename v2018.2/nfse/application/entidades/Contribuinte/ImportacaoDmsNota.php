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


namespace Contribuinte;

use Doctrine\DBAL\Types\IntegerType;
/**
 * @Entity
 * @Table(name="importacao_dms_nota")
 */
class ImportacaoDmsNota {
  
  /**
   * @var \Contribuinte\ImportacaoDms
   * @ManyToOne(targetEntity="ImportacaoDms", inversedBy="importacao_dms_nota")
   * @JoinColumn(name="id_importacao", referencedColumnName="id")
   */
  protected $importacao = NULL;
 
 /**
  * @Column(type="integer")
  */
 protected $id_importacao = null;
 
  /**
   * @var int
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id = null;

  /**
   * @var Int
   * @Column(type="integer")
   */
  protected $numero_nota;
  
  /**
   * @Column(type="integer")
   */
  protected $tipo_nota;
  
  /**
   * @Column(type="float")
   */
  protected $valor_total = null;
  
  /**
   * @Column(type="float")
   */
  protected $valor_imposto = null;
  
  /**
   * @Column(type="integer")
   */
  protected $codigo_nota_planilha = null;
  
  /**
   * @Column(type="string")
   */
  protected $operacao_nota = null;
  
  /**
   * @Column(type="date")
   */
  protected $data_emissao_nota = null;
  
  /**
   * @Column(type="string")
   */
  protected $competencia = null;
  
  /**
   * @Column(type="integer")
   */
  protected $id_contribuinte = null;
  
  /**
   * @return \Contribuinte\ImportacaoDms
   */
  public function getImportacaoDms() {
    return $this->importacao;
  }
  
  /**
   * @param \Contribuinte\Dms $oDms
   */
  public function setImportacaoDms(\Contribuinte\ImportacaoDms $oImportacaoDms) {
    $this->importacao = $oImportacaoDms;
  }
  
  public function setId($iId) {
    $this->id = $iId;
  }
  
  public function getNumeroNota() {
    return $this->numero_nota;
  }
  
  public function setNumeroNota($iNumeroNota) {
    $this->numero_nota = $iNumeroNota;
  }
  
  public function getTipoNota() {
    return $this->tipo_nota;
  }
  
  public function setTipoNota($iTipoNota) {
    $this->tipo_nota = $iTipoNota;
  }
  
  public function getValorTotal() {
    return $this->valor_total;
  }
  
  public function setValorTotal($fValorTotal) {
    $this->valor_total = $fValorTotal;
  }
  
  public function getValorImposto() {
    return $this->valor_imposto;
  }
  
  public function setValorImposto($fValorImposto) {
   $this->valor_imposto = $fValorImposto;
  }
  
  public function getCodigoNotaPlanilha() {
    return $this->codigo_nota_planilha;
  }
  
  public function setCodigoNotaPlanilha($iCodigoNotaPlanilha) {
   $this->codigo_nota_planilha = $iCodigoNotaPlanilha;
  }
  
  public function getOperacaoNota() {
    return $this->operacao_nota;
  }
  
  public function setOperacaoNota($sOperacaoNota) {
   $this->operacao_nota = $sOperacaoNota;
  }
  
  public function getDataEmissaoNota() {
    return $this->data_emissao_nota;
  }
  
  public function setDataEmissaoNota($dDataEmissaoNota) {
   $this->data_emissao_nota = $dDataEmissaoNota;
  }
  
  public function getCompetencia() {
    return $this->competencia;
  }
  
  public function setCompetencia($sCompetencia) {
   $this->competencia = $sCompetencia;
  }
  
  public function getIdContribuinte() {
    return $this->id_contribuinte;
  }
  
  public function setIdContribuinte($iIdContribuinte) {
    $this->id_contribuinte = $iIdContribuinte;
  }
}