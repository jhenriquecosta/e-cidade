<?php

class V011000 extends Ruckusing_Migration_Base {

  public function up() {

    $sSql = "
            BEGIN;

              -- Atualiza a versão com o e-cidade
              INSERT INTO versoes VALUES ('V011000', '2.3.41');

              -- Novos campos da nota
              -- Adiciona o campo t_cidade_estado informação de endereço do tomador fora do pais
              ALTER TABLE notas ADD COLUMN \"t_cidade_estado\" character varying(100);
              COMMENT ON COLUMN notas.t_cidade_estado IS 'Identifica cidade e estado do tomador quando de fora do brasil';

              -- Adiciona o campo s_dados_cidade_estado informação de endereço de incidencia do servico fora do pais
              ALTER TABLE notas ADD COLUMN \"s_dados_cidade_estado\" character varying(100);
              COMMENT ON COLUMN notas.s_dados_cidade_estado IS 'Identifica cidade e estado de incidencia do servico fora do pais';

              -- Adiciona o campo s_dados_fora_incide flag para definir se incide tributação quando o servico/tomador é fora do pais
              ALTER TABLE notas ADD COLUMN \"s_dados_fora_incide\" BOOLEAN NOT NULL DEFAULT FALSE;
              COMMENT ON COLUMN notas.s_dados_fora_incide IS 'Identifica se incide tributacao quando servico/tomador for fora do pais';

              -- Define ao pais do tomador das notas emitidas antes da melhoria
              UPDATE notas SET t_cod_pais = '01058' WHERE t_cod_pais IS NULL AND t_cod_municipio IS NOT NULL;

              -- Define ao pais do servico das notas emitidas antes da melhoria
              UPDATE notas SET s_dados_cod_pais = '01058' WHERE s_dados_cod_pais IS NULL AND s_dados_cod_municipio IS NOT NULL;

            COMMIT;";
    $this->execute($sSql);
  }

  public function down() {

    $sSql = "
            BEGIN;

              -- Atualiza a versão com o e-cidade
              DELETE FROM versoes WHERE ecidadeonline2 = 'V011000';

              -- Remove os novos campos da Nota
              --
              ALTER TABLE notas DROP COLUMN \"t_cidade_estado\";
              ALTER TABLE notas DROP COLUMN \"s_dados_cidade_estado\";
              ALTER TABLE notas DROP COLUMN \"s_dados_fora_incide\";

            COMMIT;";
    $this->execute($sSql);
  }
}
