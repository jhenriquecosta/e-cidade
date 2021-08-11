<?php

class V011100 extends Ruckusing_Migration_Base
{
    public function up() {
      $sSql = "
              BEGIN;

                -- Atualiza a versão com o e-cidade
                INSERT INTO versoes VALUES ('V011100', '2.3.43');

              COMMIT;";
      $this->execute($sSql);
    }

    public function down() {
      $sSql = "
              BEGIN;

                -- Atualiza a versão com o e-cidade
                DELETE FROM versoes WHERE ecidadeonline2 = 'V011100';

              COMMIT;";
      $this->execute($sSql);

    }
}
