<?php

class E2Tecnologia_Controller_Permission {

    /**
     *
     * @var Administrativo_Model_Action|array
     */
    private $action = null;

    /**
     *
     * @var Administrativo_Model_Usuario 
     */
    private $user = null;

    /**
     *
     * @var integer
     */
    private $contribuinte = null;

    public function __construct($action, Administrativo_Model_Usuario $user, $contribuinte) {

        $this->action = $action;
        $this->user = $user;
        $this->contribuinte = $contribuinte;
    }

    public function check() {
        if (is_array($this->action)) {
            $modulo = strtolower($this->action[0]->getControle()->getModulo()->getNome());
        } else {
            $modulo = strtolower($this->action->getControle()->getModulo()->getNome());
        }


        if ($modulo === 'administrativo') {            
            if (is_array($this->action)) {
                foreach ($this->action as $a) {
                    $usuarioAcao = Administrativo_Model_UsuarioAcao::getByUsuarioAcao($this->user, $a);
                    if (!empty($usuarioAcao))
                        break;
                }
            }else {
                $usuarioAcao = Administrativo_Model_UsuarioAcao::getByUsuarioAcao($this->user, $this->action);
            }

            if (empty($usuarioAcao)) {
                return false;
            }
        } else {         
            if (is_array($this->action)) {
                foreach ($this->action as $a) {
                    $usuarioContribuinteAcao = Administrativo_Model_UsuarioContribuinteAcao::getByUsuarioContribuinteAcao($this->user, $this->contribuinte, $a);
                    if (!empty($usuarioContribuinteAcao))
                        break;
                }
            }else {
                $usuarioContribuinteAcao = Administrativo_Model_UsuarioContribuinteAcao::getByUsuarioContribuinteAcao($this->user, $this->contribuinte, $this->action);
            }
            /* se o usuario não esta vinculado a esta ação redireciona para a index */
            if (empty($usuarioContribuinteAcao)) {
                return false;
            }
        }
        
        return true;
    }

}

?>
