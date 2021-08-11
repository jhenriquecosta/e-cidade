<?php

/**
 * Validador para Cadastro de Pessoas Fisicas e Juridicas
 * conforme Ministerio da Fazenda do Governo Federal.
 */
abstract class DbSeller_Validator_CpAbstract extends Zend_Validate_Abstract
{
  /**
   * Tamanho Invalido
   * 
   * @var string
   */
  const SIZE = 'size';
  
  /**
   * Numeros Expandidos
   * 
   * @var string
   */
  const EXPANDED = 'expanded';

  /**
   * Digito Verificador
   * 
   * @var string
   */
  const DIGIT = 'digit';

  /**
   * Tamanho do Campo
   * 
   * @var int
   */
  protected $_size = 0;

  /**
   * Modelos de Mensagens
   * 
   * @var string
   */
  protected $_messageTemplates = array(
    self::SIZE     => "'%value%' não possui tamanho esperado",
    self::EXPANDED => "'%value%' não possui um formato aceitável",
    self::DIGIT    => "'%value%' não é um documento válido"
  );

  /**
   * Modificadores de Digitos
   * 
   * @var array
   */
  protected $_modifiers = array();

  /**
   * Validacao Interna do Documento
   * 
   * @param string $value Dados para Validacaoo
   * @return boolean Confirmacao de Documento Valido
   */
  protected function _check($value)
  {
    // Captura dos Modificadores
    foreach ($this->_modifiers as $modifier)
    {
      $result = 0; // Resultado Inicial
      $size   = count($modifier); // Tamanho dos Modificadores
      
      for ($i = 0; $i < $size; $i++)
      {
        $result += $value[$i] * $modifier[$i]; // Somatario
      }
      
      $result = $result % 11;
      $digit  = ($result < 2 ? 0 : 11 - $result); // Digito
      
      // Verificacao
      if ($value[$size] != $digit)
      {
        return FALSE;
      }
    }
    
    return TRUE;
  }

  public function isValid($value)
  {
    // Filtro de Dados
    $data = preg_replace('/[^0-9]/', '', $value);
    
    // Verifica tamanho
    if ($this->_size == 14)
    {
      if (strlen($data) <= 11)
      {
        return TRUE;
      }
    }
    else
    {
      if (strlen($data) > 11)
      {
        return TRUE;
      }
    }
    
    if (strlen($data) != $this->_size)
    {
      $this->_error(self::SIZE, $value);
      return FALSE;
    }
    
    // Verifica Digitos Expandidos
    if (str_repeat($data[0], $this->_size) == $data)
    {
      $this->_error(self::EXPANDED, $value);
      return FALSE;
    }
    
    // Verifica Digitos
    if (!$this->_check($data))
    {
      $this->_error(self::DIGIT, $value);
      return FALSE;
    }
    
    // Comparacoes Concluidas
    return TRUE; // Todas Verificacoes Executadas
  }
}

?>