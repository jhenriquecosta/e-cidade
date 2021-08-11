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
 * Classe para validacao de CPF (Cadastro de Pessoa Fisica)
 *
 * @see Zend_Validate_Abstract
 * @author Gilton Guma <gilton@dbseller.com.br>
 */
class DBSeller_Validator_Cpf extends Zend_Validate_Abstract {
  
  /**
   * Constantes
   */
  const CPF_INVALIDO = 'cpf_invalido';
  
  /**
   * Mensagens de retorno
   *
   * @access protected
   * @name $_messagemTemplates
   * @var array
   */
  protected $_messageTemplates = array(self::CPF_INVALIDO => 'O CPF "%value%" é inválido!');
  
  /**
   * Metodo para validacao do CPF
   * 
   * @see Zend_Validate_Interface::isValid()
   * @param  string $value
   * @return boolean
   */
  public function isValid($value) {
    
    $this->_setValue($value);
    
    $_cpf = str_pad(preg_replace('/[^0-9]/', '', $value), 11, '0', STR_PAD_LEFT);
    
    if (strlen($_cpf) != 11 || $_cpf == '00000000000' || $_cpf == '99999999999') {
      
      $this->_error(self::CPF_INVALIDO);
      return false;
    } else {
      
      for ($t = 9; $t < 11; $t++) {
        
        for ($d = 0, $c = 0; $c < $t; $c++) {
          $d += $_cpf{$c} * (($t + 1) - $c);
        }
        
        $d = ((10 * $d) % 11) % 10;
        
        if ($_cpf{$c} != $d) {
          
          $this->_error(self::CPF_INVALIDO);
          return false;
        }
      }
      
      return true;
    }
    
    $this->_error(self::CPF_INVALIDO);
    return false;
  }
}