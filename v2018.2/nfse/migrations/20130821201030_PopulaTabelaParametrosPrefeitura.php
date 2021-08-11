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


class PopulaTabelaParametrosPrefeitura extends Ruckusing_Migration_Base {

  public function up() {
    
    $sSql = "
      BEGIN;
        INSERT INTO parametrosprefeitura VALUES (
          1, 
          true, 
          10, 
          0, 
          '4300406',
          'prefeitura teste',
          'quantidade', 
          NULL, 
          NULL, 
          NULL, 
          NULL, 
          NULL,
          NULL, 
          NULL, 
          NULL, 
          NULL, 
          NULL, 
          NULL, 
          NULL, 
          NULL, 
          NULL, 
          NULL
        );
        
        SELECT pg_catalog.setval('parametrosprefeitura_id_seq', 2, true);
      COMMIT;
    ";
    
    $this->execute($sSql);
  }

  public function down() {
    
    $sSql = '
      BEGIN;
        DELETE FROM parametrosprefeitura WHERE id = 1;
      COMMIT;
    ';
    
    $this->execute($sSql);
  }
}