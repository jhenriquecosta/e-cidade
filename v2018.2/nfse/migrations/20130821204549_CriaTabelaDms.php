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


class CriaTabelaDms extends Ruckusing_Migration_Base {
  
  public function up() {

    $sSql  = "CREATE TABLE dms ( id               bigint NOT NULL, ";
    $sSql .= "                   codigo_planilha  bigint NOT NULL, ";
    $sSql .= "                   id_contribuinte  bigint NOT NULL, ";
    $sSql .= "                   id_usuario       bigint NOT NULL, ";
    $sSql .= "                   data_operacao    date, ";
    $sSql .= "                   ano_comp         integer, ";
    $sSql .= "                   mes_comp         integer, ";
    $sSql .= "                   status           varchar(10) default 'aberto', ";
    $sSql .= "                   operacao         varchar(1)  default 's', ";
    $sSql .= "                   importada boolean DEFAULT false NOT NULL ";
    $sSql .= "                  ); ";

    $sSql .= "COMMENT ON COLUMN dms.operacao IS '[e=entrada][s=saida]'; ";
    $sSql .= "ALTER TABLE ONLY dms ADD CONSTRAINT dms_id_pkey PRIMARY KEY (id); ";
    $sSql .= "ALTER TABLE ONLY dms ADD CONSTRAINT dms_id_contribuinte_fk FOREIGN KEY (id_contribuinte) REFERENCES usuarios_contribuintes ; ";
    $sSql .= "ALTER TABLE ONLY dms ADD CONSTRAINT dms_id_usuario_fk FOREIGN KEY (id_usuario) REFERENCES usuarios ; ";
    $sSql .= "CREATE SEQUENCE dms_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1; ";
    $sSql .= "CREATE INDEX dms_id_contribuinte_in ON DMS (id_contribuinte); ";
    $sSql .= "CREATE INDEX dms_id_usuario_in ON DMS (id_usuario); ";
    $sSql .= "ALTER TABLE ONLY dms ALTER COLUMN id SET DEFAULT nextval('dms_id_seq'::regclass);";
    
    
    $this->execute($sSql);
  }

  public function down() {
  
    $sSql  = "DROP SEQUENCE IF EXISTS dms_id_seq; ";
    $sSql .= "DROP TABLE IF EXISTS dms; ";
    
    $this->execute($sSql);
  }
}