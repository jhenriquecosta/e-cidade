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


class CriaTabelaDmsNota extends Ruckusing_Migration_Base {
  
  public function up() {
    
    $sSql = "
      BEGIN;
        CREATE TABLE dms_nota (
          id bigint NOT NULL,
          id_dms bigint NOT NULL,
          id_usuario bigint NOT NULL,
          id_contribuinte bigint NOT NULL,
          nota bigint NOT NULL,
          serie character varying(5),
          dt_nota date,
          hr_nota time without time zone,
          s_data date,
          s_dados_discriminacao text,
          s_dados_cod_tributacao integer,
          s_dados_cod_cnae character varying(10),
          s_dados_iss_retido boolean DEFAULT false,
          s_dados_cod_municipio numeric(7,0),
          s_dados_cod_pais character varying(5),
          s_dados_exigibilidadeiss numeric(2,0) DEFAULT 1,
          s_dados_municipio_incidencia numeric(7,0),
          s_vl_servicos numeric(15,2),
          s_vl_aliquota numeric(4,2),
          s_vl_inss numeric(15,2) DEFAULT 0,
          s_vl_outras_retencoes numeric(15,2) DEFAULT 0,
          s_vl_desc_incondicionado numeric(15,2) DEFAULT 0,
          s_vl_condicionado numeric(15,2) DEFAULT 0,
          s_retido integer DEFAULT 0,
          s_vl_base_calculo numeric(15,2),
          p_cnpjcpf character varying(14),
          p_im character varying(15),
          p_ie character varying(20),
          p_razao_social character varying(150),
          p_nome_fantasia character varying(60),
          p_endereco character varying(125),
          p_endereco_numero character varying(10),
          p_endereco_comp character varying(60),
          p_bairro character varying(60),
          p_cod_municipio numeric(7,0),
          p_uf character(2),
          p_cod_pais character(5),
          p_cep character(8),
          p_telefone character varying(20),
          p_email character varying(80),
          t_cnpjcpf character varying(14),
          t_nome_fantasia character varying(60),
          t_im character varying(15),
          t_ie character varying(20),
          t_razao_social character varying(150),
          t_endereco character varying(125),
          t_endereco_numero character varying(10),
          t_endereco_comp character varying(60),
          t_bairro character varying(60),
          t_cod_municipio numeric(7,0),
          t_uf character(2),
          t_cod_pais character(5),
          t_cep character(8),
          t_telefone character varying(20),
          t_email character varying(80),
          vl_liquido_nfse numeric(15,2) DEFAULT 0,
          s_codigo_servico integer,
          numpre integer,
          codigo_nota_planilha integer,
          status integer,
          grupo_documento integer,
          tipo_documento integer,
          tipo_documento_descricao character varying,
          situacao_documento character varying(5) DEFAULT NULL::character varying,
          emite_guia boolean DEFAULT false NOT NULL,
          natureza_operacao integer,
          s_codigo_obra character varying,
          s_art character varying,
          s_informacoes_complementares text
        );
        
        ALTER TABLE ONLY dms_nota 
          ADD CONSTRAINT dms_nota_pkey PRIMARY KEY (id),
          ADD CONSTRAINT dms_nota_id_contribuinte_fk FOREIGN KEY (id_contribuinte) REFERENCES usuarios_contribuintes(id),
          ADD CONSTRAINT dms_nota_id_dms_fkey FOREIGN KEY (id_dms) REFERENCES dms(id),
          ADD CONSTRAINT dms_nota_id_usuario_fk FOREIGN KEY (id_usuario) REFERENCES usuarios(id);
        
        CREATE INDEX dms_nota_id_contribuinte_indice ON dms_nota USING btree (id_contribuinte);
        CREATE INDEX dms_nota_id_usuario_indice ON dms_nota USING btree (id_usuario);
        CREATE INDEX dms_nota_id_dms_indice ON dms_nota USING btree (id_dms);
        CREATE SEQUENCE dms_nota_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
        ALTER TABLE ONLY dms_nota ALTER COLUMN id SET DEFAULT nextval('dms_nota_id_seq'::regclass);

        COMMENT ON COLUMN dms_nota.grupo_documento IS 'Grupo de Documento (e-Cidade)';
        COMMENT ON COLUMN dms_nota.tipo_documento IS 'Tipo de Documento (e-Cidade)';
        COMMENT ON COLUMN dms_nota.tipo_documento_descricao IS 'Descrição do Tipo de Documento (Eventual)';
        COMMENT ON COLUMN dms_nota.natureza_operacao IS 'Dentro / Fora Prefeitura';
        COMMENT ON COLUMN dms_nota.s_art IS 'Anotação de Responsabilidade Técnica';
      COMMIT;
    ";
    
    $this->execute($sSql);
  }

  public function down() {
    
    $sSql = '
      BEGIN;
        DROP SEQUENCE dms_nota_id_seq;
        DROP TABLE dms_nota;
      COMMIT;
    ';
    
    $this->execute($sSql);
  }
}