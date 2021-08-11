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
 * Classe auxiliar para paginação de consulta à base de dados
 *
 * @package DBSeller/Controller
 * @implements Zend_Paginator_Adapter_Interface
 */

/**
 * @package DBSeller/Controller
 * @implements Zend_Paginator_Adapter_Interface
 */
class DBSeller_Controller_Paginator implements Zend_Paginator_Adapter_Interface {

  /**
   * @var Doctrine\ORM\QueryBuilder 
   */
  protected $_queryBuilder;

  /**
   * @var string
   */
  protected $_entityPath;

  /**
   * @var string
   */
  protected $_modelName;

  /**
   * @var Doctrine\ORM\QueryBuilder 
   */
  protected $_query;

  /**
   * @var array
   */
  protected $_filter = array('join', 'where', 'andWhere', 'orWhere');

  /**
   * Adaptador Doctrine para o paginador do Zend
   *
   * @param $doctrineQuery
   * @param $modelName
   * @param $entityPath
   */
  public function __construct($doctrineQuery, $modelName, $entityPath) {
    
    $this->_queryBuilder = $doctrineQuery;
    $this->_entityPath   = $entityPath;
    $this->_modelName    = $modelName;
    $this->_query        = clone($this->_queryBuilder);
    $this->_query->select('e');
    $this->_query->from($this->_entityPath, 'e');
  }

  /**
   * Retorna o itens da paginação
   *
   * @param int $iInicioPaginacao
   * @param int $iItensPorPagina
   * @return array
   */
  public function getItems($iInicioPaginacao, $iItensPorPagina) {
    
    $this->_query->setFirstResult($iInicioPaginacao);
    $this->_query->setMaxResults($iItensPorPagina);
    
    $aResultado = $this->_query->getQuery()->getResult();
    $aRetorno   = array();
    
    foreach ($aResultado as $sModelo) {
      $aRetorno[] = new $this->_modelName($sModelo);
    }
    
    return $aRetorno;
  }

  /**
   * @param $join
   * @param $alias
   */
  public function join($join, $alias) {
    
    $this->_query->join($join, $alias);
    $this->_filter['join'][] = array('join' => $join, 'alias' => $alias);
  }

  /**
   * @param $predicates
   */
  public function where($predicates) {
    
    $this->_query->where($predicates);
    $this->_filter['where'][] = $predicates;
  }

  /**
   * @param $predicates
   */
  public function andWhere($predicates) {
  
    $this->_query->andWhere($predicates);
    $this->_filter['andWhere'][] = $predicates;
  }

  /**
   * @param $predicates
   */
  public function orWhere($predicates) {
  
    $this->_query->orWhere($predicates);
    $this->_filter['orWhere'][] = $predicates;
  }

  /**
   * Retorna a quantidade de itens
   *
   * @return int
   */
  public function count() {
    
    $query = clone $this->_queryBuilder;
    $query->select("count(e) as total");
    $query->from($this->_entityPath, "e");
    
    if (!empty($this->_filter['join'])) {
      
      foreach ($this->_filter['join'] as $join) {
        $query->join($join['join'], $join['alias']);
      }
    }
    
    if (!empty($this->_filter['where'])) {
      
      foreach ($this->_filter['where'] as $where) {
        $query->where($where);
      }
    }
    
    if (!empty($this->_filter['andWhere'])) {
    
      foreach ($this->_filter['andWhere'] as $andWhere) {
        $query->andWhere($andWhere);
      }
    }
    
    if (!empty($this->_filter['orWhere'])) {
    
      foreach ($this->_filter['orWhere'] as $orWhere) {
        $query->orWhere($$orWhere);
      }
    }
    
    $query->setFirstResult(0);
    $query->setMaxResults(1);
    $resultSet = $query->getQuery()->getResult();
    
    return $resultSet[0]['total'];
  }

  /**
   * Ordem
   *
   * @param $sCampo
   * @param $sOrdem
   */
  public function orderBy ($sCampo, $sOrdem) {
    $this->_query->addOrderBy($sCampo, $sOrdem);
  }

  /**
   * Debug
   *
   * @return \Doctrine\ORM\QueryBuilder
   */
  public function getQuery() {
    return $this->_query;
  } 
}