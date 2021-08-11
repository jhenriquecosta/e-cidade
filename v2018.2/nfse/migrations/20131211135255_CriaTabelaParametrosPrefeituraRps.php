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


class CriaTabelaParametrosPrefeituraRps extends Ruckusing_Migration_Base {
  
  public function up() {
    
    $sSql = "
      BEGIN;
        CREATE TABLE parametros_prefeitura_rps (
          id                  integer           NOT NULL,
          tipo_nfse           integer           NOT NULL,
          tipo_nfse_descricao character varying NOT NULL,
          tipo_ecidade        integer
        );
        
        CREATE SEQUENCE parametros_prefeitura_rps_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
        
        ALTER SEQUENCE   parametros_prefeitura_rps_id_seq OWNED BY parametros_prefeitura_rps.id;
        ALTER TABLE ONLY parametros_prefeitura_rps ALTER COLUMN id SET DEFAULT nextval('parametros_prefeitura_rps_id_seq'::regclass);
        ALTER TABLE ONLY parametros_prefeitura_rps ADD CONSTRAINT parametros_prefeitura_rps_pkey PRIMARY KEY (id);
        ALTER TABLE ONLY parametros_prefeitura_rps ADD CONSTRAINT parametros_prefeitura_rps_tipo_nfse_key UNIQUE (tipo_ecidade);
        
        COMMENT ON TABLE  parametros_prefeitura_rps IS 'Tabela para ligação dos código de RPS da ABRASF (nfse <-> eCidade)';
        COMMENT ON COLUMN parametros_prefeitura_rps.tipo_nfse IS 'Código do tipo de RPS da ABRASF';
        COMMENT ON COLUMN parametros_prefeitura_rps.tipo_nfse_descricao IS 'Descrição do tipo de RPS da ABRASF';
        COMMENT ON COLUMN parametros_prefeitura_rps.tipo_ecidade IS 'Código do tipo de RPS do eCidade';
      COMMIT; ";
    
    $this->execute($sSql);
  }

  public function down() {
    
    $sSql = "
      BEGIN;
        DROP TABLE parametros_prefeitura_rps CASCADE;
      COMMIT;
    ";
    $this->execute($sSql);
  }
}