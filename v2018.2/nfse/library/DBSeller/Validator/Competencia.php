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
 * @package DBSeller/Validator 
 */

/**
 * Classe para Comparacao de datas
 * 
 * @package DBSeller/Validator
 * @see Zend_Validate_Abstract
 */
class DBSeller_Validator_Competencia extends Zend_Validate_Abstract {
  
  /**
   * Constante para índice da mensagem de erro com a data mínima inválida
   *  
   * @var string
   */
  const COMPETENCIA_MINIMA_INVALIDA = 'competencia_minima_invalida';
  
  /**
   * Constante para índice da mensagem de erro com a data máxima inválida
   *
   * @var string
   */
  const COMPETENCIA_MAXIMA_INVALIDA = 'competencia_maxima_invalida';
  
  /**
   * Constante para índice da mensagem de erro com a data inicial inválida
   *
   * @var string
   */
  const COMPETENCIA_INICIAL_INVALIDA = 'competencia_inicial_invalida';
  
  /**
   * Constante para índice da mensagem de erro com a data inicial maior do que a data final
   *
   * @var string
   */
  const COMPETENCIA_INICIAL_MAIOR_FINAL = 'competencia_inicial_maior_final';
  
  /**
   * Constante para índice da mensagem de erro com a data inicial menor do que a data mínima permitida
   *
   * @var string
   */
  const COMPETENCIA_INICIAL_MENOR_MINIMA = 'competencia_inicial_menor_minima';
  
  /**
   * Constante para índice da mensagem de erro com a data inicial mario do que a data máxima permitida
   *
   * @var string
   */
  const COMPETENCIA_INICIAL_MAIOR_MAXIMA = 'competencia_inicial_maior_maxima';
  
  /**
   * Constante para índice da mensagem de erro com a data final inválida
   *
   * @var string
   */
  const COMPETENCIA_FINAL_INVALIDA = 'competencia_final_invalida';
  
  /**
   * Constante para índice da mensagem de erro com a data final menor do que a data mínima
   *
   * @var string
   */
  const COMPETENCIA_FINAL_MENOR_MINIMA = 'competencia_final_menor_minima';
  
  /**
   * Constante para índice da mensagem de erro com a data final maior do que a data máxima permitida
   *
   * @var string
   */
  const COMPETENCIA_FINAL_MAIOR_MAXIMA = 'competencia_final_maior_maxima';
  
  /**
   * Data mínima permitida
   * 
   * @var Zend_Date
   */
  protected $dCompetenciaMinima;
  
  /**
   * Data máxima permitida
   *
   * @var Zend_Date
   */
  protected $dCompetenciaMaxima;
  
  /**
   * Data inicial
   *
   * @var Zend_Date
   */
  protected $dCompetenciaInicial;
  
  /**
   * Data final
   *
   * @var Zend_Date
   */
  protected $dCompetenciaFinal;
  
  /**
   * Data mínima permitida formatada para exibição nas mensagens de erro
   * 
   * @var string
   */
  protected $sCompetenciaMinima;
  
  /**
   * Data máxima permitida formatada para exibição nas mensagens de erro
   *
   * @var string
   */
  protected $sCompetenciaMaxima;
  
  /**
   * Data inicial formatada para exibição nas mensagens de erro
   *
   * @var string
   */
  protected $sCompetenciaInicial;
  
  /**
   * Data final formatada para exibição nas mensagens de erro
   *
   * @var string
   */
  protected $sCompetenciaFinal;
  
  /**
   * Nome das variáveis utilizadas no template das mensagens de erro
   * 
   * @var array
   */
  protected $_messageVariables = array(
    'sCompetenciaMinima'  => 'sCompetenciaMinima',
    'sCompetenciaMaxima'  => 'sCompetenciaMaxima',
    'sCompetenciaInicial' => 'sCompetenciaInicial',
    'sCompetenciaFinal'   => 'sCompetenciaFinal'
  );
  
  /**
   * Template das mensagens de erro
   * 
   * @var array
   */
  protected $_messageTemplates = array(
    self::COMPETENCIA_MINIMA_INVALIDA      => 'A Competência Mínima permitida "%sCompetenciaMinima%" é inválida.',
    self::COMPETENCIA_MAXIMA_INVALIDA      => 'A Competência Máxima permitida "%sCompetenciaMaxima%" é inválida.',
    self::COMPETENCIA_INICIAL_INVALIDA     => 'A Competência Inicial "%sCompetenciaInicial%" é inválida.',
    self::COMPETENCIA_INICIAL_MAIOR_FINAL  => 'A Competência Inicial "%sCompetenciaInicial%" deve ser inferior à Competência Final "%sCompetenciaFinal%".',
    self::COMPETENCIA_INICIAL_MENOR_MINIMA => 'A Competência Inicial "%sCompetenciaInicial%" não pode ser inferior à Competência Mínima permitida "%sCompetenciaMinima%".',
    self::COMPETENCIA_INICIAL_MAIOR_MAXIMA => 'A Competência Inicial "%sCompetenciaInicial%" não pode ser posterior à Competência Máxima permitida "%sCompetenciaMaxima%".',
    self::COMPETENCIA_FINAL_INVALIDA       => 'A Competência Final "%sCompetenciaFinal%" é inválida.',
    self::COMPETENCIA_FINAL_MENOR_MINIMA   => 'A Competência Final "%sCompetenciaFinal%" deve ser posterior à Competência Mínima permitida "%sCompetenciaMinima%".',
    self::COMPETENCIA_FINAL_MAIOR_MAXIMA   => 'A Competência Final "%sCompetenciaFinal%" deve ser inferior à Competência Máxima permitida "%sCompetenciaMaxima%".'
  );
  
