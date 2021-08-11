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


class PopulaTabelaMunicipiosPI extends Ruckusing_Migration_Base {
  
  public function up() {

    $sSql  = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2211704, 'WALL FERRAZ', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2211605, 'VILA NOVA DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2211506, 'VERA MENDES', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2211407, 'VARZEA GRANDE', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2211357, 'VARZEA BRANCA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2211308, 'VALENCA DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2211209, 'URUCUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2210102, 'SAO JOSE DO PEIXE', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2210052, 'SAO JOSE DO DIVINO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2210003, 'SAO JOAO DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2209971, 'SAO JOAO DO ARRAIAL', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2209955, 'SAO JOAO DA VARJOTA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2209906, 'SAO JOAO DA SERRA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2209872, 'SAO JOAO DA FRONTEIRA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2209856, 'SAO JOAO DA CANABRAVA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2209807, 'SAO GONCALO DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2209757, 'SAO GONCALO DO GURGUEIA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2209708, 'SAO FRANCISCO DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2209658, 'SAO FRANCISCO DE ASSIS DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2209609, 'SAO FELIX DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2209559, 'SAO BRAZ DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2209500, 'SANTO INACIO DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2209450, 'SANTO ANTONIO DOS MILAGRES', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2209401, 'SANTO ANTONIO DE LISBOA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2209377, 'SANTA ROSA DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2209351, 'SANTANA DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2209302, 'SANTA LUZ', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2209203, 'SANTA FILOMENA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2209153, 'SANTA CRUZ DOS MILAGRES', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2209104, 'SANTA CRUZ DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2209005, 'RIO GRANDE DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2208908, 'RIBEIRO GONCALVES', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2208874, 'RIBEIRA DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2208858, 'RIACHO FRIO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2208809, 'REGENERACAO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2208700, 'REDENCAO DO GURGUEIA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2208650, 'QUEIMADA NOVA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2208601, 'PRATA DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2208551, 'PORTO ALEGRE DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2208502, 'PORTO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2208403, 'PIRIPIRI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2208304, 'PIRACURUCA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2208205, 'PIO IX', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2208106, 'PIMENTEIRAS', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2208007, 'PICOS', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2207934, 'PEDRO LAURENTINO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2207900, 'PEDRO II', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2207850, 'PAVUSSU', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2207801, 'PAULISTANA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2207793, 'PAU D ARCO DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2207777, 'PATOS DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2207751, 'PASSAGEM FRANCA DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2207702, 'PARNAIBA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2207603, 'PARNAGUA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2207553, 'PAQUETA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2207504, 'PALMEIRAIS', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2207405, 'PALMEIRA DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2207355, 'PAJEU DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2207306, 'PAES LANDIM', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2207207, 'PADRE MARCOS', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2207108, 'OLHO D AGUA DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2207009, 'OEIRAS', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2206951, 'NOVO SANTO ANTONIO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2206902, 'NOVO ORIENTE DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2207959, 'NOVA SANTA RITA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2206803, 'NOSSA SENHORA DOS REMEDIOS', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2206753, 'NOSSA SENHORA DE NAZARE', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2206720, 'NAZARIA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2206704, 'NAZARE DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2206696, 'MURICI DOS PORTELAS', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2206670, 'MORRO DO CHAPEU DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2206654, 'MORRO CABECA NO TEMPO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2206605, 'MONTE ALEGRE DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2206506, 'MONSENHOR HIPOLITO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2206407, 'MONSENHOR GIL', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2206357, 'MILTON BRANDAO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2206308, 'MIGUEL LEAO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2206209, 'MIGUEL ALVES', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2206100, 'MATIAS OLIMPIO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2206050, 'MASSAPE DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2206001, 'MARCOS PARENTE', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2205953, 'MARCOLANDIA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2205904, 'MANOEL EMIDIO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2205854, 'MADEIRO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2205805, 'LUZILANDIA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2205706, 'LUIS CORREIA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2205607, 'LANDRI SALES', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2205540, 'LAGOINHA DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2205599, 'LAGOA DO SITIO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2205581, 'LAGOA DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2205565, 'LAGOA DO BARRO DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2205573, 'LAGOA DE SAO FRANCISCO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2205557, 'LAGOA ALEGRE', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2205532, 'JUREMA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2205524, 'JULIO BORGES', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2205516, 'JUAZEIRO DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2205508, 'JOSE DE FREITAS', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2205458, 'JOCA MARQUES', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2205409, 'JOAQUIM PIRES', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2205359, 'JOAO COSTA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2205300, 'JERUMENHA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2205276, 'JATOBA DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2205250, 'JARDIM DO MULATO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2205201, 'JAICOS', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2205151, 'JACOBINA DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2205102, 'ITAUEIRA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2205003, 'ITAINOPOLIS', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2204907, 'ISAIAS COELHO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2204808, 'IPIRANGA DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2204709, 'INHUMA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2204659, 'ILHA GRANDE', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2204600, 'HUGO NAPOLEAO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2204550, 'GUARIBAS', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2204501, 'GUADALUPE', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2204402, 'GILBUES', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2204352, 'GEMINIANO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2204303, 'FRONTEIRAS', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2204204, 'FRANCISCO SANTOS', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2204154, 'FRANCISCO MACEDO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2204105, 'FRANCISCO AYRES', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2204006, 'FRANCINOPOLIS', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2203909, 'FLORIANO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2203859, 'FLORESTA DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2203800, 'FLORES DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2203750, 'FARTURA DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2203701, 'ESPERANTINA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2203602, 'ELISEU MARTINS', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2203503, 'ELESBAO VELOSO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2203453, 'DOM INOCENCIO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2203420, 'DOMINGOS MOURAO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2203404, 'DOM EXPEDITO LOPES', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2203354, 'DIRCEU ARCOVERDE', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2203305, 'DEMERVAL LOBAO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2203271, 'CURRAL NOVO DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2203255, 'CURRALINHOS', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2203230, 'CURRAIS', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2203206, 'CURIMATA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2203107, 'CRISTINO CASTRO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2203008, 'CRISTALANDIA DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202901, 'CORRENTE', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202851, 'CORONEL JOSE DIAS', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202802, 'CONCEICAO DO CANINDE', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202778, 'COLONIA DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202752, 'COLONIA DO GURGUEIA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202737, 'COIVARAS', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202729, 'COCAL DOS ALVES', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202711, 'COCAL DE TELHA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202703, 'COCAL', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202653, 'CAXINGO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202604, 'CASTELO DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202554, 'CARIDADE DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202539, 'CARAUBAS DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202505, 'CARACOL', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202455, 'CAPITAO GERVASIO OLIVEIRA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202406, 'CAPITAO DE CAMPOS', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202307, 'CANTO DO BURITI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202251, 'CANAVIEIRA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202208, 'CAMPO MAIOR', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202174, 'CAMPO LARGO DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202133, 'CAMPO GRANDE DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202117, 'CAMPO ALEGRE DO FIDALGO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202109, 'CAMPINAS DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202091, 'CALDEIRAO GRANDE DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202083, 'CAJUEIRO DA PRAIA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202075, 'CAJAZEIRAS DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202059, 'CABECEIRAS DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202026, 'BURITI DOS MONTES', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2202000, 'BURITI DOS LOPES', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2201988, 'BREJO DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2201960, 'BRASILEIRA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2201945, 'BOQUEIRAO DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2201929, 'BONFIM DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2201919, 'BOM PRINCIPIO DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2201903, 'BOM JESUS', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2201804, 'BOCAINA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2201770, 'BOA HORA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2201739, 'BETANIA DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2201705, 'BERTOLINIA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2201606, 'BENEDITINOS', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2201572, 'BELEM DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2201556, 'BELA VISTA DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2201507, 'BATALHA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2201408, 'BARRO DURO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2201309, 'BARREIRAS DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2201200, 'BARRAS', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2201176, 'BARRA D ALCANTARA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2201150, 'BAIXA GRANDE DO RIBEIRO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2201101, 'AVELINO LOPES', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2201051, 'ASSUNCAO DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2201002, 'ARRAIAL', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2200954, 'AROEIRAS DO ITAIM', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2200905, 'AROAZES', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2200806, 'ANTONIO ALMEIDA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2200707, 'ANISIO DE ABREU', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2200608, 'ANGICAL DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2200509, 'AMARANTE', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2200459, 'ALVORADA DO GURGUEIA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2200400, 'ALTOS', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2200301, 'ALTO LONGA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2200277, 'ALEGRETE DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2200251, 'ALAGOINHA DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2200202, 'AGUA BRANCA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2200103, 'AGRICOLANDIA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2200053, 'ACAUA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2211100, 'UNIAO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2211001, 'TERESINA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2210979, 'TANQUE DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2210953, 'TAMBORIL DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2210938, 'SUSSUAPARA', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2210904, 'SOCORRO DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2210805, 'SIMPLICIO MENDES', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2210706, 'SIMOES', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2210656, 'SIGEFREDO PACHECO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2210631, 'SEBASTIAO LEAL', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2210623, 'SEBASTIAO BARROS', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2210607, 'SAO RAIMUNDO NONATO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2210508, 'SAO PEDRO DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2210409, 'SAO MIGUEL DO TAPUIO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2210391, 'SAO MIGUEL DO FIDALGO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2210383, 'SAO MIGUEL DA BAIXA GRANDE', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2210375, 'SAO LUIS DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2210359, 'SAO LOURENCO DO PIAUI', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2210300, 'SAO JULIAO', 'PI'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2210201, 'SAO JOSE DO PIAUI', 'PI'); ";
    
    $this->execute($sSql);
  }

  public function down() {
  
    $sSql = "DELETE FROM municipios WHERE uf = 'PI'; ";
    $this->execute($sSql);
  }
}