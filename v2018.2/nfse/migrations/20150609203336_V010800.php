<?php

class V010800 extends Ruckusing_Migration_Base {

  public function up() {

    $sSql = "
            BEGIN;

              -- Atualiza a versão com o e-cidade
              INSERT INTO versoes VALUES ('V010800', '2.3.39');

              -- Adiciona o campo s_nao_incide para gravar se a atividade é de grupo não incidente de tributação
              ALTER TABLE notas ADD COLUMN \"s_nao_incide\" BOOLEAN NOT NULL DEFAULT FALSE;
              COMMENT ON COLUMN notas.s_nao_incide IS 'Grupo de serviço Não Incide tributação';

              -- Adiciona o campo s_dados_exigibilidadeiss para gravar a exigibilidade do contribuinte quando emitiu a nota
              COMMENT ON COLUMN notas.s_dados_exigibilidadeiss IS 'Código de exigibilidade do contribuinte vindo do e-cidade';

              -- Adiciona o campo s_dec_reg_esp_tributacao para gravar o regime do contribuinte quando emitiu a nota
              COMMENT ON COLUMN notas.s_dec_reg_esp_tributacao IS 'Código do regime tributário do contribuinte vindo do e-cidade';

              -- Adiciona o campo webservice para verificar as notas emitidas pelo webservice
              ALTER TABLE notas ADD COLUMN \"webservice\" BOOLEAN NOT NULL DEFAULT FALSE;
              COMMENT ON COLUMN notas.webservice IS 'Identificador se a nota foi emitida pelo webservice.';

              -- Adiciona o campo p_categoria_simples_nacional informação da categoria do simples nacional
              ALTER TABLE notas ADD COLUMN \"p_categoria_simples_nacional\" INT NOT NULL DEFAULT 0;
              COMMENT ON COLUMN notas.p_categoria_simples_nacional IS 'Identificador da categoria do simples nacional: 0->Normal 1->Micro Empresa 2->Empresa de Pequeno Porte 3->MEI';

            COMMIT;";
    $this->execute($sSql);
  }

  public function down() {

    $sSql = "
            BEGIN;

              -- Atualiza a versão com o e-cidade
              DELETE FROM versoes WHERE ecidadeonline2 = 'V010800';

              -- Remove o campo s_nao_incide
              ALTER TABLE notas DROP COLUMN \"s_nao_incide\";

              -- Remove o campo webservice
              ALTER TABLE notas DROP COLUMN \"webservice\";

              -- Remove o campo p_categoria_simples_nacional
              ALTER TABLE notas DROP COLUMN \"p_categoria_simples_nacional\";

            COMMIT;";
    $this->execute($sSql);
  }
}
