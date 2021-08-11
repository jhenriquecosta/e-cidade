<?php

class V011500 extends Ruckusing_Migration_Base {
  public function up() {
    $sSql ="
            BEGIN;

              -- Atualiza a versão com o e-cidade
              INSERT INTO versoes VALUES ('V011500', '2.3.50');

              -- DESIF
              -- inclui novo metodo para reemitir guias de desif
              update acoes set sub_acoes = 'emitir-guia,geracao,geracao-detalhes,reemitir' where id = 61;

              insert into usuarios_contribuintes_acoes select nextval('usuarios_contribuintes_acoes_id_seq'), id, 50 from usuarios_contribuintes where habilitado = true;
              update controles set id_modulo = 2 where id = 32;

              insert into perfis_acoes select nextval('perfis_acoes_id_seq'), 50, id from perfis where id not in (3);

              alter table importacao_desif add arquivo_hash character varying(200);
              
              update controles set visivel = true where id in (42, 40, 38);
               
              alter table importacao_desif_receitas alter COLUMN valr_cred_mens drop not null;

            COMMIT;";
    $this->execute($sSql);
  }

  public function down() {
    $sSql = "
            BEGIN;

              -- Downgrade de a versão com o e-cidade
              DELETE FROM versoes WHERE ecidadeonline2 = 'V011500';

              -- DESIF
              -- inclui novo metodo para reemitir guias de desif
              update acoes set sub_acoes = 'emitir-guia,geracao,geracao-detalhes' where id = 61;

              delete from usuarios_contribuintes_acoes where id_acao = 50;
              update controles set id_modulo = 1 where id = 32;

              delete from perfis_acoes where id_acao = 50 and id_perfil not in (3);

              alter table importacao_desif drop column arquivo_hash ;
              
              update controles set visivel = false where id in (42, 40, 38);

              alter table importacao_desif_receitas alter COLUMN valr_cred_mens set not null;

            COMMIT;";
    $this->execute($sSql);

  }
}