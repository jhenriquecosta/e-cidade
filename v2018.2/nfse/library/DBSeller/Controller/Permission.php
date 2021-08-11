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


class DBSeller_Controller_Permission {

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
            /* se o usuario n�o esta vinculado a esta a��o redireciona para a index */
            if (empty($usuarioContribuinteAcao)) {
                return false;
            }
        }
        
        return true;
    }

}

?>