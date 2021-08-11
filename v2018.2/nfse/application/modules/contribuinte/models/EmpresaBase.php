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
 * Modelo para empresa base 
 */
class Contribuinte_Model_EmpresaBase extends Contribuinte_Lib_Model_Doctrine {
  
  static protected $entityName = 'Contribuinte\Empresa';
  static protected $className  = __CLASS__;
 
  public function persist($aDados) {
    
    if (isset($aDados['t_cnpjcpf'])) {
      $this->setCpfcnpj($aDados['t_cnpjcpf']);
    }
    
    if (isset($aDados['t_razao_social'])) {
      $this->setNomeRazaoSocial($aDados['t_razao_social']);
    }
    
    if (isset($aDados['t_nome_fantasia'])) {
      $this->setNomeFantasia($aDados['t_nome_fantasia']);
    }    
    
    if (isset($aDados['t_cod_pais'])) {
      $this->setPais($aDados['t_cod_pais']);
    }
    
    if (isset($aDados['t_uf'])) {
      $this->setUf($aDados['t_uf']);
    }
    
    if (isset($aDados['t_cod_municipio'])) {
      $this->setMunicipio($aDados['t_cod_municipio']);
    }
    
    if (isset($aDados['t_cep'])) {
      $this->setCep($aDados['t_cep']);
    }
    
    if (isset($aDados['t_bairro'])) {
      $this->setBairro($aDados['t_bairro']);
    }
    
    if (isset($aDados['t_endereco'])) {
      $this->setEndereco($aDados['t_endereco']);
    }
    
    if (isset($aDados['t_endereco_numero'])) {
      $this->setNumero($aDados['t_endereco_numero']);
    }
    
    if (isset($aDados['t_endereco_comp'])) {
      $this->setComplemento($aDados['t_endereco_comp']);
    }
    
    if (isset($aDados['t_telefone'])) {
      $this->setTelefone($aDados['t_telefone']);
    }
    
    if (isset($aDados['t_email'])) {
      $this->setEmail($aDados['t_email']);
    }
    
    $this->em->persist($this->entity);
    $this->em->flush();
  }
  
  public function isEntity() {
    return true;
  }
}