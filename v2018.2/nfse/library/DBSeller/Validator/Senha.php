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
 * Classe para validacao de senhas
 * 
 * @see Zend_Validate_Abstract
 * @author Gilton Guma <gilton@dbseller.com.br>
 */
class DBSeller_Validator_Senha extends Zend_Validate_Abstract {
  
  /**
   * Constantes
   */
  const TAMANHO = 'tamanho_invalido';
  const ESPACO  = 'possui_espaco';
  
  /**
   * Tamanho minimo de caracters do campo
   * 
   * @access public
   * @name $_tamanho_minimo
   * @var integer
   */
  public $_tamanho_minimo = 6;
  
  /**
   * Tamanho maximo de caracters do campo
   *
   * @access public
   * @name $_tamanho_maximo
   * @var integer
   */
  public $_tamanho_maximo = 20;
  
  /**
   * Variaveis utilizadas nas mensagens de retorno
   * 
   * @access protected
   * @name $_messageVariables
   * @var array
   */
  protected $_messageVariables = array(
    'tamanho_minimo'           => 'tamanho_minimo',
    'tamanho_maximo'           => 'tamanho_maximo'
  );
  
  /**
   * Mensagens de retorno
   * 
   * @access protected
   * @name $_messageTemplates 
   * @var array
   */
  protected $_messageTemplates = array(
    self::TAMANHO              => 'A senha deve possuir entre "%tamanho_minimo%" e "%tamanho_maximo%" caracteres.',
    self::ESPACO               => 'A senha não pode conter "espaços".'
  );
  
  /**
   * Metodo para validacao da senha
   * 
   * @see Zend_Validate_Interface::isValid()
   * @return boolean
   */
  public function isValid($value) {
    
    $this->_setValue($value);
    
    $isValid = true;
    
    /*
     * Valida se tem espaços na senha
     */
    $espacos = strripos($value, ' ');
    
    if ($espacos) {
      
      $this->_error(self::ESPACO);
      $isValid = false;
    }
    
    /*
     * Valida o tamanho minimo e maximo da senha
     */
    if (strlen($value) < $this->_tamanho_minimo || strlen($value) > $this->_tamanho_maximo) {
      
      $this->_error(self::TAMANHO);
      $isValid = false;
    }
    
    return $isValid;
  }
}