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
 * Classe para importação do Protocolo
 * @author Luiz Marcelo Schmitt <luiz.marcelo@dbseller.com.br>
 */

namespace Contribuinte;

use Administrativo\Protocolo;
use Contribuinte\ImportacaoArquivo;

/**
 * @Entity
 * @Table(name="protocolo_importacao")
 */
class ProtocoloImportacao {

  /**
   * @var int
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id = null;

  /**
   * @OneToOne(targetEntity="\Administrativo\Protocolo")
   * @JoinColumn(name="id_protocolo", referencedColumnName="id")
   */
  protected $protocolo = null;

  /**
   * @OneToOne(targetEntity="\Contribuinte\ImportacaoArquivo")
   * @JoinColumn(name="id_importacao", referencedColumnName="id")
   */
  protected $importacao = null;
  
  /**
   * Número do lote
   * @var integer
   * @Column(type="integer")
   */
  protected $numero_lote = null;  

  /**
   * @return number
   */
  public function getId() {
    return $this->id;
  }
  
  /**
   * @param integer $iId
   */
  public function setId($iId) {
    $this->id = $iId;
  }
  
  /**
   * @return \Administrativo\Protocolo
   */
  public function getProtocolo() {
    return $this->protocolo;
  }
  
  /**
   * @param \Administrativo\Protocolo $protocolo Instancia da entidade Administrativo\Protocolo
   */
  public function setProtocolo(\Administrativo\Protocolo $protocolo) {
    $this->protocolo = $protocolo;
  }
  
  /**
   * @return \Contribuinte\ImportacaoArquivo
   */
  public function getImportacao() {
    return $this->importacao;
  }
  
  /**
   * @param \Contribuinte\ImportacaoArquivo $importacao Instancia da entidade Contribuinte\ImportacaoArquivo
   */
  public function setImportacao(\Contribuinte\ImportacaoArquivo $importacao) {
    $this->importacao = $importacao;
  }
  
  /**
   * @return number
   */
  public function getNumeroLote() {
    return $this->numero_lote;
  }
  
  /**
   * @param integer $iNumeroLote
   */
  public function setNumeroLote($iNumeroLote) {
    $this->numero_lote = $iNumeroLote;
  }
}