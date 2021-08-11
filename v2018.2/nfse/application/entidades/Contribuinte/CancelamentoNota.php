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
 * @Table(name="cancelamento_notas")
 */
class CancelamentoNota {

  /**
   * @var integer
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id = NULL;

  /**
   * @ManyToOne(targetEntity="\Administrativo\Usuario")
   * @JoinColumn(name="id_usuario", referencedColumnName="id")
   */
  protected $usuario = NULL;

  /**
   * @Column(type="integer")
   */
  protected $motivo = NULL;

  /**
   * @Column(type="date")
   */
  protected $data = NULL;

  /**
   * @Column(type="time")
   */
  protected $hora = NULL;

  /**
   * @OneToOne(targetEntity="\Contribuinte\Nota")
   * @JoinColumn(name="id_nota", referencedColumnName="id")
   */
  protected $nota = NULL;

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
   * @param \Contribuinte\Nota $oNota
   */
  public function setNota($oNota) {

    $this->nota = $oNota;
  }

  /**
   * @return \Contribuinte\Nota $nota
   */
  public function getNota() {

    return $this->nota;
  }

  /**
   * @param \DateTime $oHora
   */
  public function setHora(\DateTime $oHora) {
    $this->hora = $oHora;
  }

  /**
   * @return string $hora
   */
  public function getHora() {

    return $this->hora;
  }

  /**
   * @param \DateTime $oData
   */
  public function setData(\DateTime $oData) {

    $this->data = $oData;
  }

  /**
   * @return string $data
   */
  public function getData() {

    return $this->data;
  }


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
}