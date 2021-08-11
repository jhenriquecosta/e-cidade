<?php

class V011721RotinasAdm extends Ruckusing_Migration_Base
{
    public function up()
    {
      $sSql = "
        begin;

        -- Atualiza a versão com o e-cidade
        INSERT INTO versoes VALUES ('V011721', '2.3.58');

        insert into acoes values (76, 48, 'Alteração de Regime de Notas (Simples)', null, 'alteracao-regime-notas-simples', 'consulta-cadastro-simples-nacional-usuario,processa-alteracao-regime-notas-simples', 't');
          select setval('acoes_id_seq', 76);
        insert into usuarios_acoes
             select nextval('usuarios_acoes_id_seq'),
                    id,
                    76
               from usuarios
              where id_perfil = 5;

        insert into perfis_acoes (id, id_acao, id_perfil) values (nextval('perfis_acoes_id_seq'), 76, 5);

        commit;
      ";

      $this->execute($sSql);
    }

    public function down()
    {
      $sSql = "
        begin;

        delete from perfis_acoes where id_perfil = 5 and id_acao in (76);
        delete from usuarios_acoes where id_acao in (76);
        delete from acoes where id in (76);

        -- Atualiza a versão com o e-cidade
        DELETE FROM versoes WHERE ecidadeonline2 = 'V011721';

        commit;
      ";

      $this->execute($sSql);
    }
}

