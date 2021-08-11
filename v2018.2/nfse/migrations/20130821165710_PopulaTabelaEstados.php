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


class PopulaTabelaEstados extends Ruckusing_Migration_Base {
  
  public function up() {
  
    $sSql  = "INSERT INTO estados (id, uf, nome, cod_pais) values (1 , 'AC', 'ACRE'               , '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (2 , 'AL', 'ALAGOAS'            , '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (3 , 'AM', 'AMAZONAS'           , '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (4 , 'AP', 'AMAPA'              , '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (5 , 'BA', 'BAHIA'              , '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (6 , 'CE', 'CEARA'              , '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (7 , 'DF', 'DISTRITO FEDERAL'   , '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (8 , 'ES', 'ESPIRITO SANTO'     , '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (9 , 'GO', 'GOIAS'              , '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (10, 'MA', 'MARANHAO'           , '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (11, 'MG', 'MINAS GERAIS'       , '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (12, 'MS', 'MATO GROSSO DO SUL' , '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (13, 'MT', 'MATO GROSSO'        , '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (14, 'PA', 'PARA'               , '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (15, 'PB', 'PARAIBA'            , '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (16, 'PE', 'PERNAMBUCO'         , '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (17, 'PI', 'PIAUI'              , '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (18, 'PR', 'PARANA'             , '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (19, 'RJ', 'RIO DE JANEIRO'     , '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (20, 'RN', 'RIO GRANDE DO NORTE', '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (21, 'RO', 'RONDONIA'           , '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (22, 'RR', 'RORAIMA'            , '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (23, 'RS', 'RIO GRANDE DO SUL'  , '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (24, 'SC', 'SANTA CATARINA'     , '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (25, 'SE', 'SERGIPE'            , '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (26, 'SP', 'SAO PAULO'          , '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (27, 'TO', 'TOCANTINS'          , '01058'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (28, 'CR', 'CORRIENTES'         , '00639'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (29, 'LP', 'LA PAMPA'           , '00639'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (30, 'BU', 'BUENOS AIRES'       , '00639'); ";
    $sSql .= "INSERT INTO estados (id, uf, nome, cod_pais) values (31, 'ER', 'ENTRE RÍOS'         , '00639'); ";
    
    $this->execute($sSql);
  }

  public function down() {
    
    $sSql = "DELETE FROM estados; ";
    $this->execute($sSql);
  }
}