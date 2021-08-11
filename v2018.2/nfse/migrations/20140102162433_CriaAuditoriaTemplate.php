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


class CriaAuditoriaTemplate extends Ruckusing_Migration_Base {
  
  public function up() {
  
    /**
     *  TEMPLATE de PL para auditoria de tabelas
     *
     *  Variáveis do Template
     *   . %tpl_tabela_esquema               = nome do esquema da tabela a ser auditada
     *   . %tpl_tabela_nome                  = nome da tabela a ser auditada
     *   . %tpl_bloco_codigo_definicao_chave = bloco de codigo da definicao da chave (xChave)
     *   . %tpl_bloco_codigo_update          = bloco de codigo a ser processado no UPDATE para montar Array com valores realmente alterados
     *   . %tpl_array_campo_nome             = definicao de array com nome dos campos da tabela a ser auditada
     *   . %tpl_array_insert_campo_valor_old = definicao de array com valores OLD dos campos para INSERT
     *   . %tpl_array_insert_campo_valor_new = definicao de array com valores NEW dos campos para INSERT
     *   . %tpl_array_delete_campo_valor_old = definicao de array com valores OLD dos campos para DELETE
     *   . %tpl_array_delete_campo_valor_new = definicao de array com valores NEW dos campos para DELETE
     */
    
    $sSql = "
        
      BEGIN; 
        
      CREATE OR REPLACE FUNCTION fc_auditoria_template() RETURNS TEXT AS
      $$
        SELECT
      E'CREATE OR REPLACE FUNCTION {%tpl_tabela_esquema}.fc_{%tpl_tabela_nome}_auditoria() RETURNS trigger AS
      \\$\\$
      DECLARE
        xMudancas tp_auditoria_mudancas_campo;
        xChave    tp_auditoria_chave_primaria;
      
        tDataHora   TIMESTAMP   DEFAULT (COALESCE(fc_getsession(\\'DB_datausu\\')::TIMESTAMP, NOW()));
        sLogin      VARCHAR(20) DEFAULT (COALESCE(fc_getsession(\\'DB_login\\'), \'noname\'));
        sAcao       TEXT        DEFAULT fc_getsession(\'DB_acessado\');
      
        rRegistro   {%tpl_tabela_esquema}.{%tpl_tabela_nome}%ROWTYPE;
      
        aCampo      TEXT[];
        aValorOld   TEXT[];
        aValorNew   TEXT[];
      BEGIN
      
        IF fc_getsession(\'__disable_audit__\') IS NOT NULL THEN
          IF TG_OP = \'DELETE\' THEN
            RETURN OLD;
          END IF;
      
          RETURN NEW;
        END IF;
      
        PERFORM fc_putsession(\'clock_timestamp\', clock_timestamp()::TEXT);
      
        IF TG_OP = \'DELETE\' THEN
          rRegistro := OLD;
        ELSE
          rRegistro := NEW;
        END IF;
      
        {%tpl_bloco_codigo_definicao_chave}
      
        IF TG_OP = \'INSERT\' THEN
      
          xMudancas := ROW(
            ARRAY[ {%tpl_array_campo_nome} ],
            ARRAY[ {%tpl_array_insert_campo_valor_old} ],
            ARRAY[ {%tpl_array_insert_campo_valor_new} ] ); 
        
        ELSIF TG_OP = \'UPDATE\' THEN
      
          IF ROW(OLD.*) IS DISTINCT FROM ROW(NEW.*) THEN
      
      {%tpl_bloco_codigo_update}
      
          ELSE
            RETURN NEW;
          END IF;
      
          xMudancas := ROW(aCampo, aValorOld, aValorNew);
        ELSE
      
          xMudancas := ROW(
            ARRAY[ {%tpl_array_campo_nome} ],
            ARRAY[ {%tpl_array_delete_campo_valor_old} ],
            ARRAY[ {%tpl_array_delete_campo_valor_new} ] ); 
      
        END IF;
      
        INSERT INTO auditoria (
          sequencial,
          esquema, 
          tabela, 
          operacao, 
          datahora, 
          usuario, 
          chave, 
          mudancas, 
          acao 
        ) VALUES (
          0,
          TG_TABLE_SCHEMA, 
          TG_TABLE_NAME, 
          SUBSTR(TG_OP,1,1), 
          tDataHora, 
          sLogin,
          xChave,
          xMudancas,
          sAcao
        );
      
        IF TG_OP = \'DELETE\' THEN
          RETURN OLD;
        END IF;
      
        RETURN NEW;
      END;
      \\$\\$
      LANGUAGE plpgsql;
      
      DROP TRIGGER IF EXISTS tg_{%tpl_tabela_nome}_auditoria ON {%tpl_tabela_esquema}.{%tpl_tabela_nome};
      CREATE TRIGGER tg_{%tpl_tabela_nome}_auditoria AFTER INSERT OR UPDATE OR DELETE ON {%tpl_tabela_esquema}.{%tpl_tabela_nome}
        FOR EACH ROW EXECUTE PROCEDURE {%tpl_tabela_esquema}.fc_{%tpl_tabela_nome}_auditoria(); '::TEXT;
      
      $$
      LANGUAGE sql;
      
      COMMIT; "; 
    
    $this->execute($sSql);
    
  }

  public function down() {
  
  }
}