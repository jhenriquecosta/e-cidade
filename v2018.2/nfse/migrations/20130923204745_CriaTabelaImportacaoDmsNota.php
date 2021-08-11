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


class CriaTabelaImportacaoDmsNota extends Ruckusing_Migration_Base {
  
  public function up() {
    
    $sSql = '
      BEGIN;
        CREATE TABLE importacao_dms_nota (
          id                   bigint        NOT NULL,
          id_importacao        bigint        NOT NULL,
          id_contribuinte      bigint        NOT NULL,
          codigo_nota_planilha integer,
          numero_nota          integer,
          tipo_nota            integer,
          operacao_nota        varchar(2),
          data_emissao_nota    date,
          valor_total          numeric(15,2) DEFAULT 0,
          valor_imposto        numeric(15,2) DEFAULT 0,
          competencia          varchar(10)
        );
      
        ALTER TABLE ONLY importacao_dms_nota ADD CONSTRAINT importacao_dms_nota_pkey PRIMARY KEY(id);
        ALTER TABLE ONLY importacao_dms_nota
          ADD CONSTRAINT importacao_dms_nota_id_dms_fkey FOREIGN KEY(id_importacao) REFERENCES importacao_dms(id);
        ALTER TABLE ONLY importacao_dms_nota
          ADD CONSTRAINT importacao_dms_nota_id_contribuinte_fk FOREIGN KEY (id_contribuinte) 
            REFERENCES usuarios_contribuintes(id);
        
        CREATE INDEX importacao_dms_nota_id_contribuinte_indice ON notas USING btree (id_contribuinte);
        CREATE SEQUENCE importacao_dms_nota_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
      COMMIT;
    ';
    
    $this->execute($sSql);
  }

  public function down() {
    
    $sSql = '
      BEGIN;
        ALTER TABLE ONLY importacao_dms_nota DROP CONSTRAINT importacao_dms_nota_id_dms_fkey;
        ALTER TABLE ONLY importacao_dms_nota DROP CONSTRAINT importacao_dms_nota_id_contribuinte_fk;
        ALTER TABLE ONLY importacao_dms_nota DROP CONSTRAINT importacao_dms_nota_pkey;
        DROP INDEX    IF EXISTS importacao_dms_nota_id_contribuinte_indice;
        DROP SEQUENCE IF EXISTS importacao_dms_nota_id_seq;
        DROP    TABLE IF EXISTS importacao_dms_nota;
      COMMIT;
    ';
    
    $this->execute($sSql);
  }
}