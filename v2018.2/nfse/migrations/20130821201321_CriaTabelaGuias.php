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


class CriaTabelaGuias extends Ruckusing_Migration_Base {
  
  public function up() {
    
    $sSql = "
      BEGIN;
        CREATE TABLE guias (
          id                    integer NOT NULL,
          id_contribuinte       bigint  NOT NULL,      
          codigo_guia           bigint,
          numpre                bigint,
          tipo_documento_origem integer,      
          mes_comp              integer NOT NULL,
          ano_comp              integer NOT NULL,
          valor_corrigido       numeric,
          valor_historico       numeric,
          juros_multa           numeric,
          codigo_barras         character varying,
          linha_digitavel       character varying,
          arquivo_guia          character varying,
          tipo                  character(1),
          situacao              character(1),
          data_fechamento       date,
          vencimento            date,
          importada boolean DEFAULT false NOT NULL
        );
        
        CREATE SEQUENCE guias_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
        ALTER TABLE ONLY guias ALTER COLUMN id SET DEFAULT nextval('guias_id_seq'::regclass);
        CREATE INDEX guias_id_contribuinte_indice ON guias USING btree (id_contribuinte);
        
        ALTER TABLE ONLY guias 
          ADD CONSTRAINT guias_id_pk PRIMARY KEY (id), 
          ADD CONSTRAINT guias_id_contribuinte_fk FOREIGN KEY (id_contribuinte) REFERENCES usuarios_contribuintes(id);
      COMMIT;
    ";
    
    $this->execute($sSql);
  }
  
  public function down() {
    
    $sSql  = '
      BEGIN;
        ALTER TABLE ONLY guias DROP CONSTRAINT guias_id_pk;    
        ALTER TABLE ONLY guias DROP CONSTRAINT guias_id_contribuinte_fk;
        DROP INDEX guias_id_contribuinte_indice;
        DROP TABLE guias;
      COMMIT;
    ';
    
    $this->execute($sSql);
  }
}