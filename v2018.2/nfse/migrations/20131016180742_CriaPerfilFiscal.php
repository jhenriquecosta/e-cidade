<?php

class CriaPerfilFiscal extends Ruckusing_Migration_Base {
  
  public function up() {
    
    $sInsert  = "INSERT INTO perfis_acoes VALUES (nextval('perfis_acoes_id_seq'), 13, 5);";
    $sInsert .= "INSERT INTO perfis_acoes VALUES (nextval('perfis_acoes_id_seq'), 12, 5);";
    $sInsert .= "INSERT INTO perfis_acoes VALUES (nextval('perfis_acoes_id_seq'), 10, 5);";
    $sInsert .= "INSERT INTO perfis_acoes VALUES (nextval('perfis_acoes_id_seq'), 9, 5);";
    $sInsert .= "INSERT INTO perfis_acoes VALUES (nextval('perfis_acoes_id_seq'), 35, 5);";
    $sInsert .= "INSERT INTO perfis_acoes VALUES (nextval('perfis_acoes_id_seq'), 32, 5);";
    $sInsert .= "INSERT INTO perfis_acoes VALUES (nextval('perfis_acoes_id_seq'), 33, 5);";
    
    $sInsert .= "INSERT INTO perfil_perfis VALUES (nextval('perfil_perfis_id_seq'), 5, 1);";
    $sInsert .= "INSERT INTO perfil_perfis VALUES (nextval('perfil_perfis_id_seq'), 5, 2);";
    $sInsert .= "INSERT INTO perfil_perfis VALUES (nextval('perfil_perfis_id_seq'), 5, 4);";
    $sInsert .= "INSERT INTO perfil_perfis VALUES (nextval('perfil_perfis_id_seq'), 5, 5);";
    
    $this->execute($sInsert);
    
  }

  public function down() {
    
    $sDelete  = "delete from perfis_acoes  where id_perfil = 5;";
    $sDelete .= "delete from perfil_perfis where id_perfil = 5;";
    $sDelete .= "delete from perfis where id               = 5;";
    
    $this->execute($sDelete);
  }
}
