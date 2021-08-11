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
 * Entidade da tabela desif_contas_guias
 * @author Roberto Carneiro <roberto@dbseller.com.br>
 */
namespace Contribuinte;

/**
 * @Entity
 * @Table(name="desif_contas_guias")
 */
class DesifContaGuia {

  /**
   * @var int
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id = NULL;
  
  /**
   * @var \Contribuinte\Guia
   * @ManyToOne(targetEntity="Guia", inversedBy="desif_contas_guias")
   * @JoinColumn(name="id_guia", referencedColumnName="id")
   */
  protected $guia = NULL;

  /**
   * @var \Contribuinte\ImportacaoDesif
   * @ManyToOne(targetEntity="ImportacaoDesif", inversedBy="desif_contas_guias")
   * @JoinColumn(name="id_importacao_desif", referencedColumnName="id")
   */
  protected $importacao_desif = NULL;

  /**
   * @var \Contribuinte\ImportacaoDesifConta
   * @ManyToOne(targetEntity="ImportacaoDesifConta", inversedBy="desif_contas_guias")
   * @JoinColumn(name="id_importacao_desif_conta", referencedColumnName="id")
   **/
  protected $importacao_desif_conta = NULL;

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
   * @param \Contribuinte\Guia $importacao_desif_conta
   */
  public function setGuia(\Contribuinte\Guia $oGuia) {
  
    $this->guia = $oGuia;
  }
  
  /**
   * @return \Contribuinte\Guia
   */
  public function getGuia() {
  
    return $this->guia;
  }

  /**
   * @param \Contribuinte\ImportacaoDesifConta $oImportacaoDesifConta
   */
  public function setImportacaoDesifConta(\Contribuinte\ImportacaoDesifConta $oImportacaoDesifConta) {

    $this->importacao_desif_conta = $oImportacaoDesifConta;
  }

  /**
   * @return \Contribuinte\ImportacaoDesifConta
   */
  public function getImportacaoDesifConta() {

    return $this->importacao_desif_conta;
  }

  /**
   * @param ImportacaoDesif $oImportacaoDesif
   */
  public function setImportacaoDesif(\Contribuinte\ImportacaoDesif $oImportacaoDesif) {

    $this->importacao_desif = $oImportacaoDesif;
  }

  /**
   * @return \Contribuinte\ImportacaoDesif
   */
  public function getImportacaoDesif() {

    return $this->importacao_desif;
  }
}