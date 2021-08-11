<?php

class V010700 extends Ruckusing_Migration_Base {

  public function up() {
    $sSql = "
          BEGIN;

            -- Atualiza a versão com o e-cidade
            INSERT INTO versoes VALUES ('V010700', '2.3.38');

            -- Altera a descrição do controller
            UPDATE controles SET controle = 'RPS(antigo)' WHERE id = 10;

            -- Inclui o controle novo da RPS
            INSERT INTO controles (id, id_modulo, controle, identidade, visivel)
              VALUES ((SELECT nextval('controles_id_seq'::regclass)), 2, 'RPS', 'rps-novo', true);

            -- Inclui a ação da nova rota de emissao da AIDOF Impressa da RPS
            INSERT INTO acoes
            SELECT (SELECT nextval('acoes_id_seq'::regclass)) AS id,
                   controles.id AS id_controle,
                   'Emissão' AS acao,
                   NULL AS identidade,
                   'index' AS acaoacl,
                   'aidof-impressa,emitir' AS sub_acoes,
                   true AS gerador_dados
              FROM controles
             WHERE identidade = 'rps-novo';

            -- Inclui a ação da nova rota de requisicao de AIDOF da RPS
              INSERT INTO acoes
              SELECT (SELECT nextval('acoes_id_seq'::regclass)) AS id,
                     controles.id AS id_controle,
                     'Requisição Aidof' AS acao,
                     NULL AS identidade,
                     'requisicao' AS acaoacl,
                     'gerar-requisicao,cancelar-requisicao,aidof-impressa' AS sub_acoes,
                     true AS gerador_dados
                FROM controles
               WHERE identidade = 'rps-novo';

            -- Inclui as permissões de emissao da RPS para os usuarios
            INSERT INTO usuarios_acoes
            SELECT nextval('usuarios_acoes_id_seq'::regclass) AS id,
                   id_usuario,
                   ( SELECT id
                       FROM acoes
                      WHERE id_controle IN( SELECT id
                                              FROM controles
                                             WHERE id_modulo = 2
                                               AND identidade = 'rps-novo' )
                        AND acaoacl = 'index' ) AS id_acao
              FROM usuarios_acoes
             WHERE id_acao IN( SELECT id
                                 FROM acoes
                                WHERE id_controle IN( SELECT id
                                                        FROM controles
                                                       WHERE id_modulo = 2
                                                         AND identidade = 'rps' )
                                  AND acaoacl = 'index' );

            -- Inclui as permissões de requisições da RPS para os usuarios
            INSERT INTO usuarios_acoes
            SELECT nextval('usuarios_acoes_id_seq'::regclass) AS id,
                   id_usuario,
                   ( SELECT id
                       FROM acoes
                      WHERE id_controle IN( SELECT id
                                              FROM controles
                                             WHERE id_modulo = 2
                                               AND identidade = 'rps-novo' )
                        AND acaoacl = 'requisicao' ) AS id_acao
              FROM usuarios_acoes
             WHERE id_acao IN( SELECT id
                                 FROM acoes
                                WHERE id_controle IN( SELECT id
                                                        FROM controles
                                                       WHERE id_modulo = 2
                                                         AND identidade = 'rps' )
                                  AND acaoacl = 'requisicao' );

            -- Inclui as permissões de emissao da RPS para os usuarios contribuintes
            INSERT INTO usuarios_contribuintes_acoes
            SELECT nextval('usuarios_contribuintes_acoes_id_seq'::regclass) AS id,
                   id_usuario_contribuinte,
                   ( SELECT id
                       FROM acoes
                      WHERE id_controle IN( SELECT id
                                              FROM controles
                                             WHERE id_modulo = 2
                                               AND identidade = 'rps-novo' )
                        AND acaoacl = 'index' ) AS id_acao
              FROM usuarios_contribuintes_acoes
             WHERE id_acao IN( SELECT id
                                 FROM acoes
                                WHERE id_controle IN( SELECT id
                                                        FROM controles
                                                       WHERE id_modulo = 2
                                                         AND identidade = 'rps' )
                                  AND acaoacl = 'index' );

            -- Inclui as permissões de requisição da RPS para os usuarios contribuintes
            INSERT INTO usuarios_contribuintes_acoes
            SELECT nextval('usuarios_contribuintes_acoes_id_seq'::regclass) AS id,
                   id_usuario_contribuinte,
                   ( SELECT id
                       FROM acoes
                      WHERE id_controle IN( SELECT id
                                              FROM controles
                                             WHERE id_modulo = 2
                                               AND identidade = 'rps-novo' )
                        AND acaoacl = 'requisicao' ) AS id_acao
              FROM usuarios_contribuintes_acoes
             WHERE id_acao IN( SELECT id
                                 FROM acoes
                                WHERE id_controle IN( SELECT id
                                                        FROM controles
                                                       WHERE id_modulo = 2
                                                         AND identidade = 'rps' )
                                  AND acaoacl = 'requisicao' );

            -- Inclui as ações de emissão da RPS para perfil de usuario
            INSERT INTO perfis_acoes
            SELECT nextval('perfis_acoes_id_seq'::regclass) AS id,
                   ( SELECT id
                       FROM acoes
                      WHERE id_controle IN( SELECT id
                                              FROM controles
                                             WHERE id_modulo = 2
                                               AND identidade = 'rps-novo' )
                        AND acaoacl = 'index' ) AS id_acao,
                   id_perfil
              FROM perfis_acoes
             WHERE id_acao IN( SELECT id
                                 FROM acoes
                                WHERE id_controle IN( SELECT id
                                                        FROM controles
                                                       WHERE id_modulo = 2
                                                         AND identidade = 'rps' )
                                  AND acaoacl = 'index' );

            -- Inclui as ações de requisição da RPS para perfil de usuario
            INSERT INTO perfis_acoes
            SELECT nextval('perfis_acoes_id_seq'::regclass) AS id,
                   ( SELECT id
                       FROM acoes
                      WHERE id_controle IN( SELECT id
                                              FROM controles
                                             WHERE id_modulo = 2
                                               AND identidade = 'rps-novo' )
                        AND acaoacl = 'requisicao' ) AS id_acao,
                   id_perfil
              FROM perfis_acoes
             WHERE id_acao IN( SELECT id
                                 FROM acoes
                                WHERE id_controle IN( SELECT id
                                                        FROM controles
                                                       WHERE id_modulo = 2
                                                         AND identidade = 'rps' )
                                  AND acaoacl = 'requisicao' );

            -- Remove as regras antigas da RPS de usuarios_acoes
            DELETE FROM usuarios_acoes WHERE id_acao IN( SELECT id
                                                       FROM acoes
                                                      WHERE id_controle IN(SELECT id
                                                                             FROM controles
                                                                            WHERE identidade IN('rps') ) );

            -- Remove as regras antigas da RPS de usuarios_contribuintes_acoes
            DELETE FROM usuarios_contribuintes_acoes WHERE id_acao IN( SELECT id
                                                                     FROM acoes
                                                                    WHERE id_controle IN(SELECT id
                                                                                           FROM controles
                                                                                          WHERE identidade IN('rps') ) );
            -- Remove as regras antigas da RPS de perfis_acoes
            DELETE FROM perfis_acoes WHERE id_acao IN( SELECT id
                                                     FROM acoes
                                                    WHERE id_controle IN(SELECT id
                                                                           FROM controles
                                                                          WHERE identidade IN('rps') ) );

            -- Remove as regras antigas da Nota
            DELETE FROM acoes WHERE id_controle IN( SELECT id FROM controles WHERE identidade = 'nota' AND id_modulo = 2 );
            DELETE FROM controles WHERE identidade = 'nota' AND id_modulo = 2;

          COMMIT;
      ";

    $this->execute($sSql);
  }

