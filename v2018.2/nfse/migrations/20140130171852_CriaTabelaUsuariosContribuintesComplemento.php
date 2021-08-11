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


class CriaTabelaUsuariosContribuintesComplemento extends Ruckusing_Migration_Base {
  
  public function up() {
    
    $sSql = '
      BEGIN;
        CREATE TABLE usuarios_contribuintes_complemento (
          cnpjcpf                   character varying(14),
          inscricao_municipal       character varying(20),
          inscricao_estadual        character varying(20),
          razao_social              character varying,
          nome_fantasia             character varying(255),
          endereco_pais_codigo      character(5),
          endereco_municipio_codigo numeric(7,0),
          endereco_uf               character(2),
          endereco_bairro           character varying(60),
          endereco_descricao        character varying(125),
          endereco_numero           character varying(30),
          endereco_complemento      character varying,
          endereco_cep              character(8),
          contato_telefone          character varying(20),
          contato_email             character varying(80)
        );
        
        ALTER TABLE ONLY usuarios_contribuintes_complemento
          ADD CONSTRAINT usuarios_contribuintes_complemento_pkey PRIMARY KEY(cnpjcpf);
      COMMIT;
    ';
    
    $this->execute($sSql);
  }
  
  public function down() {
    
    $sSql = '
      BEGIN;
        DROP TABLE IF EXISTS usuarios_contribuintes_complemento;
      COMMIT;
    ';
    
    $this->execute($sSql);
  }
}