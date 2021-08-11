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


class CriaAuditoriaConsultaMudancas extends Ruckusing_Migration_Base {
  
  public function up() {
  
    $sSql = "
      BEGIN;
      DROP TYPE IF EXISTS tp_auditoria_consulta_mudancas CASCADE;
      CREATE TYPE tp_auditoria_consulta_mudancas AS (
        esquema           TEXT,
        tabela            TEXT,
        operacao          CHAR(1),
        transacao         BIGINT,
        datahora          TIMESTAMP WITH TIME ZONE,
        usuario           VARCHAR(20),
        nome_campo        TEXT,
        valor_antigo      TEXT,
        valor_novo        TEXT,
        acao              TEXT
      );
      
      CREATE OR REPLACE FUNCTION fc_auditoria_consulta_mudancas(
        tDataHoraInicio TIMESTAMP,
        tDataHoraFim    TIMESTAMP,
        sEsquema        TEXT,
        sTabela         TEXT,
        sUsuario        TEXT,
        sAcao           TEXT,
        sCampo          TEXT,
        sValorAntigo    TEXT,
        sValorNovo      TEXT
      ) RETURNS SETOF tp_auditoria_consulta_mudancas AS
      $$
      DECLARE
        rRetorno   tp_auditoria_consulta_mudancas;
        rAuditoria RECORD;
      
        rCursorRetorno REFCURSOR;
      
        iQtdMudancas INTEGER;
        iMudanca     INTEGER;
      
        sSQL TEXT;
        sConector TEXT DEFAULT 'OR';
      BEGIN
      
        sSQL := 'SELECT * FROM auditoria ';
        sSQL := sSQL || ' WHERE datahora BETWEEN '||quote_literal(tDataHoraInicio::TEXT)||' AND '||quote_literal(tDataHoraFim::TEXT);
      
        IF sEsquema IS NOT NULL THEN
          sSQL := sSQL || '   AND esquema = '||quote_literal(sEsquema);
        END IF;
      
        IF sTabela IS NOT NULL THEN
          sSQL := sSQL || '   AND tabela  = '||quote_literal(sTabela);
        END IF;
      
        IF sUsuario IS NOT NULL THEN
          sSQL := sSQL || '   AND usuario  = '||quote_literal(sUsuario);
        END IF;
      
        IF sAcao IS NOT NULL THEN
          sSQL := sSQL || '   AND acao  ~ '||sAcao;
        END IF;
      
        IF sCampo IS NOT NULL AND (sValorAntigo IS NOT NULL OR sValorNovo IS NOT NULL) THEN
          sSQL := sSQL || '   AND (mudancas).nome_campo    @> ARRAY['||quote_literal(sCampo)||'] ';
          IF sValorAntigo IS NULL AND sValorNovo IS NOT NULL THEN
            sSQL := sSQL || '   AND (mudancas).valor_novo @> ARRAY['||quote_literal(sValorNovo)||'] ';
            sSQL := sSQL || '   AND ((mudancas).valor_novo)[array_position('||quote_literal(sCampo)||', (mudancas).nome_campo)] = '||quote_literal(sValorNovo)||' ';
          ELSIF sValorAntigo IS NOT NULL AND sValorNovo IS NULL THEN
            sSQL := sSQL || '   AND (mudancas).valor_antigo @> ARRAY['||quote_literal(sValorAntigo)||'] ';
            sSQL := sSQL || '   AND ((mudancas).valor_antigo)[array_position('||quote_literal(sCampo)||', (mudancas).nome_campo)] = '||quote_literal(sValorAntigo)||' ';
          ELSE
            sSQL := sSQL || '   AND ((mudancas).valor_antigo @> ARRAY['||quote_literal(sValorAntigo)||'] OR ';
            sSQL := sSQL || '        (mudancas).valor_novo   @> ARRAY['||quote_literal(sValorNovo)||']) ';
            sSQL := sSQL || '   AND (((mudancas).valor_antigo)[array_position('||quote_literal(sCampo)||', (mudancas).nome_campo)] = '||quote_literal(sValorAntigo)||' OR ';
            sSQL := sSQL || '        ((mudancas).valor_novo)[array_position('||quote_literal(sCampo)||', (mudancas).nome_campo)] = '||quote_literal(sValorNovo)||')';
          END IF;
        END IF;
      
        OPEN rCursorRetorno FOR EXECUTE sSQL;
      
        LOOP
          FETCH rCursorRetorno INTO rAuditoria;
          IF NOT FOUND THEN
            EXIT;
          END IF;
      
          rRetorno.esquema   = rAuditoria.esquema;
          rRetorno.tabela    = rAuditoria.tabela;
          rRetorno.operacao  = rAuditoria.operacao;
          rRetorno.transacao = rAuditoria.transacao;
          rRetorno.datahora  = rAuditoria.datahora;
          rRetorno.datahora  = rAuditoria.datahora;
          rRetorno.usuario   = rAuditoria.usuario;
          rRetorno.acao      = rAuditoria.acao;
      
          iQtdMudancas := ARRAY_UPPER((rAuditoria.mudancas).nome_campo, 1);
      
          FOR iMudanca IN 1..iQtdMudancas
          LOOP
            rRetorno.nome_campo   := (rAuditoria.mudancas).nome_campo[iMudanca];
            rRetorno.valor_antigo := (rAuditoria.mudancas).valor_antigo[iMudanca];
            rRetorno.valor_novo   := (rAuditoria.mudancas).valor_novo[iMudanca];
            RETURN NEXT rRetorno;
          END LOOP;
      
        END LOOP;
      
        CLOSE rCursorRetorno;
      
        RETURN;
      END;
      $$
      LANGUAGE plpgsql;
      
      CREATE OR REPLACE FUNCTION fc_auditoria_consulta_mudancas(
        tDataHoraInicio TIMESTAMP,
        tDataHoraFim    TIMESTAMP,
        sEsquema        TEXT,
        sTabela         TEXT,
        sUsuario        TEXT,
        sAcao           TEXT
      ) RETURNS SETOF tp_auditoria_consulta_mudancas AS
      $$
        SELECT *
          FROM fc_auditoria_consulta_mudancas($1, $2, $3, $4, $5, $6, NULL, NULL, NULL);
      $$
      LANGUAGE sql;
      
      COMMIT; ";
    
    $this->execute($sSql);
  }

  public function down() {
  
    $sSql = 'DROP TYPE IF EXISTS tp_auditoria_consulta_mudancas CASCADE;';
    $this->execute($sSql);
  }
}