<?php

/**
 * Validador para Cadastro de Pessoa Física
 */
class E2Tecnologia_Validator_Cpf extends E2Tecnologia_Validator_CpAbstract
{
    /**
     * Tamanho do Campo
     * @var int
     */
    protected $_size = 11;
 
    /**
     * Modificadores de D�gitos
     * @var array
     */
    protected $_modifiers = array(
        array(10,9,8,7,6,5,4,3,2),
        array(11,10,9,8,7,6,5,4,3,2)
    );
}
?>
