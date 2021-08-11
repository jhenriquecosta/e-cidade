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


class CriaAuditoriaCriaFuncao extends Ruckusing_Migration_Base {
  
  public function up() {
    
    $sSql = "
      
      BEGIN;
        
      CREATE OR REPLACE FUNCTION fc_auditoria_cria_funcao(TEXT) RETURNS VOID AS
      $$
      DECLARE
        sEsquema TEXT;
        sTabela  TEXT;
        aTabela  TEXT[];
      
        aProcura   TEXT[];
        aSubstitui TEXT[];
      
        sTemplate  TEXT;
        sColunas   TEXT;
        sNulls     TEXT;
        sValores   TEXT;
      
        sBlocoUpdate TEXT;
        sBlocoChave  TEXT;
      
        rTabela    RECORD;
      BEGIN
      
        -- Separa Esquema e Tabela
        IF position('.' in $1) > 0 THEN
          aTabela  := string_to_array($1, '.');
          sEsquema := aTabela[1];
          sTabela  := aTabela[2];
        ELSE
          sEsquema := 'public';
          sTabela  := $1;
        END IF;
      
        FOR rTabela IN
          SELECT esquema,
                 nome
            FROM vw_auditoria_lista_tabelas
           WHERE esquema LIKE sEsquema
             AND nome    LIKE sTabela
        LOOP
          aProcura   := '{}';
          aSubstitui := '{}';
      
          -- Variaveis para macro-substituicao
          aProcura   := ARRAY_APPEND(aProcura,   '{%tpl_tabela_esquema}');
          aSubstitui := ARRAY_APPEND(aSubstitui, rTabela.esquema::TEXT);
      
          aProcura   := ARRAY_APPEND(aProcura,   '{%tpl_tabela_nome}');
          aSubstitui := ARRAY_APPEND(aSubstitui, rTabela.nome::TEXT);
      
          -- Carrega template de PL de auditoria
          sTemplate := fc_auditoria_template();
      
          -- Monta Bloco de Codigo da Chave Primaria, se existir
          SELECT 'xChave := ROW( ARRAY['||
                 string_agg(quote_literal(attname::TEXT), ', ')||'], ARRAY['||
                 string_agg('rRegistro.'::TEXT||attname::TEXT||'::TEXT', ', ')||'] );'
            INTO sBlocoChave
            FROM pg_class a
                 INNER JOIN pg_constraint b  ON b.conrelid = a.oid
                 INNER JOIN pg_namespace c   ON c.oid      = a.relnamespace
                 INNER JOIN pg_attribute t   ON t.attrelid = b.conrelid
                                            AND t.attnum   = ANY(b.conkey)
           WHERE c.nspname = rTabela.esquema
             AND a.relname = rTabela.nome
             AND b.contype = 'p';
      
          IF sBlocoChave = 'xChave := ROW( ARRAY[], ARRAY[] );' THEN
            sBlocoChave := '';
          END IF;
      
          -- Colunas da tabela e Bloco de Código para UPDATE
          -- @TODO: Usar encode para colunas do tipo BYTEA
          SELECT string_agg(quote_literal(column_name::TEXT), ', '),
                 string_agg('NULL'::TEXT, ', '),
                 string_agg('rRegistro.'::TEXT||column_name::TEXT||'::TEXT', ', '),
      
                 string_agg(
                  '        IF OLD.'||column_name||' <> NEW.'||column_name||' THEN
                aCampo    := ARRAY_APPEND(aCampo,    '||quote_literal(column_name)||');
                aValorOld := ARRAY_APPEND(aValorOld, OLD.'||column_name||'::TEXT);
                aValorNew := ARRAY_APPEND(aValorNew, NEW.'||column_name||'::TEXT);
              END IF;', E'\n\n')
      
            INTO sColunas,
                 sNulls,
                 sValores,
                 sBlocoUpdate
            FROM information_schema.columns
           WHERE table_schema = rTabela.esquema
             AND table_name   = rTabela.nome;
      
          -- Variaveis para macro-substituicao
          aProcura   := ARRAY_APPEND(aProcura,   '{%tpl_array_campo_nome}');
          aSubstitui := ARRAY_APPEND(aSubstitui, sColunas);
      
          aProcura   := ARRAY_APPEND(aProcura,   '{%tpl_array_insert_campo_valor_old}');
          aSubstitui := ARRAY_APPEND(aSubstitui, sNulls);
      
          aProcura   := ARRAY_APPEND(aProcura,   '{%tpl_array_insert_campo_valor_new}');
          aSubstitui := ARRAY_APPEND(aSubstitui, sValores);
      
          aProcura   := ARRAY_APPEND(aProcura,   '{%tpl_array_delete_campo_valor_old}');
          aSubstitui := ARRAY_APPEND(aSubstitui, sValores);
      
          aProcura   := ARRAY_APPEND(aProcura,   '{%tpl_array_delete_campo_valor_new}');
          aSubstitui := ARRAY_APPEND(aSubstitui, sNulls);
      
          aProcura   := ARRAY_APPEND(aProcura,   '{%tpl_bloco_codigo_definicao_chave}');
          aSubstitui := ARRAY_APPEND(aSubstitui, sBlocoChave);
      
          aProcura   := ARRAY_APPEND(aProcura,   '{%tpl_bloco_codigo_update}');
          aSubstitui := ARRAY_APPEND(aSubstitui, sBlocoUpdate);
      
          -- Macro-substituicao das variáveis dentro do bloco de código do template
          sTemplate := fc_replace_multi(sTemplate, aProcura, aSubstitui);
      
          -- Execução do código do template
          IF sTemplate IS NULL THEN
            RAISE EXCEPTION 'Nao foi possivel criar funcao para tabela %.%',
              rTabela.esquema, rTabela.nome;
          ELSE
            EXECUTE sTemplate;
          END IF;
        END LOOP;
      
        RETURN;
      END;
      $$
      LANGUAGE plpgsql;
        
      COMMIT; ";
    
    $this->execute($sSql);
  }

  public function down() {
  
  }
}