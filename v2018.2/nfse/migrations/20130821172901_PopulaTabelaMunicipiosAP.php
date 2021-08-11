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


class PopulaTabelaMunicipiosAP extends Ruckusing_Migration_Base {
  
  public function up() {
    
    $sSql = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1600808, 'VITORIA DO JARI', 'AP'); ";
    $sSql = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1600709, 'TARTARUGALZINHO', 'AP'); ";
    $sSql = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1600055, 'SERRA DO NAVIO', 'AP'); ";
    $sSql = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1600600, 'SANTANA', 'AP'); ";
    $sSql = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1600550, 'PRACUUBA', 'AP'); ";
    $sSql = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1600535, 'PORTO GRANDE', 'AP'); ";
    $sSql = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1600154, 'PEDRA BRANCA DO AMAPARI', 'AP'); ";
    $sSql = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1600501, 'OIAPOQUE', 'AP'); ";
    $sSql = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1600402, 'MAZAGAO', 'AP'); ";
    $sSql = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1600303, 'MACAPA', 'AP'); ";
    $sSql = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1600279, 'LARANJAL DO JARI', 'AP'); ";
    $sSql = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1600253, 'ITAUBAL', 'AP'); ";
    $sSql = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1600238, 'FERREIRA GOMES', 'AP'); ";
    $sSql = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1600212, 'CUTIAS', 'AP'); ";
    $sSql = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1600204, 'CALCOENE', 'AP'); ";
    $sSql = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1600105, 'AMAPA', 'AP'); ";
    
    $this->execute($sSql);
  }

  public function down() {
    
    $sSql = "DELETE FROM municipios WHERE uf = 'AP'; ";
    $this->execute($sSql);
  }
}