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


class PopulaTabelaUsuariosAcoes extends Ruckusing_Migration_Base {

  public function up() {
   
    $sSql = " INSERT INTO usuarios_acoes (id, id_usuario, id_acao) VALUES (1, 1, 11);
              INSERT INTO usuarios_acoes (id, id_usuario, id_acao) VALUES (2, 1, 10);
              INSERT INTO usuarios_acoes (id, id_usuario, id_acao) VALUES (3, 1, 9);
              INSERT INTO usuarios_acoes (id, id_usuario, id_acao) VALUES (4, 1, 8);
              INSERT INTO usuarios_acoes (id, id_usuario, id_acao) VALUES (5, 1, 7);
              INSERT INTO usuarios_acoes (id, id_usuario, id_acao) VALUES (6, 1, 6);
              INSERT INTO usuarios_acoes (id, id_usuario, id_acao) VALUES (7, 1, 5);
              INSERT INTO usuarios_acoes (id, id_usuario, id_acao) VALUES (8, 1, 12);
              INSERT INTO usuarios_acoes (id, id_usuario, id_acao) VALUES (9, 1, 14); 
              SELECT pg_catalog.setval('usuarios_acoes_id_seq', 9, true); ";
    
   $this->execute($sSql);
  }

  public function down() {
    
    $sSql  = "DELETE FROM usuarios_acoes where id_usuario = 1; ";
    $sSql .= "SELECT pg_catalog.setval('usuarios_acoes_id_seq', 1, true); ";
  
    $this->execute($sSql);
  }
}