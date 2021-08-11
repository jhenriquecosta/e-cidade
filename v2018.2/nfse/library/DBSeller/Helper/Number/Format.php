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
 * Classe com métodos auxiliares para números
 *
 * @package DBSeller/Helper
 */

/**
 * @package DBSeller/Helper
 */
class DBSeller_Helper_Number_Format extends Zend_View_Helper_Abstract {

  /**
   * Retorna um numero no formato para salvar no banco de dados [999999.99]
   *
   * @param string $_number
   * @param int    $_decimals
   * @return int|string
   */
  public static function toDataBase($_number, $_decimals = 2) {

    if (!$_number) {
      return 0;
    }

    $_number = str_replace('.', '', $_number);
    $_number = str_replace(',', '.', $_number);

    return number_format($_number, $_decimals, '.', '');
  }

  /**
   * Retorna um numero no formato de moeda [R$ 999.999,99]
   *
   * @param integer $_number
   * @param integer $_decimals
   * @param string  $_prefix
   * @param string  $_sufix
   * @return string
   */
  public static function toMoney($_number = 0, $_decimals = 2, $_prefix = NULL, $_sufix = NULL) {

    if (!$_number) {
      $_number = 0;
    }

    if ($_number < 0) {
      return '(' . $_prefix . number_format($_number * -1, $_decimals, ',', '.') . ')' . $_sufix;
    }

    return $_prefix . number_format($_number, $_decimals, ',', '.') . $_sufix;
  }

  /**
   * Retorna um numero no formato float [999,999.99]
   *
   * @param  string $_number
   * @param integer $_decimals
   * @return int|string
   */
  public static function toFloat($_number, $_decimals = 2) {

    if (!$_number) {
      return 0;
    }

    if (!filter_var($_number, FILTER_VALIDATE_FLOAT)) {

      $_number = str_replace('.', '', $_number);
      $_number = (float)self::getNumbers($_number) / pow(10, $_decimals);
      $_number = str_replace(',', '.', $_number);
    }

    return number_format($_number, $_decimals, '.', '');
  }

  /**
   * Retorna apenas numeros
   *
   * @param string $_input [NULL]
   * @return mixed
   */
  public static function getNumbers($_input = NULL) {

    return preg_replace('/[^0-9]/', '', $_input);
  }

  /**
   * Retorna o CPF ou CNPJ com a mascara
   *
   * @param string $_input [NULL]
   * @return string
   */
  public static function maskCPF_CNPJ($_input = NULL) {

    $number = self::getNumbers($_input);
    $length = strlen($number);

    if ($length != 11 && $length != 14) {
      return $_input;
    }

    $return = ($length == 11) ? '###.###.###-##' : '##.###.###/####-##';
    $key = -1;

    for ($i = 0, $size = strlen($return); $i < $size; $i++) {

      if ($return[$i] == '#') {
        $return[$i] = $number[++$key];
      }
    }

    return $return;
  }

  /**
   * Remove a mascara de CPF ou CNPJ
   *
   * @param string $_input
   * @return string
   */
  public static function unmaskCPF_CNPJ($_input = NULL) {

    return self::getNumbers($_input);
  }

  /**
   * Retorna o telefone com mascara
   *
   * @param string $_input
   * @return string
   */
  public static function maskPhoneNumber($_input = NULL) {

    $_string = self::getNumbers($_input);

    switch (strlen($_string)) {

      case  7 :
        $_mask = '###-####';
        break;

      case  8 :
        $_mask = '####-####';
        break;

      case  9 :
        $_mask = '####-#####';
        break;

      case 10 :
        $_mask = '(##) ####-####';
        break;

      case 11 :
        $_mask = '(##) ###-###-###';
        break;

      case 12 :
        $_mask = '(##) (##) ####-####';
        break;

      case 13 :
        $_mask = '(##) (##) ###-###-###';
        break;

      default :
        return $_input;
    }

    for ($count = 0; $count < strlen($_string); $count++) {
      $_mask[strpos($_mask, "#")] = $_string[$count];
    }

    return $_mask;
  }

  /**
   * Retorna o CEP com mascara
   *
   * @param string $_input
   * @return string
   */
  public static function maskCep($_input = NULL) {

    $_string = self::getNumbers($_input);

    switch (strlen($_string)) {

      case  8 :
        $_mask = '#####-###';
        break;

      default :
        return $_input;
    }

    for ($count = 0; $count < strlen($_string); $count++) {
      $_mask[strpos($_mask, "#")] = $_string[$count];
    }

    return $_mask;
  }
}