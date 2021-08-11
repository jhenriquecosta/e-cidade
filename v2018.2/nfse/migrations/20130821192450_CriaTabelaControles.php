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


class CriaTabelaControles extends Ruckusing_Migration_Base {
  
  public function up() {
  
    $sSql  = " CREATE TABLE controles ( id         integer                NOT NULL, ";
    $sSql .= "                          id_modulo  integer                NOT NULL, ";
    $sSql .= "                          controle   character varying(25)  NOT NULL, ";
    $sSql .= "                          identidade character varying(25)  NOT NULL, ";
    $sSql .= "                          visivel    boolean); ";
    
    $sSql .= " CREATE SEQUENCE controles_id_seq ";
    $sSql .= "   START WITH 1  ";
    $sSql .= "   INCREMENT BY 1 ";
    $sSql .= "   NO MINVALUE ";
    $sSql .= "   NO MAXVALUE ";
    $sSql .= "   CACHE 1; ";
    
    $sSql .= " ALTER SEQUENCE controles_id_seq OWNED BY controles.id; ";
    $sSql .= " ALTER TABLE ONLY controles ALTER COLUMN id SET DEFAULT nextval('controles_id_seq'::regclass); ";
    
    $sSql .= " ALTER TABLE ONLY controles ADD CONSTRAINT controles_pkey PRIMARY KEY (id); ";
    
    $sSql .= " ALTER TABLE ONLY controles ";
    $sSql .= "   ADD CONSTRAINT controles_fk_modulos FOREIGN KEY (id_modulo) REFERENCES modulos(id); ";
    
    $sSql .= " CREATE INDEX controles_idx_modulo ON controles USING btree (id_modulo); ";
    
    $this->execute($sSql);
  }

  public function down() {
  
    $sSql  = "DROP TABLE IF EXISTS controles; ";
    $sSql .= "DROP SEQUENCE IF EXISTS controles_id_seq; ";
    
    $this->execute($sSql);
  }
}