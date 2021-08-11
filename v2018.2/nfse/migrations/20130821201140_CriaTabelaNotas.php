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


class CriaTabelaNotas extends Ruckusing_Migration_Base {
  
  public function up() {
    
    $sSql = "
      BEGIN;
        CREATE TABLE notas (
          id                           BIGINT NOT NULL,
          id_contribuinte              BIGINT NOT NULL,
          id_usuario                   BIGINT NOT NULL,
          nota                         BIGINT NOT NULL,
          dt_nota                      DATE,
          hr_nota                      TIME WITHOUT TIME ZONE,
          n_rps                        BIGINT,
          data_rps                     DATE,
          cod_verificacao              CHARACTER VARYING(10),
          mes_comp                     INTEGER NOT NULL,
          ano_comp                     INTEGER NOT NULL,
          tipo_nota                    INTEGER,
          grupo_nota                   INTEGER NOT NULL,
          natureza_operacao            INTEGER NOT NULL,
          emite_guia                   BOOLEAN DEFAULT FALSE NOT NULL,
          cancelada                    BOOLEAN DEFAULT FALSE,
          cancelamento_justificativa   TEXT,
          id_nota_substituta           BIGINT, CHECK(id_nota_substituta  <> id),
          id_nota_substituida          BIGINT, CHECK(id_nota_substituida <> id),
          outras_informacoes           CHARACTER VARYING(255),
          importada                    BOOLEAN DEFAULT FALSE NOT NULL,
          vl_liquido_nfse              NUMERIC(15,2) DEFAULT 0,
          vl_credito                   NUMERIC(15,2) DEFAULT 0,
          s_codigo_obra                CHARACTER VARYING,
          s_art                        CHARACTER VARYING,
          s_informacoes_complementares TEXT,
          s_dados_discriminacao        TEXT,
          s_vl_outras_retencoes        NUMERIC(15,2) DEFAULT 0,
          s_vl_desc_incondicionado     NUMERIC(15,2) DEFAULT 0,
          s_vl_condicionado            NUMERIC(15,2) DEFAULT 0,
          s_dados_iss_retido           NUMERIC(1,0) DEFAULT 2,
          s_dados_resp_retencao        NUMERIC(1,0) DEFAULT 1,
          s_dados_item_lista_servico   CHARACTER VARYING(5),
          s_dados_cod_municipio        NUMERIC(7,0),
          s_dados_cod_pais             CHARACTER VARYING(5),
          s_dados_exigibilidadeiss     NUMERIC(2,0) DEFAULT 1,
          s_dados_municipio_incidencia NUMERIC(7,0),
          s_dados_num_processo         CHARACTER VARYING(30),
          s_dec_cc_cod_obra            CHARACTER VARYING(30),
          s_dec_cc_art                 CHARACTER VARYING(30),
          s_dec_reg_esp_tributacao     NUMERIC(5,0) DEFAULT 0,
          s_dec_incentivo_fiscal       NUMERIC(5,0) DEFAULT 2,
          s_dec_simples_nacional       NUMERIC(5,0) DEFAULT 2,
          s_dados_cod_tributacao       BIGINT,
          s_dados_cod_cnae             CHARACTER VARYING,
          s_vl_servicos                NUMERIC(15,2),
          s_vl_deducoes                NUMERIC(15,2) DEFAULT 0,
          s_vl_bc                      NUMERIC(15,2),
          s_vl_aliquota                NUMERIC(4,2),
          s_vl_iss                     NUMERIC(15,2) DEFAULT 0,
          s_vl_pis                     NUMERIC(15,2) DEFAULT 0,
          s_vl_cofins                  NUMERIC(15,2) DEFAULT 0,
          s_vl_inss                    NUMERIC(15,2) DEFAULT 0,
          s_vl_ir                      NUMERIC(15,2) DEFAULT 0,
          s_vl_csll                    NUMERIC(15,2) DEFAULT 0,
          p_cnpjcpf                    CHARACTER VARYING(14),
          p_im character               VARYING(20),
          p_ie character               VARYING(20),
          p_razao_social               CHARACTER VARYING,
          p_nome_fantasia              CHARACTER VARYING(255),
          p_endereco                   CHARACTER VARYING(125),
          p_endereco_numero            CHARACTER VARYING(30),
          p_endereco_comp              CHARACTER VARYING,
          p_bairro                     CHARACTER VARYING(60),
          p_cod_municipio              NUMERIC(7,0),
          p_uf                         CHARACTER(2),
          p_cod_pais                   CHARACTER(5),
          p_cep                        CHARACTER(8),
          p_telefone                   CHARACTER VARYING(20),
          p_email                      CHARACTER VARYING(80),
          t_cnpjcpf                    CHARACTER VARYING(14),
          t_im                         CHARACTER VARYING(20),
          t_ie                         CHARACTER VARYING(20),
          t_razao_social               CHARACTER VARYING(150),
          t_nome_fantasia              CHARACTER VARYING,
          t_endereco                   CHARACTER VARYING(125),
          t_endereco_numero            CHARACTER VARYING(30),
          t_endereco_comp              CHARACTER VARYING,
          t_bairro character           VARYING(60),
          t_cod_municipio              NUMERIC(7,0),
          t_uf                         CHARACTER(2),
          t_cod_pais                   CHARACTER(5),
          t_cep                        CHARACTER(8),
          t_telefone                   CHARACTER VARYING(20),
          t_email                      CHARACTER VARYING(80)
        );
        
        ALTER TABLE ONLY notas
          ADD CONSTRAINT notas_pkey                PRIMARY KEY (id),
          ADD CONSTRAINT notas_cod_verificacao_key UNIQUE      (cod_verificacao),
          ADD CONSTRAINT notas_nota_p_cnpjcpf_key  UNIQUE      (nota, p_cnpjcpf),
          ADD CONSTRAINT notas_id_contribuinte_fk  FOREIGN KEY (id_contribuinte) REFERENCES usuarios_contribuintes(id),
          ADD CONSTRAINT notas_id_usuario_fk       FOREIGN KEY (id_usuario)      REFERENCES usuarios(id);
        
        CREATE INDEX notas_id_contribuinte_indice              ON notas USING btree (id_contribuinte);
        CREATE INDEX notas_id_usuario_indice                   ON notas USING btree (id_usuario);
        CREATE INDEX notas_p_cnpjcpf_mes_comp_ano_comp_indice  ON notas USING btree (p_cnpjcpf, mes_comp, ano_comp);
        CREATE INDEX notas_t_cnpjcpf_mes_comp_ano_comp_indice  ON notas USING btree (t_cnpjcpf, mes_comp, ano_comp);
        CREATE INDEX notas_mes_comp_ano_comp_indice  ON notas USING btree (mes_comp, ano_comp);
        CREATE INDEX notas_nota_indice  ON notas USING btree (nota);

        CREATE SEQUENCE notas_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
        ALTER TABLE ONLY notas ALTER COLUMN id SET DEFAULT nextval('notas_id_seq'::regclass);
      COMMIT;
    ";
    
    $this->execute($sSql);
  }
  
  public function down() {
    
    $sSql = "
      BEGIN;
        DROP SEQUENCE IF EXISTS notas_id_seq;
        DROP TABLE IF EXISTS notas;
      COMMIT;
    ";
    
    $this->execute($sSql);
  }
}