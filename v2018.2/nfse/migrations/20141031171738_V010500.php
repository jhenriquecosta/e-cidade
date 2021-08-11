<?php

class V010500 extends Ruckusing_Migration_Base
{
    public function up() {
      $sSql = "
          BEGIN;

            -- Atualiza a versão com o e-cidade
            INSERT INTO versoes VALUES ('V010500', '2.3.30');

            -- Adiciona parametro para o usuario 'pincipal'
            ALTER TABLE usuarios ADD principal BOOLEAN NOT NULL DEFAULT false;

            -- Adiciona campos para o controle de tentativas de login para o usuario
            ALTER TABLE usuarios ADD tentativa INTEGER NOT NULL DEFAULT 0;
            ALTER TABLE usuarios ADD data_tentativa TIMESTAMP;

            -- Adiciona parametrosprefeitura 'tempo_bloqueio'
            ALTER TABLE parametrosprefeitura ADD tempo_bloqueio INTEGER NOT NULL DEFAULT 1;

            -- Altera a descrição da ação
            UPDATE controles SET controle = 'NFSe(antigo)' WHERE id = 7;

            -- Inclui o controle novo da Nfse
            INSERT INTO controles (id_modulo,controle,identidade,visivel) VALUES (2,'NFSe','nfse',true);

            -- Inclui a ação da nova rota de consulta da Nfse
            INSERT INTO acoes
            SELECT nextval('acoes_id_seq'::regclass),
                   id AS id_controle,
                   'Consulta',
                   NULL,
                   'consulta',
                   'consulta-processar,email-enviar,email-enviar-post,cancelar,cancelar-post',
                   false
              FROM controles
             WHERE id_modulo = 2
               AND identidade = 'nfse';

            -- Inclui a ação da nova rota de emissao da Nfse
            INSERT INTO acoes
            SELECT nextval('acoes_id_seq'::regclass),
                   id AS id_controle,
                   'Digitação',
                   NULL,
                   'index',
                   'get-servico,dados-nota,nota-impressa,verificar-contribuinte-optante-simples,define-lista-atividades,emitir',
                   true
              FROM controles
             WHERE id_modulo = 2
               AND identidade = 'nfse';

            -- Inclui as permissões de emissao da Nfse para os usuarios
            INSERT INTO usuarios_acoes
            SELECT nextval('usuarios_acoes_id_seq'::regclass) AS id,
                   id_usuario,
                   ( SELECT id
                       FROM acoes
                      WHERE id_controle IN( SELECT id
                                              FROM controles
                                             WHERE id_modulo = 2
                                               AND identidade = 'nfse' )
                        AND acaoacl = 'index' ) AS id_acao
              FROM usuarios_acoes
             WHERE id_acao = 16;

            -- Inclui as permissões de consulta da Nfse para os usuarios
            INSERT INTO usuarios_acoes
            SELECT nextval('usuarios_acoes_id_seq'::regclass) AS id,
                   id_usuario,
                   ( SELECT id
                       FROM acoes
                      WHERE id_controle IN( SELECT id
                                              FROM controles
                                             WHERE id_modulo = 2
                                               AND identidade = 'nfse' )
                        AND acaoacl = 'consulta' ) AS id_acao
              FROM usuarios_acoes
             WHERE id_acao = 17;

            -- Inclui as permissões de emissao da Nfse para os usuarios contribuintes
            INSERT INTO usuarios_contribuintes_acoes
            SELECT nextval('usuarios_contribuintes_acoes_id_seq'::regclass) AS id,
                   id_usuario_contribuinte,
                   ( SELECT id
                       FROM acoes
                      WHERE id_controle IN( SELECT id
                                              FROM controles
                                             WHERE id_modulo = 2
                                               AND identidade = 'nfse' )
                        AND acaoacl = 'index' ) AS id_acao
              FROM usuarios_contribuintes_acoes
             WHERE id_acao = 16;

            -- Inclui as permissões de consulta da Nfse para os usuarios contribuintes
            INSERT INTO usuarios_contribuintes_acoes
            SELECT nextval('usuarios_contribuintes_acoes_id_seq'::regclass) AS id,
                   id_usuario_contribuinte,
                   ( SELECT id
                       FROM acoes
                      WHERE id_controle IN( SELECT id
                                              FROM controles
                                             WHERE id_modulo = 2
                                               AND identidade = 'nfse' )
                        AND acaoacl = 'consulta' ) AS id_acao
              FROM usuarios_contribuintes_acoes
             WHERE id_acao = 17;

            -- Inclui as ações de emissão da Nfse para perfil de usuario
            INSERT INTO perfis_acoes
            SELECT nextval('perfis_acoes_id_seq'::regclass) AS id,
                   ( SELECT id
                       FROM acoes
                      WHERE id_controle IN( SELECT id
                                              FROM controles
                                             WHERE id_modulo = 2
                                               AND identidade = 'nfse' )
                        AND acaoacl = 'index' ) AS id_acao,
                   id_perfil
              FROM perfis_acoes
             WHERE id_acao = 16;

            -- Inclui as ações de consulta da Nfse para perfil de usuario
            INSERT INTO perfis_acoes
            SELECT nextval('perfis_acoes_id_seq'::regclass) AS id,
                   ( SELECT id
                       FROM acoes
                      WHERE id_controle IN( SELECT id
                                              FROM controles
                                             WHERE id_modulo = 2
                                               AND identidade = 'nfse' )
                        AND acaoacl = 'consulta' ) AS id_acao,
                   id_perfil
              FROM perfis_acoes
             WHERE id_acao = 17;

            -- Remove as regras antigas
            DELETE FROM usuarios_acoes WHERE id_acao IN(16, 17);
            DELETE FROM usuarios_contribuintes_acoes WHERE id_acao IN(16, 17);
            DELETE FROM perfis_acoes WHERE id_acao IN(16, 17);

            -- Atualiza permissões copiar nota
            UPDATE acoes set sub_acoes = 'get-servico,dados-nota,nota-impressa,verificar-contribuinte-optante-simples,define-lista-atividades,emitir,obtem-dados-nota' WHERE id = 68;

            -- Define todos os usuarios com login = cnpj como principal
            update usuarios set principal=true where login=cnpj;

          COMMIT;
      ";

      $this->execute($sSql);
    }

