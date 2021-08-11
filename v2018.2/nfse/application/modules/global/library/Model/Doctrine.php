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
 * Modelo para interação com a base de dados
 *
 * @author Davi Busanello <davi@dbseller.com.br>
 *
 * @see     Doctrine
 * @package Global/Library
 */
class Global_Lib_Model_Doctrine {

  const TIPO_RETORNO_ARRAY = 'array';

  const TIPO_RETORNO_CLASS = 'class';

  /**
   * EntityManager do Doctrine
   *
   * @var \Doctrine\ORM\EntityManager
   */
  protected $em = NULL;

  /**
   * Entidade instanciada que representa o modelo no banco
   */
  protected $entity = NULL;

  /**
   * Retorna EntityManager do Doctrine
   *
   * @return \Doctrine\ORM\EntityManager
   */
  protected static function getEm() {

    return Zend_Registry::get('em');
  }

  /**
   * Retorna a entidade instanciada pela primary key
   *
   * @param integer $iPrimaryKey
   * @return object
   */
  public static function getEntityByPrimaryKey($iPrimaryKey) {

    $oEntityManager = self::getEm();
    $oEntity        = $oEntityManager->find(static::$entityName, $iPrimaryKey);

    return $oEntity;
  }

  /**
   * Busca todos os registros da entidade
   *
   * @deprecated
   * @param int         $iOffset
   * @param int|null    $iLimit
   * @param string|null $sOrderBy
   * @return array
   */
  public static function getAll($iOffset = 0, $iLimit = NULL, $sOrderBy = NULL) {

    $oQuery = self::getQuery();
    $oQuery->select('e');
    $oQuery->from(static::$entityName, 'e');
    $oQuery->setFirstResult($iOffset);
    $oQuery->setMaxResults($iLimit);

    if (!empty($sOrderBy)) {
      $oQuery->orderBy($sOrderBy);
    }

    $aResultado = $oQuery->getQuery()->getResult();
    $aRetorno   = array();

    foreach ($aResultado as $sNomeClasse) {
      $aRetorno[] = new static::$className($sNomeClasse);
    }

    return $aRetorno;
  }

  /**
   * Metodo para retornar todos os registros
   *
   * @param integer|null $iLimite
   * @param array        $aOrderBy
   * @param integer|null $iPagina
   * @return array
   */
  public static function getListAll($iLimite = NULL, array $aOrderBy = array(), $iPagina = NULL) {

    $oEntityManager = self::getEm();
    $oRepositorio   = $oEntityManager->getRepository(static::$entityName);
    $aResultado     = $oRepositorio->findBy(array(), $aOrderBy, $iLimite, $iLimite, $iPagina);

    return (is_array($aResultado) ? $aResultado : array());
  }

  /**
   * Retorna a Query
   *
   * @return \Doctrine\ORM\QueryBuilder
   */
  public static function getQuery() {

    return self::getEm()->createQueryBuilder();
  }

  /**
   * Busca uma entidade pelo id
   *
   * @param integer $iId
   * @return mixed
   */
  public static function getById($iId) {

    $oEntityManager = self::getEm();
    $oEntidade      = $oEntityManager->find(static::$entityName, $iId);

    return new static::$className($oEntidade);
  }

  /**
   * Busca entidades por um campo especifico
   *
   * @param string $sNomeAtributo
   * @param string $sValor
   * @param string $sOperador
   * @return array|null
   */
  public static function getByAttribute($sNomeAtributo,
                                           $sValor,
                                           $sOperador = '=',
                                           $sTipoRetorno = self::TIPO_RETORNO_CLASS) {

    $oQuery = self::getQuery();
    $oQuery->select('e');
    $oQuery->from(static::$entityName, 'e');

    $sParamWhere = " {$sOperador} ?1";

    if (is_array($sValor)) {
      $sParamWhere = 'IN (?1)';
    } else if (is_null($sValor)) {
      $sParamWhere = 'is null';
    }

    $oQuery->where("e.{$sNomeAtributo} {$sParamWhere}");

    if (!is_null($sValor)) {
      $oQuery->setParameter(1, $sValor);
    }

    if ($sTipoRetorno == self::TIPO_RETORNO_ARRAY) {

      return $oQuery->getQuery()->getResult(Doctrine\ORM\Query::HYDRATE_ARRAY);
    } else {

      $aResultado = $oQuery->getQuery()->getResult();

      if (count($aResultado) == 0) {
        return NULL;
      }

      if (count($aResultado) == 1) {
        return new static::$className($aResultado[0]);
      }

      $aRetorno = array();

      foreach ($aResultado as $sNomeClasse) {
        $aRetorno[] = new static::$className($sNomeClasse);
      }
    }

    return $aRetorno;
  }

  /**
   * Busca Entidades por 1 ou mais campos podendo definir uma distinção e ordenação
   *
   * @param array $aAtributos   Atributos para utilizar na pesquisa
   * @param array $aCamposOrdem Campos e suas formas de ordenação na pesquisa
   * @param integer $iLimit
   * @param integer $iOffset
   * @return array
   * @throws Exception
   */
  public static function getByAttributes(array $aAtributos, array $aCamposOrdem = array(), $iLimit = null, $iOffset = null) {

    if (count($aAtributos) <= 0) {
      throw new Exception('Atributos Inválidos para pesquisa.');
    }

    $oEntityManager = self::getEm();
    $oRepositorio   = $oEntityManager->getRepository(static::$entityName);
    $aResultado     = $oRepositorio->findBy($aAtributos, $aCamposOrdem, $iLimit, $iOffset);
    $aRetorno       = array();

    if (is_array($aResultado) && count($aResultado) > 0) {

      foreach ($aResultado as $oResultado) {
        $aRetorno[] = new static::$className($oResultado);
      }
    }

    return $aRetorno;
  }

