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


class PopulaTabelaParametrosPrefeituraRps extends Ruckusing_Migration_Base {
  
  public function up() {
    
    $sSql = "
      BEGIN;
        INSERT INTO parametros_prefeitura_rps VALUES (1, 1, 'Recibo Provisório de Serviços', NULL);
        INSERT INTO parametros_prefeitura_rps VALUES (2, 2, 'RPS Nota Fiscal Conjugada', NULL);
        INSERT INTO parametros_prefeitura_rps VALUES (3, 3, 'Cupom', NULL);
        
        SELECT pg_catalog.setval('parametros_prefeitura_rps_id_seq', 3, true);
      COMMIT;
    ";
    
    $this->execute($sSql);
  }

  public function down() {
    
    $sSql = "
      BEGIN;
        DELETE FROM parametros_prefeitura_rps WHERE id in (1,2,3);
        SELECT pg_catalog.setval('parametros_prefeitura_rps_id_seq', 1, true);
      COMMIT;
    ";
    
    $this->execute($sSql);
    
  }
}