<?php

class V011716 extends Ruckusing_Migration_Base
{
    public function up()
    {
      $sSql = "
        begin;

        insert into controles values (48, 6, 'Procedimento', 'procedimento', 't' );
          select setval('controles_id_seq', 48);

        insert into acoes values (74, 48, 'Cancelamento de NFS-e', null, 'cancela-nota', '', 't');
          select setval('acoes_id_seq', 74);

        insert into acoes values (75, 48, 'Abertura de Competência', null, 'abertura-competencia', '', 't');
          select setval('acoes_id_seq', 75);

        insert into usuarios_acoes
             select nextval('usuarios_acoes_id_seq'),
                    id,
                    74
               from usuarios
              where id_perfil = 5;

        insert into usuarios_acoes
             select nextval('usuarios_acoes_id_seq'),
                    id,
                    75
               from usuarios
              where id_perfil = 5;

        insert into perfis_acoes (id, id_acao, id_perfil) values (nextval('perfis_acoes_id_seq'), 74, 5);
        insert into perfis_acoes (id, id_acao, id_perfil) values (nextval('perfis_acoes_id_seq'), 75, 5);

        commit;
      ";

      $this->execute($sSql);
    }

    public function down()
    {
      $sSql = "
        begin;

        delete from perfis_acoes where id_perfil = 5 and id_acao in (74, 75);
        delete from usuarios_acoes where id_acao in (74, 75);
        delete from acoes where id in (74, 75);
        delete from controles where id = 48;

        commit;
      ";

      $this->execute($sSql);
    }
}
