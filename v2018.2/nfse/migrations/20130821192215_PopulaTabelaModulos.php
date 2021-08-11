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


class PopulaTabelaModulos extends Ruckusing_Migration_Base {
  
  public function up() {
   
    $sSql = "INSERT INTO modulos (id, modulo, identidade, visivel) VALUES (1, 'Administrativo', 'administrativo', true);
             INSERT INTO modulos (id, modulo, identidade, visivel) VALUES (2, 'Contribuinte', 'contribuinte', true);
             INSERT INTO modulos (id, modulo, identidade, visivel) VALUES (3, 'Global', 'global', false);
             INSERT INTO modulos (id, modulo, identidade, visivel) VALUES (5, 'Default', 'default', false);
             INSERT INTO modulos (id, modulo, identidade, visivel) VALUES (6, 'Fiscal', 'fiscal', true);
             INSERT INTO modulos (id, modulo, identidade, visivel) VALUES (7, 'Autenticação', 'auth', false);
             SELECT pg_catalog.setval('modulos_id_seq', 7, true);";
    
    $this->execute($sSql);
  }

  public function down() {
    
    $sSql  = "DELETE FROM modulos where id <= 7; ";
    $sSql .= "SELECT pg_catalog.setval('modulos_id_seq', 1, true); ";
    
    $this->execute($sSql);
  }
}