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
 * Relacionamento de quais perfis um perfil pode cadastrar
 *
 * @author guilherme
 */

namespace Administrativo;

/**
 * @Entity
 * @Table(name="perfil_perfis")
 */
class PerfilPerfis {

    /**
     * @var int
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id = null;

    /**
     * @var \Adminstrativo\Perfil
     * @ManyToOne(targetEntity="Perfil")
     * @JoinColumn(name="id_perfil", referencedColumnName="id")
     * */
    protected $id_perfil = null;

    /**
     * @var \Adminstrativo\Perfil
     * @ManyToOne(targetEntity="Perfil")
     * @JoinColumn(name="id_perfil", referencedColumnName="id")
     * */
    protected $id_perfil_cad = null;

    public function getPerfil() {
        return $this->id_perfil;
    }

    public function setPerfil(\Adminstrativo\Perfil $id_perfil) {
        $this->id_perfil = $id_perfil;
    }

    public function getPerfilCad() {
        return $this->id_perfil_cad;
    }

    public function setIdPerfilCad(\Adminstrativo\Perfil $id_perfil_cad) {
        $this->id_perfil_cad = $id_perfil_cad;
    }

    public function getId() {
        return $this->id;
    }

}

?>