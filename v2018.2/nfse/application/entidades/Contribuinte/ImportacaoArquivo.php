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
 * Classe responsável pela manipulação do banco de dados na importação de arquivos 
 */
namespace Contribuinte;

/**
 * @Entity
 * @Table(name="importacao_arquivo")
 */
class ImportacaoArquivo {
  
  /**
   * @var int
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id = NULL;
  
  /**
   * @var date
   * @Column(type="date")
   */
  protected $data = NULL;
  
  /**
   * @var time
   * @Column(type="time")
   */
  protected $hora = NULL;
  
  /**
   * @var string
   * @Column(type="string")
   */
  protected $tipo = NULL;
  
  /**
   * @var integer
   * @Column(type="integer")
   */
  protected $quantidade_documentos = NULL;
  
  /**
   * @var float
   * @Column(type="float")
   */
  protected $valor_total = NULL;
  
  /**
   * @var float
   * @Column(type="float")
   */
  protected $valor_imposto = NULL;
  
  /**
   * @var string
   * @Column(type="string")
   */
  protected $versao_layout = NULL;
  
  /**
   * @var integer
   * @Column(type="integer")
   */
  protected $id_usuario = NULL;

  /**
   * @var integer
   * @Column(type="integer")
   */
  protected $numero_lote = NULL;
  
  /**
   * @var \Doctrine\Common\Collections\ArrayCollection
   * @OneToMany(targetEntity="\Contribuinte\ImportacaoArquivoDocumento", mappedBy="importacao_arquivo",cascade={"persist", "remove"})
   */
  protected $oImportacaoArquivoDocumentos = NULL;
  
  /**
   * Construtor da classe
   */
  public function __construct() {
    $this->oImportacaoArquivoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
  }
  
  /**
   * Retorna o identificador
   * 
   * @return number
   */
  public function getId() {
    return $this->id;
  }
  
  /**
   * Retorna a data da importação
   * 
   * @return date
   */
  public function getData() {
    return $this->data;
  }
  
  /**
   * Define a data da importação
   * 
   * @param data $dData
   */
  public function setData($dData) {
    $this->data = $dData;
  }
  
  /**
   * Retorna a hora
   * 
   * @return time
   */
  public function getHora() {
    return $this->hora;
  }
  
  /**
   * Define a hora
   * 
   * @param time $tHora
   */
  public function setHora($tHora) {
    $this->hora = $tHora;
  }
  
  /**
   * Retorna o tipo de importação (RPS, NFSe, DMS)
   * 
   * @param unknown $sTipo
   */
  public function getTipo() {
    return $this->tipo;
  }
  
  /**
   * Define o tipo de importação (RPS, NFSe, DMS)
   * 
   * @return string
   */
  public function setTipo($sTipo) {
    $this->tipo = $sTipo;
  }
  
  /**
   * Retorna o valor total dos documentos importados
   * 
   * @return float
   */
  public function getValorTotal() {
    return $this->valor_total;
  }
  
  /**
   * Define o valor total dos documentos importados
   * 
   * @param float $fValorTotal
   */
  public function setValorTotal($fValorTotal) {
    $this->valor_total = $fValorTotal;
  }

  /**
   * Retorna o valor total de imposto dos documentos importados
   * 
   * @return float
   */
  public function getValorImposto() {
    return $this->valor_imposto;
  }
  
  /**
   * Define o valor total de imposto dos documentos importados
   * 
   * @param float $fValorImposto
   */
  public function setValorImposto($fValorImposto) {
    $this->valor_imposto = $fValorImposto;
  }

  /**
   * Retorna a quantidade de documentos importados
   * 
   * @return integer
   */
  public function getQuantidadeDocumentos() {
    return $this->quantidade_documentos;
  }

  /**
   * Define a quantidade de documentos importados
   * 
   * @param integer $iQuantidadeDocumentos
   */
  public function setQuantidadeDocumentos($iQuantidadeDocumentos) {
    $this->quantidade_documentos = $iQuantidadeDocumentos;
  }
  
  /**
   * Retorna a versão do layout do arquivo importado
   *
   * @return string
   */
  public function getVersaoLayout() {
    return $this->versao_layout;
  }
  
  /**
   * Define a versão do layout do arquivo importado
   *
   * @param string $iIdUsuario
   */
  public function setVersaoLayout($sVersaoLayout) {
    $this->versao_layout = $sVersaoLayout;
  }
  
  /**
   * Retorna o usuário responsável pela importação de arquivo
   * 
   * @return integer
   */
  public function getIdUsuario() {
    return $this->id_usuario;
  }
  
  /**
   * Define o usuário responsável pela importação de arquivo
   * 
   * @param integer $iIdUsuario
   */
  public function setIdUsuario($iIdUsuario) {
    $this->id_usuario = $iIdUsuario;
  }
  
  /**
   * Retorna os documentos vinculados à importação
   * 
   * @return \Contribuinte\Doctrine\Common\Collections\ArrayCollection
   */
  public function getImportacaoArquivoDocumentos() {
    return $this->oImportacaoArquivoDocumentos;
  }
  
  /**
   * Define o numero do lote na importação de arquivo
   *
   * @param integer $iNumeroLote
   */
  public function setNumeroLote($iNumeroLote) {
    $this->numero_lote = $iNumeroLote;
  }
  
  /**
   * Retorna o número do lote
   *
   * @return integer
   */
  public function getNumeroLote() {
    return $this->numero_lote;
  }
  
  /**
   * Vincula o documento à importação
   * 
   * @param \Contribuinte\ImportacaoArquivoDocumento $oImportacaoArquivoDocumento
   */
  public function addImportacaoArquivoDocumentos(\Contribuinte\ImportacaoArquivoDocumento $oImportacaoArquivoDocumento) {
    $this->oImportacaoArquivoDocumentos[] = $oImportacaoArquivoDocumento;
  }
}