  /**
   * Método contrutor
   */
  public function __construct() {
    
    $this->dCompetenciaMinima = new Zend_Date(date('d/m/') . (date('Y') - 5), Zend_Date::DATES, 'pt_BR');
    $this->dCompetenciaMaxima = new Zend_Date(date('d/m/Y'), Zend_Date::DATES, 'pt_BR');
  }
  
  /**
   * Define a competencia mínima permitida
   *
   * @param string $sCompetencia [Formato: "MM/yyyy"]
   */
  public function setCompetenciaMinima($sCompetencia) {
    $this->dCompetenciaMinima = new Zend_Date("01/{$sCompetencia}", Zend_Date::DATES, 'pt_BR');
  }
  
  /**
   * Define a competencia máxima permitida
   *
   * @param string $sCompetencia [Formato: "MM/yyyy"]
   */
  public function setCompetenciaMaxima($sCompetencia) {
    $this->dCompetenciaMaxima = new Zend_Date("01/{$sCompetencia}", Zend_Date::DATES, 'pt_BR');
  }
  
  /**
   * Define a competencia inicial
   *
   * @param string $sCompetencia [Formato: "MM/yyyy"]
   */
  public function setCompetenciaInicial($sCompetencia) {
    $this->dCompetenciaInicial = new Zend_Date("01/{$sCompetencia}", Zend_Date::DATES, 'pt_BR');
  }
  
  /**
   * Define a competencia final
   * 
   * @param string $sCompetencia [Formato: "MM/yyyy"]
   */
  public function setCompetenciaFinal($sCompetencia) {
    $this->dCompetenciaFinal = new Zend_Date("01/{$sCompetencia}", Zend_Date::DATES, 'pt_BR');
  }
  
  /**
   * Validação da competência
   * 
   * (non-PHPdoc)
   * @see Zend_Validate_Interface::isValid()
   */
  public function isValid($sCompetencia) {
    
    $this->_setValue($sCompetencia);

    self::setCompetenciaInicial($sCompetencia);
    
    // Define as datas formatadas para mostrar no template de erros
    $this->sCompetenciaInicial = $this->dCompetenciaInicial->toString('MM/yyyy');
    $this->sCompetenciaFinal   = $this->dCompetenciaFinal->toString('MM/yyyy');
    $this->sCompetenciaMinima  = $this->dCompetenciaMinima->toString('MM/yyyy');
    $this->sCompetenciaMaxima  = $this->dCompetenciaMaxima->toString('MM/yyyy');

    // Validador de datas
    $oValidaData = new Zend_Validate_Date();
    
    // Competência mínima permitida inválida
    if (!$oValidaData->isValid($this->dCompetenciaMinima)) {
      
      $this->_error(self::COMPETENCIA_MINIMA_INVALIDA);
      return FALSE;
    }
    
    // Competência máxima permitida inválida
    if (!$oValidaData->isValid($this->dCompetenciaMaxima)) {
      
      $this->_error(self::COMPETENCIA_MAXIMA_INVALIDA);
      return FALSE;
    }
    
    // Competência inicial menor do que a competência mínima permitida
    if ($this->dCompetenciaMinima->get('yyyyMM') > $this->dCompetenciaInicial->get('yyyyMM')) {

      $this->_error(self::COMPETENCIA_INICIAL_MENOR_MINIMA);
      return FALSE;
    }
    
    // Competência inicial maior do que a competência máxima permitida
    if ($this->dCompetenciaInicial->get('yyyyMM') > $this->dCompetenciaMaxima->get('yyyyMM')) {

      $this->_error(self::COMPETENCIA_INICIAL_MAIOR_MAXIMA);
      return FALSE;
    }
    
    // Competência inicial maior do que a competência final
    if ($this->dCompetenciaInicial->get('yyyyMM') > $this->dCompetenciaFinal->get('yyyyMM')) {
      
      $this->_error(self::COMPETENCIA_INICIAL_MAIOR_FINAL);
      return FALSE;
    }
    
    // Competência final maior do que a competência máxima permitida
    if ($this->dCompetenciaFinal->get('yyyyMM') > $this->dCompetenciaMaxima->get('yyyyMM')) {
      
      $this->_error(self::COMPETENCIA_FINAL_MAIOR_MAXIMA);
      return FALSE;
    }
    
    return TRUE;
  }
}