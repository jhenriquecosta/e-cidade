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


namespace Contribuinte;

/**
 * @Entity
 * @Table(name="empresas")
 */
class Empresa {
    /**
     * @var int
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id = null;
    
    /**
     * @Column(type="string")
     */
    protected $cpfcnpj = null;
    
    /**
     * @Column(type="string")
     */
    protected $nome_razao_social = null;
    
    /**
     * @Column(type="string")
     */
    protected $nome_fantasia = null;
    
    /**
     * @Column(type="string")
     */
    protected $pais = null;
    
    /**
     * @Column(type="string")
     */
    protected $uf = null;
    
    /**
     * @Column(type="string")
     */
    protected $municipio = null;
    
    /**
     * @Column(type="string")
     */
    protected $cep = null;
    
    /**
     * @Column(type="string")
     */
    protected $bairro = null;
    
    /**
     * @Column(type="string")
     */
    protected $endereco = null;
    
    /**
     * @Column(type="string")
     */
    protected $numero = null;
    
    /**
     * @Column(type="string")
     */
    protected $complemento = null;
    
    /**
     * @Column(type="string")
     */
    protected $telefone = null;
    
    /**
     * @Column(type="string")
     */
    protected $email = null;
    
    public function getId() {
        return $this->id;
    }
    
    public function getCpfcnpj() {
        return $this->cpfcnpj;
    }

    public function setCpfcnpj($cpfcnpj) {
        $this->cpfcnpj = $cpfcnpj;
    }

    public function getNomeRazaoSocial() {
        return $this->nome_razao_social;
    }

    public function setNomeRazaoSocial($nome_razao_social) {
        $this->nome_razao_social = $nome_razao_social;
    }

    public function getNomeFantasia() {
        return $this->nome_fantasia;
    }

    public function setNomeFantasia($nome_fantasia) {
        $this->nome_fantasia = $nome_fantasia;
    }

    public function getPais() {
        return $this->pais;
    }

    public function setPais($pais) {
        $this->pais = $pais;
    }

    public function getUf() {
        return $this->uf;
    }

    public function setUf($uf) {
        $this->uf = $uf;
    }

    public function getMunicipio() {
        return $this->municipio;
    }

    public function setMunicipio($municipio) {
        $this->municipio = $municipio;
    }

    public function getCep() {
        return $this->cep;
    }

    public function setCep($cep) {
        $this->cep = $cep;
    }

    public function getBairro() {
        return $this->bairro;
    }

    public function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function getComplemento() {
        return $this->complemento;
    }

    public function setComplemento($complemento) {
        $this->complemento = $complemento;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }   
}