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

class V010103 extends Ruckusing_Migration_Base
{
    public function up()
    {

      $sSql = "
        BEGIN;

          -- Atualiza a versão com o e-cidade
          INSERT INTO versoes VALUES ('V010103', '2.3.26');
          -- Adicionado permissões para a recusa do cadastro eventual
          UPDATE acoes SET sub_acoes = 'comparar,liberar-cadastro,liberar-cadastro-salvar,recusar-cadastro,recusar-cadastro-salvar' WHERE id = 26;

          update acoes set sub_acoes = 'aidof-impressa' where id = 24;
          
          -- Criando tabela para informativo
          CREATE TABLE informativo (
            id        integer not null,
            descricao text
          );

          ALTER TABLE ONLY informativo ADD CONSTRAINT informativo_pkey PRIMARY KEY (id);
          
          -- INSERIR VALOR PADRÃO NA TABELA INFORMATIVO
          INSERT INTO informativo(id, descricao) VALUES (1, '');
          
          -- Adiciona rotina de inserção e consulta do informativo ao menu do módulo administrativo
          INSERT INTO controles (id,id_modulo,controle,identidade,visivel) VALUES (35,6,'Informativo','informativo',true);
          INSERT INTO acoes (id,id_controle,acao,acaoacl,sub_acoes) VALUES (54,35,'Inserção de Informativo','form','form-salvar');
          INSERT INTO perfis_acoes (id_acao,id_perfil) VALUES (54,5);

          -- Adiciona rotina de exportação de RPS para arquivo XML do módulo contribuinte
          INSERT INTO controles (id,id_modulo,controle,identidade,visivel) VALUES (36,2,'Exportação Arquivo','exportacao-arquivo',true);
          INSERT INTO acoes (id,id_controle,acao,acaoacl,sub_acoes) VALUES (55,36,'Exportação de RPS','rps','rps-consultar,rps-exportar,download');

          -- Alterado label de exibição da importação de RPS
          UPDATE acoes set acao = 'Importação de RPS' WHERE id = 38;

          -- Adiciona rotina de geração automatica para o módulo fiscal
          INSERT INTO controles (id,id_modulo,controle,identidade,visivel) VALUES (37,6,'Guias','guias',true);
          INSERT INTO acoes (id,id_controle,acao,acaoacl,sub_acoes) VALUES (56,37,'Geração Automatica','geracao-automatica','consultar,gerar');

          -- Cria os indices por ano e mês de competência na tabela guias
          CREATE INDEX guias_mes_comp_in ON guias(mes_comp);
          CREATE INDEX guias_ano_comp_in ON guias(ano_comp);
          
          -- Adiciona coluna para inserir setor e secretaria nas impressões pdf 
          ALTER TABLE parametrosprefeitura ADD setor character varying;
          ALTER TABLE parametrosprefeitura ADD secretaria character varying;
          
          UPDATE acoes SET sub_acoes = 'gerar-requisicao,cancelar-requisicao,aidof-impressa' where id = 25;
          
          INSERT INTO controles (id, id_modulo, controle, identidade, visivel) VALUES  (39, 6, 'Relatório Nfse Período', 'relatorio-nfse-periodo', true);
          INSERT INTO acoes (id,id_controle,acao,acaoacl,sub_acoes) values (57, 39, 'Index', 'index', 'consultar,download');

        COMMIT;
      ";

      $this->execute($sSql);
    }

    public function down()
    {

      $sSql = "
        BEGIN;

          DELETE FROM versoes WHERE ecidadeonline2 = 'V010103';
          DROP TABLE informativo CASCADE;
          DELETE FROM usuarios_acoes WHERE id_acao = 54;
          DELETE FROM perfis_acoes WHERE id_acao = 54 and id_perfil = 5;
          DELETE FROM acoes WHERE id = 54;
          DELETE FROM controles WHERE id = 35;
          DELETE FROM usuarios_contribuintes_acoes WHERE id_acao = 55;
          DELETE FROM acoes WHERE id = 55;
          DELETE FROM controles WHERE id = 36;
          DELETE FROM usuarios_acoes where id_acao = 56;
          DELETE FROM acoes WHERE id = 56;
          DELETE FROM controles WHERE id = 37;
          DROP INDEX guias_mes_comp_in;
          DROP INDEX guias_ano_comp_in;
          
          DELETE FROM acoes where id = 57;
          DELETE FROM controles where id = 39;

        COMMIT;
      ";

      $this->execute($sSql);
    }
}
