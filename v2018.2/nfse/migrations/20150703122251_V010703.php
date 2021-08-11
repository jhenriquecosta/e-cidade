<?php

class V010703 extends Ruckusing_Migration_Base {

  public function up() {

    $sSql = "
          BEGIN;

            -- Inclui no conta da COS-IF/DES-IF
            INSERT INTO plano_contas_abrasf(conta_abrasf, titulo_contabil_desc, tributavel, versao) VALUES ('70000009', 'DEMONSTRATIVO DE RENDAS', false, '1.00');

          COMMIT;
      ";
    $this->execute($sSql);
  }

  public function down() {

    $sSql = "
          BEGIN;

            -- Remove a conta da COS-IF/DES-IF
            DELETE FROM plano_contas_abrasf WHERE conta_abrasf = '70000009';

          COMMIT;";
    $this->execute($sSql);
  }
}
