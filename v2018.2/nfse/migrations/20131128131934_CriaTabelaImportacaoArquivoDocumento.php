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


class CriaTabelaImportacaoArquivoDocumento extends Ruckusing_Migration_Base {
  
  public function up() {
    
    $sSql = "
      BEGIN;
        CREATE TABLE importacao_arquivo_documento (
          id                    integer NOT NULL,
          id_importacao_arquivo bigint  NOT NULL,
          valor_total           numeric NOT NULL,
          valor_imposto         numeric NOT NULL
        );
        
        CREATE SEQUENCE  importacao_arquivo_documento_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
        ALTER SEQUENCE   importacao_arquivo_documento_id_seq OWNED BY importacao_arquivo_documento.id;
        ALTER TABLE ONLY importacao_arquivo_documento 
          ALTER COLUMN id SET DEFAULT nextval('importacao_arquivo_documento_id_seq'::regclass),
          ADD CONSTRAINT importacao_arquivo_documento_pkey PRIMARY KEY (id),
          ADD CONSTRAINT importacao_arquivo_documento_id_importacao_arquivo_fk FOREIGN KEY 
            (id_importacao_arquivo) REFERENCES importacao_arquivo (id);
          
        COMMENT ON TABLE  importacao_arquivo_documento                       IS 'Lista de documentos importados';
        COMMENT ON COLUMN importacao_arquivo_documento.id_importacao_arquivo IS 'Identificador da importação';
        COMMENT ON COLUMN importacao_arquivo_documento.valor_total           IS 'Valor total do documento importado';
        COMMENT ON COLUMN importacao_arquivo_documento.valor_imposto         IS 'Valor de imposto do documento importado';
      COMMIT;
    ";
    
    $this->execute($sSql);
  }

  public function down() {
    
    $sSql = "
      BEGIN;
        DROP TABLE importacao_arquivo_documento CASCADE;
      COMMIT;
    ";
    $this->execute($sSql);
  }
}