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


class CriaComentariosNotas extends Ruckusing_Migration_Base {
  
  public function up() {
    
    $sSql  = "
      BEGIN;
        COMMENT ON COLUMN notas.nota                         IS 'Numero da nota - tcInfNfse';
        COMMENT ON COLUMN notas.dt_nota                      IS 'Data Emissao da Nota - tcInfNfse';
        COMMENT ON COLUMN notas.hr_nota                      IS 'Hora da Emissao da nota - tcInfNfse';
        COMMENT ON COLUMN notas.cod_verificacao              IS 'Codigo de Verificacao da Nota - tcInfNfse';
        COMMENT ON COLUMN notas.s_dados_discriminacao        IS 'Descricao do servico - tcInfDeclaracaoPrestacaoServico';
        COMMENT ON COLUMN notas.s_vl_servicos                IS 'Era o valor nota agora eh Valor do Servico - tcValoresDeclaracaoServico';
        COMMENT ON COLUMN notas.s_vl_deducoes                IS 'Valor da Deducao do Servico - tcValoresDeclaracaoServico';
        COMMENT ON COLUMN notas.s_vl_bc                      IS 'Base Calculo da nota - tcValoresNfse';
        COMMENT ON COLUMN notas.s_vl_aliquota                IS 'Aliquota da NFSE - tcValoresNfse';
        COMMENT ON COLUMN notas.s_vl_iss                     IS 'Valor do iss da nota - tcValoresNfse';
        COMMENT ON COLUMN notas.s_vl_pis                     IS 'Grava valor do Pis - tcValoresDeclaracaoServico';
        COMMENT ON COLUMN notas.s_vl_cofins                  IS 'Grava Valor do Cofins - tcValoresDeclaracaoServico';
        COMMENT ON COLUMN notas.s_vl_inss                    IS 'Grava valor inss - tcValoresDeclaracaoServico';
        COMMENT ON COLUMN notas.s_vl_ir                      IS 'Grava valor do Ir - tcValoresDeclaracaoServico';
        COMMENT ON COLUMN notas.s_vl_csll                    IS 'Grava valor csll - tcValoresDeclaracaoServico';
        COMMENT ON COLUMN notas.p_cnpjcpf                    IS 'Cnpj/Cpf do Prestador - tcDadosPrestador';
        COMMENT ON COLUMN notas.p_im                         IS 'Inscricao Municipal do Prestador - tcDadosPrestador';
        COMMENT ON COLUMN notas.p_ie                         IS 'Inscricao estadual do prestador - SAISS';
        COMMENT ON COLUMN notas.p_razao_social               IS 'Razao Social do Prestador - tcDadosPrestador';
        COMMENT ON COLUMN notas.p_nome_fantasia              IS 'Nome Fantasia do Prestador - tcDadosPrestador';
        COMMENT ON COLUMN notas.p_endereco                   IS 'Enderedo do Prestador - tcDadosPrestador';
        COMMENT ON COLUMN notas.p_endereco_numero            IS 'Numero da rua do Prestador - tcDadosPrestador';
        COMMENT ON COLUMN notas.p_endereco_comp              IS 'Complemento do endereco do Prestador - tcDadosPrestador';
        COMMENT ON COLUMN notas.p_bairro                     IS 'Bairro do Prestador - tcDadosPrestador';
        COMMENT ON COLUMN notas.p_cod_municipio              IS 'Codigo do municipio (IBGE) do Prestador - tcDadosPrestador';
        COMMENT ON COLUMN notas.p_uf                         IS 'UF do Prestador - tcDadosPrestador';
        COMMENT ON COLUMN notas.p_cod_pais                   IS 'Codigo do Pais (BACEN) do Prestador - tcDadosPrestador';
        COMMENT ON COLUMN notas.p_cep                        IS 'Cep do Prestador - tcDadosPrestador';
        COMMENT ON COLUMN notas.p_telefone                   IS 'Telefone do Prestador - tcDadosPrestador';
        COMMENT ON COLUMN notas.p_email                      IS 'Email do Prestador - tcDadosPrestador';
        COMMENT ON COLUMN notas.t_cnpjcpf                    IS 'Cnpj do Tomador - tcDadosTomador';
        COMMENT ON COLUMN notas.t_im                         IS 'Insc Municipal do Tomador - tcDadosTomador';
        COMMENT ON COLUMN notas.t_ie                         IS 'Inscricao Estaduao Tomador - SAISS';
        COMMENT ON COLUMN notas.t_razao_social               IS 'Razao Social do Tomador - tcDadosTomador';
        COMMENT ON COLUMN notas.t_endereco                   IS 'Endereco do Tomador - tcDadosTomador';
        COMMENT ON COLUMN notas.t_endereco_numero            IS 'Numero da rua do Tomador - tcDadosTomador';
        COMMENT ON COLUMN notas.t_endereco_comp              IS 'Complemento do endereco do Tomador - tcDadosTomador';
        COMMENT ON COLUMN notas.t_bairro                     IS 'Bairro do Tomador - tcDadosTomador';
        COMMENT ON COLUMN notas.t_cod_municipio              IS 'Codigo do municipio (IBGE) do Tomador - tcDadosTomador';
        COMMENT ON COLUMN notas.t_uf                         IS 'Uf do Tomador - tcDadosTomador';
        COMMENT ON COLUMN notas.t_cod_pais                   IS 'Codigo do Pais (BACEN) do Tomador - tcDadosTomador';
        COMMENT ON COLUMN notas.t_cep                        IS 'Cep do Tomador - tcDadosTomador';
        COMMENT ON COLUMN notas.t_telefone                   IS 'Telefone do Tomador - tcDadosTomador';
        COMMENT ON COLUMN notas.t_email                      IS 'Email do Tomador - tcDadosTomador';
        COMMENT ON COLUMN notas.vl_liquido_nfse              IS 'Valor Liquido da Nfse - tcValoresNfse  (ValorServicos - ValorPIS - ValorCOFINS - ValorINSS - ValorIR -  ValorCSLL - Outras Retençoes - ValorISSRetido - DescontoIncondicionado - DescontoCondicionado)';
        COMMENT ON COLUMN notas.s_vl_outras_retencoes        IS 'Valor outras retencaos do servico - tcValoresDeclaracaoServico';
        COMMENT ON COLUMN notas.s_vl_desc_incondicionado     IS 'Valor desconto incondicionado do servico - tcValoresDeclaracaoServico';
        COMMENT ON COLUMN notas.s_vl_condicionado            IS 'Valor desconto condicionado do servico - tcValoresDeclaracaoServico';
        COMMENT ON COLUMN notas.s_dados_iss_retido           IS 'Verifica se o iss eh retido: 1->Sim 2->Nao - tcDadosServico';
        COMMENT ON COLUMN notas.s_dados_item_lista_servico   IS 'Codigo da lista de servico da Lei Complementar não 116 - tcDadosServico';
        COMMENT ON COLUMN notas.s_dados_cod_municipio        IS 'Codigo do IBGE de onde servico foi prestado - tcDadosServico';
        COMMENT ON COLUMN notas.s_dados_cod_pais             IS 'Codigo do Pais (BACEN) do Tomador - tcDadosServico';
        COMMENT ON COLUMN notas.s_dados_municipio_incidencia IS 'Municipio de incidencia do servico - tcDadosServico';
        COMMENT ON COLUMN notas.s_dados_num_processo         IS 'Número do processo judicial ou administrativo de suspensão da exigibilidade - tcDadosServico';
        COMMENT ON COLUMN notas.s_dec_cc_cod_obra            IS 'Dados da Contrucao Civil - tcInfDeclaracaoPrestacaoServico';
        COMMENT ON COLUMN notas.s_dec_cc_art                 IS 'Dados da Construcao Civil Cod Art - tcInfDeclaracaoPrestacaoServico';
        COMMENT ON COLUMN notas.s_dec_incentivo_fiscal       IS 'Servico Icentivo Fiscal: 1->Sim 2->Nao - tcInfDeclaracaoPrestacaoServico';
        COMMENT ON COLUMN notas.s_dec_simples_nacional       IS 'Simples Nacional: 1 Sim 2 Nao';
        COMMENT ON COLUMN notas.vl_credito                   IS 'Valor do Crédito - tcInfNfse';
        COMMENT ON COLUMN notas.outras_informacoes           IS 'Informações adicionais ao documento - tcInfNfse';
        COMMENT ON COLUMN notas.s_dados_cod_tributacao       IS 'Codigo da lista de servico do municipio';
        COMMENT ON COLUMN notas.tipo_nota                    IS 'Grava o tipo da nota - sempre ELETRONICA';
        COMMENT ON COLUMN notas.grupo_nota                   IS 'Grupo de notas do eCidade (grupo_notasiss)';
        COMMENT ON COLUMN notas.emite_guia                   IS 'Flag para identificar se a nota deve ser incluída na guia de pagamento';
        COMMENT ON COLUMN notas.id_nota_substituta           IS 'Identificador da nova nota, caso esta esteja sendo substituida por outra nota';
        COMMENT ON COLUMN notas.id_nota_substituida          IS 'Identificador da nota antiga, caso esta esteja substituindo outra nota';
      COMMIT;
    ";
    
    $this->execute($sSql);
  }

