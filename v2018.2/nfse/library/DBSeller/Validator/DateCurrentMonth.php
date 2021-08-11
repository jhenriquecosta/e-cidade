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
 * Classe para validacao da data de competencia
 *
 * @see Zend_Validate_Abstract
 */
class DBSeller_Validator_DateCurrentMonth extends Zend_Validate_Abstract {
  
  /**
   * Constantes
   */
  const COMPETENCIA_INVALIDA = 'competencia_invalida';
  
  /**
   * Mes
   *
   * @access protected
   * @name $_mes
   * @var string
   */
  protected $_mes = NULL;
  
  /**
   * Ano
   *
   * @access protected
   * @name $_ano
   * @var string
   */
  protected $_ano = NULL;
  
  /**
   * Mensagens de retorno
   *
   * @access protected
   * @name $_messagemTemplates
   * @var array
   */
  protected $_messageTemplates = array(
    self::COMPETENCIA_INVALIDA => 'A data informada ("%value%") não é referente a competência.'
  );
  
  /**
   * Retorna o mes
   * 
   * @access public
   * @return string
   */
  public function getMes() {
    return $this->_mes;
  }
  
  /**
   * Seta o mes
   * 
   * @access public
   * @param string $_mes
   */
  public function setMes($_mes) {
    $this->_mes = str_pad((int) $_mes, 2, '0', STR_PAD_LEFT);
  }
  
  /**
   * Retorna o ano
   * 
   * @access public 
   * @return string
   */
  public function getAno() {
    return $this->_ano;
  }
  
  /**
   * Seta o ano
   * 
   * @access public
   * @param unknown $_ano
   */
  public function setAno($_ano) {
    $this->_ano = $_ano;
  }
  
  /**
   * Metodo para validacao da competencia
   * 
   * @access public
   * @see Zend_Validate_Interface::isValid()
   * @return boolean
   */
  public function isValid($value) {
    
    $this->_setValue($value);
    
    $oData       = new Zend_Date($value);
    $iAnoMesNota = $oData->get('yyyyMM');
    
    if ($this->_mes && $this->_ano) {
      $iAnoMesSistema = "{$this->_ano}{$this->_mes}";   
    } else if ($this->_mes) {
      $iAnoMesSistema = date('Y').$this->_mes;
    } else if ($this->_ano) {
      $iAnoMesSistema = $this->_ano.date('m');
    } else {
      $iAnoMesSistema = date('Ym');      
    }
    
    if ($iAnoMesSistema != $iAnoMesNota) {
      
      $this->_error(self::COMPETENCIA_INVALIDA);
      return FALSE;
    } else {
      return TRUE;
    }    
  }
}