  /**
   * Retorna a quantidade de registros da entidade
   *
   * @return array
   */
  public static function count() {

    $oQuery = self::getQuery();
    $oQuery->select('count(e)');
    $oQuery->from(static::$entityName, 'e');

    return $oQuery->getQuery()->getScalarResult();
  }

  /**
   * Recebe uma daa no formato (dd/mm/YYYY) e converte em um objeto DateTime
   *
   * @param string $sData
   * @return DateTime
   */
  public static function stringToDate($sData) {

    $aData = explode('/', $sData);

    return new DateTime($aData[2] . '/' . $aData[1] . '/' . $aData[0]);
  }

  /**
   * Método construtor
   *
   * @param object|null $oEntidade
   */
  function __construct($oEntidade = NULL) {

    $this->em = Zend_Registry::get('em');

    /** TODO: procurar por uma forma de garantir que o objeto é uma entidade Doctrine.
     * Essa solução comentada (->contains()) abaixo retorna FALSE se o objeto é uma entidade ainda não persistida */
    /*
    if ($entity !== null && !$this->em->contains($entity)) {
        throw new Exception("Classe " . get_class($entity) . " não é uma entidade mapeada.");
    }
    */

    if ($oEntidade === NULL) {
      $oEntidade = new static::$entityName();
    }

    $this->entity = $oEntidade;
  }

  /**
   * Retorna entidade referente ao objeto
   */
  public function getEntity() {

    return $this->entity;
  }

  /**
   * Remove entidade da base de dados
   */
  public function destroy() {

    $this->em->remove($this->entity);
    $this->em->flush();
  }

  /**
   * Se o método não for encontrado no modelo, reflete a chamada para a Entidade
   *
   * @param string $sNomeAtributo
   * @param array  $aArgumentos
   * @return mixed
   * @throws Exception
   */
  public function __call($sNomeAtributo, $aArgumentos) {

    if ($this->entity !== NULL) {

      if (is_array($this->entity)) {
        throw new Exception("Entidade inválida (é um vetor)");
      }

      if (method_exists($this->entity, $sNomeAtributo)) {
        return call_user_func_array(array($this->entity, $sNomeAtributo), $aArgumentos);
      } else {
        throw new Exception("Método $sNomeAtributo não encontrado para a entidade " . get_class($this->entity));
      }
    }

    throw new Exception("Ocorreu um erro ao processar o método {$sNomeAtributo}.");
  }

  /**
   * Método para executar update em um ou mais atributos e nenhum ou mais argumentos como condição
   * @param array $aAtributos
   * @param array $aArgumentos
   * @return boolean
   * @throws Exception
  */
  public static function update(array $aAtributos, array $aArgumentos = array()) {

    try {

      $oQuery = self::getQuery();
      $oQuery->update(static::$entityName, 'p');

      // Define os Sets do UPDATE
      if (count($aAtributos) > 0) {

        foreach ($aAtributos as $sCampo => $valor) {

          if (is_null($valor)) {
            $oQuery->set("p.{$sCampo}", 'NULL');
          } else {
            $oQuery->set("p.{$sCampo}", $valor);
          }
        }
      }

      // Define as clausulas Where do UPDATE
      if (count($aArgumentos) > 0) {

        $oQuery->where('1=1');
        foreach ($aArgumentos as $sCampo => $valor) {

          if (is_array($valor)) {

            $oQuery->andWhere("p.{$sCampo} in(:{$sCampo})");
            $oQuery->setParameter("{$sCampo}", $valor);
          } elseif (is_null($valor)) {

            $oQuery->andWhere("p.{$sCampo} IS NULL");
          } else if (is_string($valor) && strpos($valor, '<>') !== false) {
            $oQuery->andWhere("p.{$sCampo} {$valor}");
          } else {

            $oQuery->andWhere("p.{$sCampo} = :{$sCampo}");
            $oQuery->setParameter("{$sCampo}", $valor);
          }
        }
      }

      return $oQuery->getQuery()->execute();

    } catch (Exception $oErro) {
      throw new Exception("Erro ao atualizar: ".$oErro->getMessage());
    }
  }

  /**
   * Método para executar delete com nenhum ou mais argumentos como condição
   * @param array $aArgumentos
   * @return boolean
   * @throws Exception
  */
  public static function delete(array $aArgumentos = array()) {

    try {

      $oQuery = self::getQuery();
      $oQuery->delete(static::$entityName, 'p');

      // Define as clausulas Where do DELETE
      if (count($aArgumentos) > 0) {

        $oQuery->where('1=1');
        foreach ($aArgumentos as $sCampo => $valor) {

          if (is_array($valor)) {

            $oQuery->andWhere("p.{$sCampo} in (:{$sCampo})");
            $oQuery->setParameter("{$sCampo}", $valor);
          } elseif (is_null($valor)) {

            $oQuery->andWhere("p.{$sCampo} IS NULL");
          } else {

            $oQuery->andWhere("p.{$sCampo} = :{$sCampo}");
            $oQuery->setParameter("{$sCampo}", $valor);
          }
        }
      }

      return $oQuery->getQuery()->execute();

    } catch (Exception $oErro) {
      throw new Exception("Erro ao atualizar: ".$oErro->getMessage());
    }
  }
}