    public function down() {
      $sSql = "
          BEGIN;

            -- Atualiza a versão com o e-cidade
            DELETE FROM versoes WHERE ecidadeonline2 = 'V010500';

            -- Remove parametro para o usuario 'pincipal'
            ALTER TABLE usuarios DROP principal;

            -- Remove campos de controle de tentativas de login do usuario
            ALTER TABLE usuarios DROP tentativas;
            ALTER TABLE usuarios DROP data_tentativa;

            -- Remove parametrosprefeitura 'tempo_bloqueio'
            ALTER TABLE parametrosprefeitura DROP tempo_bloqueio;

            -- Inclui as permissões de emissao da Nfse para os usuarios
            INSERT INTO usuarios_acoes
            SELECT nextval('usuarios_acoes_id_seq'::regclass) AS id,
                   id_usuario,
                   16 AS id_acao
              FROM usuarios_acoes
             WHERE id_acao IN( SELECT id
                                 FROM acoes
                                WHERE id_controle IN( SELECT id
                                                        FROM controles
                                                       WHERE id_modulo = 2
                                                         AND identidade = 'nfse' )
                                  AND acaoacl = 'index' );

            -- Inclui as permissões de consulta da Nfse para os usuarios
            INSERT INTO usuarios_acoes
            SELECT nextval('usuarios_acoes_id_seq'::regclass) AS id,
                   id_usuario,
                   17 AS id_acao
              FROM usuarios_acoes
             WHERE id_acao IN( SELECT id
                                 FROM acoes
                                WHERE id_controle IN( SELECT id
                                                        FROM controles
                                                       WHERE id_modulo = 2
                                                         AND identidade = 'nfse' )
                                  AND acaoacl = 'consulta' );

            -- Inclui as permissões de emissao da Nfse para os usuarios contribuintes
            INSERT INTO usuarios_contribuintes_acoes
            SELECT nextval('usuarios_contribuintes_acoes_id_seq'::regclass) AS id,
                   id_usuario_contribuinte,
                   16 AS id_acao
              FROM usuarios_contribuintes_acoes
             WHERE id_acao IN( SELECT id
                                 FROM acoes
                                WHERE id_controle IN( SELECT id
                                                        FROM controles
                                                       WHERE id_modulo = 2
                                                         AND identidade = 'nfse' )
                                  AND acaoacl = 'index' );

            -- Inclui as permissões de consulta da Nfse para os usuarios contribuintes
            INSERT INTO usuarios_contribuintes_acoes
            SELECT nextval('usuarios_contribuintes_acoes_id_seq'::regclass) AS id,
                   id_usuario_contribuinte,
                   17 AS id_acao
              FROM usuarios_contribuintes_acoes
             WHERE id_acao IN( SELECT id
                                 FROM acoes
                                WHERE id_controle IN( SELECT id
                                                        FROM controles
                                                       WHERE id_modulo = 2
                                                         AND identidade = 'nfse' )
                                  AND acaoacl = 'consulta' );

            -- Inclui as ações de emissão da Nfse para perfil de usuario
            INSERT INTO perfis_acoes
            SELECT nextval('perfis_acoes_id_seq'::regclass) AS id,
                   16 AS id_acao,
                   id_perfil
              FROM perfis_acoes
             WHERE id_acao IN( SELECT id
                                 FROM acoes
                                WHERE id_controle IN( SELECT id
                                                        FROM controles
                                                       WHERE id_modulo = 2
                                                         AND identidade = 'nfse' )
                                  AND acaoacl = 'index' );

            -- Inclui as ações de consulta da Nfse para perfil de usuario
            INSERT INTO perfis_acoes
            SELECT nextval('perfis_acoes_id_seq'::regclass) AS id,
                   17 AS id_acao,
                   id_perfil
              FROM perfis_acoes
             WHERE id_acao IN( SELECT id
                                 FROM acoes
                                WHERE id_controle IN( SELECT id
                                                        FROM controles
                                                       WHERE id_modulo = 2
                                                         AND identidade = 'nfse' )
                                  AND acaoacl = 'consulta' );

            -- Remove as novas regras do menu
            DELETE FROM usuarios_acoes WHERE id_acao IN( SELECT id FROM acoes WHERE id_controle IN( SELECT id FROM controles WHERE id_modulo = 2 AND identidade = 'nfse' ) );
            DELETE FROM usuarios_contribuintes_acoes WHERE id_acao IN( SELECT id FROM acoes WHERE id_controle IN( SELECT id FROM controles WHERE id_modulo = 2 AND identidade = 'nfse' ) );
            DELETE FROM perfis_acoes WHERE id_acao IN( SELECT id FROM acoes WHERE id_controle IN( SELECT id FROM controles WHERE id_modulo = 2 AND identidade = 'nfse' ) );

            -- Remove a ação de consultar e emitir da nova rota da Nfse
            DELETE FROM acoes WHERE id IN( SELECT id FROM acoes WHERE id_controle IN( SELECT id FROM controles WHERE id_modulo = 2 AND identidade = 'nfse' ) );

            -- Remove o controle novo da Nfse
            DELETE FROM controles WHERE id_modulo = 2 AND controle = 'NFSe' AND identidade = 'nfse' AND visivel = true;

            -- Altera a descrição da ação
            UPDATE controles SET controle = 'NFSe' WHERE id = 7;

            -- Remove permissão copiar nota
            UPDATE acoes set sub_acoes = 'get-servico,dados-nota,nota-impressa,verificar-contribuinte-optante-simples,define-lista-atividades,emitir' WHERE id = 68;

          COMMIT;";
      $this->execute($sSql);
    }
}
