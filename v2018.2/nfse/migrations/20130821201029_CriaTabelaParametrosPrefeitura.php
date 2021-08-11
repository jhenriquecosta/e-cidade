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


class CriaTabelaParametrosPrefeitura extends Ruckusing_Migration_Base {

  public function up() {
    
    $sSql = "
      BEGIN;
        CREATE TABLE parametrosprefeitura (
          id                              bigint  NOT NULL,
          ibge                            character varying,
          nome                            character varying,
          cnpj                            character varying,
          controle_aidof                  character varying,
          nome_relatorio                  character varying,
          endereco                        character varying,
          numero                          character varying,
          complemento                     character varying,
          bairro                          character varying,
          municipio                       character varying,
          uf                              character varying,
          cep                             character varying,
          telefone                        character varying,
          fax                             character varying,
          email                           character varying,
          url                             character varying,
          verifica_autocadastro           boolean,
          avisofim_emissao_nota           integer DEFAULT 0,
          nota_retroativa                 integer DEFAULT 0,
          modelo_importacao_rps           character varying,
          informacoes_complementares_nfse character varying,
          modelo_impressao_nfse           text DEFAULT 1
        );
        
        CREATE SEQUENCE parametrosprefeitura_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
        ALTER TABLE ONLY parametrosprefeitura ADD CONSTRAINT parametrosprefeitura_ibge_unique UNIQUE (ibge);
        ALTER TABLE ONLY parametrosprefeitura ADD CONSTRAINT parametrosprefeitura_id_pk PRIMARY KEY (id);
        
        COMMENT ON COLUMN parametrosprefeitura.verifica_autocadastro           IS 'Status para Verificação do autocadastro pelos fiscais';
        COMMENT ON COLUMN parametrosprefeitura.avisofim_emissao_nota           IS 'Quantidade de AIDOFs para aviso ao emitir documentos';
        COMMENT ON COLUMN parametrosprefeitura.nota_retroativa                 IS 'Dias retroativos para emissão de NFSe';
        COMMENT ON COLUMN parametrosprefeitura.modelo_importacao_rps           IS 'Modelo para importacao de arquivo de RPS';
        COMMENT ON COLUMN parametrosprefeitura.informacoes_complementares_nfse IS 'Informações complementares inseridos automaticamente na NFSe';
        COMMENT ON COLUMN parametrosprefeitura.modelo_impressao_nfse           IS 'Modelo para impressão de NFSE';
      COMMIT;
    ";
    
    $this->execute($sSql);
  }

  public function down() {
    
    $sSql = '
      BEGIN;
        DROP SEQUENCE IF EXISTS parametrosprefeitura_id_seq;    
        DROP TABLE parametrosprefeitura CASCADE;
      COMMIT;
    ';
    
    $this->execute($sSql);
  }
}