  public function down() {
    
    $sSql  = "
      BEGIN;
        COMMENT ON COLUMN notas.nota                         IS NULL;
        COMMENT ON COLUMN notas.dt_nota                      IS NULL;
        COMMENT ON COLUMN notas.hr_nota                      IS NULL;
        COMMENT ON COLUMN notas.cod_verificacao              IS NULL;
        COMMENT ON COLUMN notas.s_dados_discriminacao        IS NULL;
        COMMENT ON COLUMN notas.s_vl_servicos                IS NULL;
        COMMENT ON COLUMN notas.s_vl_deducoes                IS NULL;
        COMMENT ON COLUMN notas.s_vl_bc                      IS NULL;
        COMMENT ON COLUMN notas.s_vl_aliquota                IS NULL;
        COMMENT ON COLUMN notas.s_vl_iss                     IS NULL;
        COMMENT ON COLUMN notas.s_vl_pis                     IS NULL;
        COMMENT ON COLUMN notas.s_vl_cofins                  IS NULL;
        COMMENT ON COLUMN notas.s_vl_inss                    IS NULL;
        COMMENT ON COLUMN notas.s_vl_ir                      IS NULL;
        COMMENT ON COLUMN notas.s_vl_csll                    IS NULL;
        COMMENT ON COLUMN notas.p_cnpjcpf                    IS NULL;
        COMMENT ON COLUMN notas.p_im                         IS NULL;
        COMMENT ON COLUMN notas.p_ie                         IS NULL;
        COMMENT ON COLUMN notas.p_razao_social               IS NULL;
        COMMENT ON COLUMN notas.p_nome_fantasia              IS NULL;
        COMMENT ON COLUMN notas.p_endereco                   IS NULL;
        COMMENT ON COLUMN notas.p_endereco_numero            IS NULL;
        COMMENT ON COLUMN notas.p_endereco_comp              IS NULL;
        COMMENT ON COLUMN notas.p_bairro                     IS NULL;
        COMMENT ON COLUMN notas.p_cod_municipio              IS NULL;
        COMMENT ON COLUMN notas.p_uf                         IS NULL;
        COMMENT ON COLUMN notas.p_cod_pais                   IS NULL;
        COMMENT ON COLUMN notas.p_cep                        IS NULL;
        COMMENT ON COLUMN notas.p_telefone                   IS NULL;
        COMMENT ON COLUMN notas.p_email                      IS NULL;
        COMMENT ON COLUMN notas.t_cnpjcpf                    IS NULL;
        COMMENT ON COLUMN notas.t_im                         IS NULL;
        COMMENT ON COLUMN notas.t_ie                         IS NULL;
        COMMENT ON COLUMN notas.t_razao_social               IS NULL;
        COMMENT ON COLUMN notas.t_endereco                   IS NULL;
        COMMENT ON COLUMN notas.t_endereco_numero            IS NULL;
        COMMENT ON COLUMN notas.t_endereco_comp              IS NULL;
        COMMENT ON COLUMN notas.t_bairro                     IS NULL;
        COMMENT ON COLUMN notas.t_cod_municipio              IS NULL;
        COMMENT ON COLUMN notas.t_uf                         IS NULL;
        COMMENT ON COLUMN notas.t_cod_pais                   IS NULL;
        COMMENT ON COLUMN notas.t_cep                        IS NULL;
        COMMENT ON COLUMN notas.t_telefone                   IS NULL;
        COMMENT ON COLUMN notas.t_email                      IS NULL;
        COMMENT ON COLUMN notas.vl_liquido_nfse              IS NULL;
        COMMENT ON COLUMN notas.s_vl_outras_retencoes        IS NULL;
        COMMENT ON COLUMN notas.s_vl_desc_incondicionado     IS NULL;
        COMMENT ON COLUMN notas.s_vl_condicionado            IS NULL;
        COMMENT ON COLUMN notas.s_dados_iss_retido           IS NULL;
        COMMENT ON COLUMN notas.s_dados_item_lista_servico   IS NULL;
        COMMENT ON COLUMN notas.s_dados_cod_municipio        IS NULL;
        COMMENT ON COLUMN notas.s_dados_cod_pais             IS NULL;
        COMMENT ON COLUMN notas.s_dados_municipio_incidencia IS NULL;
        COMMENT ON COLUMN notas.s_dados_num_processo         IS NULL;
        COMMENT ON COLUMN notas.s_dec_cc_cod_obra            IS NULL;
        COMMENT ON COLUMN notas.s_dec_cc_art                 IS NULL;
        COMMENT ON COLUMN notas.s_dec_incentivo_fiscal       IS NULL;
        COMMENT ON COLUMN notas.s_dec_simples_nacional       IS NULL;
        COMMENT ON COLUMN notas.vl_credito                   IS NULL;
        COMMENT ON COLUMN notas.outras_informacoes           IS NULL;
        COMMENT ON COLUMN notas.s_dados_cod_tributacao       IS NULL;
        COMMENT ON COLUMN notas.tipo_nota                    IS NULL;
        COMMENT ON COLUMN notas.grupo_nota                   IS NULL;
        COMMENT ON COLUMN notas.emite_guia                   IS NULL;
      COMMIT;
    ";
    
    $this->execute($sSql);
  }
}