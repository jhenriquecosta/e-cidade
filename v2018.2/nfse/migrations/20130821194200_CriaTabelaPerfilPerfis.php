<?php
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2014  DBSeller Servicos de Informatica           
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa e software livre; voce pode redistribui-lo e/ou     
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versao 2 da      
 *  Licenca como (a seu criterio) qualquer versao mais nova.          
 *                                                                    
 *  Este programa e distribuido na expectativa de ser util, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM           
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU     
 *  junto com este programa; se nao, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Copia da licenca no diretorio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */


class CriaTabelaPerfilPerfis extends Ruckusing_Migration_Base {
  
  public function up() {
  
    $sSql  = "CREATE TABLE perfil_perfis ( id           integer NOT NULL, ";
    $sSql .= "                             id_perfil    bigint,           ";
    $sSql .= "                             id_perfilcad bigint );         ";

    $sSql .= "CREATE SEQUENCE perfil_perfis_id_seq  ";
    $sSql .= "  START WITH 1                        ";
    $sSql .= "  INCREMENT BY 1                      ";
    $sSql .= "  NO MINVALUE                         ";
    $sSql .= "  NO MAXVALUE                         ";
    $sSql .= "  CACHE 1;                            ";

    $sSql .= "ALTER SEQUENCE perfil_perfis_id_seq OWNED BY perfil_perfis.id; ";
    $sSql .= "ALTER TABLE ONLY perfil_perfis ALTER COLUMN id SET DEFAULT nextval('perfil_perfis_id_seq'::regclass); ";

    $sSql .= "ALTER TABLE ONLY perfil_perfis ADD CONSTRAINT perfil_perfis_pk PRIMARY KEY (id); ";
    $sSql .= "ALTER TABLE ONLY perfil_perfis ADD CONSTRAINT id_perfil_fk FOREIGN KEY (id_perfil) REFERENCES perfis(id); ";
    $sSql .= "ALTER TABLE ONLY perfil_perfis ";
    $sSql .= "  ADD CONSTRAINT id_perfilcad_fk FOREIGN KEY (id_perfilcad) REFERENCES perfis(id); ";
    
    $this->execute($sSql);
  }

  public function down() {
    
    $sSql .= "DROP SEQUENCE IF EXISTS perfil_perfis_id_seq; ";
    $sSql  = "DROP TABLE IF EXISTS perfil_perfis; ";
    
    $this->execute($sSql);
  }
}