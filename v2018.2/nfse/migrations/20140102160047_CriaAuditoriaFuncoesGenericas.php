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


class CriaAuditoriaFuncoesGenericas extends Ruckusing_Migration_Base {

  public function up() {
  
    $sSqlFuncoesGerericas  = 
      " BEGIN;
        -- Create functions
        create or replace function fc_replace_multi(text, aProcura text[], aSubstitui text[]) returns text
        as $$
        declare
          iConta integer;
          iLinha integer;
          sAlvo  text;
        begin
          sAlvo  := $1;
          iConta := array_upper(aProcura, 1);
        
          if iConta <> array_upper(aSubstitui, 1) then
            raise exception 'Numero de strings de procura diferente do número de a substituir';
          end if;
        
          for iLinha in 1..iConta
          loop
            sAlvo := replace(sAlvo, aProcura[iLinha], aSubstitui[iLinha]);
          end loop;
        
          return sAlvo;
        end;
        $$
        language plpgsql;
     
        create or replace function fc_ultimodiames_data(integer,integer)
        returns date
        as $$
          select (date ($1||'-'||$2||'-'||'1') + interval '1 month' - interval '1 day')::date;
        $$
        immutable language sql;
        
        create or replace function fc_ultimodiames(integer,integer)
        returns integer
        as $$
          select extract(day from fc_ultimodiames_data($1, $2))::integer;
        $$
        immutable language sql;
        
        create or replace function fc_parse_schema(text) returns text as
        $$
          select case
                   when position('.' in $1) > 0 then
                     (string_to_array($1, '.'))[1]
                   else
                     'public'::text
                 end;
        $$
        language sql;
        
        create or replace function fc_parse_relation(text) returns text as
        $$
          select case
                   when position('.' in $1) > 0 then
                     (string_to_array($1, '.'))[2]
                   else
                     $1
                 end;
        $$
        language sql;
     
        /***
         *
         *  fc_clone_table_constraints(text, text)
         *   
         *  . Funcao para clonar as constraints (PK, FK, CK) de uma tabela com todas suas caracteristicas 
         *
         *
         *  @param text Tabela de Origem
         *  @param text Tabela de Destino
         *
         *  @return boolean Verdadeiro se realizou a clonagem ou Falso caso nao tenha efetuado
         *
         */
        create or replace function fc_clone_table_constraints(text, text) returns boolean as
        $$
        declare
          sEsquemaOrigem text;
          sTabelaOrigem text;
          sEsquemaDestino text;
          sTabelaDestino text;
          aTabela text[];
          
          rObjeto record;
        begin
        
          -- Separa Esquema e Tabela de Origem
          sEsquemaOrigem := fc_parse_schema($1);
          sTabelaOrigem  := fc_parse_relation($1);
        
          -- Separa Esquema e Tabela de Destino
          sEsquemaDestino := fc_parse_schema($2);
          sTabelaDestino  := fc_parse_relation($2);
        
          -- Cria constraints (PK, FK) da tabela 
          for rObjeto in
            select replace('ALTER TABLE '||nspname||'.'||relname||' ADD CONSTRAINT '||conname||' '||pg_get_constraintdef(b.oid)||';', sTabelaOrigem, sTabelaDestino) as condef
              from pg_class a
                   inner join pg_namespace c on c.oid = a.relnamespace
                   inner join pg_constraint b on b.conrelid = a.oid
             where c.nspname = sEsquemaOrigem
               and a.relname = sTabelaOrigem
          loop
            execute rObjeto.condef;
          end loop;
        
          return true;
        end;
        $$
        language plpgsql;
     
        /***
         *
         *  fc_clone_table_indexes(text, text, text)
         *   
         *  . Funcao para clonar os indices de uma tabela com todas suas caracteristicas 
         *
         *
         *  @param text Tabela de Origem
         *  @param text Tabela de Destino
         *  @param text Tablespace a ser utilizada
         *
         *  @return boolean Verdadeiro se realizou a clonagem ou Falso caso nao tenha efetuado
         *
         */
        create or replace function fc_clone_table_indexes(text, text, text) returns boolean as
        $$
        declare
          sEsquemaOrigem text;
          sTabelaOrigem text;
          sEsquemaDestino text;
          sTabelaDestino text;
          sTableSpaceDestino text;
          aTabela text[];
          sSql text;
          rObjeto record;
        begin
        
          -- Separa Esquema e Tabela de Origem
          sEsquemaOrigem := fc_parse_schema($1);
          sTabelaOrigem  := fc_parse_relation($1);
        
          -- Separa Esquema e Tabela de Destino
          sEsquemaDestino := fc_parse_schema($2);
          sTabelaDestino  := fc_parse_relation($2);
        
          -- Determina TableSpace a ser utilizada... se nao encontrar a tablespace passada por parametro utiliza
          -- a mesma tablespace da tabela de origem
          sTableSpaceDestino := coalesce($3, 'pg_default');
        
          if not exists (select 1 from pg_tablespace where spcname = sTableSpaceDestino) then
        
            select coalesce(t.spcname, 'pg_default')
              into sTableSpaceDestino
              from pg_class c
                   join pg_namespace n on n.oid = c.relnamespace
                   left join pg_tablespace t on t.oid = c.reltablespace
             where n.nspname = sEsquemaOrigem
               and c.relname = sTabelaOrigem
               and c.relkind = 'r';
        
          end if;
        
          -- Cria indices da tabela
          for rObjeto in
            select replace(
                     replace(
                       replace(
                         pg_get_indexdef(i.oid),
                         'INDEX '||sTabelaOrigem,
                         'INDEX '||sTabelaDestino
                       ),
                       'ON '||sEsquemaOrigem||'.'||sTabelaOrigem,
                       'ON '||quote_ident(sEsquemaDestino)||'.'||quote_ident(sTabelaDestino)
                     ),
                     'ON '||sTabelaOrigem,
                     'ON '||quote_ident(sTabelaDestino)
                   ) || ' TABLESPACE '||quote_ident(sTableSpaceDestino) as indexdef
              from pg_index x
                   join pg_class c           on c.oid = x.indrelid
                   join pg_class i           on i.oid = x.indexrelid
                   left join pg_namespace n  on n.oid = c.relnamespace
                   left join pg_tablespace t on t.oid = i.reltablespace
             where c.relkind = 'r'
               and i.relkind = 'i'
               and n.nspname = sEsquemaOrigem
               and c.relname = sTabelaOrigem
               and x.indisprimary is false
          loop
            execute rObjeto.indexdef;
          end loop;
        
          return true;
        end;
        $$
        language plpgsql;
     
        /***
         *
         *  fc_clone_table(text, text, text, boolean)
         *   
         *  . Funcao para clonar a estrutura de uma tabela com todas suas caracteristicas (colunas, 
         *    defaults, constraints, indices, etc)
         *
         *
         *  @param text Tabela de Origem
         *  @param text Tabela de Destino
         *  @param text Tablespace a ser utilizada
         *  @param boolean Se deve ou nao herdar da tabela de origem (INHERIT)
         *
         *  @return boolean Verdadeiro se realizou a clonagem ou Falso caso nao tenha efetuado
         *
         */
        create or replace function fc_clone_table(text, text, text, lHerdaOrigem boolean) returns boolean as
        $$
        declare
          sEsquemaOrigem text;
          sTabelaOrigem text;
          sEsquemaDestino text;
          sTabelaDestino text;
          sTableSpaceDestino text;
          aTabela text[];
          sSql text;
          rObjeto record;
        begin
        
          -- Separa Esquema e Tabela de Origem
          sEsquemaOrigem := fc_parse_schema($1);
          sTabelaOrigem  := fc_parse_relation($1);
        
          -- Separa Esquema e Tabela de Destino
          sEsquemaDestino := fc_parse_schema($2);
          sTabelaDestino  := fc_parse_relation($2);
        
          -- Determina TableSpace a ser utilizada... se nao encontrar a tablespace passada por parametro utiliza
          -- a mesma tablespace da tabela de origem
          sTableSpaceDestino := coalesce($3, 'pg_default');
        
          if not exists (select 1 from pg_tablespace where spcname = sTableSpaceDestino) then
        
            select coalesce(t.spcname, 'pg_default')
              into sTableSpaceDestino
              from pg_class c
                   join pg_namespace n on n.oid = c.relnamespace
                   left join pg_tablespace t on t.oid = c.reltablespace
             where n.nspname = sEsquemaOrigem
               and c.relname = sTabelaOrigem
               and c.relkind = 'r';
        
          end if;
        
          -- Verifica se tabela destino ja nao existe
          if exists (select 1
                       from pg_class c
                            join pg_namespace n on n.oid = c.relnamespace
                      where c.relname = sTabelaDestino
                        and c.relkind = 'r'
                        and n.nspname = sEsquemaDestino) then
            return false;
          end if;
        
          -- Cria nova tabela com as colunas e constraints basicas
          sSql := 'create table '||quote_ident(sEsquemaDestino)||'.'||quote_ident(sTabelaDestino)||' (';
          sSql := sSql || 'like '||quote_ident(sEsquemaOrigem)||'.'||quote_ident(sTabelaOrigem)|| ' including defaults)';
          sSql := sSql || 'tablespace '||quote_ident(sTableSpaceDestino);
          execute sSql;
        
          -- Cria constraints (PK, FK) da tabela 
          perform fc_clone_table_constraints(sEsquemaOrigem||'.'||sTabelaOrigem, sEsquemaDestino||'.'||sTabelaDestino);
        
          -- Cria indices da tabela
          perform fc_clone_table_indexes(sEsquemaOrigem||'.'||sTabelaOrigem, sEsquemaDestino||'.'||sTabelaDestino, sTableSpaceDestino);
        
          -- Seta heranca em relacao a tabela de origem (usada para Particionamento)
          if lHerdaOrigem is true then
            sSql := 'alter table '||quote_ident(sEsquemaDestino)||'.'||quote_ident(sTabelaDestino);
            sSql := sSql || ' inherit '||quote_ident(sEsquemaOrigem)||'.'||quote_ident(sTabelaOrigem);
        
            execute sSql;
          end if;
        
          return true;
        end;
        $$
        language plpgsql; 

        COMMIT; ";
    
    $this->execute($sSqlFuncoesGerericas);
    
  }

  public function down() {
  
  }
}