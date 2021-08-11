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

use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="importacao_dms")
 */
class ImportacaoDms {
  
  /**
   * @var int
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id = NULL;
  
  /**
   * @Column(type="date")
   */
  protected $data_operacao = NULL;
  
  /**
   * @Column(type="float")
   */
  protected $valor_total = NULL;
  
  /**
   * @Column(type="float")
   */
  protected $valor_imposto = NULL;
  
  /**
   * @Column(type="string")
   */
  protected $nome_arquivo = NULL;
  
  /**
   * @Column(type="integer")
   */
  protected $quantidade_notas = NULL;
  
  /**
   * @Column(type="integer")
   */
  protected $codigo_escritorio = NULL;
  
  /**
   * @Column(type="integer")
   */
  protected $id_usuario = NULL;
  
  /**
   * @var Doctrine\Common\Collections\ArrayCollection
   * @OneToMany(targetEntity="ImportacaoDmsNota", mappedBy="importacao",cascade={"persist", "remove"})
   */
  protected $oImportacaoNotas = null;
  
  
  public function getId() {
    return $this->id;
  }
  
  public function getDataOperacao() {
    return $this->data_operacao;
  }
  
  public function setDataOperacao($dDataOperacao) {
    $this->data_operacao = $dDataOperacao;
  }
  
  public function setValorTotal($fValorTotal) {
    $this->valor_total = $fValorTotal;
  }
  
  public function getValorTotal() {
    return $this->valor_total;
  }
  
  public function setValorImposto($fValorImposto) {
    $this->valor_imposto = $fValorImposto;
  }

  public function getValorImposto() {
    return $this->valor_imposto;
  }

  public function setNomeArquivo($sNomeArquivo) {
    $this->nome_arquivo = $sNomeArquivo;
  }

  public function getNomeArquivo() {
    return $this->nome_arquivo;
  }

  public function setQuantidadeNotas($iQuantidadeNotas) {
    $this->quantidade_notas = $iQuantidadeNotas;
  }

  public function getQuantidadeNotas() {
    return $this->quantidade_notas;
  }

  public function setCodigoEscritorio($iCodigoEscritorio) {
    $this->codigo_escritorio = $iCodigoEscritorio;
  }

  public function getCodigoEscritorio() {
    return $this->codigo_escritorio;
  }
  
  /**
   * Construtor da classe
   */
  public function __construct() {
    $this->oImportacaoNotas = new ArrayCollection();
  }
  
  public function getImportacaoNotas() {
    return $this->oImportacaoNotas;
  }
  
  public function addImportacaoNotas(\Contribuinte\ImportacaoDmsNota $oImportacaoNota) {
    $this->oImportacaoNotas->add($oImportacaoNota);
  }
  
  public function getIdUsuario() {
    return $this->id_usuario;
  }
  
  public function setIdUsuario($iIdUsuario) {
    $this->id_usuario = $iIdUsuario;
  }
}