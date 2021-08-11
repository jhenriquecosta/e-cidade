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


class CriaTabelaGuiasNotas extends Ruckusing_Migration_Base {
  
  public function up() {
    
    $sSql = '
      BEGIN;
        CREATE TABLE guias_notas (
          id_guia bigint NOT NULL,
          id_nota bigint NOT NULL
        );
        
        ALTER TABLE ONLY guias_notas 
          ADD constraint guias_notas_pk primary key (id_guia, id_nota),
          ADD CONSTRAINT guias_notas_id_guia_fk FOREIGN KEY (id_guia) REFERENCES guias(id),
          ADD CONSTRAINT guias_notas_id_nota_fk FOREIGN KEY (id_nota) REFERENCES notas(id);
      COMMIT;
    ';
    
    $this->execute($sSql);
  }
  
  public function down() {
    
    $sSql =  '
      BEGIN;
        ALTER TABLE ONLY guias_notas DROP CONSTRAINT guias_notas_id_nota_fk;
        ALTER TABLE ONLY guias_notas DROP CONSTRAINT guias_notas_id_guia_fk;
        ALTER TABLE ONLY guias_notas DROP CONSTRAINT guias_notas_pk;
        DROP  TABLE      guias_notas;
      COMMIT;
    ';
    
    $this->execute($sSql);
  }
}