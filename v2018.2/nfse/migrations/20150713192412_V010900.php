<?php

class V010900 extends Ruckusing_Migration_Base {

  public function up() {

    $sSql = "
            BEGIN;

              -- Atualiza a versão com o e-cidade
              INSERT INTO versoes VALUES ('V010900', '2.3.40');

              -- Adiciona nova coluna para guardar o valor inicial da emissão
              ALTER TABLE guias ADD COLUMN valor_origem NUMERIC DEFAULT 0;

              -- Adiciona nova coluna para guardar se foi feito um pagamento parcial
              ALTER TABLE guias ADD COLUMN pagamento_parcial BOOLEAN DEFAULT FALSE;

              -- Atualiza os valores da nova coluna com o valor histórico
              UPDATE guias SET valor_origem = subquery.valor_historico
                FROM (SELECT id,
                             valor_historico
                        FROM guias) AS subquery
               WHERE guias.id = subquery.id;

              -- Adiciona nova coluna para guardar o valor total pago
              ALTER TABLE guias ADD COLUMN valor_pago NUMERIC DEFAULT 0;

              -- Atualiza os valores da nova coluna com o valor pago
              UPDATE guias SET valor_pago = subquery.valor_corrigido
                FROM (SELECT id,
                             valor_corrigido
                        FROM guias
                       WHERE situacao = 'p') AS subquery
               WHERE guias.id = subquery.id;

              -- Adiciona novo parâmetro nas configurações gerais da prefeitura
              ALTER TABLE parametrosprefeitura ADD COLUMN requisicao_nfse boolean DEFAULT FALSE;

            -- Inclui a ação da nova rota de requisição da NFS-e
            INSERT INTO acoes
            SELECT (SELECT nextval('acoes_id_seq'::regclass)) AS id,
                   controles.id AS id_controle,
                   'Requisição Aidof' AS acao,
                   NULL AS identidade,
                   'requisicao' AS acaoacl,
                   'gerar-requisicao,cancelar-requisicao' AS sub_acoes,
                   true AS gerador_dados
              FROM controles
             WHERE id_modulo = 2
              AND identidade = 'nfse';

            -- Remove menu da RPS antigo
            DELETE FROM usuarios_contribuintes_acoes WHERE id_acao IN(SELECT id FROM acoes WHERE id_controle IN(SELECT id FROM controles WHERE identidade = 'rps'));
            DELETE FROM usuarios_acoes WHERE id_acao IN(SELECT id FROM acoes WHERE id_controle IN(SELECT id FROM controles WHERE identidade = 'rps'));
            DELETE FROM acoes WHERE id_controle IN(SELECT id FROM controles WHERE identidade = 'rps');
            DELETE FROM controles WHERE identidade = 'rps';

            -- Adiciona o campo requisicao_idof informação de a nota foi emitida com o sistema de requisicao de aidof para notas
            ALTER TABLE notas ADD COLUMN \"requisicao_aidof\" BOOLEAN NOT NULL DEFAULT FALSE;
            COMMENT ON COLUMN notas.requisicao_aidof IS 'Identifica nota emitida dentro do modo de requisicao de AIDOF de notas';

            COMMIT;";
    $this->execute($sSql);
  }

  public function down() {

    $sSql = "
            BEGIN;

              -- Atualiza a versão com o e-cidade
              DELETE FROM versoes WHERE ecidadeonline2 = 'V010900';

              -- Remove nova coluna para guardar o valor inicial da emissão
              ALTER TABLE guias DROP COLUMN valor_origem;

              -- Remove nova coluna para guardar o valor pago
              ALTER TABLE guias DROP COLUMN valor_pago;

              -- Remove nova coluna para guardar se possui algum pagamento parcial
              ALTER TABLE guias DROP COLUMN pagamento_parcial;

              -- Remove nova coluna do novo parâmetro nas configurações gerais da prefeitura
              ALTER TABLE parametrosprefeitura DROP COLUMN requisicao_nfse;

              -- Remove a ação nova de requisição da NFS-e
              DELETE FROM usuarios_contribuintes_acoes WHERE id_acao IN(SELECT id FROM acoes WHERE id_controle IN(SELECT id FROM controles WHERE id_modulo = 2 AND identidade = 'nfse') AND acaoacl = 'requisicao');
              DELETE FROM usuarios_acoes WHERE id_acao IN(SELECT id FROM acoes WHERE id_controle IN(SELECT id FROM controles WHERE id_modulo = 2 AND identidade = 'nfse') AND acaoacl = 'requisicao');
              DELETE FROM acoes WHERE id_controle IN(SELECT id FROM controles WHERE id_modulo = 2 AND identidade = 'nfse') AND acaoacl = 'requisicao';

              -- Remove requisição aidof da nota
              ALTER TABLE notas DROP COLUMN \"requisicao_aidof\";

            COMMIT;";
    $this->execute($sSql);
  }
}
