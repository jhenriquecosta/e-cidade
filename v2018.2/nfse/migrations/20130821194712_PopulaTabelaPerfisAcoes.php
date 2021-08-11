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


class PopulaTabelaPerfisAcoes extends Ruckusing_Migration_Base {
  
  public function up() {
    
    $sSql = "
      BEGIN;
        INSERT INTO perfis_acoes VALUES (33, 11, 3);
        INSERT INTO perfis_acoes VALUES (34, 10, 3);
        INSERT INTO perfis_acoes VALUES (35, 9, 3);
        INSERT INTO perfis_acoes VALUES (36, 8, 3);
        INSERT INTO perfis_acoes VALUES (37, 7, 3);
        INSERT INTO perfis_acoes VALUES (38, 6, 3);
        INSERT INTO perfis_acoes VALUES (39, 5, 3);
        INSERT INTO perfis_acoes VALUES (40, 12, 3);
        INSERT INTO perfis_acoes VALUES (41, 14, 3);
        INSERT INTO perfis_acoes VALUES (42, 11, 4);
        INSERT INTO perfis_acoes VALUES (43, 1, 4);
        INSERT INTO perfis_acoes VALUES (44, 19, 4);
        INSERT INTO perfis_acoes VALUES (51, 11, 6);
        INSERT INTO perfis_acoes VALUES (52, 3, 6);
        INSERT INTO perfis_acoes VALUES (53, 20, 6);
        INSERT INTO perfis_acoes VALUES (139, 11, 2);
        INSERT INTO perfis_acoes VALUES (140, 10, 2);
        INSERT INTO perfis_acoes VALUES (141, 8, 2);
        INSERT INTO perfis_acoes VALUES (142, 6, 2);
        INSERT INTO perfis_acoes VALUES (143, 2, 2);
        INSERT INTO perfis_acoes VALUES (157, 11, 7);
        INSERT INTO perfis_acoes VALUES (158, 4, 7);
        INSERT INTO perfis_acoes VALUES (159, 3, 7);
        INSERT INTO perfis_acoes VALUES (160, 2, 7);
        INSERT INTO perfis_acoes VALUES (161, 1, 7);
        INSERT INTO perfis_acoes VALUES (162, 15, 7);
        INSERT INTO perfis_acoes VALUES (163, 19, 7);
        INSERT INTO perfis_acoes VALUES (164, 20, 7);
        INSERT INTO perfis_acoes VALUES (165, 18, 7);
        INSERT INTO perfis_acoes VALUES (166, 39, 7);
        INSERT INTO perfis_acoes VALUES (167, 11, 1);
        INSERT INTO perfis_acoes VALUES (168, 10, 1);
        INSERT INTO perfis_acoes VALUES (169, 8, 1);
        INSERT INTO perfis_acoes VALUES (170, 1, 1);
        INSERT INTO perfis_acoes VALUES (171, 15, 1);
        INSERT INTO perfis_acoes VALUES (172, 17, 1);
        INSERT INTO perfis_acoes VALUES (173, 16, 1);
        INSERT INTO perfis_acoes VALUES (174, 19, 1);
        INSERT INTO perfis_acoes VALUES (175, 21, 1);
        INSERT INTO perfis_acoes VALUES (176, 18, 1);
        INSERT INTO perfis_acoes VALUES (177, 25, 1);
        INSERT INTO perfis_acoes VALUES (178, 24, 1);
        INSERT INTO perfis_acoes VALUES (179, 38, 1);
        INSERT INTO perfis_acoes VALUES (180, 39, 1);
        INSERT INTO perfis_acoes VALUES (200, 11, 5);
        INSERT INTO perfis_acoes VALUES (201, 10, 5);
        INSERT INTO perfis_acoes VALUES (202, 8, 5);
        INSERT INTO perfis_acoes VALUES (203, 6, 5);
        INSERT INTO perfis_acoes VALUES (204, 5, 5);
        INSERT INTO perfis_acoes VALUES (205, 26, 5);
        INSERT INTO perfis_acoes VALUES (206, 41, 5);
        INSERT INTO perfis_acoes VALUES (207, 40, 5);
        INSERT INTO perfis_acoes VALUES (208, 43, 5);
        INSERT INTO perfis_acoes VALUES (209, 42, 5);
        INSERT INTO perfis_acoes VALUES (210, 44, 5);
        INSERT INTO perfis_acoes VALUES (211, 45, 5);
        INSERT INTO perfis_acoes VALUES (212, 46, 5);
        INSERT INTO perfis_acoes VALUES (213, 47, 5);
        INSERT INTO perfis_acoes VALUES (215, 49, 5);

        SELECT pg_catalog.setval('perfis_acoes_id_seq', 215, true);
      COMMIT;
    ";
    
    $this->execute($sSql);
  }
  
  public function down() {
    
    $sSql  = "
      BEGIN;
        DELETE FROM perfis_acoes where id <= 215;
        SELECT pg_catalog.setval('perfis_acoes_id_seq', 1, true);
      COMMIT;
    ";
    
    $this->execute($sSql);
  }
}