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


class CriaTabelaGuiasNumpre extends Ruckusing_Migration_Base {
  
  public function up() {
    
    $sSql = " CREATE TABLE guias_numpre (id      integer NOT NULL,
                                         id_guia bigint NOT NULL,
                                         numpre  bigint NOT NULL); ";
        
    $sSql .= " CREATE SEQUENCE guias_numpre_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1; ";
    $sSql .= " CREATE INDEX guias_numpre_id_guia_indice ON guias_numpre USING btree (id_guia);";
        
    $sSql .= " ALTER TABLE ONLY guias_numpre
                ADD CONSTRAINT guias_numpre_id_pk PRIMARY KEY (id),
                ADD CONSTRAINT id_guia_and_numpre_uk UNIQUE (id_guia, numpre),
                ADD CONSTRAINT guias_numpre_id_guia_fk FOREIGN KEY (id_guia) REFERENCES guias(id); ";
    
    $this->execute($sSql);
  }

  public function down() {
    
    $sSql  = ' ALTER TABLE ONLY guias_numpre DROP CONSTRAINT guias_numpre_id_pk;
               ALTER TABLE ONLY guias_numpre DROP CONSTRAINT guias_numpre_id_guia_fk;
               DROP INDEX guias_numpre_id_guia_indice; ;
               DROP TABLE guias_numpre; ';
    
    $this->execute($sSql);
  
  }
}