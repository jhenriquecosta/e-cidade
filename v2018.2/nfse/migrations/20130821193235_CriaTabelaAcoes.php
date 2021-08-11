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


class CriaTabelaAcoes extends Ruckusing_Migration_Base {
  
  public function up() {
  
    $sSql  = "CREATE TABLE acoes ( id          integer               NOT NULL, ";
    $sSql .= "                     id_controle integer               NOT NULL, ";
    $sSql .= "                     acao        character varying(256) NOT NULL, ";
    $sSql .= "                     identidade  character varying(256), ";
    $sSql .= "                     acaoacl     character varying(256),  ";
    $sSql .= "                     sub_acoes   text,   ";
    $sSql .= "                     gerador_dados bool default false  ); ";

    $sSql .= "ALTER TABLE ONLY acoes ADD CONSTRAINT acoes_pkey PRIMARY KEY (id); ";
    
    $sSql .= "CREATE INDEX acoes_idx_controle ON acoes USING btree (id_controle); ";
    
    $sSql .= "ALTER TABLE ONLY acoes ";
    $sSql .= "  ADD CONSTRAINT acoes_fk_controles FOREIGN KEY (id_controle) REFERENCES controles(id); ";
    
    $sSql .= "CREATE SEQUENCE acoes_id_seq ";
    $sSql .= "  START WITH 1 ";
    $sSql .= "  INCREMENT BY 1 ";
    $sSql .= "  NO MINVALUE ";
    $sSql .= "  NO MAXVALUE ";
    $sSql .= "  CACHE 1; ";
    
    $sSql .= "ALTER SEQUENCE acoes_id_seq OWNED BY acoes.id; ";
    $sSql .= "ALTER TABLE ONLY acoes ALTER COLUMN id SET DEFAULT nextval('acoes_id_seq'::regclass); ";
    
    $this->execute($sSql);
  }

  public function down() {
  
    $sSql  = "DELETE SEQUENCE IF EXISTS acoes_id_seq; ";
    $sSql .= "DROP TABLE IF EXISTS acoes; ";
    
    $this->execute($sSql);
  }
}