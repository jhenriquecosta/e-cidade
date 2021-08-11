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
 * Classe responsável pela manipulação dos parâmetros da prefeitura referentes ao RPS
 * @author Roberto Carneiro <roberto@dbseller.com.br>
 * @package Administrativo/Model
 */
class Administrativo_Model_ParametroPrefeituraRps extends Administrativo_Lib_Model_Doctrine {
  
  /**
   * Nome da entidade doctrine
   * 
   * @var string
   */
  static protected $entityName = 'Administrativo\ParametroPrefeituraRps';
  
  /**
   * Nome da classe
   * 
   * @var string
   */
  static protected $className = __CLASS__;
  
  /**
   * Construtor da classe
   * 
   * @param string $entity
   */
  public function __construct($entity = NULL) {
    parent::__construct($entity);
  }
  
  /**
   * Método que retorna o parametro rps pelo tipo no Nota
   * @param  integer $iTipoNfse
   * @return Administrativo_Model_ParametroPrefeituraRps
   */
  public static function getByTipoNfse($iTipoNfse) {
    
    $oEntityManager = parent::getEm();
    $oRepository    = $oEntityManager->getRepository(self::$entityName);
    
    return new self($oRepository->findOneBy(array('tipo_nfse' => $iTipoNfse)));
  }

  /**
   * Método que retorna o parametro rps pelo tipo no ecidade
   * @param  integer $iTipoEcidade
   * @return Administrativo_Model_ParametroPrefeituraRps
   */
  public static function getByTipoEcidade($iTipoEcidade) {
    
    $oEntityManager = parent::getEm();
    $oRepository    = $oEntityManager->getRepository(self::$entityName);
    
    return new self($oRepository->findOneBy(array('tipo_ecidade' => $iTipoEcidade)));
  }
  
  /**
   * Grava os parâmetros da prefeitura na base de dados
   */
  public function persist() {
    
    $em = $this->getEm();
    $em->persist($this->entity);
    $em->flush();
  }
}