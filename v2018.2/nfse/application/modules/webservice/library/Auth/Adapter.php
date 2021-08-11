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


class WebService_Lib_Auth_Adapter implements Zend_Auth_Adapter_Interface {

    /**
     * Doctrine Entity Manager
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_em = null;

    /**
     * The entity name to check for an identity.
     *
     * @var string
     */
    protected $_entityName;

    /**
     * $_identityColumn - the column to use as the identity
     *
     * @var string
     */
    protected $_identityColumn = null;

    /**
     * $_credentialColumn - columns to be used as the credentials
     *
     * @var string
     */
    protected $_credentialColumn = null;

    /**
     * $_identity - Identity value
     *
     * @var string
     */
    protected $_identity = null;

    /**
     * $_credential - Credential values
     *
     * @var string
     */
    protected $_credential = null;

    /**
     * $_authenticateResultInfo
     *
     * @var array
     */
    protected $_authenticateResultInfo = null;

    /**
     * __construct() - Sets configuration options
     *
     * @return void
     */
    public function __construct($sLogin) {
        
        $em = Zend_Registry::get('em');
        
        if (null !== $em) {
            $this->setEm($em);
        }

        $entityName = 'Administrativo\Usuario';
        
        if (null !== $entityName) {
            $this->setEntityName($entityName);
        }

        $identityColumn = 'login';
        
        if (null !== $identityColumn) {
            $this->setIdentityColumn($identityColumn);
        }
        
        if ($sLogin == NULL) {
          throw new Zend_Auth_Adapter_Exception('Login não informado');
        }
        
        $this->setIdentity($sLogin);

    }

    /**
     *
     * setEm() - set the Doctrine2 Entity Manager
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function setEm($em) {
        $this->_em = $em;
        return $this;
    }

    /**
     * setEntityName() - set the entity name to be used in the select query
     *
     * @param string $entityName
     * @return Doctrine_Auth_Adapter Provides a fluent interface
     */
    public function setEntityName($entityName) {
        $this->_entityName = $entityName;
        return $this;
    }

    /**
     * setIdentityColumn() - set the column name to be used as the identity column
     *
     * @param string $identityColumn
     * @return Doctrine_Auth_Adapter Provides a fluent interface
     */
    public function setIdentityColumn($identityColumn) {
        $this->_identityColumn = $identityColumn;
        return $this;
    }

    /**
     * setIdentity() - set the value to be used as the identity
     *
     * @param string $value
     * @return Doctrine_Auth_Adapter Provides a fluent interface
     */
    public function setIdentity($value) {
        $this->_identity = $value;
        return $this;
    }

    /**
     * authenticate() - defined by Zend_Auth_Adapter_Interface. This method is called to
     * attempt an authentication. Previous to this call, this adapter would have already
     * been configured with all necessary information to successfully connect to a database
     * table and attempt to find a record matching the provided identity.
     *
     * @throws Zend_Auth_Adapter_Exception if answering the authentication query is impossible
     * @return Zend_Auth_Result
     */
    public function authenticate() {
        $this->_authenticateSetup();
        $query = $this->_getQuery();
        $resultIdentities = $this->_performQuery($query);
        $authResult = $this->_validateResult($resultIdentities);
        return $authResult;
    }

    /**
     * _authenticateSetup() - This method abstracts the steps involved with making sure
     * that this adapter was indeed setup properly with all required peices of information.
     *
     * @throws Zend_Auth_Adapter_Exception - in the event that setup was not done properly
     * @return true
     */
    protected function _authenticateSetup() {
        $exception = null;

        if ($this->_em === null) {
            $exception = 'A database connection was not set, nor could one be created.';
        } elseif ($this->_entityName == '') {
            $exception = 'A entity name must be supplied for the Doctrine_Auth_Adapter authentication adapter.';
        } elseif ($this->_identityColumn == '') {
            $exception = 'An identity column must be supplied for the Doctrine_Auth_Adapter authentication adapter.';
        }

        if (null !== $exception) {
            /**
             * @see Zend_Auth_Adapter_Exception
             */
            require_once 'Zend/Auth/Adapter/Exception.php';
            throw new Zend_Auth_Adapter_Exception($exception);
        }

        $this->_authenticateResultInfo = array(
            'code' => Zend_Auth_Result::FAILURE,
            'identity' => $this->_identity,
            'messages' => array()
        );

        return true;
    }

