<?php

class WebservicesV010103 extends Ruckusing_Migration_Base
{
    public function up()
    {
      $sSql  = "
          CREATE TABLE cancelamento_notas (
            id              integer NOT NULL,
            id_usuario      integer NOT NULL,
            id_nota         integer NOT NULL,
            motivo          integer DEFAULT 9,
            data            date NOT NULL,
            hora            time NOT NULL
          );

          CREATE SEQUENCE cancelamento_notas_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
          ALTER TABLE ONLY cancelamento_notas
            ADD CONSTRAINT cancelamento_notas_id_pk PRIMARY KEY (id),
            ADD CONSTRAINT cancelamento_notas_id_usuario_fk FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
            ADD CONSTRAINT cancelamento_notas_id_nota_fk FOREIGN KEY (id_nota) REFERENCES notas(id);
          ALTER TABLE ONLY cancelamento_notas ALTER COLUMN id SET DEFAULT nextval('cancelamento_notas_id_seq'::regclass);";
      $this->execute($sSql);
    }//up()

    public function down()
    {

      $sSql = "
        BEGIN;

          DROP TABLE cancelamento_notas CASCADE;
          DROP SEQUENCE cancelamento_notas_id_seq;

        COMMIT;
      ";

      $this->execute($sSql);
    }//down()
}
