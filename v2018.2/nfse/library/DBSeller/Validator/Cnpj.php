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
 * Classe para validacao de CNPJ (Cadastro Nacional de Pessoa Juridica)
 *
 * @see Zend_Validate_Abstract
 * @author Gilton Guma <gilton@dbseller.com.br>
 */
class DBSeller_Validator_Cnpj extends Zend_Validate_Abstract {
  
  /**
   * Índice de erro para CNPJ inválido
   *
   * @var string
   */
  const INVALID_DIGITS = 'cnpj_invalido';
  
  /**
   * Índice de erro para CNPJ com formato inválido
   *
   * @var string
   */
  const INVALID_FORMAT = 'cnpj_formato_invalido';
  
  /**
   * Mensagens de retorno
   *
   * @access protected
   * @name $_messagemTemplates
   * @var array
   */
  protected $_messageTemplates = array(
    self::INVALID_DIGITS       => 'O CNPJ "%value%" não é válido.',
    self::INVALID_FORMAT       => 'O formato do CNPJ "%value%" não é válido.'
  );
  
  /**
   * Expressao regular para validacao de CNPJ
   *
   * @access private
   * @name $_pattern
   * @var string
   */
  private $_pattern = '/(\d{2})\.(\d{3})\.(\d{3})\/(\d{4})-(\d{2})/i';
  
  /**
   * Variavel para informa se deve considerar as mascaras
   *
   * @access private
   * @name $_skipFormat
   * @var boolean
   */
  private $_skipFormat = false;
  
  /**
   * Metodo construtor
   *
   * @param boolen $_skipFormat
   */
  public function __construct($_skipFormat = true) {
    $this->_skipFormat = $_skipFormat;
  }
   
  /**
   * Metodo para validacao do CNPJ
   *
   * @see Zend_Validate_Interface::isValid()
   * @param string $value
   * @return boolean
   */
  public function isValid($value) {
    
    $this->_setValue($value);
    
    if (!$this->_skipFormat && preg_match($this->_pattern, $value) == false) {
      
      $this->_error(self::INVALID_FORMAT);
      return false;
    }
    $digits    = preg_replace('/[^\d]+/i', '', $value);
    $firstSum  = 0;
    $secondSum = 0;
    
    /**
     * Garantimos que a string seja um cpf, e contenha 14 digitos
     */
    if (strlen($digits) != 14) {
       
      $this->_error(self::INVALID_FORMAT);
      return false;
    }
    if (str_repeat('0', 14) == $digits || str_repeat('1', 14) == $digits ||
        str_repeat('2', 14) == $digits || str_repeat('3', 14) == $digits ||
        str_repeat('4', 14) == $digits || str_repeat('5', 14) == $digits ||
        str_repeat('6', 14) == $digits || str_repeat('7', 14) == $digits ||
        str_repeat('8', 14) == $digits || str_repeat('9', 14) == $digits) {
      
      $this->_error(self::INVALID_FORMAT);
      return false;
    }
    
    $firstSum  += (5 * $digits{0}) + (4 * $digits{1}) + (3 * $digits{2})  + (2 * $digits{3});
    $firstSum  += (9 * $digits{4}) + (8 * $digits{5}) + (7 * $digits{6})  + (6 * $digits{7});
    $firstSum  += (5 * $digits{8}) + (4 * $digits{9}) + (3 * $digits{10}) + (2 * $digits{11});
    
    $firstDigit = 11 - fmod($firstSum, 11);
    
    if ($firstDigit >= 10) {
      $firstDigit = 0;
    }
     
    $secondSum  += (6 * $digits{0}) + (5 * $digits{1}) + (4 * $digits{2})  + (3 * $digits{3});
    $secondSum  += (2 * $digits{4}) + (9 * $digits{5}) + (8 * $digits{6})  + (7 * $digits{7});
    $secondSum  += (6 * $digits{8}) + (5 * $digits{9}) + (4 * $digits{10}) + (3 * $digits{11});
    $secondSum  += ($firstDigit*2);
    
    $secondDigit = 11 - fmod($secondSum, 11);
    
    if ($secondDigit >= 10) {
      $secondDigit = 0;
    }
     
    if (substr($digits, -2) != ($firstDigit . $secondDigit)) {
      
      $this->_error(self::INVALID_DIGITS);
      return false;
    }
    
    return true;
  }
}