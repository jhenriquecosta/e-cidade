<?php

class V011725AddMunicipio extends Ruckusing_Migration_Base
{
    public function up()
    {
	  $sSql = "
        begin;

        -- Atualiza a versão com o e-cidade
        INSERT INTO versoes VALUES ('V011726', '2.3.58');

        INSERT INTO municipios (cod_ibge, nome, uf) VALUES ('4220000', 'BALNEARIO RINCAO', 'SC');
        
        commit;
      ";

      $this->execute($sSql);

    }

    public function down()
    {
      $sSql = "
        begin;

        DELETE FROM municipios where cod_ibge = '4220000';

        -- Atualiza a versão com o e-cidade
        DELETE FROM versoes WHERE ecidadeonline2 = 'V011726';

        commit;
      ";

      $this->execute($sSql);
    }
}
