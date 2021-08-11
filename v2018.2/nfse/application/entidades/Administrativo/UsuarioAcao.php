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
 * Description of UsuarioContribuinteAcao
 *
 * @author guilherme
 */

namespace Administrativo;

/**
 * @Entity
 * @Table(name="usuarios_acoes")
 */
class UsuarioAcao {
    
    /**
     * @var int
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id = null;
    
    /**
     * @var \Adminstrativo\Usuario
     * @ManyToOne(targetEntity="Usuario", inversedBy="usuarios_acoes")
     * @JoinColumn(name="id_usuario", referencedColumnName="id")
     **/
    protected $usuario = null;
    
    /**
     * @var \Adminstrativo\Acao
     * @ManyToOne(targetEntity="Acao", inversedBy="usuarios_contribuintes_acoes")
     * @JoinColumn(name="id_acao", referencedColumnName="id")
     **/
    protected $acao = null;
    
    /**
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     *
     * @param integer $id 
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     *
     * @return Administrativo\Usuario
     */
    public function getUsuario() {
        return $this->usuario;
    }

    /**
     *
     * @param Administrativo\Usuario $usuario 
     */
    public function setUsuario(Usuario $usuario) {
        $this->usuario = $usuario;
    }

    /**
     *
     * @return Administrativo\Acao
     */
    public function getAcao() {
        return $this->acao;
    }

    /**
     *
     * @param Administrativo\Acao $acao 
     */
    public function setAcao(Acao $acao) {
        $this->acao = $acao;
    }




    
}

?>