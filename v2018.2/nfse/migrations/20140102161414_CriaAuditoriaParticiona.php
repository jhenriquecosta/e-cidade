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


class CriaAuditoriaParticiona extends Ruckusing_Migration_Base {
  
  public function up() {
    
    $sSql = 'BEGIN; ';
    
    /**
     *  fc_auditoria_particao_cria()
     *  . Função acessora responsável pela criação da partição (clonar tabela)
     */
    $sSql .= "
      CREATE OR REPLACE FUNCTION fc_auditoria_particao_cria (
        sEsquema      TEXT,
        sTabela        TEXT,
        sEsquemaParticao  TEXT,
        sTabelaParticao    TEXT,
        sCheck        TEXT
      ) RETURNS void AS
      $$
      declare
        sSQL TEXT;
      BEGIN
      
        IF fc_clone_table(sEsquema||'.'||sTabela, sEsquemaParticao||'.'||sTabelaParticao, null, true) IS TRUE THEN
          sSQL := 'ALTER TABLE '||sEsquemaParticao||'.'||sTabelaParticao;
          sSQL := sSQL || ' ADD CONSTRAINT '||sTabelaParticao||'_datahora_ck';
          sSQL := sSQL || ' CHECK ('||sCheck||');';
      
          EXECUTE sSQL;
      
          sSQL := 'ALTER TABLE '||sEsquemaParticao||'.'||sTabelaParticao;
          sSQL := sSQL || ' SET WITHOUT OIDS;';
      
          EXECUTE sSQL;
        END IF;
      
        RETURN;
      END;
      $$
      LANGUAGE plpgsql; ";
    
    /**
     *  fc_auditoria_particiona_inc()
     * 
     *  . Função responsável pelo particionamento da tabela auditoria
     *    em segmentos de ANO/MES, ex:
     * 
     *     auditoria_201101
     *     auditoria_201102
     *     auditoria_??????
     * 
     *    A chave para determinar o particionamento é o atributo "datahora"
     */
    $sSql .= "
      CREATE OR REPLACE FUNCTION fc_auditoria_particiona_inc() RETURNS trigger AS
      $$
      declare
        sEsquema         TEXT;
        sTabela          TEXT;
      
        sEsquemaParticao TEXT;
        sTabelaParticao  TEXT;
      
        sDataIni         TEXT;
        sDataFim         TEXT;
        iAno             INTEGER;
        iMes             INTEGER;
      BEGIN
      
        sEsquema := TG_TABLE_SCHEMA;
        sTabela  := TG_TABLE_NAME;
        iAno     := extract(year  from NEW.datahora);
        iMes     := extract(month from NEW.datahora);
        sDataIni := iAno::TEXT || '-' || iMes::TEXT || '-01 00:00:00.000000';
        sDataFim := iAno::TEXT || '-' || iMes::TEXT || '-' || fc_ultimodiames(iAno, iMes)::TEXT || ' 23:59:59.999999';
      
        sEsquemaParticao := COALESCE(fc_getsession('db_esquema_auditoria_particao'), sEsquema);
        sTabelaParticao  := sTabela || '_' ||
          trim(to_char(iAno, '0000')) ||
          trim(to_char(iMes, '00'));
      
        PERFORM fc_auditoria_particao_cria (
          sEsquema,
          sTabela,
          sEsquemaParticao,
          sTabelaParticao,
          'datahora BETWEEN '||quote_literal(sDataIni)||' AND '||quote_literal(sDataFim)
        );
      
        EXECUTE '
          INSERT INTO '||sEsquemaParticao||'.'||sTabelaParticao||' (
            esquema,
            tabela,
            operacao,
            tempo,
            usuario,
            chave,
            mudancas,
            acao
          ) VALUES ($1, $2, $3, $4, $5, $6, $7, $8);'
        USING
          NEW.esquema,
          NEW.tabela,
          NEW.operacao,
          NEW.tempo,
          NEW.usuario,
          NEW.chave,
          NEW.mudancas,
          NEW.acao;
      
        RETURN NULL;
      END;
      $$
      LANGUAGE plpgsql;

      DROP TRIGGER IF EXISTS tg_auditoria_particiona_inc ON auditoria;
      CREATE TRIGGER tg_auditoria_particiona_inc BEFORE INSERT ON auditoria
        FOR EACH ROW EXECUTE PROCEDURE fc_auditoria_particiona_inc();
      ";
    
    $sSql .= 'COMMIT;';
    
    $this->execute($sSql);
    
  }

  public function down() {
  
  }
}