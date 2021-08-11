<?php

class V011700PHP56 extends Ruckusing_Migration_Base
{
    public function up()
    {

      $sSql = "
        BEGIN;

          -- Atualiza a versão com o e-cidade
          INSERT INTO versoes VALUES ('V011700', '2.3.52');

          COMMIT;";

      $this->execute($sSql);
    }

    public function down()
    {

      $sSql = "
        BEGIN;

          -- Downgrade de a versão com o e-cidade
          DELETE FROM versoes WHERE ecidadeonline2 = 'V011700';

          COMMIT;";
      $this->execute($sSql);
    }
}
