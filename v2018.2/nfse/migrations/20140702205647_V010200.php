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
class V010200 extends Ruckusing_Migration_Base
{
  public function up()
  {

    $sSql = "
        BEGIN;

          -- Atualiza a versão com o e-cidade
          INSERT INTO versoes VALUES ('V010200', '2.3.27');

          --Insere uma nova coluna nos parâmetros do contribuinte para ter um iss fixo
          ALTER TABLE parametroscontribuinte ADD valor_iss_fixo numeric(15,2);

          -- Adiciona controle de novo usuário
          UPDATE acoes SET sub_acoes = 'editar,get-contribuinte-cnpj' WHERE id = 10 AND id_controle = 2;
          INSERT INTO acoes (id,id_controle,acao,acaoacl,sub_acoes) VALUES (53, 2, 'Novo Usuário', 'novo', 'get-contribuinte-cnpj,get-contadores');
          INSERT INTO usuarios_acoes (id_usuario,id_acao) VALUES (1,53);

          -- Inserido tipo de perfil
          ALTER TABLE perfis ADD tipo INTEGER;
          UPDATE perfis SET tipo = 1 WHERE id IN (7,1,6,4);
          UPDATE perfis SET tipo = 2 WHERE id = 2;
          UPDATE perfis SET tipo = 3 WHERE id IN (3, 5);

          -- Insere permissões para controller do DES-IF
          INSERT INTO controles (id, id_modulo, controle, identidade, visivel) VALUES (40, 2, 'Desif', 'desif', true);
          INSERT INTO acoes (id, id_controle, acao, acaoacl, sub_acoes, gerador_dados)
            VALUES (58, 40, 'Importação Desif', 'importacao-desif', 'processar-importacao', true);

          -- Cria a tabela de importação da desif
          CREATE TABLE importacao_desif (
            id                  INTEGER     NOT NULL,
            id_contribuinte     INTEGER     NOT NULL,
            competencia_inicial VARCHAR(6)  NOT NULL,
            competencia_final   VARCHAR(6)  NOT NULL,
            versao              VARCHAR(10) NOT NULL,
            data_importacao     TIMESTAMP   NOT NULL,
            nome_arquivo        VARCHAR(200)
          );

          CREATE SEQUENCE importacao_desif_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

          ALTER TABLE ONLY importacao_desif
            ADD CONSTRAINT importacao_desif_id_pk PRIMARY KEY (id),
            ADD CONSTRAINT importacao_desif_comp_inicial_comp_final_comp_uk UNIQUE (id_contribuinte, competencia_inicial, competencia_final),
            ADD CONSTRAINT importacao_desif_id_contribuinte_fk FOREIGN KEY (id_contribuinte) REFERENCES usuarios_contribuintes(id);

          ALTER SEQUENCE importacao_desif_id_seq OWNED BY importacao_desif.id;
          ALTER TABLE ONLY importacao_desif ALTER COLUMN id SET DEFAULT nextval('importacao_desif_id_seq'::regclass);

          -- Cria tabela de contas da DES-IF
          CREATE TABLE importacao_desif_contas (
            id                         INTEGER     NOT NULL,
            id_contribuinte            INTEGER     NOT NULL,
            id_importacao_desif_conta  INTEGER,
            conta                      VARCHAR(30) NOT NULL,
            conta_cosif                VARCHAR(20) NOT NULL,
            nome                       TEXT        NOT NULL,
            descricao_conta            TEXT        NOT NULL
          );

          ALTER TABLE ONLY importacao_desif_contas ADD CONSTRAINT importacao_desif_contas_id_pk PRIMARY KEY (id),
            ADD CONSTRAINT importacao_desif_contas_id_contribuinte_fk FOREIGN KEY (id_contribuinte) REFERENCES usuarios_contribuintes(id),
            ADD CONSTRAINT importacao_desif_contas_id_importacao_desif_conta_fk FOREIGN KEY (id_importacao_desif_conta) REFERENCES importacao_desif_contas(id);

          CREATE SEQUENCE importacao_desif_contas_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
          ALTER SEQUENCE importacao_desif_contas_id_seq OWNED BY importacao_desif_contas.id;
          ALTER TABLE ONLY importacao_desif_contas ALTER COLUMN id SET DEFAULT nextval('importacao_desif_contas_id_seq'::regclass);

          -- Cria a tabela de importação das tarifas do banco
          CREATE TABLE importacao_desif_tarifas (
            id                            INTEGER     NOT NULL,
            id_importacao                 INTEGER     NOT NULL,
            id_importacao_desif_conta     INTEGER     NOT NULL,
            tarifa_banco                  VARCHAR(20) NOT NULL,
            descricao                     TEXT        NOT NULL
          );

          CREATE SEQUENCE importacao_desif_tarifas_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

          ALTER TABLE ONLY importacao_desif_tarifas
            ADD CONSTRAINT importacao_desif_tarifas_id_pk PRIMARY KEY (id),
            ADD CONSTRAINT importacao_desif_tarifas_id_importacao_fk FOREIGN KEY (id_importacao) REFERENCES importacao_desif(id),
            ADD CONSTRAINT importacao_desif_tarifas_id_importacao_desif_conta_fk FOREIGN KEY (id_importacao_desif_conta) REFERENCES importacao_desif_contas(id);

          ALTER SEQUENCE importacao_desif_tarifas_id_seq OWNED BY importacao_desif_tarifas.id;
          ALTER TABLE ONLY importacao_desif_tarifas ALTER COLUMN id SET DEFAULT nextval('importacao_desif_tarifas_id_seq'::regclass);

          -- Cria tabela com as receitas
          CREATE TABLE importacao_desif_receitas (
            id INTEGER NOT NULL,
            id_importacao_desif INTEGER NOT NULL,
            id_importacao_desif_conta INTEGER NOT NULL,
            sub_titu VARCHAR(30) NOT NULL,
            cod_trib_desif VARCHAR(20) NOT NULL,
            valr_cred_mens NUMERIC(16,2) NOT NULL,
            valr_debt_mens NUMERIC(16,2) NOT NULL,
            rece_decl NUMERIC(16,2) NOT NULL,
            dedu_rece_decl NUMERIC(16,2),
            desc_dedu VARCHAR(255),
            base_calc NUMERIC(16,2) NOT NULL,
            aliq_issqn NUMERIC(5,2) NOT NULL,
            inct_fisc NUMERIC(16,2)
          );

          CREATE SEQUENCE importacao_desif_receitas_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

          ALTER TABLE ONLY importacao_desif_receitas
            ADD CONSTRAINT importacao_desif_receitas_id_pk PRIMARY KEY (id),
            ADD CONSTRAINT importacao_desif_receitas_id_importacao_fk FOREIGN KEY (id_importacao_desif) REFERENCES importacao_desif(id),
            ADD CONSTRAINT importacao_desif_receitas_id_import_desif_conta_fk FOREIGN KEY (id_importacao_desif_conta) REFERENCES importacao_desif_contas(id),
            ADD CONSTRAINT importacao_desif_receitas_id_import_desif_conta_uk UNIQUE (id_importacao_desif, id_importacao_desif_conta);

          ALTER SEQUENCE importacao_desif_receitas_id_seq OWNED BY importacao_desif_receitas.id;
          ALTER TABLE ONLY importacao_desif_receitas ALTER COLUMN id SET DEFAULT nextval('importacao_desif_receitas_id_seq'::regclass);

          COMMIT;
      ";

    $this->execute($sSql);
  }

