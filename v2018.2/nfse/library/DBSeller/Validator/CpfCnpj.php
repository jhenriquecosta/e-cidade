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
 * @see DBSeller_Validator_Cpf
 * @see DBSeller_Validator_Cnpj
 * @see Zend_Validate_Abstract
 * 
 * @author Gilton Guma <gilton@dbseller.com.br>
 */
class DBSeller_Validator_CpfCnpj extends Zend_Validate_Abstract {
  
  /**
   * Constantes
   */
  const CNPJ_INVALIDO             = 'cnpj_invalido';
  const CPF_INVALIDO              = 'cpf_invalido';
  const CPF_CNPJ_INVALID_FORMAT   = 'cpf_cnpj_formato_invalido';
  
  /**
   * Tamanho minimo de caracters do cpf
   * 
   * @access public
   * @name $tamanho_cpf
   * @var integer
   */
  protected $tamanho_cpf = 11;
  
  /**
   * Tamanho minimo de caracters do cnpj
   *
   * @access public
   * @name $tamanho_cnpj
   * @var integer
   */
  protected $tamanho_cnpj = 14;
  
  /**
   * Mensagens de retorno
   *
   * @access protected
   * @name $_messagemTemplates
   * @var array
   */
  protected $_messageTemplates    = array(
    self::CPF_CNPJ_INVALID_FORMAT => 'O formato "%value%" é inválido.',
    self::CPF_INVALIDO            => 'O CPF "%value%" é inválido.',
    self::CNPJ_INVALIDO           => 'O CNPJ "%value%" é inválido.'
  );
  
  /**
   * Valida se o CPF ou CNPJ e valido
   * 
   * @see Zend_Validate_Interface::isValid()
   */
  public function isValid($value) {
    
    $this->_setValue($value);
    
    $sDigitos            = preg_replace('/[^\d]+/i', '', $value);
    $iTamanhoCaracteres  = strlen($sDigitos);
    
    switch ($iTamanhoCaracteres) {
      
      case $this->tamanho_cpf:
        
        $oValidateCpf = new DBSeller_Validator_Cpf();
        
        if (!$oValidateCpf->isValid($value)) {
          
          $this->_error(self::CPF_INVALIDO);
          return false;
        }
        break;
        
      case $this->tamanho_cnpj :
        
        $oValidateCnpj = new DBSeller_Validator_Cnpj();
        
        if (!$oValidateCnpj->isValid($value)) {
          
          $this->_error(self::CNPJ_INVALIDO);
          return false;
        }
        break;
        
      default:
        
        $this->_error(self::CPF_CNPJ_INVALID_FORMAT);
        return false;
    }
    
    return true;
  }
}