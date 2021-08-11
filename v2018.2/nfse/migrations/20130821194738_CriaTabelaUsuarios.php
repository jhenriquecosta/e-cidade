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


class CriaTabelaUsuarios extends Ruckusing_Migration_Base {
  
  public function up() {
  
    $sSql  = "CREATE TABLE usuarios ( id             integer               NOT NULL, ";
    $sSql .= "                        login          character varying(20) NOT NULL, ";
    $sSql .= "                        senha          varchar                       , ";
    $sSql .= "                        habilitado     boolean               DEFAULT true, ";
    $sSql .= "                        nome           character varying(60), ";
    $sSql .= "                        email          character varying(65), ";
    $sSql .= "                        fone           character varying(50), ";
    $sSql .= "                        administrativo boolean, ";
    $sSql .= "                        id_perfil      integer, ";
    $sSql .= "                        tipo           integer, ";
    $sSql .= "                        cgm            bigint, ";
    $sSql .= "                        cnpj           character varying(14) ); ";
    
    $sSql .= "CREATE SEQUENCE usuarios_id_seq ";
    $sSql .= "  START WITH 1                  ";
    $sSql .= "  INCREMENT BY 1                ";
    $sSql .= "  NO MINVALUE                   ";
    $sSql .= "  NO MAXVALUE                   ";
    $sSql .= "  CACHE 1;                      ";
    
    $sSql .= "ALTER SEQUENCE usuarios_id_seq OWNED BY usuarios.id; ";
    
    $sSql .= "ALTER TABLE ONLY usuarios ALTER COLUMN id SET DEFAULT nextval('usuarios_id_seq'::regclass); ";
    
    $sSql .= "ALTER TABLE ONLY usuarios ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id); ";
    
    $sSql .= "ALTER TABLE ONLY usuarios ";
    $sSql .= "  ADD CONSTRAINT perfil_pkey FOREIGN KEY (id_perfil) REFERENCES perfis(id); ";

    $sSql .= "CREATE INDEX fki_perfil_pkey ON usuarios USING btree (id_perfil); ";
    
    $sSql .= "ALTER TABLE ONLY usuarios ADD CONSTRAINT email_unique UNIQUE (email); ";
    $sSql .= "ALTER TABLE ONLY usuarios ADD CONSTRAINT login_unique UNIQUE (login)";
    
    $this->execute($sSql);
  }

  public function down() {
  
    $sSql  = "DROP SEQUENCE IF EXISTS usuarios_id_seq; ";
    $sSql .= "DROP TABLE IF EXISTS usuarios; ";
    
    $this->execute($sSql);
  }
}