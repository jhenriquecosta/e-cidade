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

namespace Contribuinte;

/**
 * @Entity
 * @Table(name="guias")
 */
class Guia {

  /**
   * @var int
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id = NULL;

  /**
   * @Column(type="float")
   */
  protected $valor_corrigido = NULL;

  /**
   * @Column(type="float")
   */
  protected $valor_historico = NULL;

  /**
   * @Column(type="string")
   */
  protected $codigo_barras = NULL;

  /**
   * @Column(type="string")
   */
  protected $linha_digitavel = NULL;

  /**
   * @Column(type="float")
   */
  protected $juros_multa = NULL;

  /**
   * @Column(type="integer")
   */
  protected $codigo_guia = NULL;

  /**
   * @Column(type="string")
   */
  protected $arquivo_guia = NULL;

  /**
   * @Column(type="integer")
   */
  protected $numpre = NULL;

  /**
   * @Column(type="integer")
   */
  protected $ano_comp = NULL;

  /**
   * @Column(type="integer")
   */
  protected $mes_comp = NULL;

  /**
   * @Column(type="integer")
   */
  protected $id_contribuinte = NULL;

  /**
   * @Column(type="string")
   */
  protected $tipo = NULL;

  /**
   * @Column(type="string")
   */
  protected $situacao = NULL;

  /**
   * @Column(type="date")
   */
  protected $data_fechamento = NULL;

  /**
   * @Column(type="date")
   */
  protected $vencimento = NULL;

  /**
   * @Column (type="integer")
   */
  protected $tipo_documento_origem = NULL;

  /**
   * @ManyToMany(targetEntity="Nota", inversedBy="guia")
   * @JoinTable(
   *   name="guias_notas",
   *   joinColumns={@JoinColumn(name="id_guia", referencedColumnName="id")},
   *   inverseJoinColumns={@JoinColumn(name="id_nota", referencedColumnName="id", unique=true)}
   * )
   */
  protected $notas = NULL;

  /**
   * @ManyToMany(targetEntity="Dms", inversedBy="guia" , fetch="EXTRA_LAZY")
   * @JoinTable(
   *   name="guias_dms",
   *   joinColumns={@JoinColumn(name="id_guia", referencedColumnName="id")},
   *   inverseJoinColumns={@JoinColumn(name="id_dms", referencedColumnName="id", unique=true)}
   * )
   */
  protected $dms = NULL;

  /**
   * @var \Doctrine\Common\Collections\ArrayCollection
   * @OneToMany(targetEntity="GuiasNumpre", mappedBy="guia", cascade={"persist", "remove"})
   */
  protected $debitos;

  /**
   * @Column(type="float")
   */
  protected $valor_origem = NULL;

  /**
   * @Column(type="float")
   */
  protected $valor_pago = NULL;

  /**
   * @Column(type="boolean")
   */
  protected $pagamento_parcial = FALSE;

  /**
   * @Column(type="integer")
   */
  protected $id_competencia = NULL;

  /**
   * @ManyToOne(targetEntity="Competencia", inversedBy="guias")
   * @JoinColumn(name="id_competencia", referencedColumnName="id")
   */
  protected $competencia = NULL;


  /**
   * Construtor
   */
  public function __construct() {

    $this->notas   = new \Doctrine\Common\Collections\ArrayCollection();
    $this->dms     = new \Doctrine\Common\Collections\ArrayCollection();
    $this->debitos = new \Doctrine\Common\Collections\ArrayCollection();
  }

  /**
   * Retorna o identificador da guia
   * @return integer
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Retorna o valor corrigido
   * @return float
   */
  public function getValorCorrigido() {
    return $this->valor_corrigido;
  }

  /**
   * Define o valor corrigido
   * @param float $fValorCorrigido
   */
  public function setValorCorrigido($fValorCorrigido) {
    $this->valor_corrigido = $fValorCorrigido;
  }

  /**
   * Retorna o valor do historico
   * @return float
   */
  public function getValorHistorico() {
    return $this->valor_historico;
  }

  /**
   * Define o valor do historico
   * @param float $fValorHistorico
   */
  public function setValorHistorico($fValorHistorico) {
    $this->valor_historico = $fValorHistorico;
  }

  /**
   * Retorna o código de barras
   * @return string
   */
  public function getCodigoBarras() {
    return $this->codigo_barras;
  }

  /**
   * Define o código de barras
   * @param string $codigo_barras
   */
  public function setCodigoBarras($codigo_barras) {
    $this->codigo_barras = $codigo_barras;
  }

  /**
   * Retorna a linha digitável
   * @return string
   */
  public function getLinhaDigitavel() {
    return $this->linha_digitavel;
  }

  /**
   * Define a linha digitável
   * @param $sLinhaDigitavel
   */
  public function setLinhaDigitavel($sLinhaDigitavel) {
    $this->linha_digitavel = $sLinhaDigitavel;
  }

  /**
   * @return null
   */
  public function getJurosMulta() {
    return $this->juros_multa;
  }

  /**
   * @param $juros_multa
   */
  public function setJurosMulta($juros_multa) {
    $this->juros_multa = $juros_multa;
  }

  /**
   * @return null
   */
  public function getCodigoGuia() {
    return $this->codigo_guia;
  }

  /**
   * @param $codigo_guia
   */
  public function setCodigoGuia($codigo_guia) {
    $this->codigo_guia = $codigo_guia;
  }

  /**
   * @return null
   */
  public function getArquivoGuia() {
    return $this->arquivo_guia;
  }

