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


class CriaTabelaLogsAcessa extends Ruckusing_Migration_Base {
  
  public function up() {
  
    $sSql = "
      BEGIN;
      CREATE TABLE logsacessa (
        sequencial SERIAL,
        datahora   TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT now(),
        usuario    VARCHAR(20) NOT NULL DEFAULT 'noname',
        acao       TEXT        NOT NULL,
        ip         character varying
      ) WITHOUT OIDS;
      
      ALTER TABLE logsacessa
        ADD CONSTRAINT logsacessa_sequencial_pk
        PRIMARY KEY (sequencial);
        
      CREATE INDEX logsacessa_acao_in     ON logsacessa(acao);
      CREATE INDEX logsacessa_ip_in       ON logsacessa(ip);
      CREATE INDEX logsacessa_datahora_in ON logsacessa(datahora);
      CREATE INDEX logsacessa_usuario_in  ON logsacessa(usuario);
    
      COMMIT; ";
    $this->execute($sSql);
    
  }

  public function down() {
    
    $this->execute("DROP TABLE IF EXISTS logsacessa CASCADE;");
  }
}