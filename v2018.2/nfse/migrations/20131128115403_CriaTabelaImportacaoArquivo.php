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


class CriaTabelaImportacaoArquivo extends Ruckusing_Migration_Base {
  
  public function up() {
    
    $sSql = "
      BEGIN;
        CREATE TABLE importacao_arquivo (
          id                    bigint                 NOT NULL,
          data                  date                   NOT NULL,
          hora                  time without time zone NOT NULL,
          tipo                  character varying(50)  NOT NULL,
          quantidade_documentos bigint                 NOT NULL,
          valor_total           numeric                NOT NULL,
          valor_imposto         numeric                NOT NULL,
          versao_layout         character varying(50)  NOT NULL,
          id_usuario            bigint                 NOT NULL
        );
        
        CREATE SEQUENCE  importacao_arquivo_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
        ALTER  SEQUENCE  importacao_arquivo_id_seq OWNED BY importacao_arquivo.id;
        ALTER TABLE ONLY importacao_arquivo 
          ALTER COLUMN id SET DEFAULT nextval('importacao_arquivo_id_seq'::regclass),
          ADD CONSTRAINT importacao_arquivo_pkey PRIMARY KEY (id);
        
        COMMENT ON TABLE  importacao_arquivo                       IS 'Importação de notas';
        COMMENT ON COLUMN importacao_arquivo.tipo                  IS 'Tipo de importação (DMS, NFSE, RPS)';
        COMMENT ON COLUMN importacao_arquivo.quantidade_documentos IS 'Quantidade de documentos importados';
        COMMENT ON COLUMN importacao_arquivo.valor_total           IS 'Valor total do documentos importados';
        COMMENT ON COLUMN importacao_arquivo.valor_imposto         IS 'Valor total de imposto dos documentos importados';
        COMMENT ON COLUMN importacao_arquivo.versao_layout         IS 'Versão do layout do arquivo importado';
      COMMIT;
    ";
    
    $this->execute($sSql);
  }

  public function down() {
    
    $sSql = "
      BEGIN;
        DROP TABLE importacao_arquivo CASCADE;
      COMMIT;
    ";
    $this->execute($sSql);
  }
}