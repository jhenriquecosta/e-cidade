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
 * Classe responsável pela manipulação dos dados da estrutura de tarifas do banco
 * @author Luiz Marcelo Schmitt <luiz.marcelo@dbseller.com.br>
 */
namespace Contribuinte;

/**
 * @Entity
 * @Table(name="importacao_desif_tarifas")
 */
class ImportacaoDesifTarifa {

  /**
   * @var int
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id = NULL;

  /**
   * @var \Contribuinte\ImportacaoDesif
   * @ManyToOne(targetEntity="ImportacaoDesif", inversedBy="importacao_desif_tarifas")
   * @JoinColumn(name="id_importacao", referencedColumnName="id")
   */
  protected $importacao_desif = NULL;

  /**
   * @var \Contribuinte\ImportacaoDesifConta
   * @ManyToOne(targetEntity="ImportacaoDesifConta", inversedBy="importacao_desif_tarifas")
   * @JoinColumn(name="id_importacao_desif_conta", referencedColumnName="id")
   **/
  protected $importacao_desif_conta = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $tarifa_banco;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $descricao = NULL;

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
   * @param ImportacaoDesif $importacao_desif
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
   * @param string $tarifa_banco
   */
  public function setTarifaBanco($tarifa_banco) {

    $this->tarifa_banco = $tarifa_banco;
  }

  /**
   * @return string
   */
  public function getTarifaBanco() {

    return $this->tarifa_banco;
  }

  /**
   * @param string $descricao
   */
  public function setDescricao($descricao) {

    $this->descricao = $descricao;
  }

  /**
   * @return string
   */
  public function getDescricao() {

    return $this->descricao;
  }
}