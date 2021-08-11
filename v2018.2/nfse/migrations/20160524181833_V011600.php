<?php

class V011600 extends Ruckusing_Migration_Base
{
    public function up()
    {

      $sSql = "
        BEGIN;

          -- Atualiza a versão com o e-cidade
          INSERT INTO versoes VALUES ('V011600', '2.3.52');

          -- Encerramento Competencia
          -- Cria tabela da competência
          CREATE TABLE competencias (
            id INT4 NOT NULL ,
            id_contribuinte INT4 NOT NULL,
            tipo INT4 NOT NULL,
            mes INT4 NOT NULL,
            ano INT4 NOT NULL,
            data_fechamento date NOT NULL,
            situacao INT4 NOT NULL,
            CONSTRAINT competencias_id_pk PRIMARY KEY (id),
            CONSTRAINT competencias_id_contribuinte_fk FOREIGN KEY (id_contribuinte) REFERENCES usuarios_contribuintes(id)
          );

          CREATE SEQUENCE competencias_id_seq
                INCREMENT 1
                 MINVALUE 1
                 MAXVALUE 9223372036854775807
                    START 1
                    CACHE 1
                 OWNED BY competencias.id;

          -- Adiciona competencia na tabela guias
          ALTER TABLE guias ADD COLUMN id_competencia INT4;
          ALTER TABLE guias ADD CONSTRAINT guias_id_competencias_fk FOREIGN KEY (id_competencia) REFERENCES competencias(id);

          -- Insere competencia na tabela de controles
          INSERT INTO controles VALUES ( 47, 2, 'Competencia', 'competencia', 't' );
          select setval('controles_id_seq', 47);

          INSERT INTO acoes VALUES (73, 47, 'NFS-e Encerramento', NULL, 'nfse-encerramento', 'detalhes,confirmar-encerramento,encerrar-competencia', 't');
          select setval('acoes_id_seq', 73);

          -- Insere usuarios e acao na tabela usuarios_acoes
          INSERT INTO usuarios_acoes
               SELECT nextval('usuarios_acoes_id_seq'),
                      id_usuario,
                      73
                 from usuarios_acoes where id_acao = 21;

          -- Insere usuarios e acao na tabela usuarios_contribuintes_acoes
          INSERT INTO usuarios_contribuintes_acoes
               SELECT nextval('usuarios_contribuintes_acoes_id_seq'),
                      id_usuario_contribuinte,
                      73 from usuarios_contribuintes_acoes
                where id_acao = 21;

          -- Insere acao no perfil do contribuinte
          insert into perfis_acoes (id, id_acao, id_perfil) values(nextval('perfis_acoes_id_seq'), 73, 1);

          -- Retiramos a permissão principal do menu de Geração de Guias
          update acoes set sub_acoes = 'competencia,fecha-competencia,reemitir' where id = 21;

          -- Fechamos as competências de todas as guias geradas
          insert into competencias
               select nextval('competencias_id_seq'::regclass),
                      id_contribuinte,
                      tipo_documento_origem,
                      mes_comp,
                      ano_comp,
                      data_fechamento,
                      4
                 from guias
                where tipo_documento_origem = 10
             order by data_fechamento;

          -- Vincula as competencias fechadas as guias ja existentes
          UPDATE guias
            SET id_competencia = competencias.id
            FROM competencias
            WHERE competencias.id_contribuinte = guias.id_contribuinte
              AND competencias.ano = guias.ano_comp
              AND competencias.mes = guias.mes_comp
              AND competencias.tipo = guias.tipo_documento_origem;

        COMMIT;";

      $this->execute($sSql);

    }

    public function down()
    {

      $sSql = "
              BEGIN;

                -- Downgrade de a versão com o e-cidade
                DELETE FROM versoes WHERE ecidadeonline2 = 'V011600';

                -- Encerramento Competencia

                -- Deletamos a estrutura de competências
                ALTER TABLE guias DROP CONSTRAINT guias_id_competencias_fk;
                ALTER TABLE guias DROP COLUMN id_competencia;
                DROP TABLE competencias;

                -- Inserimos a permissão principal do menu de Geração de Guias
                update acoes set sub_acoes = 'index,competencia,fecha-competencia,reemitir' where id = 21;

                -- Deletamos as permissões dos usuarios na tabela usuarios_acoes com permissao 73
                DELETE FROM usuarios_acoes WHERE id_acao = 73;

                -- Deletamos as permissões dos usuarios na tabela usuarios_contribuintes_acoes com permissao 73
                DELETE FROM usuarios_contribuintes_acoes WHERE id_acao = 73;

                -- Deleta de perfis_acoes a acao 73 NFS-e Encerramento do perfil de contribuinte
                DELETE FROM perfis_acoes where id_acao = 73;

                -- Deleta a acao de Encerramento de Nfse
                DELETE FROM acoes where id = 73;

                -- Deleta o controller competencia
                DELETE FROM controles where id = 47;

              COMMIT;";
      $this->execute($sSql);
    }
}
