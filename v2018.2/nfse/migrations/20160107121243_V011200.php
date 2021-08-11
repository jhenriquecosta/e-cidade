<?php

class V011200 extends Ruckusing_Migration_Base {
  public function up() {
    $sSql = "
            BEGIN;

              -- Atualiza a versão com o e-cidade
              INSERT INTO versoes VALUES ('V011200', '2.3.46');

              -- Cria coluna para indentificando se o tomador é cooperado
              alter table notas add column t_cooperado boolean default false;
              comment on column notas.t_cooperado is 'Identifica quando tomador é cooperado';

            COMMIT;";
    $this->execute($sSql);
  }

  public function down() {
    $sSql = "
            BEGIN;

              -- Atualiza a versão com o e-cidade
              DELETE FROM versoes WHERE ecidadeonline2 = 'V011200';

              -- Remove coluna para indentificando se o tomador é cooperado
              alter table notas drop column t_cooperado;

            COMMIT;";
    $this->execute($sSql);

  }
}