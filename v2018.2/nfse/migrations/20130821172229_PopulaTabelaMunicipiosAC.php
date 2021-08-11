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


class PopulaTabelaMunicipiosAC extends Ruckusing_Migration_Base {
  
  public function up() {
    
    $sSql  = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1200708, 'XAPURI', 'AC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1200609, 'TARAUACA', 'AC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1200500, 'SENA MADUREIRA', 'AC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1200450, 'SENADOR GUIOMARD', 'AC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1200435, 'SANTA ROSA DO PURUS', 'AC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1200427, 'RODRIGUES ALVES', 'AC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1200401, 'RIO BRANCO', 'AC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1200393, 'PORTO WALTER', 'AC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1200807, 'PORTO ACRE', 'AC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1200385, 'PLACIDO DE CASTRO', 'AC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1200351, 'MARECHAL THAUMATURGO', 'AC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1200344, 'MANOEL URBANO', 'AC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1200336, 'MANCIO LIMA', 'AC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1200328, 'JORDAO', 'AC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1200302, 'FEIJO', 'AC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1200252, 'EPITACIOLANDIA', 'AC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1200203, 'CRUZEIRO DO SUL', 'AC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1200179, 'CAPIXABA', 'AC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1200138, 'BUJARI', 'AC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1200104, 'BRASILEIA', 'AC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1200054, 'ASSIS BRASIL', 'AC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1200013, 'ACRELANDIA', 'AC'); ";
    
    $this->execute($sSql);
  }

  public function down() {
  
    $sSql = "DELETE FROM municipios WHERE uf = 'AC'; ";
    $this->execute($sSql);
  }
}