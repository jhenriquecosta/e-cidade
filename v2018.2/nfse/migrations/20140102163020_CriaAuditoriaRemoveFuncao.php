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


class CriaAuditoriaRemoveFuncao extends Ruckusing_Migration_Base {
  
  public function up() {
  
    $sSql = "
      
      BEGIN;
        
      CREATE OR REPLACE FUNCTION fc_auditoria_remove_funcao(TEXT) RETURNS VOID AS
      $$
      DECLARE
        sEsquema TEXT;
        sTabela  TEXT;
        aTabela  TEXT[];
      
        sSQL     TEXT;
      
        rTabela  RECORD;
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
        
          -- Apaga Trigger de Auditoria
          sSQL := 'DROP TRIGGER IF EXISTS tg_'||rTabela.nome||'_auditoria ON '||rTabela.esquema||'.'||rTabela.nome||';';
          EXECUTE sSQL;
      
          -- Apaga Funcao de Auditoria
          sSQL := 'DROP FUNCTION IF EXISTS '||rTabela.esquema||'.fc_'||rTabela.nome||'_auditoria();';
          EXECUTE sSQL;
      
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