  public function down() {
    $sSql = "
          BEGIN;

            -- Atualiza a versão com o e-cidade
            DELETE FROM versoes WHERE ecidadeonline2 = 'V010700';

            -- Altera as ações para a versão antiga RPS
            INSERT INTO usuarios_acoes
            SELECT nextval('usuarios_acoes_id_seq'::regclass) AS id,
                   id_usuario,
                   ( SELECT id
                       FROM acoes
                      WHERE id_controle IN( SELECT id
                                              FROM controles
                                             WHERE id_modulo = 2
                                               AND identidade = 'rps' )
                        AND acaoacl = 'index' ) AS id_acao
              FROM usuarios_acoes
             WHERE id_acao IN( SELECT id
                                 FROM acoes
                                WHERE id_controle IN( SELECT id
                                                        FROM controles
                                                       WHERE id_modulo = 2
                                                         AND identidade = 'rps-novo' )
                                  AND acaoacl = 'index' );

            -- Altera as ações do contribuinte para a versão antiga RPS

            -- Remove as regras antigas da RPS de usuarios_acoes
            DELETE FROM usuarios_acoes WHERE id_acao IN( SELECT id
                                                       FROM acoes
                                                      WHERE id_controle IN(SELECT id
                                                                             FROM controles
                                                                            WHERE identidade IN('rps-novo') ) );

            -- Remove as regras antigas da RPS de usuarios_contribuintes_acoes
            DELETE FROM usuarios_contribuintes_acoes WHERE id_acao IN( SELECT id
                                                                     FROM acoes
                                                                    WHERE id_controle IN(SELECT id
                                                                                           FROM controles
                                                                                          WHERE identidade IN('rps-novo') ) );
            -- Remove as regras antigas da RPS de perfis_acoes
            DELETE FROM perfis_acoes WHERE id_acao IN( SELECT id
                                                     FROM acoes
                                                    WHERE id_controle IN(SELECT id
                                                                           FROM controles
                                                                          WHERE identidade IN('rps-novo') ) );


            -- Remove a ação do controller RpsNovo
            DELETE FROM acoes WHERE id IN( SELECT id FROM acoes WHERE id_controle IN( SELECT id FROM controles WHERE id_modulo = 2 AND identidade = 'rps-novo' ) );

            -- Remove o controle para a versão antiga RPS
            DELETE FROM controles WHERE identidade = 'rps-novo';

            -- Altera a descrição do controller para a versão antiga RPS
            UPDATE controles SET controle = 'RPS' WHERE id = 10;

          COMMIT;";
    $this->execute($sSql);
  }
}
