<?php

class V010607 extends Ruckusing_Migration_Base {

  public function up() {
    $sSql = "
          BEGIN;

            -- Cria PLSQL responsavel por encontar os cancelamentos duplicados e remover o último registro
            CREATE OR REPLACE FUNCTION removeCancelamentoDuplicado() RETURNS INT AS
            \$BODY\$
            DECLARE
              total INT;
              retorno INT;
              recordset RECORD;
            BEGIN
              retorno := 0;
              FOR recordset IN
                  SELECT b.id
                    FROM ( SELECT max(id) AS id,
                                  id_nota,
                                  id_usuario
                             FROM cancelamento_notas
                            WHERE id_nota in( SELECT id_nota
                                                FROM cancelamento_notas
                                            GROUP BY id_nota
                                              HAVING count(id_nota) > 1 )
                         GROUP BY id_nota,
                                  id_usuario
                         ORDER BY id_usuario ) AS b
              LOOP
                retorno := retorno+1;
                DELETE FROM cancelamento_notas WHERE id = recordset.id;
              END LOOP;
              IF (retorno > 0) THEN
                  retorno := ( SELECT * FROM removeCancelamentoDuplicado() );
                  RETURN retorno;
              ELSE
                  RETURN retorno; 
              END IF;
            END
            \$BODY\$
            LANGUAGE 'plpgsql';

            -- Executa a PLSQL e cria uma chave única por nota no cancelamento
            SELECT * FROM removeCancelamentoDuplicado();
            ALTER TABLE ONLY cancelamento_notas ADD CONSTRAINT cancelamento_notas_id_nota_uk UNIQUE (id_nota);

          COMMIT;
      ";

    $this->execute($sSql);
  }

  public function down() {
    $sSql = "
          BEGIN;

            -- Dropa a PLSQL
            DROP FUNCTION removeCancelamentoDuplicado();

            -- Dropa a chave única
            ALTER TABLE cancelamento_notas DROP constraint cancelamento_notas_id_nota_uk;

          COMMIT;";
    $this->execute($sSql);
  }
}
