<?php

/**
 * Classe genérica para implementação de Enums
 *
 * @author guilherme
 */
class E2Tecnologia_Model_Enumeration {
    
    public static function getLista() {
        return static::$lista;
    }

    public static function getById($id) {
        if(!isset(static::$lista[$id])) {
            return static::$default;
        }
        return static::$lista[$id];
    }

}

?>