  /**
   * @param $arquivo_guia
   */
  public function setArquivoGuia($arquivo_guia) {
    $this->arquivo_guia = $arquivo_guia;
  }

  /**
   * Retorna o ano de competência
   * @return integer
   */
  public function getAnoComp() {
    return $this->ano_comp;
  }

  /**
   * Define o ano de competência
   * @param integer $iAnoCompetencia
   */
  public function setAnoComp($iAnoCompetencia) {
    $this->ano_comp = $iAnoCompetencia;
  }

  /**
   * Retorna o mês de competência
   * @return integer
   */
  public function getMesComp() {
    return $this->mes_comp;
  }

  /**
   * Define o mês de competência
   * @param integer $iMesCompetencia
   */
  public function setMesComp($iMesCompetencia) {
    $this->mes_comp = $iMesCompetencia;
  }

  /**
   * Retorna o id do contribuinte
   * @return integer
   */
  public function getIdContribuinte() {
    return $this->id_contribuinte;
  }

  /**
   * Define o id  contribuinte
   * @param integer $iIdContribuinte
   */
  public function setIdContribuinte($iIdContribuinte) {
    $this->id_contribuinte = $iIdContribuinte;
  }

  /**
   * Retorna o tipo
   * @return string
   */
  public function getTipo() {
    return $this->tipo;
  }

  /**
   * Define o tipo
   * @param $sTipo
   */
  public function setTipo($sTipo) {
    $this->tipo = $sTipo;
  }

  /**
   * Retorna a situação
   * @return string
   */
  public function getSituacao() {
    return $this->situacao;
  }

  /**
   * Define a situação
   * @param string $sSituacao
   */
  public function setSituacao($sSituacao) {
    $this->situacao = $sSituacao;
  }

  /**
   * @return null
   */
  public function getNumpre() {
    return $this->numpre;
  }

  /**
   * @param $numpre
   */
  public function setNumpre($numpre) {
    $this->numpre = $numpre;
  }

  /**
   * @return null
   */
  public function getDataFechamento() {
    return $this->data_fechamento;
  }

  /**
   * @param $data_fechamento
   */
  public function setDataFechamento($data_fechamento) {
    $this->data_fechamento = $data_fechamento;
  }

  /**
   * @return null
   */
  public function getVencimento() {
    return $this->vencimento;
  }

  /**
   * @param $vencimento
   */
  public function setVencimento($vencimento) {
    $this->vencimento = $vencimento;
  }

  /**
   * @param $sTipoDocumentoOrigem
   */
  public function setTipoDocumentoOrigem ($sTipoDocumentoOrigem) {
    $this->tipo_documento_origem = $sTipoDocumentoOrigem;
  }

  /**
   * @return null
   */
  public function getTipoDocumentoOrigem () {
    return $this->tipo_documento_origem;
  }

  /**
   * Retorna as notas da guia
   * @return \Doctrine\Common\Collections\ArrayCollection
   */
  public function getNotas() {
    return $this->notas;
  }

  /**
   * Adiciona a nota na guia
   * @param $oNota
   */
  public function addNota($oNota) {
    $this->notas->add($oNota);
  }

  /**
   * Remove a nota da guia
   * @param $oNota
   */
  public function remNota($oNota) {
    $this->notas->removeElement($oNota);
  }

  /**
   * Retorna as dms da guia
   * @return \Doctrine\Common\Collections\ArrayCollection
   */
  public function getDms() {
    return $this->dms;
  }

  /**
   * Adiciona a nota na guia
   * @param $oDms
   */
  public function addDms($oDms) {
    $this->dms->add($oDms);
  }

  /**
   * Remove a nota da guia
   * @param $oDms
   */
  public function remDms($oDms) {
    $this->dms->removeElement($oDms);
  }

  /**
   * Adiciona os débitos da guia
   *
   * @param integer $iNumpre
   */
  public function addNumpre($iNumpre) {

    $oNumpre = new \Contribuinte\GuiasNumpre();
    $oNumpre->setNumpre($iNumpre);
    $oNumpre->setGuia($this);
    $this->debitos->add($oNumpre);
  }

  /**
   * Retorna a lista de débitos da guia
   *
   * @return \Doctrine\Common\Collections\ArrayCollection
   */
  public function getDebitos() {
    return $this->debitos;
  }

  /**
   * @return mixed
   */
  public function getValorOrigem() {
    return $this->valor_origem;
  }

  /**
   * @param mixed $nValorOrigem
   */
  public function setValorOrigem($nValorOrigem) {
    $this->valor_origem = $nValorOrigem;
  }

  /**
   * @return mixed
   */
  public function getValorPago() {
    return $this->valor_pago;
  }

  /**
   * @param mixed $nValorPago
   */
  public function setValorPago($nValorPago) {
    $this->valor_pago = $nValorPago;
  }

  /**
   * @return boolean
   */
  public function getPagamentoParcial() {
    return $this->pagamento_parcial;
  }

  /**
   * @param boolean $bPagamentoParcial
   */
  public function setPagamentoParcial($bPagamentoParcial) {
    $this->pagamento_parcial = $bPagamentoParcial;
  }

  /**
   * @param integer $iIdCompetencia
   */
  public function setId_competencia($iIdCompetencia ) {
    $this->id_competencia = $iIdCompetencia;
  }

  /**
   * @return integer
   */
  public function getId_competencia() {
    return $this->id_competencia;
  }

  public function setCompetencia($competencia) {
    $this->competencia = $competencia;
  }

  public function getCompetencia() {
    return $this->competencia;
  }

}