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
 * Model responsável pela abstração dos dados do Protocolo
 * @author Roberto Carneiro <roberto@dbseller.com.br>
 */

class Administrativo_Model_Informativo extends Administrativo_Lib_Model_Doctrine {
  
  static protected $entityName = 'Administrativo\Informativo';
  static protected $className  = __CLASS__;
  
  /**
   * Método que altera a descrição do Informativo
   * @param string $sDescricao
   * @throws Exception
   */
  public function salvarDescricao($sDescricao) {
  	
    try {
      
      //Busca linha única na tabela inserida no momento do migration
      $oInformativo = $this->getById(1);
      $oInformativo->setDescricao($sDescricao);
      $this->getEm()->persist($oInformativo->getEntity());
            
      $this->getEm()->flush();
    } catch (Exception $oErro) {
      throw new Exception($oErro->getMessage());
    }    
  }
  
  /**
   * Método que insere informativo padrão
   * @throws Exception
   */
  public function inserePadrao() {
    
    try {
    	
      $this->setId(1);
      $this->setDescricao("");
      
      $this->em->persist($this->entity);
      $this->em->flush();
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }
}