  public function down()
  {
    $sSql = "
        BEGIN;

         -- Atualiza a versão com o e-cidade
         DELETE FROM versoes WHERE ecidadeonline2 = 'V010200';

         --Insere uma nova coluna nos parâmetros do contribuinte para ter um iss fixo
         ALTER TABLE parametroscontribuinte DROP valor_iss_fixo;

         -- Remove controle de novo usuário
         UPDATE acoes SET sub_acoes = 'editar,novo,get-contribuinte-cnpj' WHERE id = 10 AND id_controle = 2;
         DELETE FROM usuarios_contribuintes_acoes WHERE id_acao = 53;
         DELETE FROM usuarios_acoes WHERE id_acao = 53;
         DELETE FROM acoes WHERE id = 53 AND id_controle = 2;

         -- Inserido tipo de perfil 
         ALTER TABLE perfis DROP tipo;

         -- Remove a tabela de importação da desif
         DROP TABLE importacao_desif_receitas CASCADE;
         DROP TABLE importacao_desif_tarifas CASCADE;
         DROP TABLE importacao_desif_contas CASCADE;
         DROP TABLE importacao_desif CASCADE;

         -- Detela permissão do DES-IF
         DELETE FROM usuarios_contribuintes_acoes WHERE id_acao = 58;
         DELETE FROM acoes WHERE id = 58;
         DELETE FROM controles WHERE id = 40;

        COMMIT;
      ";

    $this->execute($sSql);
  }
}
