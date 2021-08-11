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
 * Description of Liberacao
 *
 * @author guilherme
 */


namespace Administrativo;
/**
 * @Entity
 * @Table(name="liberacoes")
 */
class Liberacao {
    /**
     * @var int
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id = null;
    
    /**
     * @var int
     * @Column(type="integer")
     */
    protected $im = null;
    
    /**
     * @var DateTime
     * @Column(type="date")
     */
    protected $data_limite = null;
    
    /**
     * @var int
     * @Column(type="integer")
     */
    protected $nota_limite = null;
    
    /**
     * @var \DateTime
     * @Column(type="date")
     */
    protected $data_liberacao = null;
    
    /**
     * @var \DateTime
     * @Column(type="date")
     */
    protected $data_requisicao = null;
    
    public function getId() {
        return $this->id;
    }
    
    public function getIm() {
        return $this->im;
    }

    public function setIm($im) {
        $this->im = $im;
    }

    public function getDataLimite() {
        return $this->data_limite;
    }

    public function setDataLimite($data_limite) {
        $this->data_limite = $data_limite;
    }

    public function getNotaLimite() {
        return $this->nota_limite;
    }

    public function setNotaLimite($nota_limite) {
        $this->nota_limite = $nota_limite;
    }

    public function getDataLiberacao() {
        return $this->data_liberacao;
    }

    public function setDataLiberacao(\DateTime $data_liberacao) {
        $this->data_liberacao = $data_liberacao;
    }

    public function getDataRequisicao() {
        return $this->data_requisicao;
    }

    public function setDataRequisicao(\DateTime $data_requisicao) {
        $this->data_requisicao = $data_requisicao;
    }


    

}
?>