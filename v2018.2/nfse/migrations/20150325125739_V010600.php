<?php

class V010600 extends Ruckusing_Migration_Base {

  public function up() {
    $sSql = "
          BEGIN;

            -- Atualiza a versão com o e-cidade
            INSERT INTO versoes VALUES ('V010600', '2.3.36');

            -- Cria tabela de configuração do valor aprox. dos tributos
            CREATE TABLE parametroscontribuinte_tributos (
              id INTEGER NOT NULL,
              id_contribuinte INTEGER NOT NULL,
              ano INTEGER NOT NULL,
              percentual_tributos FLOAT NOT NULL,
              fonte_tributacao VARCHAR(80)
            );

            CREATE SEQUENCE parametroscontribuinte_tributos_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

            ALTER TABLE ONLY parametroscontribuinte_tributos
              ADD CONSTRAINT parametroscontribuinte_tributos_id_pk PRIMARY KEY (id),
              ADD CONSTRAINT parametroscontribuinte_tributos_id_contribuinte_fk FOREIGN KEY (id_contribuinte) REFERENCES usuarios_contribuintes(id),
              ADD CONSTRAINT parametroscontribuinte_tributos_id_cntr_ano_uk UNIQUE (id_contribuinte, ano);

            ALTER SEQUENCE parametroscontribuinte_tributos_id_seq OWNED BY parametroscontribuinte_tributos.id;
            ALTER TABLE ONLY parametroscontribuinte_tributos ALTER COLUMN id SET DEFAULT nextval('parametroscontribuinte_tributos_id_seq'::regclass);

            -- Adiciona nova action na rotina dos parametros do contribuinte
            UPDATE acoes SET sub_acoes = 'buscar-tributacao' WHERE id_controle = 6;

            -- Adiciona permissão de administrador para o usuário dbseller
            UPDATE usuarios SET administrativo = true, tipo = 1, id_perfil = 5 WHERE login = 'dbseller';

          COMMIT;
      ";

    $this->execute($sSql);
  }

  public function down() {
    $sSql = "
          BEGIN;

            -- Atualiza a versão com o e-cidade
            DELETE FROM versoes WHERE ecidadeonline2 = 'V010600';

            -- Remove tabela de configuração do valor aprox. dos tributos
            DROP TABLE parametroscontribuinte_tributos CASCADE;

            -- Remove nova action na rotina dos parametros do contribuinte
            UPDATE acoes SET sub_acoes = '' WHERE id_controle = 6;

            -- Remove a permissão de administrador para o usuário dbseller
            UPDATE usuarios SET administrativo = false, tipo = 3, id_perfil = 5 WHERE login = 'dbseller';

          COMMIT;";
    $this->execute($sSql);
  }
}