    /**
     * _getQuery() - This method creates a Doctrine\ORM\Query object that
     * is completely configured to be queried against the database.
     *
     * @return Doctrine\ORM\Query
     */
    protected function _getQuery() {
        $dql = 'SELECT u FROM ' . $this->_entityName . ' u WHERE u.' . $this->_identityColumn . ' = ?1';
        
        $query = $this->_em->createQuery($dql)
                ->setParameter(1, $this->_identity);

        return $query;
    }

    /**
     * _performQuery() - This method accepts a Doctrine\ORM\Query object and
     * performs a query against the database with that object.
     *
     * @param Doctrine\ORM\Query $query
     * @throws Zend_Auth_Adapter_Exception - when a invalid select object is encoutered
     * @return array
     */
    protected function _performQuery(Doctrine\ORM\Query $query) {
        try {
            $resultIdentities = $query->execute();
        } catch (Exception $e) {
            /**
             * @see Zend_Auth_Adapter_Exception
             */
            require_once 'Zend/Auth/Adapter/Exception.php';
            throw new Zend_Auth_Adapter_Exception('The supplied parameters to \Doctrine\ORM\EntityManager failed to '
                    . 'produce a valid sql statement, please check entity and column names '
                    . 'for validity.');
        }
        return $resultIdentities;
    }

    /**
     * _validateResult() - This method attempts to validate that the record in the
     * result set is indeed a record that matched the identity provided to this adapter.
     *
     * @param array $resultIdentities
     * @return Zend_Auth_Result
     */
    protected function _validateResult($resultIdentities) {
        if (count($resultIdentities) < 1) {
            $this->_authenticateResultInfo['code'] = Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND;
            $this->_authenticateResultInfo['messages'][] = 'A record with the supplied identity could not be found.';
            return $this->_authenticateCreateAuthResult();
        } elseif (count($resultIdentities) > 1) {
            $this->_authenticateResultInfo['code'] = Zend_Auth_Result::FAILURE_IDENTITY_AMBIGUOUS;
            $this->_authenticateResultInfo['messages'][] = 'More than one record matches the supplied identity.';
            return $this->_authenticateCreateAuthResult();
        } elseif (count($resultIdentities) == 1) {
            
            $resultIdentity = $resultIdentities[0];
            if ($resultIdentity->getLogin() != $this->_identity) {    
                $this->_authenticateResultInfo['code'] = Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND;
                $this->_authenticateResultInfo['messages'][] = 'Identificação não encontrada.';
            } else {
                $this->_authenticateResultInfo['code'] = Zend_Auth_Result::SUCCESS;
                $this->_authenticateResultInfo['identity'] = $this->_identity;
                $this->_authenticateResultInfo['messages'][] = 'Authentication successful.';
            }
        } else {
            $this->_authenticateResultInfo['code'] = Zend_Auth_Result::FAILURE_UNCATEGORIZED;
        }

        return $this->_authenticateCreateAuthResult();
    }

    /**
     * _authenticateCreateAuthResult() - This method creates a Zend_Auth_Result object
     * from the information that has been collected during the authenticate() attempt.
     *
     * @return Zend_Auth_Result
     */
    protected function _authenticateCreateAuthResult() {
        return new Zend_Auth_Result(
                        $this->_authenticateResultInfo['code'],
                        $this->_authenticateResultInfo['identity'],
                        $this->_authenticateResultInfo['messages']
        );
    }

}
?>