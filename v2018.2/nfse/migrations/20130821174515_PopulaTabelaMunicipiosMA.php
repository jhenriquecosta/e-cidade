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


class PopulaTabelaMunicipiosMA extends Ruckusing_Migration_Base {
  
  public function up() {
  
    $sSql  = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2103505, 'COLINAS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2103406, 'COELHO NETO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2103307, 'CODO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2103257, 'CIDELANDIA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2103208, 'CHAPADINHA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2103174, 'CENTRO NOVO DO MARANHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2103158, 'CENTRO DO GUILHERME', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2103125, 'CENTRAL DO MARANHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2103109, 'CEDRAL', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2103000, 'CAXIAS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2102903, 'CARUTAPERA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2102804, 'CAROLINA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2102754, 'CAPINZAL DO NORTE', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2102705, 'CANTANHEDE', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2102606, 'CANDIDO MENDES', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2102556, 'CAMPESTRE DO MARANHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2102507, 'CAJARI', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2102408, 'CAJAPIO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2102374, 'CACHOEIRA GRANDE', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2102358, 'BURITIRANA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2102325, 'BURITICUPU', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2102309, 'BURITI BRAVO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2102200, 'BURITI', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2102150, 'BREJO DE AREIA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2102101, 'BREJO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2102077, 'BOM LUGAR', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2102036, 'BOM JESUS DAS SELVAS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2102002, 'BOM JARDIM', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2101970, 'BOA VISTA DO GURUPI', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2101939, 'BERNARDO DO MEARIM', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2101905, 'BEQUIMAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2101806, 'BENEDITO LEITE', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2101772, 'BELA VISTA DO MARANHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2101731, 'BELAGUA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2101707, 'BARREIRINHAS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2101608, 'BARRA DO CORDA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2101509, 'BARAO DE GRAJAU', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2101400, 'BALSAS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2101350, 'BACURITUBA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2101301, 'BACURI', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2101251, 'BACABEIRA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2101202, 'BACABAL', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2101103, 'AXIXA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2101004, 'ARARI', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2100956, 'ARAME', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2100907, 'ARAIOSES', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2100873, 'ARAGUANA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2100832, 'APICUM-ACU', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2100808, 'ANAPURUS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2100709, 'ANAJATUBA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2100600, 'AMARANTE DO MARANHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2100550, 'AMAPA DO MARANHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2100501, 'ALTO PARNAIBA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2100477, 'ALTO ALEGRE DO PINDARE', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2100436, 'ALTO ALEGRE DO MARANHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2100402, 'ALTAMIRA DO MARANHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2100303, 'ALDEIAS ALTAS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2100204, 'ALCANTARA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2100154, 'AGUA DOCE DO MARANHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2100105, 'AFONSO CUNHA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2100055, 'ACAILANDIA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2113009, 'VITORINO FREIRE', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2112902, 'VITORIA DO MEARIM', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2112852, 'VILA NOVA DOS MARTIRIOS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2112803, 'VIANA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2112704, 'VARGEM GRANDE', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2112605, 'URBANO SANTOS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2112506, 'TUTOIA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2112456, 'TURILANDIA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2112407, 'TURIACU', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2112308, 'TUNTUM', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2112274, 'TUFILANDIA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2112233, 'TRIZIDELA DO VALE', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2112209, 'TIMON', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2112100, 'TIMBIRAS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2112001, 'TASSO FRAGOSO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2111953, 'SUCUPIRA DO RIACHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2111904, 'SUCUPIRA DO NORTE', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2111805, 'SITIO NOVO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2111789, 'SERRANO DO MARANHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2111763, 'SENADOR LA ROCQUE', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2111748, 'SENADOR ALEXANDRE COSTA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2111722, 'SATUBINHA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2111706, 'SAO VICENTE FERRER', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2111672, 'SAO ROBERTO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2111631, 'SAO RAIMUNDO DO DOCA BEZERRA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2111607, 'SAO RAIMUNDO DAS MANGABEIRAS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2111573, 'SAO PEDRO DOS CRENTES', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2111532, 'SAO PEDRO DA AGUA BRANCA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2111508, 'SAO MATEUS DO MARANHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2111409, 'SAO LUIS GONZAGA DO MARANHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2111300, 'SAO LUIS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2111250, 'SAO JOSE DOS BASILIOS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2111201, 'SAO JOSE DE RIBAMAR', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2111102, 'SAO JOAO DOS PATOS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2111078, 'SAO JOAO DO SOTER', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2111052, 'SAO JOAO DO PARAISO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2111029, 'SAO JOAO DO CARU', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2111003, 'SAO JOAO BATISTA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2110906, 'SAO FRANCISCO DO MARANHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2110856, 'SAO FRANCISCO DO BREJAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2110807, 'SAO FELIX DE BALSAS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2110708, 'SAO DOMINGOS DO MARANHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2110658, 'SAO DOMINGOS DO AZEITAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2110609, 'SAO BERNARDO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2110500, 'SAO BENTO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2110401, 'SAO BENEDITO DO RIO PRETO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2110302, 'SANTO ANTONIO DOS LOPES', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2110278, 'SANTO AMARO DO MARANHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2110203, 'SANTA RITA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2110104, 'SANTA QUITERIA DO MARANHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2110237, 'SANTANA DO MARANHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2110039, 'SANTA LUZIA DO PARUA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2110005, 'SANTA LUZIA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2109908, 'SANTA INES', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2109809, 'SANTA HELENA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2109759, 'SANTA FILOMENA DO MARANHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2109700, 'SAMBAIBA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2109601, 'ROSARIO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2109551, 'RIBAMAR FIQUENE', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2109502, 'RIACHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2109452, 'RAPOSA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2109403, 'PRIMEIRA CRUZ', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2109304, 'PRESIDENTE VARGAS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2109270, 'PRESIDENTE SARNEY', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2109239, 'PRESIDENTE MEDICI', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2109205, 'PRESIDENTE JUSCELINO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2109106, 'PRESIDENTE DUTRA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2109056, 'PORTO RICO DO MARANHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2109007, 'PORTO FRANCO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2108900, 'POCAO DE PEDRAS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2108801, 'PIRAPEMAS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2108702, 'PIO XII', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2108603, 'PINHEIRO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2108504, 'PINDARE-MIRIM', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2108454, 'PERITORO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2108405, 'PERI MIRIM', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2108306, 'PENALVA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2108256, 'PEDRO DO ROSARIO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2108207, 'PEDREIRAS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2108108, 'PAULO RAMOS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2108058, 'PAULINO NEVES', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2108009, 'PASTOS BONS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2107902, 'PASSAGEM FRANCA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2107803, 'PARNARAMA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2107704, 'PARAIBANO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2107605, 'PALMEIRANDIA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2107506, 'PACO DO LUMIAR', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2107456, 'OLINDA NOVA DO MARANHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2107407, 'OLHO D AGUA DAS CUNHAS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2107357, 'NOVA OLINDA DO MARANHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2107308, 'NOVA IORQUE', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2107258, 'NOVA COLINAS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2107209, 'NINA RODRIGUES', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2107100, 'MORROS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2107001, 'MONTES ALTOS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2106904, 'MONCAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2106805, 'MIRINZAL', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2106755, 'MIRANDA DO NORTE', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2106706, 'MIRADOR', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2106672, 'MILAGRES DO MARANHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2106631, 'MATOES DO NORTE', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2106607, 'MATOES', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2106508, 'MATINHA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2106409, 'MATA ROMA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2106375, 'MARANHAOZINHO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2106359, 'MARAJA DO SENA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2106326, 'MARACACUME', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2106300, 'MAGALHAES DE ALMEIDA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2106201, 'LUIS DOMINGUES', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2106102, 'LORETO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2106003, 'LIMA CAMPOS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2105989, 'LAJEADO NOVO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2105906, 'LAGO VERDE', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2105948, 'LAGO DOS RODRIGUES', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2105807, 'LAGO DO JUNCO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2105708, 'LAGO DA PEDRA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2105963, 'LAGOA GRANDE DO MARANHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2105922, 'LAGOA DO MATO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2105658, 'JUNCO DO MARANHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2105609, 'JOSELANDIA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2105500, 'JOAO LISBOA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2105476, 'JENIPAPO DOS VIEIRAS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2105450, 'JATOBA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2105427, 'ITINGA DO MARANHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2105401, 'ITAPECURU MIRIM', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2105351, 'ITAIPAVA DO GRAJAU', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2105302, 'IMPERATRIZ', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2105203, 'IGARAPE GRANDE', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2105153, 'IGARAPE DO MEIO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2105104, 'ICATU', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2105005, 'HUMBERTO DE CAMPOS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2104909, 'GUIMARAES', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2104800, 'GRAJAU', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2104701, 'GRACA ARANHA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2104677, 'GOVERNADOR NUNES FREIRE', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2104651, 'GOVERNADOR NEWTON BELLO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2104628, 'GOVERNADOR LUIZ ROCHA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2104602, 'GOVERNADOR EUGENIO BARROS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2104552, 'GOVERNADOR EDISON LOBAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2104503, 'GOVERNADOR ARCHER', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2104404, 'GONCALVES DIAS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2104305, 'GODOFREDO VIANA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2104206, 'FORTUNA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2104107, 'FORTALEZA DOS NOGUEIRAS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2104099, 'FORMOSA DA SERRA NEGRA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2104081, 'FERNANDO FALCAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2104073, 'FEIRA NOVA DO MARANHAO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2104057, 'ESTREITO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2104008, 'ESPERANTINOPOLIS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2103901, 'DUQUE BACELAR', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2103802, 'DOM PEDRO', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2103752, 'DAVINOPOLIS', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2103703, 'CURURUPU', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2103604, 'COROATA', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2103554, 'CONCEICAO DO LAGO-ACU', 'MA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2114007, 'ZE DOCA', 'MA'); ";
    
    $this->execute($sSql);
  }

  public function down() {
  
    $sSql = "DELETE FROM municipios WHERE uf = 'MA'; ";
    $this->execute($sSql);
  }
}