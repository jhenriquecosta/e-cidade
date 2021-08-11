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
 * Classe para verificar se existe registro no banco de dados, utilizando o Doctrine
 */

/**
 * @package Library\DBSeller\Validator 
 * @uses Doctrine
 * @see Zend_Validate_Abstract
 * @author Gilton Guma <gilton@dbseller.com.br>
 */
class DBSeller_Validator_NaoExisteRegistroNoBanco extends Zend_Validate_Abstract {
  
  /**
   * Índice do erro
   * 
   * @var string
   */
  const RECORD_FOUND = 'record_found';
  
  /**
   * Nome da entidade Doctrine
   * 
   * @var string
   */
  private $entityName;
  
  /**
   * Nome do campo para verificar se existem dados
   * 
   * @var string
   */
  private $field;
  
  /**
   * Mensagens de retorno
   *
   * @var array
   */
  protected $_messageTemplates = array(
    self::RECORD_FOUND => '"%value%" já está cadastrado no sistema.'
  );
  
  /**
   * Método construtor
   * 
   * @param string $entityName
   * @param string $field
   */
  public function __construct($entityName = null, $field = null) {
    
    $this->entityName = $entityName;
    $this->field      = $field;
  }
  
  /**
   * Método para validar se existem a informação no banco de dados
   * 
   * @see Zend_Validate_Interface::isValid()
   * @return boolean
   * @throws Exception
   */
  public function isValid($value) {
    
    $this->_setValue($value);
    
    try {
      
      $oDoctrineEntityManager = Zend_Registry::get('em');
      $oDoctrineRepository    = $oDoctrineEntityManager->getRepository($this->entityName); 
      
      // Verifica se existe algum registro no banco de dados
      if ($oDoctrineRepository->findOneBy(array($this->field => $value))) {
        
        $this->_error(self::RECORD_FOUND);
        return false;
      }
    } catch (Exception $oError) {
      return false;
    }
    
    return true;
  }
}