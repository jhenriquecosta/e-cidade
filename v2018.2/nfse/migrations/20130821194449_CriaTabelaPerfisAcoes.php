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


class CriaTabelaPerfisAcoes extends Ruckusing_Migration_Base {

  public function up() {

    $sSql  = "CREATE TABLE perfis_acoes ( id integer NOT NULL, ";
    $sSql .= "                            id_acao integer NOT NULL, ";
    $sSql .= "                            id_perfil integer NOT NULL ); ";

    $sSql .= "CREATE SEQUENCE perfis_acoes_id_seq ";
    $sSql .= "  START WITH 1 ";
    $sSql .= "  INCREMENT BY 1 ";
    $sSql .= "  NO MINVALUE ";
    $sSql .= "  NO MAXVALUE ";
    $sSql .= "  CACHE 1; ";

    $sSql .= "ALTER SEQUENCE perfis_acoes_id_seq OWNED BY perfis_acoes.id; ";
    $sSql .= "ALTER TABLE ONLY perfis_acoes ALTER COLUMN id SET DEFAULT nextval('perfis_acoes_id_seq'::regclass); ";
    
    $sSql .= "CREATE INDEX fki_id_perfil_pk ON perfis_acoes USING btree (id_perfil); ";
    
    $sSql .= "ALTER TABLE ONLY perfis_acoes ";
    $sSql .= "  ADD CONSTRAINT id_acoes_pk FOREIGN KEY (id_acao) REFERENCES acoes(id); ";
    
    $sSql .= "ALTER TABLE ONLY perfis_acoes ";
    $sSql .= "  ADD CONSTRAINT id_perfil_pk FOREIGN KEY (id_perfil) REFERENCES perfis(id); ";
    
    $sSql .= "ALTER TABLE ONLY perfis_acoes ADD CONSTRAINT perfils_acoes_pkey PRIMARY KEY (id); ";

    $this->execute($sSql);
  }

  public function down() {
    
    $sSql  = "DROP SEQUENCE IF EXISTS perfis_acoes_id_seq; ";
    $sSql .= "DROP TABLE IF EXISTS perfis_acoes; ";
    
    $this->execute($sSql);
  }
}