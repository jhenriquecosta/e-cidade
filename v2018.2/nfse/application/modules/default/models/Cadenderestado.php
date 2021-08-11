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
 * Description of Estado
 */
class Default_Model_Cadenderestado extends E2Tecnologia_Model_Doctrine {
  
  static protected $entityName = 'Geral\Estado';
  static protected $className  = __CLASS__;
  
  /**
   * Retorna todos os estados de um pais
   * 
   * @param integer $iPais
   * @return array 
   */
  public static function getByPais($iPais) {
    
    $sSql       = 'SELECT e FROM Geral\Estado e WHERE e.cod_pais = :pais ORDER BY e.uf';
    $oResultado = self::getEm()->createQuery($sSql)->setParameter('pais', $iPais)->getResult();
    $aRetorno   = array();
    
    foreach($oResultado as $oRetorno) {
      $aRetorno[] = new self($oRetorno);
    }
    
    return $aRetorno;
  }

  /**
   * Busca todos os estados de um Pais <br/>
   * Caso o pais nao seja indicado <br/>
   * retorna os estados do <b>Brasil</b>
   * @param integer $pais Id do pais
   * @return Array Todos os estados de um Pais
   */
  public static function getEstados($iPais = '01058') {
    
    $aRetorno   = array('0' => '- Selecione -');    
    $aResultado = self::getByPais($iPais);

    if ($aResultado !== null) {
      
      foreach ($aResultado as $oEstado) {
        $aRetorno[strtoupper($oEstado->getUf())] = strtoupper($oEstado->getUf());
      }
    }
    
    return $aRetorno;
  }
}

?>