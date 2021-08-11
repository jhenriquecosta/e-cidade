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


class PopulaTabelaAcoes extends Ruckusing_Migration_Base {
  
  public function up() {
  
    $sSql = "
      BEGIN;
        INSERT INTO acoes VALUES (1, 1, 'Digitação Serviços Tomados', NULL, 'emissao-manual-entrada-competencia', 'emissao-manual-entrada-salvar,emissao-manual-entrada-verificar-documento,emissao-manual-entrada,emissao-manual-entrada-lista-notas-excluir,emissao-manual-entrada-lista-notas,emissao-manual-entrada-visualizar,emissao-manual-entrada-lista-dms-excluir,emissao-manual-entrada-lista-dms-alterar-status,emissao-manual-entrada-lista-dms,emissao-manual-calcula-valores-dms,emissao-manual-buscar-dados-servico,emissao-manual-lista-notas-excluir,emissao-manual-lista-dms-excluir', false);
        INSERT INTO acoes VALUES (2, 1, 'Importação', NULL, 'importacao', 'processar-arquivo,comprovante,importacao-documentacao', false);
        INSERT INTO acoes VALUES (3, 1, 'Digitação Serviço Prestados', NULL, 'emissao-manual-saida-competencia', 'emissao-manual-saida-salvar,emissao-manual-saida-verificar-documento,emissao-manual-saida,emissao-manual-saida-lista-notas-excluir,emissao-manual-saida-lista-notas,emissao-manual-saida-visualizar,emissao-manual-saida-lista-dms-excluir,emissao-manual-saida-lista-dms-alterar-status,emissao-manual-saida-lista-dms,emissao-manual-calcula-valores-dms,emissao-manual-buscar-dados-servico,emissao-manual-lista-notas-excluir,emissao-manual-lista-dms-excluir,emissao-manual-saida-verificar-documento-prestador-eventual,verificar-contribuinte-optante-simples,emissao-manual-lista-notas-excluir,emissao-manual-lista-dms-excluir', true);
        INSERT INTO acoes VALUES (4, 1, 'Requisição Aidof', NULL, 'requisicao', 'gerar-requisicao,cancelar-requisicao', true);
        INSERT INTO acoes VALUES (5, 2, 'Contribuintes', NULL, 'desvincular', 'permissao,set-permissao,get-contribuinte,contribuintes', false);
        INSERT INTO acoes VALUES (6, 2, 'Excluir', NULL, 'remover', '', false);
        INSERT INTO acoes VALUES (7, 2, 'Ativar', NULL, 'ativar', '', false);
        INSERT INTO acoes VALUES (8, 2, 'Desativar', NULL, 'desativar', '');
        INSERT INTO acoes VALUES (9, 2, 'Permissões Administrativas', NULL, 'set-permissao-adm', '', false);
        INSERT INTO acoes VALUES (10, 2, 'Cadastro', NULL, 'index', 'editar,novo,get-contribuinte-cnpj', false);
        INSERT INTO acoes VALUES (11, 2, 'Alterar Senha', NULL, 'trocar-senha', '', false);
        INSERT INTO acoes VALUES (12, 3, 'Cadastro', NULL, 'index', 'novo,editar,set-perfil-perfis,set-permissao-perfil', false);
        INSERT INTO acoes VALUES (13, 4, 'Index', NULL, 'index', '', false);
        INSERT INTO acoes VALUES (14, 5, 'Parâmetros', NULL, 'prefeitura', 'prefeitura-salvar,prefeitura-salvar-geral,prefeitura-salvar-nfse,prefeitura-salvar-rps', false);
        INSERT INTO acoes VALUES (15, 6, 'Editar', NULL, 'contribuinte', '', false);
        INSERT INTO acoes VALUES (16, 7, 'Digitação', NULL, 'index', 'get-servico,dadosnota,nota-impressa,verificar-contribuinte-optante-simples', true);
        INSERT INTO acoes VALUES (17, 7, 'Consulta', NULL, 'consulta', 'consulta-processar,email-enviar,email-enviar-post,cancelar,cancelar-post', false);
        INSERT INTO acoes VALUES (18, 8, 'Declaração sem Movimento', NULL, 'declaracao-sem-movimento', 'declaracao-sem-movimento-listar,declaracao-sem-movimento-gerar', false);
        INSERT INTO acoes VALUES (20, 8, 'Emissão DMS (Prestados)', NULL, 'emissao-dms', 'consulta,emissao-dms-lista,dms-gerar,dms-gerar-modal,reemitir-dms-guia,', false);
        INSERT INTO acoes VALUES (22, 9, 'Index', NULL, 'index', '', false);
        INSERT INTO acoes VALUES (23, 9, 'Seleciona Contribuinte', NULL, 'contribuinte', 'set-contribuinte', false);
        INSERT INTO acoes VALUES (24, 10, 'Emissão', NULL, 'index', '', true);
        INSERT INTO acoes VALUES (25, 10, 'Requisição Aidof', NULL, 'requisicao', 'gerar-requisicao,cancelar-requisicao', true);
        INSERT INTO acoes VALUES (26, 11, 'Cadastro Eventuais', NULL, 'listar-novos-cadastros', 'comparar,liberar-cadastro,liberar-cadastro-salvar,recusar-cadastro', false);
        INSERT INTO acoes VALUES (27, 13, 'Index', NULL, 'index', '', false);
        INSERT INTO acoes VALUES (28, 14, 'Cadastrar', NULL, 'novo', 'edita,remove', false);
        INSERT INTO acoes VALUES (29, 15, 'Cadastrar', NULL, 'edita', 'novo', false);
        INSERT INTO acoes VALUES (30, 16, 'Cadastro', NULL, 'index', 'remove,edita,novo', false);
        INSERT INTO acoes VALUES (31, 17, 'Verifica Sessão', NULL, 'verificar', '', false);
        INSERT INTO acoes VALUES (32, 12, 'Index', NULL, 'index', 'get,autentica', false);
        INSERT INTO acoes VALUES (33, 18, 'Index', NULL, 'index', '', false);
        INSERT INTO acoes VALUES (34, 19, 'Index', NULL, 'index', 'post,esqueci-minha-senha,esqueci-minha-senha-post,recuperar-senha,recuperar-senha-post', false);
        INSERT INTO acoes VALUES (35, 20, 'Pesquisa Cgm', NULL, 'dados-cgm', '', false);
        INSERT INTO acoes VALUES (36, 21, 'Cadastro', NULL, 'index', 'salvar,verificacao,confirmar', false);
        INSERT INTO acoes VALUES (37, 22, 'Autenticação de NFSE', NULL, 'autenticar', 'autenticar-post', false);
        INSERT INTO acoes VALUES (21, 8, 'Emissão NFSE', NULL, 'consulta-emissao-nota', 'index,competencia,fecha-competencia,reemitir', false);
        INSERT INTO acoes VALUES (19, 8, 'Emissão DMS (Tomados)', NULL, 'emissao-dms-entrada', 'consulta-emissao-dms,emissao-dms-lista,reemitir-dms-guia,dms-gerar,dms-gerar-modal', false);
        INSERT INTO acoes VALUES (38, 23, 'RPS', NULL, 'rps', 'rps-processar,rps-recibo', true);
        INSERT INTO acoes VALUES (39, 24, 'Livro Fiscal', NULL, 'livro-fiscal', 'livro-fiscal-gerar,livro-fiscal-download', false);
        INSERT INTO acoes VALUES (40, 25, 'Evolução de Arrecadação', NULL, 'evolucao-arrecadacao', 'evolucao-arrecadacao-gerar,download', false);
        INSERT INTO acoes VALUES (41, 25, 'Valores Atividade/Serviço', NULL, 'valores-atividade-servico', 'valores-atividade-servico-gerar,download', false);
        INSERT INTO acoes VALUES (42, 26, 'Declarações Sem Movimento', NULL, 'declaracoes-sem-movimento', 'declaracoes-sem-movimento-gerar,download', false);
        INSERT INTO acoes VALUES (43, 26, 'Empresas Omissas', NULL, 'empresas-omissas', 'empresas-omissas-gerar,download', false);
        INSERT INTO acoes VALUES (44, 27, 'Comparativo de Declarações', NULL, 'comparativo-declaracoes', 'comparativo-declaracoes-gerar,download', false);
        INSERT INTO acoes VALUES (45, 28, 'Comparativo de Retenções', NULL, 'comparativo-retencoes', 'comparativo-retencoes-gerar,download', false);
        INSERT INTO acoes VALUES (46, 29, 'Inconsistâncias nas Declaracoes', NULL, 'inconsistencias-declaracoes', 'inconsistencias-declaracoes-gerar,download', false);
        INSERT INTO acoes VALUES (47, 30, 'NFSe', NULL, 'nfse', 'nfse-gerar,download', false);
        INSERT INTO acoes VALUES (48, 24, 'NFSe Prestador/Tomador', NULL, 'nfse', 'nfse,nfse-gerar,download', false);
        INSERT INTO acoes VALUES (49, 31, 'Lista de Usuários', NULL, 'listar-cadastros', 'set-usuario');

        SELECT pg_catalog.setval('acoes_id_seq', 49, true);
      COMMIT;
   ";
    
    $this->execute($sSql);
  }

  public function down() {
  
    $sSql  = "
      BEGIN;
        DELETE FROM acoes where id <= 48;
        SELECT pg_catalog.setval('acoes_id_seq', 1, true);
      COMMIT;
    ";
    $this->execute($sSql);
  }
}