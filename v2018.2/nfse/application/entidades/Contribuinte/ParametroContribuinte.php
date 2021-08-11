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

use Symfony\Component\Console\Input\StringInput;

/**
 * @Entity
 * @Table(name="parametroscontribuinte")
 */
class ParametroContribuinte {
  
  /**
   * @var int
   * @Id
   * @Column(type="integer")
   */
  protected $id_contribuinte = null;
  
  /**
   * Aviso para criar novas AIDOFs (Autorização de Impressão de Documentos Fiscais) na emissão dos documentos
   * @var integer
   * @Column(type="integer")
   */
  protected $avisofim_emissao_nota = null;
  
  /**
   * Percentual máximo para o cálculo para dedução de impostos
   * @var float
   * @Column(type="float")
   */
  protected $max_deducao = null;
  
  /**
   * Percentual para cálculo do INSS
   * @var float
   * @Column(type="float")
   */
  protected $inss = null;
  
  /**
   * Percentual para cálculo do PIS
   * @var float
   * @Column(type="float")
   */
  protected $pis = null;
  
  /**
   * Percentual para cálculo do COFINS
   * @var float
   * @Column(type="float")
   */
  protected $cofins = null;
  
  /**
   * Percentual para cálculo do IR
   * @var float
   * @Column(type="float")
   */
  protected $ir = null;
  
  /**
   * Percentual para cálculo do CSLL
   * @var float
   * @Column(type="float")
   */
  protected $csll  = null;
  
  /**
   * Valor fixo da alíquota
   * @var number
   * @Column(type="float")
   */
  protected $valor_iss_fixo = NULL;
  
  public function getIdContribuinte() {
    return $this->id_contribuinte;
  }
  
  public function setIdContribuinte($iIdContribuinte) {
    $this->id_contribuinte = $iIdContribuinte;
  }

  public function getHabilitaDeducao() {
    return $this->habilita_deducao;
  }

  public function setHabilitaDeducao($habilita_deducao) {
    $this->habilita_deducao = $habilita_deducao;
  }

  public function getAvisofimEmissaoNota() {
    return $this->avisofim_emissao_nota;
  }
  
  public function setAvisofimEmissaoNota($avisofim_emissao_nota) {
    $this->avisofim_emissao_nota = $avisofim_emissao_nota;
  }
  
  public function getMaxDeducao() {
    return $this->max_deducao;
  }

  public function setMaxDeducao($max_deducao) {
    $this->max_deducao = $max_deducao;
  }

  public function getInss() {
      return $this->inss;
  }

  public function setInss($inss) {
    $this->inss = $inss;
  }

  public function getPis() {
    return $this->pis;
  }

  public function setPis($pis) {
    $this->pis = $pis;
  }

  public function getCofins() {
    return $this->cofins;
  }

  public function setCofins($cofins) {
    $this->cofins = $cofins;
  }

  public function getIr() {
    return $this->ir;
  }

  public function setIr($ir) {
    $this->ir = $ir;
  }

  public function getCsll() {
      return $this->csll;
  }

  public function setCsll($csll) {
    $this->csll = $csll;
  }
  
  /**
   * Busca valor fixo da aliquota do ISS
   * @return float
   */
  public function getValorIssFixo() {
    return $this->valor_iss_fixo;
  }
  
  /**
   * Define um valor fixo para aliquota do ISS
   * @param float $fValorIss
   */
  public function setValorIssFixo($fValorIss) {
    $this->valor_iss_fixo = $fValorIss;
  }
}