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


class PopulaTabelaMunicipiosSE extends Ruckusing_Migration_Base {
  
  public function up() {
    
    $sSql  = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2807600, 'UMBAUBA', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2807501, 'TOMAR DO GERU', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2807402, 'TOBIAS BARRETO', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2807303, 'TELHA', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2807204, 'SIRIRI', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2807105, 'SIMAO DIAS', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2807006, 'SAO MIGUEL DO ALEIXO', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2806909, 'SAO FRANCISCO', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2806800, 'SAO DOMINGOS', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2806701, 'SAO CRISTOVAO', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2806602, 'SANTO AMARO DAS BROTAS', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2806503, 'SANTA ROSA DE LIMA', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2806404, 'SANTANA DO SAO FRANCISCO', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2806305, 'SANTA LUZIA DO ITANHY', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2806206, 'SALGADO', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2806107, 'ROSARIO DO CATETE', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2806008, 'RIBEIROPOLIS', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2805901, 'RIACHUELO', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2805802, 'RIACHAO DO DANTAS', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2805703, 'PROPRIA', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2805604, 'PORTO DA FOLHA', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2805505, 'POCO VERDE', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2805406, 'POCO REDONDO', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2805307, 'PIRAMBU', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2805208, 'PINHAO', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2805109, 'PEDRINHAS', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2805000, 'PEDRA MOLE', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2804904, 'PACATUBA', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2804805, 'NOSSA SENHORA DO SOCORRO', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2804706, 'NOSSA SENHORA DE LOURDES', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2804607, 'NOSSA SENHORA DAS DORES', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2804508, 'NOSSA SENHORA DA GLORIA', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2804458, 'NOSSA SENHORA APARECIDA', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2804409, 'NEOPOLIS', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2804300, 'MURIBECA', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2804201, 'MONTE ALEGRE DE SERGIPE', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2804102, 'MOITA BONITA', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2804003, 'MARUIM', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2803906, 'MALHADOR', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2803807, 'MALHADA DOS BOIS', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2803708, 'MACAMBIRA', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2803609, 'LARANJEIRAS', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2803500, 'LAGARTO', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2803401, 'JAPOATA', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2803302, 'JAPARATUBA', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2803203, 'ITAPORANGA D AJUDA', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2803104, 'ITABI', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2803005, 'ITABAIANINHA', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2802908, 'ITABAIANA', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2802809, 'INDIAROBA', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2802700, 'ILHA DAS FLORES', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2802601, 'GRACHO CARDOSO', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2802502, 'GENERAL MAYNARD', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2802403, 'GARARU', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2802304, 'FREI PAULO', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2802205, 'FEIRA NOVA', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2802106, 'ESTANCIA', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2802007, 'DIVINA PASTORA', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2801900, 'CUMBE', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2801702, 'CRISTINAPOLIS', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2801603, 'CEDRO DE SAO JOAO', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2801504, 'CARMOPOLIS', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2801405, 'CARIRA', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2801306, 'CAPELA', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2801207, 'CANINDE DE SAO FRANCISCO', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2801108, 'CANHOBA', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2801009, 'CAMPO DO BRITO', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2800704, 'BREJO GRANDE', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2800670, 'BOQUIM', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2800605, 'BARRA DOS COQUEIROS', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2800506, 'AREIA BRANCA', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2800407, 'ARAUA', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2800308, 'ARACAJU', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2800209, 'AQUIDABA', 'SE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2800100, 'AMPARO DE SAO FRANCISCO', 'SE'); ";
    
    $this->execute($sSql);
  }

  public function down() {
  
    $sSql = "DELETE FROM municipios WHERE uf = 'SE'; ";
    $this->execute($sSql);
  }
}