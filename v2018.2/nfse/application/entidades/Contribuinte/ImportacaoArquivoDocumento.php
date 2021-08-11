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


/**
 * Classe responsável pela manipulação do banco de dados nos documentos da importação de arquivos 
 */

namespace Contribuinte;

/**
 * @Entity
 * @Table(name="importacao_arquivo_documento")
 */
class ImportacaoArquivoDocumento {
  
  /**
   * @var int
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id = NULL;
  
  /**
   * @Column(type="integer")
   */
  protected $id_importacao_arquivo = NULL;

  /**
   * @Column(type="float")
   */
  protected $valor_total = NULL;
  
  /**
   * @Column(type="float")
   */
  protected $valor_imposto = NULL;
  
  /**
   * @var \Contribuinte\ImportacaoArquivo
   * @ManyToOne(targetEntity="\Contribuinte\ImportacaoArquivo", inversedBy="importacao_arquivo_documento")
   * @JoinColumn(name="id_importacao_arquivo", referencedColumnName="id")
   */
  protected $importacao_arquivo = NULL;
  
  /**
   * @var Doctrine\Common\Collections\ArrayCollection
   * @ManyToMany(targetEntity="\Contribuinte\Nota")
   * @JoinTable(
   *   name="importacao_arquivo_documento_nota",
   *   joinColumns={@JoinColumn(name="id_importacao_arquivo_documento", referencedColumnName="id")},
   *   inverseJoinColumns={@JoinColumn(name="id_nota", referencedColumnName="id")}
   * )
   */
  protected $notas = NULL;
  
  /**
   * Construtor da classe
   */
  public function __construct() {
    $this->importacao_documento_notas = new \Doctrine\Common\Collections\ArrayCollection();
  }
  
  /**
   * Retorna o identificador
   * 
   * @param integer $iId
   */
  public function getId() {
    return $this->id;
  }
  
  /**
   * Retorna a instância da importacao de arquivo
   * 
   * @return \Contribuinte\ImportacaoDms
   */
  public function getImportacaoDms() {
    return $this->importacao;
  }
  
  /**
   * Define a instância da importacao de arquivo
   * 
   * @param \Contribuinte\ImportacaoArquivo $oImportacaoArquivo
   */
  public function setImportacaoDms(\Contribuinte\ImportacaoArquivo $oImportacaoArquivo) {
    $this->importacao_arquivo = $oImportacaoArquivo;
  }
  
  /**
   * Retorna o valor total do documento
   * 
   * @return float
   */
  public function getValorTotal() {
    return $this->valor_total;
  }
  
  /**
   * Define o valot total do documento
   * 
   * @param float $fValorTotal
   */
  public function setValorTotal($fValorTotal) {
    $this->valor_total = $fValorTotal;
  }
  
  /**
   * Retorna o valor total de imposto do documento
   * 
   * @return float
   */
  public function getValorImposto() {
    return $this->valor_imposto;
  }
  
  /**
   * Define o valor total de imposto do documento
   * 
   * @param float $fValorImposto
   */
  public function setValorImposto($fValorImposto) {
    $this->valor_imposto = $fValorImposto;
  }
  
  /**
   * Retorna as notas da importação 
   * 
   * @return \Contribuinte\Doctrine\Common\Collections\ArrayCollection
   */
  public function getNotas() {
    return $this->notas;
  }
  
  /**
   * Adiciona um documento do tipo nota à importação
   * 
   * @param \Contribuinte\Nota
   */
  public function addNota(\Contribuinte\Nota $oNota) {
    $this->notas[] = $oNota;
  }
  
  /**
   * Remove um documento do tipo nota da importação
   *
   * @param \Contribuinte\Nota
   */
  public function removeNota(\Contribuinte\Nota $oNota) {
    $this->notas->removeElement($oNota);
  }
}