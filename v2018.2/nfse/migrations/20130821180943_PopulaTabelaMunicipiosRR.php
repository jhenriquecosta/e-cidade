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


class PopulaTabelaMunicipiosRR extends Ruckusing_Migration_Base {
  
  public function up() {
  
    $sSql  = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1400407, 'NORMANDIA', 'RR'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1400308, 'MUCAJAI', 'RR'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1400282, 'IRACEMA', 'RR'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1400233, 'CAROEBE', 'RR'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1400209, 'CARACARAI', 'RR'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1400175, 'CANTA', 'RR'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1400159, 'BONFIM', 'RR'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1400100, 'BOA VISTA', 'RR'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1400027, 'AMAJARI', 'RR'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1400050, 'ALTO ALEGRE', 'RR'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1400704, 'UIRAMUTA', 'RR'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1400605, 'SAO LUIZ', 'RR'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1400506, 'SAO JOAO DA BALIZA', 'RR'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1400472, 'RORAINOPOLIS', 'RR'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1400456, 'PACARAIMA', 'RR'); ";
    
    $this->execute($sSql);
  }

  public function down() {
  
    $sSql = "DELETE FROM municipios WHERE uf = 'RR'; ";
    $this->execute($sSql);
  }
}