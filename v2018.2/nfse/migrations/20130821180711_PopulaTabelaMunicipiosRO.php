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


class PopulaTabelaMunicipiosRO extends Ruckusing_Migration_Base {
  
  public function up() {
  
    $sSql  = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100304, 'VILHENA', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1101807, 'VALE DO PARAISO', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1101757, 'VALE DO ANARI', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1101708, 'URUPA', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1101609, 'THEOBROMA', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1101559, 'TEIXEIROPOLIS', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1101500, 'SERINGUEIRAS', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100320, 'SAO MIGUEL DO GUAPORE', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1101492, 'SAO FRANCISCO DO GUAPORE', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1101484, 'SAO FELIPE D OESTE', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100296, 'SANTA LUZIA D OESTE', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100288, 'ROLIM DE MOURA', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100262, 'RIO CRESPO', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1101476, 'PRIMAVERA DE RONDONIA', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100254, 'PRESIDENTE MEDICI', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100205, 'PORTO VELHO', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1101468, 'PIMENTEIRAS DO OESTE', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100189, 'PIMENTA BUENO', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1101450, 'PARECIS', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100155, 'OURO PRETO DO OESTE', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100502, 'NOVO HORIZONTE DO OESTE', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1101435, 'NOVA UNIAO', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100338, 'NOVA MAMORE', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100148, 'NOVA BRASILANDIA D OESTE', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1101401, 'MONTE NEGRO', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1101302, 'MIRANTE DA SERRA', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1101203, 'MINISTRO ANDREAZZA', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100130, 'MACHADINHO D OESTE', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100122, 'JI-PARANA', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100114, 'JARU', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1101104, 'ITAPUA DO OESTE', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100106, 'GUAJARA-MIRIM', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1101005, 'GOVERNADOR JORGE TEIXEIRA', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100098, 'ESPIGAO D OESTE', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100940, 'CUJUBIM', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100080, 'COSTA MARQUES', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100072, 'CORUMBIARA', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100064, 'COLORADO DO OESTE', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100924, 'CHUPINGUAIA', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100056, 'CEREJEIRAS', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100908, 'CASTANHEIRAS', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100809, 'CANDEIAS DO JAMARI', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100700, 'CAMPO NOVO DE RONDONIA', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100049, 'CACOAL', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100601, 'CACAULANDIA', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100031, 'CABIXI', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100452, 'BURITIS', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100023, 'ARIQUEMES', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100346, 'ALVORADA D OESTE', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100403, 'ALTO PARAISO', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100379, 'ALTO ALEGRE DOS PARECIS', 'RO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1100015, 'ALTA FLORESTA D OESTE', 'RO'); ";
    
    $this->execute($sSql);
  }

  public function down() {
  
    $sSql = "DELETE FROM municipios WHERE uf = 'RO'; ";
    $this->execute($sSql);
  }
}