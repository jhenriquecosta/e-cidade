<?php

/**
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
class V010300 extends Ruckusing_Migration_Base
{
    public function up()
    {
      $sSql = "
          BEGIN;

            -- Atualiza a versão com o e-cidade
            INSERT INTO versoes VALUES ('V010300', '2.3.28');

            -- Cria tabela do Plano de Contas Abrasf
            CREATE TABLE plano_contas_abrasf (
              id INTEGER NOT NULL,
              conta_abrasf VARCHAR NOT NULL,
              titulo_contabil_desc VARCHAR NOT NULL,
              versao VARCHAR NOT NULL,
              tributavel BOOLEAN NOT NULL,
              obrigatorio BOOLEAN DEFAULT false
            );

            CREATE SEQUENCE plano_contas_abrasf_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

            ALTER TABLE ONLY plano_contas_abrasf
              ADD CONSTRAINT plano_contas_abrasf_id_pk PRIMARY KEY (id),
              ADD CONSTRAINT plano_contas_abrasf_conta_abrasf_versao_uk UNIQUE (conta_abrasf, versao);

            ALTER SEQUENCE plano_contas_abrasf_seq OWNED BY plano_contas_abrasf.id;
            ALTER TABLE ONLY plano_contas_abrasf ALTER COLUMN id SET DEFAULT nextval('plano_contas_abrasf_seq'::regclass);

            --Adicionando plano de contas da Abrasf
            --Página 1
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71000008', 'RECEITAS OPERACIONAIS', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71100001', 'Rendas de Operações de Crédito', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71103008', 'RENDAS DE ADIANTAMENTOS A DEPOSITANTES', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71105006', 'RENDAS DE EMPRÉSTIMOS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71110008', 'RENDAS DE TÍTULOS DESCONTADOS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71115003', 'RENDAS DE FINANCIAMENTOS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71118000', 'RENDAS DE FINANCIAMENTOS A AGENTES FINANCEIROS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71120005', 'RENDAS DE FINANCIAMENTOS À EXPORTAÇÃO', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71123002', 'RENDAS DE FINANCIAMENTOS DE MOEDAS ESTRANGEIRAS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71125000', 'RENDAS DE FINANCIAMENTOS COM INTERVENIÊNCIA', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71135007', 'RENDAS DE REFINANCIAMENTOS DE OPERAÇÕES DE ARRENDAMENTO', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71140009', 'RENDAS DE FINANCIAMENTOS RURAIS - APLICAÇÕES LIVRES', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71145004', 'RENDAS DE FINANCIAMENTOS RURAIS - APLICAÇÕES OBRIGATÓRIAS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71150006', 'RENDAS DE FINANCIAMENTOS RURAIS - APLICAÇÕES REPASSADAS E REFINANCIADAS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71152004', 'RENDAS DE REFINANCIAMENTOS DE OPERAÇÕES COM O GOVERNO FEDERAL', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71155001', 'RENDAS DE FINANCIAMENTOS AGROINDUSTRIAIS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71160003', 'RENDAS DE FINANCIAMENTOS DE EMPREENDIMENTOS IMOBILIÁRIOS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71165008', 'RENDAS DE FINANCIAMENTOS HABITACIONAIS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71170000', 'RENDAS DE FINANCIAMENTOS DE INFRAESTRUTURA E DESENVOLVIMENTO', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71180007', 'RENDAS DE DIREITOS POR EMPRÉSTIMOS DE AÇÕES', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71185002', 'RENDAS DE FINANCIAMENTOS DE CONTA MARGEM', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71190004', 'RENDAS DE FINANCIAMENTOS DO PROCAP', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71192002', 'RENDAS DE DIREITOS POR EMPRÉSTIMOS DE OURO', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71200004', 'Rendas de Arrendamento Mercantil', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71210001', 'RENDAS DE ARRENDAMENTOS FINANCEIROS - RECURSOS INTERNOS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71215006', 'RENDAS DE ARRENDAMENTOS OPERACIONAIS - RECURSOS INTERNOS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71220008', 'RENDAS DE ARRENDAMENTOS FINANCEIROS - RECURSOS EXTERNOS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71225003', 'RENDAS DE ARRENDAMENTOS OPERACIONAIS - RECURSOS EXTERNOS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71230005', 'RENDAS DE SUBARRENDAMENTOS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71260006', 'LUCROS NA ALIENAÇÃO DE BENS ARRENDADOS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71260109', 'Arrendamento Financeiro', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71260202', 'Arrendamento Operacional', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71300007', 'Rendas de Câmbio', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71310004', 'RENDAS DE OPERAÇÕES DE CÂMBIO', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71310107', 'Exportação', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71310200', 'Importação', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71310303', 'Financeiro', false, '1.00');

            --Página 2
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71310901', 'Outras', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71330008', 'RENDAS DE VARIAÇÕES E DIFERENÇAS DE TAXAS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71370006', 'RENDAS DE DISPONIBILIDADES EM MOEDAS ESTRANGEIRAS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71400000', 'Rendas de Aplicações Interfinanceiras de Liquidez', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71410007', 'RENDAS DE APLICAÇÕES EM OPERAÇÕES COMPROMISSADAS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71410100', 'Posição Bancada', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71410203', 'Posição Financiada', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71410409', 'Posição Vendida', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71420004', 'RENDAS DE APLICAÇÕES EM DEPÓSITOS INTERFINANCEIROS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71440008', 'RENDAS DE APLICAÇÕES VOLUNTÁRIAS NO BANCO CENTRAL', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71500003', 'Rendas com Títulos e Valores Mobiliários e Instrumentos Financeiros Derivativos', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71510000', 'RENDAS DE TÍTULOS DE RENDA FIXA', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71515005', 'RENDAS DE TÍTULOS E VALORES MOBILIÁRIOS NO EXTERIOR', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71520007', 'RENDAS DE TÍTULOS DE RENDA VARIÁVEL', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71530004', 'RENDAS DE PARTICIPAÇÕES SOCIETÁRIAS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71540001', 'RENDAS DE APLICAÇÕES EM FUNDOS DE INVESTIMENTO', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71550008', 'RENDAS DE APLICAÇÕES NO FUNDO DE DESENVOLVIMENTO SOCIAL', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71560005', 'RENDAS DE APLICAÇÕES EM TÍTULOS DE DESENVOLVIMENTO ECONÔMICO', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71570002', 'RENDAS DE APLICAÇÕES EM OURO', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71575007', 'LUCROS COM TÍTULOS DE RENDA FIXA', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71580009', 'RENDAS EM OPERAÇÕES COM DERIVATIVOS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71580119', 'Swap', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71580133', 'Swap - Hedge de Título Mantido até o Vencimento', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71580212', 'Termo', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71580236', 'Termo - Hedge de Título Mantido até o Vencimento', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71580315', 'Futuro', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71580339', 'Futuro - Hedge de Título Mantido até o Vencimento', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71580391', 'Opções - Ações', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71580425', 'Opções - Ativos Financeiros e Mercadorias', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71580432', 'Opções - Hedge de Título Mantido até o Vencimento', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71580504', 'Intermediação de Swap', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71580607', 'Derivativos de Crédito', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71580638', 'Derivativos de Crédito - Hedge de Título Mantido até o Vencimento', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71580906', 'Outros', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71590006', 'TVM - AJUSTE POSITIVO AO VALOR DE MERCADO', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71590109', 'Títulos para Negociação', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71590202', 'Títulos Disponíveis para Venda', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71700009', 'Rendas de Prestação de Serviços', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71710006', 'RENDAS DE ADMINISTRAÇÃO DE FUNDOS DE INVESTIMENTO', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71715001', 'RENDAS DE ADMINISTRAÇÃO DE FUNDOS E PROGRAMAS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71720003', 'RENDAS DE ADMINISTRAÇÃO DE LOTERIAS', true, '1.00');

            --Página 3
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71725008', 'RENDAS DE ADMINISTRAÇÃO DE SOCIEDADES DE INVESTIMENTO', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71730000', 'RENDAS DE ASSESSORIA TÉCNICA', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71735005', 'RENDAS DE TAXAS DE ADMINISTRAÇÃO DE CONSÓRCIOS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71740007', 'RENDAS DE COBRANÇA', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71745002', 'RENDAS DE COMISSÕES DE COLOCAÇÃO DE TÍTULOS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71750004', 'RENDAS DE CORRETAGENS DE CÂMBIO', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71755009', 'RENDAS DE ADMINISTRAÇÃO DE ATIVOS REDESCONTADOS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71760001', 'RENDAS DE CORRETAGENS DE OPERAÇÕES EM BOLSAS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71770008', 'RENDAS DE SERVIÇOS DE CUSTÓDIA', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71780005', 'RENDAS DE SERVIÇOS PRESTADOS A LIGADAS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71790002', 'RENDAS DE TRANSFERÊNCIA DE FUNDOS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71794008', 'RENDAS DE PACOTES DE SERVIÇOS - PF', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71795007', 'RENDAS DE SERVIÇOS PRIORITÁRIOS - PF', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71795014', 'Confecção de Cadastro', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71795038', 'Fornecimento de 2a Via de Cartão Magnético com Função de Débito', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71795045', 'Fornecimento de 2a Via de Cartão Magnético de Conta de Poupança', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71795052', 'Exclusão do Cadastro de Emitentes de Cheques sem Fundos', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71795069', 'Contra-Ordem, Oposição e Sustação de Cheques', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71795076', 'Fornecimento de Folhas de Cheques', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71795083', 'Cheque Administrativo', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71795100', 'Cheque Visado', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71795117', 'Saque de Conta de Depósitos à Vista e de Poupança', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71795124', 'Depósito Identificado', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71795131', 'Fornecimento de Extrato Mensal ou de Período', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71795148', 'Fornecimento de Microfilme, Microficha ou Assemelhados', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71795155', 'Transferência por meio de DOC/TED', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71795162', 'Transferência Agendada por meio de DOC/TED', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71795179', 'Transferência entre Contas da Própria Instituição  ', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71795186', 'Ordem de Pagamento', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71795193', 'Concessão de Adiantamento a Depositante', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71795203', 'Cartão de crédito básico - anuidade', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71795210', 'Fornecimento de 2a via de cartão com função crédito', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71795227', 'Utilização de canais de atendimento para retirada em espécie - cartão de crédito', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71795234', 'Pagamento de contas utilizando a função crédito', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71795241', 'Avaliação emergencial de crédito - cartão de crédito', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71795258', 'Cãmbio Manual Relacionado a Viagens Internacionais', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71796006', 'RENDAS DE SERVIÇOS DIFERENCIADOS - PF', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71796013', 'Administração de fundos de investimento', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71796020', 'Aval e fiança', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71796037', 'Avaliação, reavaliação e substituição de bens recebidos em garantia', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71796044', 'Câmbio', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71796051', 'Cartão de crédito diferenciado - anuidade diferenciada', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71796068', 'Cartão pré-pago', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71796075', 'Corretagem envolvendo títulos, valores mobiliários, derivativos e custódia', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71796996', 'Outros serviços diferenciados - PF', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71797005', 'RENDAS DE SERVIÇOS ESPECIAIS - PF', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71798004', 'RENDAS DE TARIFAS BANCÁRIAS - PJ', true, '1.00');

            --Página 4
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71798011', 'Cadastro', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71798028', 'Contas de Depósitos', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71798035', 'Transferência de Recursos', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71798042', 'Operações de Crédito', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71798994', 'Outras Rendas de Tarifas Bancárias - PJ', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71799003', 'RENDAS DE OUTROS SERVIÇOS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71800002', 'Rendas de Participações', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71810009', 'RENDAS DE AJUSTES EM INVESTIMENTOS NO EXTERIOR', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71820006', 'RENDAS DE AJUSTES EM INVESTIMENTOS EM COLIGADAS E CONTROLADAS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71900005', 'Outras Receitas Operacionais', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71910002', 'RENDAS DE CRÉDITOS VINCULADOS A OPERAÇÕES ADQUIRIDAS EM CESSÃO', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71910105', 'De Operações de Crédito', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71910208', 'De Operações de Arrendamento Mercantil', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71910301', 'De Outras Operações com Características de Concessão de Crédito', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71910404', 'De Outros Ativos Financeiros', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71915007', 'LUCROS EM OPERAÇÕES DE VENDA OU DE TRANSFERÊNCIA DE ATIVOS FINANCEIROS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71915100', 'De Operações de Crédito', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71915203', 'De Operações de Arrendamento Mercantil', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71915306', 'De Outras Operações com Características de Concessão de Crédito', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71915409', 'De Outros Ativos Financeiros', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71920009', 'RECUPERAÇÃO DE CRÉDITOS BAIXADOS COMO PREJUÍZO', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71925004', 'RENDAS DE CRÉDITOS DECORRENTES DE CONTRATOS DE EXPORTAÇÃO ADQUIRIDOS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71930006', 'RECUPERAÇÃO DE ENCARGOS E DESPESAS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71940003', 'RENDAS DE APLICAÇÕES NO EXTERIOR', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71947006', 'RENDAS DE APLICAÇÕES EM MOEDAS ESTRANGEIRAS NO PAÍS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71950000', 'RENDAS DE CRÉDITOS POR AVAIS E FIANÇAS HONRADOS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71955005', 'RENDAS DE CRÉDITOS VINCULADOS AO CRÉDITO RURAL', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71960007', 'RENDAS DE CRÉDITOS VINCULADOS AO BANCO CENTRAL', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71965002', 'RENDAS DE CRÉDITOS VINCULADOS AO SFH', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71970004', 'RENDAS DE GARANTIAS PRESTADAS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71975009', 'RENDAS DE OPERAÇÕES ESPECIAIS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71980001', 'RENDAS DE REPASSES INTERFINANCEIROS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71985006', 'RENDAS DE CRÉDITOS ESPECÍFICOS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71986005', 'INGRESSOS DE DEPÓSITOS INTERCOOPERATIVOS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71990008', 'REVERSÃO DE PROVISÕES OPERACIONAIS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71990053', 'Perdas em Aplicações em Depósitos Interfinanceiros', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71990101', 'Desvalorização de Títulos Livres', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71990125', 'Desvalorização de Créditos Vinculados', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71990156', 'Desvalorização de Títulos Vinculados a Operações Compromissadas', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71990204', 'Desvalorização de Títulos Vinculados à Negociação e Intermediação de Valores', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71990266', 'Derivativos de Crédito', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71990307', 'Operações de Crédito de Liquidação Duvidosa', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71990352', 'Repasses Interfinanceiros', false, '1.00');

            --Página 5
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71990400', 'Créditos de Arrendamento de Liquidação Duvidosa', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71990503', 'Perdas na Venda de Valor Residual', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71990606', 'Outros Créditos de Liquidação Duvidosa', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71990709', 'Perdas em Participações Societárias', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71990802', 'Perdas em Dependências no Exterior', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71990905', 'Perdas em Sociedades Coligadas e Controladas', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71990950', 'Imposto de Renda', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71990998', 'Outras', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('71999009', 'OUTRAS RENDAS OPERACIONAIS', true, '1.00');

            --Página 6
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('73000006', 'RECEITAS NÃO OPERACIONAIS', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('73100009', 'Lucros em Transações com Valores e Bens', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('73110006', 'LUCROS NA ALIENAÇÃO DE INVESTIMENTOS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('73130000', 'LUCROS NA ALIENAÇÃO DE PARTICIPAÇÕES SOCIETÁRIAS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('73150004', 'LUCROS NA ALIENAÇÃO DE VALORES E BENS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('73900003', 'Outras Receitas Não Operacionais', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('73910000', 'GANHOS DE CAPITAL', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('73920007', 'RENDAS DE ALUGUÉIS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('73990006', 'REVERSÃO DE PROVISÕES NÃO OPERACIONAIS', true, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('73990109', 'Desvalorização de Outros Valores e Bens', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('73990202', 'Perdas em Investimentos por Incentivos Fiscais', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('73990305', 'Perdas em Títulos Patrimoniais', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('73990408', 'Perdas em Ações e Cotas', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('73990903', 'Perdas em Outros Investimentos', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('73990996', 'Outras', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('73999007', 'OUTRAS RENDAS NÃO OPERACIONAIS', true, '1.00');

            --Página 7
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('78000001', 'RATEIO DE RESULTADOS INTERNOS', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('78100004', 'Rateio de Resultados Internos', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('78110001', 'RATEIO DE RESULTADOS INTERNOS', true, '1.00');

            --Página 8
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('79000000', 'APURAÇÃO DE RESULTADO', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('79100003', 'Apuração de Resultado', false, '1.00');
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('79110000', 'APURAÇÃO DE RESULTADO (+)', true, '1.00');

            -- ACL
            INSERT INTO controles VALUES (38, 2, 'Plano Contas Abrasf', 'conta-abrasf', true);
            INSERT INTO controles VALUES (41, 6, 'Plano Contas Abrasf', 'conta-abrasf', true);
            SELECT pg_catalog.setval('controles_id_seq', 41, true);

            INSERT INTO acoes (id,id_controle,acao,acaoacl,sub_acoes) VALUES (59,38,'Consultar Plano Contas Abrasf','listar-contas','');
            INSERT INTO acoes (id,id_controle,acao,acaoacl,sub_acoes, gerador_dados) VALUES (60,41,'Contas Obrigatórias - Padrão Abrasf','consultar','listar-contas,salvar-contas', 't');
            SELECT pg_catalog.setval('acoes_id_seq', 60, true);

            ALTER TABLE importacao_desif_contas DROP COLUMN conta_cosif;
            ALTER TABLE importacao_desif_contas ADD id_plano_conta_abrasf INTEGER;
            ALTER TABLE importacao_desif_contas ADD CONSTRAINT importacao_desif_conta_id_plano_contas_abrasf FOREIGN KEY (id_plano_conta_abrasf) REFERENCES plano_contas_abrasf(id);

            -- ACL para Guias Desif
            INSERT INTO controles VALUES (42, 2, 'Guias Desif', 'guia-desif', true);
            SELECT pg_catalog.setval('controles_id_seq', 42, true);

            INSERT INTO acoes (id,id_controle,acao,acaoacl, sub_acoes, gerador_dados) VALUES (61,42,'Emissão DES-IF','consulta-emissao', 'emitir-guia,geracao,geracao-detalhes', 't');
            SELECT pg_catalog.setval('acoes_id_seq', 61, true);

            -- ACL adicionaProtocolo
            UPDATE acoes SET sub_acoes = 'processar-importacao, adiciona-protocolo' WHERE id = 58;

            -- Cria tabela das guias de desif
            CREATE TABLE desif_contas_guias (
              id integer not null,
              id_guia integer,
              id_importacao_desif_conta integer not null,
              id_importacao_desif integer not null
            );

            CREATE SEQUENCE desif_contas_guias_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

            ALTER SEQUENCE desif_contas_guias_id_seq OWNED BY desif_contas_guias.id;
            ALTER TABLE ONLY desif_contas_guias ALTER COLUMN id SET DEFAULT nextval('desif_contas_guias_id_seq'::regclass);
            ALTER TABLE ONLY desif_contas_guias
              ADD CONSTRAINT desif_contas_guias_id_pk PRIMARY KEY (id),
              ADD CONSTRAINT desif_contas_guias_id_guia_fk FOREIGN KEY (id_guia) REFERENCES guias(id),
              ADD CONSTRAINT desif_contas_guias_id_importacao_desif_conta_fk FOREIGN KEY (id_importacao_desif_conta) REFERENCES importacao_desif_contas(id),
              ADD CONSTRAINT desif_contas_guias_id_importacao_desif_fk FOREIGN KEY (id_importacao_desif) REFERENCES importacao_desif(id);

            -- Adicionado id_protocolo na tabela importacao_desif
            ALTER TABLE ONLY importacao_desif
              ADD COLUMN id_protocolo INTEGER,
              ADD CONSTRAINT importacao_desif_id_protocolo_fk FOREIGN KEY (id_protocolo) REFERENCES protocolo(id),
              ADD CONSTRAINT importacao_desif_id_protocolo_uk UNIQUE (id_protocolo);

            -- Adiciona acl para emitir as contas
            INSERT INTO acoes(id, id_controle, acao, acaoacl, sub_acoes, gerador_dados) VALUES (62, 40, 'Emitir Contas', 'emitir-contas', 'listar-contas-emissao,salvar-emissao', true);
            SELECT pg_catalog.setval('acoes_id_seq', 62, true);

            -- Adiciona parâmetro para solicitar cancelamentos
            ALTER TABLE parametrosprefeitura ADD solicita_cancelamento BOOLEAN;

            -- Criada tabela para armazenar solicitações de cancelamentos
            CREATE TABLE solicitacao_cancelamento(
              id bigint NOT NULL,
              id_nota bigint NOT NULL,
              id_usuario integer not null,
              dt_solicitacao timestamp,
              motivo text,
              justificativa TEXT,
              rejeitado boolean,
              autorizado boolean,
              justificativa_fiscal TEXT,
              email_tomador VARCHAR(80)
            );

            CREATE SEQUENCE solicitacao_cancelamento_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

            ALTER TABLE ONLY solicitacao_cancelamento
              ADD CONSTRAINT solicitacao_cancelamento_id_pk PRIMARY KEY (id),
              ADD CONSTRAINT solicitacao_cancelamento_id_nota_fk FOREIGN KEY (id_nota) REFERENCES notas(id),
              ADD CONSTRAINT solicitacao_cancelamento_id_usuario_fk FOREIGN KEY (id_usuario) REFERENCES usuarios(id);

            ALTER SEQUENCE solicitacao_cancelamento_id_seq OWNED BY solicitacao_cancelamento.id;
            ALTER TABLE ONLY solicitacao_cancelamento ALTER COLUMN id SET DEFAULT nextval('solicitacao_cancelamento_id_seq'::regclass);

          -- Adiciona rotina de geração automatica para o módulo fiscal
          INSERT INTO controles (id,id_modulo,controle,identidade,visivel) VALUES (43,6,'Solicitação Cancelamento','cancelamento-nfse',true);
          INSERT INTO acoes (id,id_controle,acao,acaoacl,sub_acoes) VALUES (63,43,'Cancelamentos de NFS-e','consultar','visualizar,confirmar,rejeitar');

          -- Corrige sequencias ACL
          SELECT setval('controles_id_seq', 44);
          SELECT setval('acoes_id_seq', 63);

          -- Adiciona ação de impressão do relatorio da geração automatica pelo fiscal
          INSERT INTO acoes (id,id_controle,acao,acaoacl) VALUES (64,37,'Impressão Geração Automática','impressao-geracao-automatica');
          SELECT pg_catalog.setval('acoes_id_seq', 64, true);

          -- Adiciona ação de consulta das Importações DES-IF
          INSERT INTO acoes (id,id_controle,acao,acaoacl, sub_acoes) VALUES (65,40,'Consulta Importacao','consulta-importacao', 'listar-importacao-desif,imprime-importacao');
          SELECT pg_catalog.setval('acoes_id_seq', 65, true);

          INSERT INTO controles (id, id_modulo, controle, identidade, visivel) VALUES (44, 6, 'Relatório Webservice', 'relatorio-webservice', true);
          INSERT INTO acoes(id, id_controle, acao, acaoacl, sub_acoes) VALUES(66, 44, 'Consulta e Impressão', 'consulta', 'download');
          SELECT pg_catalog.setval('acoes_id_seq', 66, true);

          COMMIT;
      ";

      $this->execute($sSql);

    }

    public function down()
    {
      $sSql = "
        BEGIN;

          -- Atualiza a versão com o e-cidade
          DELETE FROM versoes WHERE ecidadeonline2 = 'V010300';

          -- Remove as referencias de protocolo em importacao_desif
          ALTER TABLE importacao_desif DROP CONSTRAINT importacao_desif_id_protocolo_uk;
          ALTER TABLE importacao_desif DROP CONSTRAINT importacao_desif_id_protocolo_fk;
          ALTER TABLE importacao_desif DROP COLUMN id_protocolo;

          ALTER TABLE importacao_desif_contas DROP CONSTRAINT importacao_desif_conta_id_plano_contas_abrasf_fk;
          ALTER TABLE importacao_desif_contas DROP COLUMN id_plano_conta_abrasf;
          ALTER TABLE importacao_desif_contas ADD conta_cosif VARCHAR(20);

          -- Remove tabela de Plano de Contas Abrasf
          DROP TABLE plano_contas_abrasf CASCADE;

          -- Remove ACL
          DELETE FROM usuarios_acoes where id_acao in(59,60);
          DELETE FROM usuarios_contribuintes_acoes where id_acao in(59,60);
          DELETE FROM acoes where id in(59, 60);
          DELETE FROM controles where id in(38, 41);

          -- Remove sub_acao adiciona-protocolo
          UPDATE acoes SET sub_acoes = 'processar-importacao' WHERE id = 58;

          --  Remove acl das guias DES-IF
          DELETE FROM usuarios_acoes where id_acao = 61;
          DELETE FROM usuarios_contribuintes_acoes where id_acao = 61;
          DELETE FROM acoes where id = 61;
          DELETE FROM controles where id = 42;

          -- Remove acl para emitir as contas
          DELETE FROM usuarios_acoes where id_acao = 62;
          DELETE FROM usuarios_contribuintes_acoes where id_acao = 62;
          DELETE FROM acoes where id = 62;

          -- Remove tabela das guias de desif
          DROP TABLE desif_contas_guias CASCADE;

          -- Remove coluna de solicitar cancelamento
          ALTER TABLE parametrosprefeitura DROP solicita_cancelamento;

          -- Remove tabela de solicitações de cancelamentos
          DROP TABLE solicitacao_cancelamento CASCADE;

          -- Remove as permissões de solicitações de cancelamento
          DELETE FROM usuarios_acoes where id_acao = 63;
          DELETE FROM usuarios_contribuintes_acoes where id_acao = 63;
          DELETE FROM acoes where id = 63;
          DELETE FROM controles where id = 43;

          -- Remove ACL  Relatório Geração Automatica Guias
          DELETE FROM usuarios_acoes where id_acao = 64;
          DELETE FROM usuarios_contribuintes_acoes where id_acao = 64;
          DELETE FROM acoes where id = 64;
          SELECT setval('acoes_id_seq', 63);

          -- REMOVE A ACL DE CONSULTA DE IMPORTAÇÕES DES-IF
          DELETE FROM usuarios_acoes where id_acao = 65;
          DELETE FROM usuarios_contribuintes_acoes where id_acao = 65;
          DELETE FROM acoes where id = 65;
          SELECT setval('acoes_id_seq', 64);

          --  Remove acl da consulta de contribuintes com webservice
          DELETE FROM usuarios_acoes where id_acao = 66;
          DELETE FROM usuarios_contribuintes_acoes where id_acao = 66;
          DELETE FROM acoes where id = 66;
          DELETE FROM controles where id = 43;

        COMMIT;
      ";

      $this->execute($sSql);
    }
}
