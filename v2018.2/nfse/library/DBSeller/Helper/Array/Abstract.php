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
 * Classe auxiliar para troca de charset's nos arrays
 * 
 * @package DBSeller
 * @subpackage Array
 */

/**
 * @tutorial
 *   $_newArray = DBSeller_Helper_Array_EncodeDecode::utf8_array_encode($_oldArray);
 * @author Gilton Guma <gilton@dbseller.com.br>
 */
class DBSeller_Helper_Array_Abstract extends Zend_View_Helper_Abstract {
    
  /**
   * Converte o array de ISO para UTF-8
   * 
   * @param ambiguos <string, array, object> $_input
   */
  public static function utf8_encode(&$_input) {
    
    if (is_string($_input)) {
      $_input = utf8_encode($_input);
    } else if (is_array($_input)) {
      
      foreach ($_input as &$_value) {
        self::utf8_encode($_value);
      }
      
      unset($_value);
    } else if (is_object($_input)) {
      
      $_vars = array_keys(get_object_vars($_input));
      
      foreach ($_vars as $_var) {
        self::utf8_encode($_input->$_var);
      }
    }
  }
  
  /**
   * Converte o array de UTF-8 para ISO
   * 
   * @param string|array|object $_input
   */
  public static function utf8_decode(&$_input) {
    
    if (is_string($_input)) {
      $_input = utf8_decode($_input);
    } else if (is_array($_input)) {
      
      foreach ($_input as &$_value) {
        self::utf8_decode($_value);
      }
  
      unset($_value);
    } else if (is_object($_input)) {
      
      $_vars = array_keys(get_object_vars($_input));
  
      foreach ($_vars as $_var) {
        self::utf8_decode($_input->$_var);
      }
    }
  }

  /**
   * Ordenação de array por índice
   *
   * @param  array   $aArray
   * @param  string  $sIndex
   * @param  string  $sOrdem
   * @param  boolean $lOrdemNatural
   * @param  boolean $lConsiderarMaiusculas
   * @return array
   */
  public static function ordenarPorIndice($aArray,
                                          $sIndex,
                                          $sOrdem                = 'asc',
                                          $lOrdemNatural         = FALSE,
                                          $lConsiderarMaiusculas = FALSE) {

    if (is_array($aArray) && count($aArray) > 0) {

      foreach(array_keys($aArray) as $iIndiceArray) {
        $aAuxilixar[$iIndiceArray] = $aArray[$iIndiceArray][$sIndex];
      }

      if (!$lOrdemNatural) {
        (strtolower($sOrdem) == 'asc') ? asort($aAuxilixar) : arsort($aAuxilixar);
      } else {

        $lConsiderarMaiusculas ? natsort($aAuxilixar) : natcasesort($aAuxilixar);

        if (strtolower($sOrdem != 'asc')) {
          $aAuxilixar = array_reverse($aAuxilixar, TRUE);
        }
      }

      $aOrdenado = array();

      foreach(array_keys($aAuxilixar) as $iIndiceArray) {

        (is_numeric($iIndiceArray)) ? $aOrdenado[]              = $aArray[$iIndiceArray] :
                                      $aOrdenado[$iIndiceArray] = $aArray[$iIndiceArray];
      }

      return $aOrdenado;
    }

    return $aArray;
  }
}