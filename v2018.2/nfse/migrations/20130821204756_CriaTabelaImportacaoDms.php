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


class CriaTabelaImportacaoDms extends Ruckusing_Migration_Base {
  
  public function up() {

    $sSql = '
      BEGIN;
        CREATE TABLE importacao_dms (
          id                bigint    NOT NULL,
          id_usuario        bigint    NOT NULL,
          data_operacao     date,
          valor_total       double precision,
          valor_imposto     double precision,
          nome_arquivo      character varying(100),
          quantidade_notas  integer,
          codigo_escritorio integer,
          codigo_dms        integer
        );
        
        ALTER TABLE ONLY importacao_dms
          ADD CONSTRAINT importacao_dms_pkey          PRIMARY KEY (id),
          ADD CONSTRAINT importacao_dms_id_usuario_fk FOREIGN KEY (id_usuario) REFERENCES usuarios(id);
        
        CREATE SEQUENCE importacao_dms_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
        CREATE INDEX    importacao_dms_id_usuario_indice ON importacao_dms USING btree (id_usuario);
      COMMIT;
    ';
    
    $this->execute($sSql);
  }

  public function down() {
    
    $sSql  = '
      BEGIN;
        DROP SEQUENCE IF EXISTS importacao_dms_id_seq;
        DROP    TABLE IF EXISTS importacao_dms;
      COMMIT;
    ';
    
    $this->execute($sSql);
  }
}