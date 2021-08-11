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
 * Entidade para representação de um estado. Apenas métodos de leitura porque 
 * não há modificação dos dados
 *
 * @author guilherme
 */

namespace Geral;

/**
 * @Entity
 * @Table(name="estados")
 */
class Estado {

    /**
     * @var int
     * @Id
     * @Column(type="integer")
     */
    protected $id = null;

    /**
     * @var string 
     * @Column(type="string")
     */
    protected $uf = null;

    /**
     * @var string 
     * @Column(type="string")
     */
    protected $nome = null;
    
    /**
     * @var string 
     * @Column(type="string")
     * @ManyToOne(targetEntity="Pais", inversedBy="estados")
     * @JoinColumn(name="cod_pais", referencedColumnName="cod_bacen")
     */
    protected $cod_pais = null;
    
    public function getId() {
        return $this->id;
    }

    public function getUf() {
        return $this->uf;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getPais() {
        return $this->cod_pais;
    }



}