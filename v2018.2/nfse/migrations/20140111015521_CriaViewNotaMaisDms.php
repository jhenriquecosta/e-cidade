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


/**
 * Classe para criacao da view para listar os documentos de DMS juntamente com as NFSe's
 */
class CriaViewNotaMaisDms extends Ruckusing_Migration_Base {
  
  public function up() {
    
    $sSql = "
      BEGIN;
        CREATE VIEW view_nota_mais_dms AS (
          SELECT dms.id AS dms_id,
                 dms.data_operacao AS dms_data_operacao,
                 dms.operacao AS dms_operacao,
                 dms.codigo_planilha AS dms_codigo_planilha,
                 dms.status AS dms_status,
                 NULL::integer AS rps_numero,
                 NULL::date AS rps_data,
                 'dms'::text AS documento_classe,
                 dms_nota.id AS documento_id,
                 dms_nota.id_usuario AS documento_id_usuario,
                 dms_nota.id_contribuinte AS documento_id_contribuinte,
                 dms.ano_comp AS documento_competencia_ano,
                 dms.mes_comp AS documento_competencia_mes,
                 dms_nota.numpre AS documento_numpre,
                 dms_nota.emite_guia AS documento_emite_guia,
                 dms_nota.natureza_operacao AS documento_natureza_operacao,
                 dms_nota.tipo_documento AS documento_tipo,
                 dms_nota.tipo_documento_descricao AS documento_tipo_descricao,
                 dms_nota.nota::numeric AS documento_numero,
                 dms_nota.serie AS documento_serie,
                 dms_nota.status AS documento_status,
                 dms_nota.dt_nota AS documento_data,
                 dms_nota.hr_nota AS documento_hora,
                 CASE
                     WHEN dms_nota.situacao_documento::text NOT IN ('C',
                                                                    'E')
                          AND dms.operacao::text = 's'::text
                          AND dms_nota.emite_guia = TRUE THEN 'T'::character varying
                     WHEN dms_nota.situacao_documento::text NOT IN ('C',
                                                                    'E')
                          AND dms.operacao::text = 's'::text
                          AND dms_nota.emite_guia = FALSE
                          AND dms_nota.s_dados_iss_retido = TRUE THEN 'R'::character varying
                     WHEN dms_nota.situacao_documento::text NOT IN ('C',
                                                                    'E')
                          AND dms.operacao::text = 's'::text
                          AND dms_nota.emite_guia = FALSE
                          AND dms_nota.s_dados_iss_retido = FALSE THEN 'Is'::character varying
                     WHEN dms_nota.situacao_documento::text NOT IN ('C',
                                                                    'E')
                          AND dms.operacao::text = 'e'::text
                          AND dms_nota.emite_guia = FALSE THEN 'T'::character varying
                     WHEN dms_nota.situacao_documento::text NOT IN ('C',
                                                                    'E')
                          AND dms.operacao::text = 'e'::text
                          AND dms_nota.emite_guia = TRUE
                          AND dms_nota.s_dados_iss_retido = TRUE THEN 'R'::character varying
                     WHEN dms_nota.situacao_documento::text NOT IN ('C',
                                                                    'E')
                          AND dms.operacao::text = 'e'::text
                          AND dms_nota.emite_guia = FALSE
                          AND dms_nota.s_dados_iss_retido = FALSE THEN 'Is'::character varying
                     ELSE dms_nota.situacao_documento
                 END AS documento_situacao,
                 dms_nota.codigo_nota_planilha AS documento_codigo_planilha,
                 dms_nota.grupo_documento AS documento_grupo,
                 NULL::character varying AS documento_codigo_verificacao,
                 NULL::character varying AS documento_outras_informacoes,
                 NULL::boolean AS documento_status_cancelamento,
                 NULL::text AS documento_cancelamento_justificativa,
                 NULL::integer AS documento_id_nota_substituta,
                 NULL::integer AS documento_id_nota_substituida,
                 dms_nota.vl_liquido_nfse AS servico_valor_liquido,
                 dms_nota.s_vl_aliquota AS servico_valor_aliquota,
                 dms_nota.s_vl_servicos AS servico_valor_servicos,
                 dms_nota.s_vl_base_calculo AS servico_valor_base_calculo,
                 dms_nota.s_vl_condicionado AS servico_valor_condicionado,
                 dms_nota.s_vl_desc_incondicionado AS servico_valor_incondicionado,
                 dms_nota.s_vl_outras_retencoes AS servico_valor_outras_retencoes,
                 0.00 AS servico_valor_inss,
                 dms_nota.s_vl_inss AS servico_valor_iss,
                 0.00 AS servico_valor_ir,
                 0.00 AS servico_valor_csll,
                 0.00 AS servico_valor_pis,
                 0.00 AS servico_valor_cofins,
                 0.00 AS servico_valor_deducoes,
                 0.00 AS servico_valor_credito,
                 dms_nota.s_data AS servico_data_servico,
                 dms_nota.s_dados_discriminacao AS servico_descricao,
                 dms_nota.s_dados_cod_cnae AS servico_codigo_cnae,
                 dms_nota.s_dados_cod_pais AS servico_codigo_pais,
                 dms_nota.s_dados_iss_retido AS servico_iss_retido,
                 dms_nota.s_dados_exigibilidadeiss AS servico_exibilidade_iss,
                 dms_nota.s_dados_municipio_incidencia AS servico_municipio_incidencia,
                 dms_nota.s_informacoes_complementares AS servico_informacoes_complementares,
                 dms_nota.s_dados_cod_municipio AS servico_codigo_municipio,
                 dms_nota.s_dados_cod_tributacao AS servico_codigo_tributacao,
                 dms_nota.s_codigo_servico AS servico_codigo_servico,
                 dms_nota.s_codigo_obra AS servico_codigo_obra,
                 dms_nota.s_art AS servico_codigo_art,
                 NULL::character varying AS servico_numero_processo,
                 NULL::numeric AS servico_responsavel_retencao,
                 NULL::numeric AS servico_incentivo_fiscal,
                 NULL::numeric AS servico_simples_nacional,
                 NULL::numeric AS servico_regime_especial_tributacao,
                 NULL::character varying AS servico_item_lista_servico,
                 dms_nota.p_cnpjcpf AS prestador_cnpjcpf,
                 COALESCE(dms_nota.p_razao_social, dms_nota.p_nome_fantasia) AS prestador_razao_social,
                 dms_nota.p_ie AS prestador_inscricao_estadual,
                 dms_nota.p_im AS prestador_inscricao_municipal,
                 dms_nota.p_cod_pais AS prestador_endereco_pais_codigo,
                 dms_nota.p_cod_municipio AS prestador_endereco_municipio_codigo,
                 dms_nota.p_uf AS prestador_endereco_uf,
                 dms_nota.p_endereco AS prestador_endereco_descricao,
                 dms_nota.p_endereco_numero AS prestador_endereco_numero,
                 dms_nota.p_endereco_comp AS prestador_endereco_complemento,
                 dms_nota.p_bairro AS prestador_endereco_bairro,
                 dms_nota.p_cep AS prestador_endereco_cep,
                 dms_nota.p_telefone AS prestador_contato_telefone,
                 dms_nota.p_email AS prestador_contato_email,
                 dms_nota.t_cnpjcpf AS tomador_cnpjcpf,
                 dms_nota.t_razao_social AS tomador_razao_social,
                 dms_nota.t_ie AS tomador_inscricao_estadual,
                 dms_nota.t_im AS tomador_inscricao_municipal,
                 dms_nota.t_cod_pais AS tomador_endereco_pais_codigo,
                 dms_nota.t_cod_municipio AS tomador_endereco_municipio_codigo,
                 dms_nota.t_uf AS tomador_endereco_uf,
                 dms_nota.t_endereco AS tomador_endereco_descricao,
                 dms_nota.t_endereco_numero AS tomador_endereco_numero,
                 dms_nota.t_endereco_comp AS tomador_endereco_complemento,
                 dms_nota.t_bairro AS tomador_endereco_bairro,
                 dms_nota.t_cep AS tomador_endereco_cep,
                 dms_nota.t_telefone AS tomador_contato_telefone,
                 dms_nota.t_email AS tomador_contato_email
          FROM dms_nota
          JOIN dms ON dms_nota.id_dms = dms.id

          UNION

          SELECT NULL::bigint AS dms_id,
                 NULL::date AS dms_data_operacao,
                 NULL::character varying AS dms_operacao,
                 NULL::bigint AS dms_codigo_planilha,
                 NULL::character varying AS dms_status,
                 notas.n_rps AS rps_numero,
                 notas.data_rps AS rps_data,
                 'nfse'::text AS documento_classe,
                 notas.id AS documento_id,
                 notas.id_usuario AS documento_id_usuario,
                 notas.id_contribuinte AS documento_id_contribuinte,
                 notas.ano_comp AS documento_competencia_ano,
                 notas.mes_comp AS documento_competencia_mes,
                 0 AS documento_numpre,
                 notas.emite_guia AS documento_emite_guia,
                 notas.natureza_operacao AS documento_natureza_operacao,
                 notas.tipo_nota AS documento_tipo,
                 NULL::character varying AS documento_tipo_descricao,
                 notas.nota::numeric AS documento_numero,
                 NULL::character varying AS documento_serie,
                 NULL::integer AS documento_status,
                 notas.dt_nota AS documento_data,
                 notas.hr_nota AS documento_hora,
                 CASE
                     WHEN notas.s_dados_iss_retido = 1::numeric
                          AND notas.emite_guia = FALSE
                          AND notas.natureza_operacao = 2 THEN 'Is'::character varying
                     WHEN notas.s_dados_iss_retido = 1::numeric
                          AND notas.emite_guia = FALSE THEN 'Is'::character varying
                     WHEN notas.s_dados_iss_retido = 2::numeric THEN 'R'::character varying
                     WHEN notas.emite_guia = TRUE THEN 'T'::character varying
                     WHEN notas.cancelada = TRUE THEN 'C'::character varying
                     ELSE NULL::character varying
                 END AS documento_situacao,
                 NULL::integer AS documento_codigo_planilha,
                 notas.grupo_nota AS documento_grupo,
                 notas.cod_verificacao AS documento_codigo_verificacao,
                 notas.outras_informacoes AS documento_outras_informacoes,
                 notas.cancelada AS documento_status_cancelamento,
                 notas.cancelamento_justificativa AS documento_cancelamento_justificativa,
                 notas.id_nota_substituta AS documento_id_nota_substituta,
                 notas.id_nota_substituida AS documento_id_nota_substituida,
                 notas.vl_liquido_nfse AS servico_valor_liquido,
                 notas.s_vl_aliquota AS servico_valor_aliquota,
                 notas.s_vl_servicos AS servico_valor_servicos,
                 notas.s_vl_bc AS servico_valor_base_calculo,
                 notas.s_vl_condicionado AS servico_valor_condicionado,
                 notas.s_vl_desc_incondicionado AS servico_valor_incondicionado,
                 notas.s_vl_outras_retencoes AS servico_valor_outras_retencoes,
                 notas.s_vl_inss AS servico_valor_inss,
                 notas.s_vl_iss AS servico_valor_iss,
                 notas.s_vl_ir AS servico_valor_ir,
                 notas.s_vl_csll AS servico_valor_csll,
                 notas.s_vl_pis AS servico_valor_pis,
                 notas.s_vl_cofins AS servico_valor_cofins,
                 notas.s_vl_deducoes AS servico_valor_deducoes,
                 notas.vl_credito AS servico_valor_credito,
                 NULL::date AS servico_data_servico,
                 notas.s_dados_discriminacao AS servico_descricao,
                 notas.s_dados_cod_cnae AS servico_codigo_cnae,
                 notas.s_dados_cod_pais AS servico_codigo_pais,
                 notas.s_dados_iss_retido = 2::numeric AS servico_iss_retido,
                 notas.s_dados_exigibilidadeiss AS servico_exibilidade_iss,
                 notas.s_dados_municipio_incidencia AS servico_municipio_incidencia,
                 notas.s_informacoes_complementares AS servico_informacoes_complementares,
                 notas.s_dados_cod_municipio AS servico_codigo_municipio,
                 notas.s_dados_cod_tributacao AS servico_codigo_tributacao,
                 NULL::integer AS servico_codigo_servico,
                 notas.s_codigo_obra AS servico_codigo_obra,
                 notas.s_art AS servico_codigo_art,
                 notas.s_dados_num_processo AS servico_numero_processo,
                 notas.s_dados_resp_retencao AS servico_responsavel_retencao,
                 notas.s_dec_incentivo_fiscal AS servico_incentivo_fiscal,
                 notas.s_dec_simples_nacional AS servico_simples_nacional,
                 notas.s_dec_reg_esp_tributacao AS servico_regime_especial_tributacao,
                 notas.s_dados_item_lista_servico AS servico_item_lista_servico,
                 notas.p_cnpjcpf AS prestador_cnpjcpf,
                 COALESCE(notas.p_razao_social, notas.p_nome_fantasia) AS prestador_razao_social,
                 notas.p_ie AS prestador_inscricao_estadual,
                 notas.p_im AS prestador_inscricao_municipal,
                 notas.p_cod_pais AS prestador_endereco_pais_codigo,
                 notas.p_cod_municipio AS prestador_endereco_municipio_codigo,
                 notas.p_uf AS prestador_endereco_uf,
                 notas.p_endereco AS prestador_endereco_descricao,
                 notas.p_endereco_numero AS prestador_endereco_numero,
                 notas.p_endereco_comp AS prestador_endereco_complemento,
                 notas.p_bairro AS prestador_endereco_bairro,
                 notas.p_cep AS prestador_endereco_cep,
                 notas.p_telefone AS prestador_contato_telefone,
                 notas.p_email AS prestador_contato_email,
                 notas.t_cnpjcpf AS tomador_cnpjcpf,
                 notas.t_razao_social AS tomador_razao_social,
                 notas.t_ie AS tomador_inscricao_estadual,
                 notas.t_im AS tomador_inscricao_municipal,
                 notas.t_cod_pais AS tomador_endereco_pais_codigo,
                 notas.t_cod_municipio AS tomador_endereco_municipio_codigo,
                 notas.t_uf AS tomador_endereco_uf,
                 notas.t_endereco AS tomador_endereco_descricao,
                 notas.t_endereco_numero AS tomador_endereco_numero,
                 notas.t_endereco_comp AS tomador_endereco_complemento,
                 notas.t_bairro AS tomador_endereco_bairro,
                 notas.t_cep AS tomador_endereco_cep,
                 notas.t_email AS tomador_contato_telefone,
                 notas.t_telefone AS tomador_contato_email
          FROM notas
        );
      COMMIT;
    ";
    
    $this->execute($sSql);
  }

  public function down() {
    
    $sSql = "
      BEGIN;
        DELETE FROM parametros_prefeitura_rps WHERE id in (1,2,3);
        SELECT pg_catalog.setval('parametros_prefeitura_rps_id_seq', 1, true);
      COMMIT;
    ";
    
    $this->execute($sSql);
    
  }
}