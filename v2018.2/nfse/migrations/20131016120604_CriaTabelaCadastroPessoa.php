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


class CriaTabelaCadastroPessoa extends Ruckusing_Migration_Base {
 
  public function up() {
    
    $sSql  = "DROP TABLE cadastros;                                                                          ";
    $sSql  = "CREATE TABLE cadastro_pessoa ( id                   integer NOT NULL,                          ";
    $sSql .= "                               cpfcnpj              character varying,                         ";
    $sSql .= "                               nome                 character varying,                         ";
    $sSql .= "                               nome_fantasia        character varying,                         ";
    $sSql .= "                               estado               character(2),                              ";
    $sSql .= "                               cidade               bigint,                                    ";
    $sSql .= "                               cep                  character varying,                         ";
    $sSql .= "                               bairro               character varying,                         ";
    $sSql .= "                               endereco             character varying,                         ";
    $sSql .= "                               numero               character varying,                         ";
    $sSql .= "                               complemento          character varying,                         ";
    $sSql .= "                               telefone             character varying,                         ";
    $sSql .= "                               email                character varying,                         ";
    $sSql .= "                               cod_bairro           BIGINT DEFAULT NULL,                       ";
    $sSql .= "                               cod_endereco         BIGINT DEFAULT NULL,                       ";
    $sSql .= "                               status               SMALLINT DEFAULT NULL,                     "; 
    $sSql .= "                               comentario           TEXT DEFAULT NULL,                         ";
    $sSql .= "                               hash                 character varying,                         ";
    $sSql .= "                               data_cadastro        date DEFAULT CURRENT_DATE,                 ";
    $sSql .= "                               recusa_justificativa character varying,                         ";
    $sSql .= "                               id_perfil integer,                                              ";
    $sSql .= "                               tipo_liberacao integer);                                        ";
    $sSql .= "COMMENT ON COLUMN cadastro_pessoa.tipo_liberacao IS '[1=criar CGM/Usuario][2=Criar Usuário][3=Recusar Usuário]'; ";
    $sSql .= "CREATE SEQUENCE cadastro_pessoa_id_seq                                                         ";
    $sSql .= "  START WITH 1                                                                                 ";
    $sSql .= "  INCREMENT BY 1                                                                               ";
    $sSql .= "  NO MINVALUE                                                                                  ";
    $sSql .= "  NO MAXVALUE                                                                                  ";
    $sSql .= "  CACHE 1;                                                                                     ";
    $sSql .= "ALTER SEQUENCE cadastro_pessoa_id_seq OWNED BY cadastro_pessoa.id;                             ";
    $sSql .= "ALTER TABLE ONLY cadastro_pessoa                                                               ";
    $sSql .= "  ALTER COLUMN id SET DEFAULT nextval('cadastro_pessoa_id_seq'::regclass);                     ";
    $sSql .= "ALTER TABLE ONLY cadastro_pessoa                                                               ";
    $sSql .= "  ADD CONSTRAINT cadastro_pessoa_pkey PRIMARY KEY (id);                                        ";
    $sSql .= "ALTER TABLE ONLY cadastro_pessoa                                                               ";
    $sSql .= "  ADD CONSTRAINT id_perfil_pkey FOREIGN KEY (id_perfil) REFERENCES perfis(id);                 ";
        
    $this->execute($sSql);
  }
  
  public function down() {
   
    $sSql  = "DROP SEQUENCE IF EXISTS cadastro_pessoa_id_seq;                                                ";
    $sSql .= "DROP TABLE IF EXISTS cadastro_pessoa;                                                          ";
    $sSql .= "CREATE TABLE cadastros ( id            serial NOT NULL,                                        ";
    $sSql .= "                         cpfcnpj       character varying,                                      ";
    $sSql .= "                         login         character varying,                                      ";
    $sSql .= "                         nome          character varying,                                      ";
    $sSql .= "                         nome_fantasia character varying,                                      ";
    $sSql .= "                         senha         character varying,                                      ";
    $sSql .= "                         estado        character(2),                                           ";
    $sSql .= "                         cidade        bigint,                                                 ";
    $sSql .= "                         cep           character varying,                                      ";
    $sSql .= "                         bairro        character varying,                                      ";
    $sSql .= "                         endereco      character varying,                                      ";
    $sSql .= "                         numero        character varying,                                      ";
    $sSql .= "                         complemento   character varying,                                      ";
    $sSql .= "                         telefone      character varying,                                      ";
    $sSql .= "                         email         character varying,                                      ";
    $sSql .= "                         cod_bairro    BIGINT DEFAULT NULL,                                    ";
    $sSql .= "                         cod_endereco  BIGINT DEFAULT NULL,                                    ";
    $sSql .= "                         tipo          INTEGER,                                                ";
    $sSql .= "                         status        SMALLINT DEFAULT NULL,                                  ";
    $sSql .= "                         comentario    TEXT DEFAULT NULL );                                    ";
    $sSql .= "ALTER TABLE ONLY cadastros ADD CONSTRAINT cadastros_pk PRIMARY KEY (id);                       ";
    $sSql .= "COMMENT ON COLUMN cadastros.status IS '[NULL=Aguardando][0=Recusado][1=Aprovado]';             ";
    $sSql .= "COMMENT ON COLUMN cadastros.comentario IS 'Motivo da recusa para enviar ao usuario por email'; ";
    
    $this->execute($sSql);
  }
}