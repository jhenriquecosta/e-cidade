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


class CriaTabelaUsuariosContribuintesAcoes extends Ruckusing_Migration_Base {
  
  public function up() {

    $sSql  = "CREATE TABLE usuarios_contribuintes_acoes ( id integer NOT NULL, ";
    $sSql .= "                                            id_usuario_contribuinte integer, ";
    $sSql .= "                                            id_acao integer); ";

    $sSql .= "CREATE SEQUENCE usuarios_contribuintes_acoes_id_seq ";
    $sSql .= "  START WITH 1 ";
    $sSql .= "  INCREMENT BY 1 ";
    $sSql .= "  NO MINVALUE ";
    $sSql .= "  NO MAXVALUE ";
    $sSql .= "  CACHE 1; ";

    $sSql .= "ALTER SEQUENCE usuarios_contribuintes_acoes_id_seq OWNED BY usuarios_contribuintes_acoes.id; ";

    $sSql .= "ALTER TABLE ONLY usuarios_contribuintes_acoes ";
    $sSql .= "  ALTER COLUMN id SET DEFAULT nextval('usuarios_contribuintes_acoes_id_seq'::regclass); ";

    $sSql .= "CREATE INDEX usuarios_contribuintes_acoes_idx_acao ON usuarios_contribuintes_acoes USING btree (id_acao); ";

    $sSql .= "CREATE INDEX usuarios_contribuintes_acoes_idx_id_usuario_contribuinte ";
    $sSql .= "  ON usuarios_contribuintes_acoes USING btree (id_usuario_contribuinte); ";

    $sSql .= "ALTER TABLE ONLY usuarios_contribuintes_acoes ";
    $sSql .= "  ADD CONSTRAINT usuarios_contribuintes_acoes_fk_acao FOREIGN KEY (id_acao) REFERENCES acoes(id); ";

    $sSql .= "ALTER TABLE ONLY usuarios_contribuintes_acoes ";
    $sSql .= "  ADD CONSTRAINT usuarios_contribuintes_acoes_fk_usuario_contribuinte ";
    $sSql .= "  FOREIGN KEY (id_usuario_contribuinte) REFERENCES usuarios_contribuintes(id); ";

    $sSql .= "ALTER TABLE ONLY usuarios_contribuintes_acoes ";
    $sSql .= "  ADD CONSTRAINT usuarios_contribuintes_acoes_pkey PRIMARY KEY (id); ";
    
    $this->execute($sSql);
  }

  public function down() {
    
    $sSql  = "DROP SEQUENCE IF EXISTS usuarios_contribuintes_acoes_id_seq; ";
    $sSql .= "DROP TABLE IF EXISTS usuarios_contribuintes_acoes; ";
    
    $this->execute($sSql);
  }
}