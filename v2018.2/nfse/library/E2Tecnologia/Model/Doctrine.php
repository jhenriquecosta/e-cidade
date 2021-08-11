<?php

/**
 * Doctrine E2Tecnologia
 * @author dbseller
 * @package \E2Tecnologia\Model\Doctrine
 *
 */

class E2Tecnologia_Model_Doctrine {

  /**
   *  EntityManager do Doctrine
   * @var \Doctrine\ORM\EntityManager 
   */
  protected $em = null;

  /**
   * Entidade instanciada que representa o modelo no banco 
   */
  protected $entity = null;

  /**
   * Retorna EntityManager do Doctrine
   * @return \Doctrine\ORM\EntityManager
   */
  protected static function getEm() {
    return Zend_Registry::get('em');
  }

  /**
   * Busca todos os registros da entidade
   * @param integer $offset
   * @param integer $limit
   * @return Array
   */
  public static function getAll($offset = 0, $limit = null) {

    $em = self::getEm();

    $query = $em->createQueryBuilder();
    $query->select('e');
    $query->from(static::$entityName, "e");
    $query->setFirstResult($offset);
    $query->setMaxResults($limit);

    $results = $query->getQuery()->getResult();
    $objects = array();
    
    foreach ($results as $r) {
      $objects[] = new static::$className($r);
    }

    return $objects;
  }

  public static function getQuery() {
    return self::getEm()->createQueryBuilder();
  }

  /**
   * Busca uma entidade pelo id
   * @param integer $id
   * @return self
   */
  public static function getById($id) {
    
    $em = self::getEm();
    $e = $em->find(static::$entityName, $id);
    
    return new static::$className($e);
  }

  /**
   * Busca entidades por um campo especifico
   * @param string $columnName
   * @param string $value
   * @param string $mode
   * @return Array
   */
  public static function getByAttribute($attrName, $value, $mode = '=') {
    
    $em = self::getEm();
    
    $query = $em->createQueryBuilder();
    $query->select('e');
    $query->from(static::$entityName, "e");

    if (is_array($value)) {
      $query->where("e." . $attrName . " IN (?1)");
    } else {
      $query->where("e." . $attrName . " $mode ?1");
    }
    
    $query->setParameter(1, $value);

    $result = $query->getQuery()->getResult();
    
    if (count($result) == 0)
      return null;

    if (count($result) == 1)
      return new static::$className($result[0]);


    $a = array();
    
    foreach ($result as $r) {
      
      $a[] = new static::$className($r);
    }
    
    return $a;
  }

  /**
   * 
   * @return 
   */
  public static function count() {
    
    $em = self::getEm();
    $query = $em->createQueryBuilder();
    $query->select('count(e)');
    $query->from(static::$entityName, "e");
    $r = $query->getQuery()->getScalarResult();
    
    return $r;
  }

  /**
   * Recebe uma daa no formato (dd/mm/YYYY) e converte em um objeto DateTime
   * @param string $data
   * @return \DateTime
   */
  public static function stringToDate($data) {
    
    $array_data = explode('/', $data);
    
    return new DateTime($array_data[2] . '/' . $array_data[1] . '/' . $array_data[0]);
  }
  
  /**
   * @param  $entity 
   */
  function __construct($entity = null) {
    $this->em = Zend_Registry::get('em');

    if ($entity === null)
      $entity = new static::$entityName();
     
    $this->entity = $entity;
  }

  /**
   * Retorna entidade referente ao objeto 
   */
  public function getEntity() {
    return $this->entity;
  }

  public function destroy() {

    $this->em->remove($this->entity);
    $this->em->flush();
  }

  /**
   * Se o m�todo n�o for encontrado no modelo, reflete a chamada para a Entidade
   * @param string $name
   * @param string $arguments
   */
  public function __call($name, $arguments) {
    if ($this->entity !== null) {
      
      if (is_array($this->entity)) {
        throw new Exception("Entidade inválida (é um vetor)");
      }
      
      if (method_exists($this->entity, $name)) {
        
        return call_user_func_array(array($this->entity, $name), $arguments);
      } else {
        
        throw new Exception("Método $name não encontrado para a entidade " . get_class($this->entity));
      }
    }
  }
  
  /**
   * Busca Entidades por 1 ou mais campos podendo definir uma distinção e ordenação
   * @param array $aAtributos Atributos para utilizar na pesquisa
   * @param array $aCamposOrdem Campos e suas formas de ordenação na pesquisa
   * @return Contribuinte_Model_Nota[]
   */
  public static function getByAttributes(array $aAtributos, array $aCamposOrdem = array()) {
  
    if (count($aAtributos) <= 0) {
      throw new Exception('Atributos Inválidos para pesquisa.');
    }
    
    $oEntityManager = self::getEm();
    $oRepositorio   = $oEntityManager->getRepository(static::$entityName);
  
    $aResultado     = $oRepositorio->findBy($aAtributos, $aCamposOrdem);
    $aRetorno       = array();
  
    if (is_array($aResultado) && count($aResultado) > 0) {
  
      foreach ($aResultado as $oResultado) {
        
        $aRetorno[] = new static::$className($oResultado);
      }
    }
  
    return $aRetorno;
  }
}