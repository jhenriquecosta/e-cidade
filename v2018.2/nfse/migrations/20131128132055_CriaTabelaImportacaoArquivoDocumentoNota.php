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


class CriaTabelaImportacaoArquivoDocumentoNota extends Ruckusing_Migration_Base {
  
  public function up() {
    
    $sSql = "
      BEGIN;
        CREATE TABLE importacao_arquivo_documento_nota (
          id_importacao_arquivo_documento bigint NOT NULL,
          id_nota                         bigint NOT NULL
        );
        
        ALTER TABLE ONLY importacao_arquivo_documento_nota 
          ADD CONSTRAINT importacao_arquivo_documento_nota_pk PRIMARY KEY (id_importacao_arquivo_documento, id_nota),
          ADD CONSTRAINT importacao_arquivo_documento_nota_id_importacao_arquivo_documento_fk FOREIGN KEY 
            (id_importacao_arquivo_documento) REFERENCES importacao_arquivo_documento (id),
          ADD CONSTRAINT importacao_arquivo_documento_nota_id_nota_fk FOREIGN KEY 
            (id_nota) REFERENCES notas (id);
        
        COMMENT ON TABLE importacao_arquivo_documento_nota IS 
          'Tabela de ligação entre o documento importado e a nota registrada no sistema';
        
        COMMENT ON COLUMN importacao_arquivo_documento_nota.id_importacao_arquivo_documento IS 
          'Identificador do documento importado';
        
        COMMENT ON COLUMN importacao_arquivo_documento_nota.id_nota IS 
          'Identificador da nota registrada no sistema';        
      COMMIT;
    ";
    
    $this->execute($sSql);
  }

  public function down() {
    
    $sSql = "
      BEGIN;
        ALTER TABLE importacao_arquivo_documento_nota DROP CONSTRAINT importacao_arquivo_documento_nota_pk;
        ALTER TABLE importacao_arquivo_documento_nota DROP CONSTRAINT importacao_arquivo_documento_nota_id_importacao_arquivo_documento_fk;
        ALTER TABLE importacao_arquivo_documento_nota DROP CONSTRAINT importacao_arquivo_documento_nota_id_nota_fk;
        DROP TABLE importacao_arquivo_documento_nota;
      COMMIT;
    ";
    $this->execute($sSql);
  }
}