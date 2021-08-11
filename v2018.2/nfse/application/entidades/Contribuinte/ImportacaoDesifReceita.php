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
 * Classe responsável pela manipulação dos dados do estrutural da conta
 * @author Luiz Marcelo Schmitt <luiz.marcelo@dbseller.com.br>
 */
namespace Contribuinte;

/**
 * @Entity
 * @Table(name="importacao_desif_receitas")
 */
class ImportacaoDesifReceita {

  /**
   * @var int
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id = NULL;

  /**
   * @var \Contribuinte\ImportacaoDesif
   * @ManyToOne(targetEntity="ImportacaoDesif", inversedBy="importacao_desif_receitas")
   * @JoinColumn(name="id_importacao_desif", referencedColumnName="id")
   **/
  protected $importacao_desif = NULL;

  /**
   * @var \Contribuinte\ImportacaoDesifConta
   * @OneToOne(targetEntity="ImportacaoDesifConta")
   * @JoinColumn(name="id_importacao_desif_conta", referencedColumnName="id")
   **/
  protected $importacao_desif_conta = NULL;

  /**
   * @Column(type="string")
   */
  protected $sub_titu = NULL;

  /**
   * @Column(type="string")
   */
  protected $cod_trib_desif = NULL;

  /**
   * @Column(type="float")
   */
  protected $valr_cred_mens = NULL;

  /**
   * @Column(type="float")
   */
  protected $valr_debt_mens = NULL;

  /**
   * @Column(type="float")
   */
  protected $rece_decl = NULL;

  /**
   * @Column(type="float")
   */
  protected $dedu_rece_decl = NULL;

  /**
   * @Column(type="string")
   */
  protected $desc_dedu = NULL;

  /**
   * @Column(type="float")
   */
  protected $base_calc = NULL;

  /**
   * @Column(type="float")
   */
  protected $aliq_issqn = NULL;

  /**
   * @Column(type="float")
   */
  protected $inct_fisc = NULL;

  /**
   * @param int $id
   */
  public function setId($id) {

    $this->id = $id;
  }

  /**
   * @return int
   */
  public function getId() {

    return $this->id;
  }

  /**
   * @param float $aliq_issqn
   */
  public function setAliqIssqn($aliq_issqn) {

    $this->aliq_issqn = $aliq_issqn;
  }

  /**
   * @return float
   */
  public function getAliqIssqn() {

    return $this->aliq_issqn;
  }

  /**
   * @param float $base_calc
   */
  public function setBaseCalc($base_calc) {

    $this->base_calc = $base_calc;
  }

  /**
   * @return float
   */
  public function getBaseCalc() {

    return $this->base_calc;
  }

  /**
   * @param float $cod_trib_desif
   */
  public function setCodTribDesif($cod_trib_desif) {

    $this->cod_trib_desif = $cod_trib_desif;
  }

  /**
   * @return float
   */
  public function getCodTribDesif() {

    return $this->cod_trib_desif;
  }

  /**
   * @param float $dedu_rece_decl
   */
  public function setDeduReceDecl($dedu_rece_decl) {

    $this->dedu_rece_decl = $dedu_rece_decl;
  }

  /**
   * @return float
   */
  public function getDeduReceDecl() {

    return $this->dedu_rece_decl;
  }

  /**
   * @param string $desc_dedu
   */
  public function setDescDedu($desc_dedu) {

    $this->desc_dedu = $desc_dedu;
  }

  /**
   * @return string
   */
  public function getDescDedu() {

    return $this->desc_dedu;
  }

  /**
   * @param \Contribuinte\ImportacaoDesif $importacao_desif
   */
  public function setImportacaoDesif(\Contribuinte\ImportacaoDesif $importacao_desif) {

    $this->importacao_desif = $importacao_desif;
  }

  /**
   * @return \Contribuinte\ImportacaoDesif
   */
  public function getImportacaoDesif() {

    return $this->importacao_desif;
  }

  /**
   * @param \Contribuinte\ImportacaoDesifConta $importacao_desif_conta
   */
  public function setImportacaoDesifConta(\Contribuinte\ImportacaoDesifConta $importacao_desif_conta) {

    $this->importacao_desif_conta = $importacao_desif_conta;
  }

  /**
   * @return \Contribuinte\ImportacaoDesifConta
   */
  public function getImportacaoDesifConta() {

    return $this->importacao_desif_conta;
  }

  /**
   * @param float $inct_fisc
   */
  public function setInctFisc($inct_fisc) {

    $this->inct_fisc = $inct_fisc;
  }

  /**
   * @return float
   */
  public function getInctFisc() {

    return $this->inct_fisc;
  }

  /**
   * @param float $rece_decl
   */
  public function setReceDecl($rece_decl) {

    $this->rece_decl = $rece_decl;
  }

  /**
   * @return float
   */
  public function getReceDecl() {

    return $this->rece_decl;
  }

  /**
   * @param string $sub_titu
   */
  public function setSubTitu($sub_titu) {

    $this->sub_titu = $sub_titu;
  }

  /**
   * @return string
   */
  public function getSubTitu() {

    return $this->sub_titu;
  }

  /**
   * @param float $valr_cred_mens
   */
  public function setValrCredMens($valr_cred_mens) {

    $this->valr_cred_mens = $valr_cred_mens;
  }

  /**
   * @return float
   */
  public function getValrCredMens() {

    return $this->valr_cred_mens;
  }

  /**
   * @param float $valr_debt_mens
   */
  public function setValrDebtMens($valr_debt_mens) {

    $this->valr_debt_mens = $valr_debt_mens;
  }

  /**
   * @return float
   */
  public function getValrDebtMens() {

    return $this->valr_debt_mens;
  }
}