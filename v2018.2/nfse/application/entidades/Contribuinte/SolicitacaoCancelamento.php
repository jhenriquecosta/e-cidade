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
 * @Table(name="solicitacao_cancelamento")
 */
class SolicitacaoCancelamento {

  /**
   * @var integer
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id = NULL;

  /**
   * @ManyToOne(targetEntity="\Contribuinte\Nota")
   * @JoinColumn(name="id_nota", referencedColumnName="id")
   */
  protected $nota = NULL;

  /**
   * @ManyToOne(targetEntity="\Administrativo\Usuario")
   * @JoinColumn(name="id_usuario", referencedColumnName="id")
   */
  protected $usuario = NULL;

  /**
   * @Column(type="string")
   */
  protected $justificativa = NULL;

  /**
   * @Column(type="string")
   */
  protected $justificativa_fiscal = NULL;

  /**
   * @Column(type="boolean")
   */
  protected $autorizado = NULL;

    /**
   * @Column(type="integer")
   */
  protected $motivo = NULL;

  /**
   * @Column(type="boolean")
   */
  protected $rejeitado = NULL;

  /**
   * @Column(type="datetime")
   */
  protected $dt_solicitacao = NULL;

  /**
   * @Column(type="string")
   */
  protected $email_tomador = NULL;

  /**
   * @param int $iId
   */
  public function setId($iId) {
    $this->id = $iId;
  }

  /**
   * @return integer $id
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @param \Contribuinte\Nota $oNota
   */
  public function setNota(\Contribuinte\Nota $oNota) {
    $this->nota = $oNota;
  }

  /**
   * @return \Contribuinte\Nota $nota
   */
  public function getNota() {
    return $this->nota;
  }

  /**
   * @param \Administrativo\Usuario $oUsuario
   */
  public function setUsuario($oUsuario) {
    $this->usuario = $oUsuario;
  }

  /**
   * @return \Administrativo\Usuario $usuario
   */
  public function getUsuario() {
    return $this->usuario;
  }

  /**
   * @param \DateTime $oDtSolicitacao
   */
  public function setDtSolicitacao(\DateTime $oDtSolicitacao) {
    $this->dt_solicitacao = $oDtSolicitacao;
  }

  /**
   * @return string $data
   */
  public function getDtSolicitacao() {
    return $this->dt_solicitacao;
  }

  /**
   * @param string $sJustificativa
   */
  public function setJustificativa($sJustificativa) {
    $this->justificativa = $sJustificativa;
  }

  /**
   * @return string $justificativa
   */
  public function getJustificativa() {
    return $this->justificativa;
  }

  /**
   * @param string $sJustificativaFiscal
   */
  public function setJustificativaFiscal($sJustificativaFiscal) {
    $this->justificativa_fiscal = $sJustificativaFiscal;
  }

  /**
   * @return string $justificativa_fiscal
   */
  public function getJustificativaFiscal() {
    return $this->justificativa_fiscal;
  }

  /**
   * @param boolean $lRejeitado
   */
  public function setRejeitado($lRejeitado) {
    $this->rejeitado = $lRejeitado;
  }

  /**
   * @return string $autorizado
   */
  public function getRejeitado() {
    return $this->rejeitado;
  }

  /**
   * @param boolean $lAutorizado
   */
  public function setAutorizado($lAutorizado) {
    $this->autorizado = $lAutorizado;
  }

  /**
   * @return string $autorizado
   */
  public function getAutorizado() {
    return $this->autorizado;
  }

  /**
   * @param integer $iMotivo
   */
  public function setMotivo($iMotivo) {
    $this->motivo = $iMotivo;
  }

  /**
   * @return integer $motivo
   */
  public function getMotivo() {
    return $this->motivo;
  }

  /**
   * @param string $sEmailTomador
   */
  public function setEmailTomador($sEmailTomador) {
    $this->email_tomador = $sEmailTomador;
  }

  /**
   * @return string $justificativa
   */
  public function getEmailTomador() {
    return $this->email_tomador;
  }
}