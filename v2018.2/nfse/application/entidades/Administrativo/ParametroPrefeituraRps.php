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
 * Parametro Prefeitura
 */
namespace Administrativo;

/**
 * @Entity
 * @Table(name="parametros_prefeitura_rps")
 */
class ParametroPrefeituraRps {
  
 /**
  * Identificador da tabela
  * 
  * @var int
  * @Id
  * @Column(type="integer")
  */
 protected $id;
 
  /**
   * Código do tipo de RPS do eCidade
   * 
   * @var int
   * @Column(type="integer")
   */
  protected $tipo_ecidade = NULL;

  /**
   * Código do tipo de RPS da ABRASF
   * 
   * @var string
   * @Column(type="integer", unique=true, nullable=false)
   */
  protected $tipo_nfse;
  
  /**
   * Descrição do tipo de RPS da ABRASF
   * 
   * @var string
   * @Column(type="string", nullable=false) 
   */
  protected $tipo_nfse_descricao;
  
  /**
   * Retorna o código IBGE do município da prefeitura
   * 
   * @return integer
   */
  public function getId() {
    return $this->id;
  }
  
  /**
   * Define o código da ligação entre o tipo da ABRASF com o código do "ecidade"
   * 
   * @param integer $iId
   */
  public function setId($iId) {
    $this->id = $iId;
  }
  
  /**
   * Retorna o código do tipo de rps referente ao "ecidade"
   * 
   * @return integer
   */
  public function getTipoEcidade() {
    return $this->tipo_ecidade; 
  }
  
  /**
   * Define o código do tipo de rps referente ao "ecidade"
   *
   * @param $iTipoRpsEcidade integer
   */
  public function setTipoEcidade($iTipoEcidade) {
    $this->tipo_ecidade = $iTipoEcidade;
  }
  
  /**
   * Retorna o código do tipo de rps do sistema ("nfse")
   *
   * @return integer
   */
  public function getTipoNfse() {
    return $this->tipo_nfse;
  }
  
  /**
   * Define a descrição do tipo de rps do sistema ("nfse")
   * 
   * @param $iTipoRpsNfse integer
   */
  public function setTipoNfse($iTipoNfse) {
    $this->tipo_nfse = $iTipoNfse;
  }
  
  /**
   * Retorna a descrição do tipo de rps do sistema ("nfse")
   *
   * @return integer
   */
  public function getTipoNfseDescricao() {
    return $this->tipo_nfse_descricao;
  }
  
  /**
   * Define o código do tipo de rps do sistema ("nfse")
   *
   * @param $iTipoRpsNfse integer
   */
  public function setTipoNfseDescricao($sTipoNfseDescricao) {
    $this->tipo_nfse_descricao = $sTipoNfseDescricao;
  }
}