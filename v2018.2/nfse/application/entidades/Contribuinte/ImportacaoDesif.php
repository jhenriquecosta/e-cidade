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
 * Classe responsável pela manipulação dos dados da estrutura principal do DES-IF
 * @author Luiz Marcelo Schmitt <luiz.marcelo@dbseller.com.br>
 */
namespace Contribuinte;

/**
 * @Entity
 * @Table(name="importacao_desif")
 */
class ImportacaoDesif {

  /**
   * @var int
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id = NULL;

  /**
   * @var \Administrativo\UsuarioContribuinte
   * @OneToOne(targetEntity="\Administrativo\UsuarioContribuinte")
   * @JoinColumn(name="id_contribuinte", referencedColumnName="id")
   */
  protected $contribuinte = null;

  /**
   * @Column(type="string")
   */
  protected $competencia_inicial = NULL;

  /**
   * @Column(type="string")
   */
  protected $competencia_final = NULL;

  /**
   * @Column(type="string")
   */
  protected $versao = NULL;

  /**
   * @Column(type="string")
   */
  protected $nome_arquivo = NULL;

  /**
   * @Column(type="datetime")
   */
  protected $data_importacao = NULL;

  /**
   * @var \Contribuinte\Protocolo
   * @OneToOne(targetEntity="\Contribuinte\Protocolo")
   * @JoinColumn(name="id_protocolo", referencedColumnName="id")
   */
  protected $protocolo = NULL;

  /**
   * @Column(type="string")
   */
  protected $arquivo_hash = NULL;


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
   * @return \Administrativo\UsuarioContribuinte
   */
  public function getContribuinte() {
    return $this->contribuinte;
  }

  /**
   * @param \Administrativo\UsuarioContribuinte $oContribuinte
   */
  public function setContribuinte(\Administrativo\UsuarioContribuinte $oContribuinte) {

    $this->contribuinte = $oContribuinte;
  }

  /**
   * @param string $competenciaInicial
   */
  public function setCompetenciaInicial($competenciaInicial) {

    $this->competencia_inicial = $competenciaInicial;
  }

  /**
   * @return string
   */
  public function getCompetenciaInicial() {

    return $this->competencia_inicial;
  }

  /**
   * @param string $competenciaFinal
   */
  public function setCompetenciaFinal($competenciaFinal) {

    $this->competencia_final = $competenciaFinal;
  }

  /**
   * @return string
   */
  public function getCompetenciaFinal() {

    return $this->competencia_final;
  }

  /**
   * @param string $versao
   */
  public function setVersao($versao) {

    $this->versao = $versao;
  }

  /**
   * @return string
   */
  public function getVersao() {

    return $this->versao;
  }

  /**
   * @param string $nomeArquivo
   */
  public function setNomeArquivo($nomeArquivo) {
    $this->nome_arquivo = $nomeArquivo;
  }

  /**
   * @return string
   */
  public function getNomeArquivo() {
    return $this->nome_arquivo;
  }

  /**
   * @param datetime $dDataImportacao
   */
  public function setDataImportacao($dDataImportacao) {
    $this->data_importacao = $dDataImportacao;
  }

  /**
   * @return datetime
   */
  public function getDataImportacao() {
    return $this->data_importacao;
  }

  /**
   * Buscar Protocolo
   *
   * @return \Contribuinte\Protocolo
   */
  public function getProtocolo() {
    return $this->protocolo;
  }

  /**
   * Define o Protocolo
   *
   * @param \Contribuinte\Protocolo $oProtocolo
   */
  public function setProtocolo(\Contribuinte\Protocolo $oProtocolo) {

    $this->protocolo = $oProtocolo;
  }

  /**
   * @param string $arquivo_hash
   */
  public function setHashImportacao($arquivo_hash) {
    $this->arquivo_hash = $arquivo_hash;
  }

  /**
   * @return string
   */
  public function getHashImportacao() {
    return $this->arquivo_hash;
  }
}