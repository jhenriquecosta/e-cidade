<?php

class E2Tecnologia_Controller_Paginator implements Zend_Paginator_Adapter_Interface {

    /**
     * @var Doctrine\ORM\QueryBuilder 
     */
    protected $_queryBuilder;
    protected $_entityPath;
    protected $_modelName;

    /**
     * @var Doctrine\ORM\QueryBuilder 
     */
    protected $_query;
    protected $_filter = array('join', 'where');

    /**
     * Adaptador Doctrine para o paginador do Zend
     * @param Doctrine\ORM\QueryBuilder  $doctrineQuery
     * @param string $entityPath 
     */
    public function __construct($doctrineQuery, $modelName, $entityPath) {
        $this->_queryBuilder = $doctrineQuery;
        $this->_entityPath = $entityPath;
        $this->_modelName = $modelName;

        $this->_query = clone($this->_queryBuilder);
        $this->_query->select("e");
        $this->_query->from($this->_entityPath, "e");
    }

    public function getItems($offset, $itemCountPerPage) {
        $this->_query->setFirstResult($offset);
        $this->_query->setMaxResults($itemCountPerPage);

        $a = $this->_query->getQuery()->getResult();
        $r = array();
        foreach ($a as $i) {
            $r[] = new $this->_modelName($i);
        }

        return $r;
    }

    public function join($join, $alias) {
        $this->_query->join($join, $alias);
        $this->_filter['join'][] = array('join' => $join, 'alias' => $alias);
    }

    public function where($predicates) {
        $this->_query->where($predicates);
        $this->_filter['where'][] = $predicates;
    }

    public function count() {
        $query = clone $this->_queryBuilder;
        $query->select("count(e) as total");
        $query->from($this->_entityPath, "e");

        if (!empty($this->_filter['join'])) {
            foreach ($this->_filter['join'] as $j) {
                $query->join($j['join'], $j['alias']);
            }
        }
        if (!empty($this->_filter['where'])) {
            foreach ($this->_filter['where'] as $w) {
                $query->where($w);
            }
        }
        
        $query->setFirstResult(0);
        $query->setMaxResults(1);
        $rs = $query->getQuery()->getResult();

        return $rs[0]['total'];
    }

    /* public function getQuery() {
      return $this->_query;
      } */
}

?>
