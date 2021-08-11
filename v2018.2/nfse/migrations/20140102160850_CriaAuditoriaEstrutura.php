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


class CriaAuditoriaEstrutura extends Ruckusing_Migration_Base {

  public function up() {

    $sSql = "
        CREATE TYPE tp_auditoria_mudancas_campo AS (
          nome_campo    TEXT[],
          valor_antigo  TEXT[],
          valor_novo    TEXT[]
        );

        CREATE TYPE tp_auditoria_chave_primaria AS (
          nome_campo  TEXT[],
          valor       TEXT[]
        );

        CREATE DOMAIN dm_operacao_tabela AS
        CHAR(1) NOT NULL CHECK (VALUE ~ '(I|U|D)');

        CREATE TABLE auditoria (
          sequencial SERIAL,
          esquema    TEXT NOT NULL,
          tabela     TEXT NOT NULL,
          operacao   dm_operacao_tabela,
          transacao  BIGINT NOT NULL DEFAULT txid_current(),
          datahora   TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT now(),
          tempo      INTERVAL NOT NULL DEFAULT (clock_timestamp() - now()),
          usuario    VARCHAR(20) NOT NULL,
          chave      tp_auditoria_chave_primaria,
          mudancas   tp_auditoria_mudancas_campo NOT NULL,
          acao       TEXT
        ) WITHOUT OIDS;

        ALTER TABLE auditoria
        ADD CONSTRAINT auditoria_sequencial_pk
        PRIMARY KEY (sequencial);

        CREATE INDEX auditoria_esquema_in             ON auditoria(esquema);
        CREATE INDEX auditoria_tabela_in              ON auditoria(tabela);
        CREATE INDEX auditoria_datahora_in            ON auditoria(datahora);
        CREATE INDEX auditoria_usuario_in             ON auditoria(usuario);
        CREATE INDEX auditoria_acao_in                ON auditoria(acao);
        CREATE INDEX auditoria_mudancas_nome_campo_in ON auditoria USING GIN (((mudancas).nome_campo));

        CREATE OR REPLACE VIEW vw_auditoria_lista_tabelas AS
        SELECT table_schema AS esquema,
        table_name   AS nome
        FROM information_schema.tables
        WHERE table_type   = 'BASE TABLE'

        /* esquemas do PostgreSQL para não gerar auditoria */
        AND table_schema NOT IN ('pg_catalog', 'information_schema', 'pg_toast')
        AND table_schema !~ '^pg_'

        /* Tabelas do NFSe para nao gerar auditoria */
        AND table_name   !~ '^(auditoria|schema_migrations)'
        ORDER BY table_schema, table_name; ";

    $this->execute($sSql);

  }

  public function down() {

    $sSql = '
      BEGIN;
        DROP TABLE IF EXISTS auditoria CASCADE;
        DROP TYPE IF EXISTS tp_auditoria_mudancas_campo CASCADE;
        DROP TYPE IF EXISTS tp_auditoria_chave_primaria CASCADE;
        DROP DOMAIN IF EXISTS dm_operacao_tabela CASCADE;
        DROP VIEW IF EXISTS vw_auditoria_lista_tabelas CASCADE;
      COMMIT; ';
    
    $this->execute($sSql);
  }
}