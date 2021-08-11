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


class PopulaTabelaMunicipiosGO extends Ruckusing_Migration_Base {
  
  public function up() {
  
    $sSql  = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5222302, 'VILA PROPICIO', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5222203, 'VILA BOA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5222054, 'VICENTINOPOLIS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5222005, 'VIANOPOLIS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5221908, 'VARJAO', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5221858, 'VALPARAISO DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5221809, 'URUTAI', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5221700, 'URUANA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5221601, 'URUACU', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5221577, 'UIRAPURU', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5221551, 'TURVELANDIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5221502, 'TURVANIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5221452, 'TROMBAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5221403, 'TRINDADE', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5221304, 'TRES RANCHOS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5221197, 'TEREZOPOLIS DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5221080, 'TERESINA DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5221007, 'TAQUARAL DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5220702, 'SITIO D ABADIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5220686, 'SIMOLANDIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5220603, 'SILVANIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5220504, 'SERRANOPOLIS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5220454, 'SENADOR CANEDO', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5220405, 'SAO SIMAO', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5220280, 'SAO PATRICIO', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5220264, 'SAO MIGUEL DO PASSA QUATRO', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5220207, 'SAO MIGUEL DO ARAGUAIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5220157, 'SAO LUIZ DO NORTE', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5220108, 'SAO LUIS DE MONTES BELOS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5220058, 'SAO JOAO DA PARAUNA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5220009, 'SAO JOAO D ALIANCA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5219902, 'SAO FRANCISCO DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5219803, 'SAO DOMINGOS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5219753, 'SANTO ANTONIO DO DESCOBERTO', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5219738, 'SANTO ANTONIO DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5219712, 'SANTO ANTONIO DA BARRA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5219704, 'SANTA TEREZINHA DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5219605, 'SANTA TEREZA DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5219506, 'SANTA ROSA DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5219456, 'SANTA RITA DO NOVO DESTINO', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5219407, 'SANTA RITA DO ARAGUAIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5219357, 'SANTA ISABEL', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5219308, 'SANTA HELENA DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5219258, 'SANTA FE DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5219209, 'SANTA CRUZ DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5219100, 'SANTA BARBARA DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5219001, 'SANCLERLANDIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5218904, 'RUBIATABA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5218805, 'RIO VERDE', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5218789, 'RIO QUENTE', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5218706, 'RIANAPOLIS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5218607, 'RIALMA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5218508, 'QUIRINOPOLIS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5218391, 'PROFESSOR JAMIL', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5218300, 'POSSE', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5218102, 'PORTELANDIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5218052, 'PORTEIRAO', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5218003, 'PORANGATU', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5217708, 'PONTALINA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5217609, 'PLANALTINA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5217401, 'PIRES DO RIO', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5217302, 'PIRENOPOLIS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5217203, 'PIRANHAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5217104, 'PIRACANJUBA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5216908, 'PILAR DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5216809, 'PETROLINA DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5216452, 'PEROLANDIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5216403, 'PARAUNA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5216304, 'PARANAIGUARA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5216007, 'PANAMA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5214408, 'NAZARIO', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5214101, 'MUTUNOPOLIS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5214051, 'MUNDO NOVO', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5214002, 'MOZARLANDIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5213905, 'MOSSAMEDES', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5213855, 'MORRO AGUDO DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5213806, 'MORRINHOS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5213772, 'MONTIVIDIU DO NORTE', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5213756, 'MONTIVIDIU', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5213707, 'MONTES CLAROS DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5213509, 'MONTE ALEGRE DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5213400, 'MOIPORA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5213103, 'MINEIROS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5213087, 'MINACU', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5213053, 'MIMOSO DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5213004, 'MAURILANDIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5212956, 'MATRINCHA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5212907, 'MARZAGAO', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5212808, 'MARA ROSA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5212709, 'MAMBAI', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5212600, 'MAIRIPOTABA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5212501, 'LUZIANIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5212303, 'LEOPOLDO DE BULHOES', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5212253, 'LAGOA SANTA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5212204, 'JUSSARA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5212105, 'JOVIANIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5212055, 'JESUPOLIS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5212006, 'JAUPACI', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5211909, 'JATAI', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5211800, 'JARAGUA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5211701, 'JANDAIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5211602, 'IVOLANDIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5211503, 'ITUMBIARA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5211404, 'ITAUCU', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5211305, 'ITARUMA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5211206, 'ITAPURANGA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5211008, 'ITAPIRAPUA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5210901, 'ITAPACI', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5210802, 'ITAJA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5210604, 'ITAGUARU', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5210562, 'ITAGUARI', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5210406, 'ITABERAI', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5210307, 'ISRAELANDIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5210208, 'IPORA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5210158, 'IPIRANGA DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5210109, 'IPAMERI', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5210000, 'INHUMAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5209952, 'INDIARA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5209937, 'INACIOLANDIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5209903, 'IACIARA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5209804, 'HIDROLINA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5209705, 'HIDROLANDIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5209606, 'HEITORAI', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5209457, 'GUARINOS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5209408, 'GUARANI DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5209291, 'GUARAITA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5209200, 'GUAPO', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5209150, 'GOUVELANDIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5209101, 'GOIATUBA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5208905, 'GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5208806, 'GOIANIRA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5208707, 'GOIANIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5208608, 'GOIANESIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5208509, 'GOIANDIRA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5208400, 'GOIANAPOLIS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5208152, 'GAMELEIRA DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5208103, 'FORMOSO', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5208004, 'FORMOSA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5207907, 'FLORES DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5207808, 'FIRMINOPOLIS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5207600, 'FAZENDA NOVA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5207535, 'FAINA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5207501, 'ESTRELA DO NORTE', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5207402, 'EDEIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5207352, 'EDEALINA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5207253, 'DOVERLANDIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5208301, 'DIVINOPOLIS DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5207105, 'DIORAMA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5206909, 'DAVINOPOLIS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5206800, 'DAMOLANDIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5206701, 'DAMIANOPOLIS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5206602, 'CUMARI', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5206503, 'CROMINIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5206404, 'CRIXAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5206305, 'CRISTIANOPOLIS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5206206, 'CRISTALINA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5205901, 'CORUMBAIBA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5205802, 'CORUMBA DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5205703, 'CORREGO DO OURO', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5205521, 'COLINAS DO SUL', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5205513, 'COCALZINHO DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5205497, 'CIDADE OCIDENTAL', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5205471, 'CHAPADAO DO CEU', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5205455, 'CEZARINA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5205406, 'CERES', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5205307, 'CAVALCANTE', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5205208, 'CATURAI', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5205109, 'CATALAO', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5205059, 'CASTELANDIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5205000, 'CARMO DO RIO VERDE', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5204953, 'CAMPOS VERDES', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5204904, 'CAMPOS BELOS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5204854, 'CAMPO LIMPO DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5204805, 'CAMPO ALEGRE DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5204706, 'CAMPINORTE', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5204656, 'CAMPINACU', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5204607, 'CAMPESTRE DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5204557, 'CALDAZINHA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5204508, 'CALDAS NOVAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5204409, 'CAIAPONIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5204300, 'CACU', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5204250, 'CACHOEIRA DOURADA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5204201, 'CACHOEIRA DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5204102, 'CACHOEIRA ALTA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5204003, 'CABECEIRAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5203962, 'BURITINOPOLIS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5203939, 'BURITI DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5203906, 'BURITI ALEGRE', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5203807, 'BRITANIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5203609, 'BRAZABRANTES', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5203575, 'BONOPOLIS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5203559, 'BONFINOPOLIS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5203500, 'BOM JESUS DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5203401, 'BOM JARDIM DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5203302, 'BELA VISTA DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5203203, 'BARRO ALTO', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5203104, 'BALIZA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5202809, 'AVELINOPOLIS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5202601, 'AURILANDIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5202502, 'ARUANA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5202353, 'ARENOPOLIS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5202155, 'ARAGUAPAZ', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5201801, 'ARAGOIANIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5201702, 'ARAGARCAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5201603, 'ARACU', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5201504, 'APORE', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5201454, 'APARECIDA DO RIO DOCE', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5201405, 'APARECIDA DE GOIANIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5201306, 'ANICUNS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5201207, 'ANHANGUERA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5201108, 'ANAPOLIS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5200902, 'AMORINOPOLIS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5200852, 'AMERICANO DO BRASIL', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5200829, 'AMARALINA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5200803, 'ALVORADA DO NORTE', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5200605, 'ALTO PARAISO DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5200555, 'ALTO HORIZONTE', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5200506, 'ALOANDIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5200308, 'ALEXANIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5200258, 'AGUAS LINDAS DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5200209, 'AGUA LIMPA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5200175, 'AGUA FRIA DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5200159, 'ADELANDIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5200134, 'ACREUNA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5200100, 'ABADIANIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5200050, 'ABADIA DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5215900, 'PALMINOPOLIS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5215801, 'PALMELO', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5215702, 'PALMEIRAS DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5215652, 'PALESTINA DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5215603, 'PADRE BERNARDO', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5215504, 'OUVIDOR', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5215405, 'OURO VERDE DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5215306, 'ORIZONA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5215256, 'NOVO PLANALTO', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5215231, 'NOVO GAMA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5215207, 'NOVO BRASIL', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5215009, 'NOVA VENEZA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5214903, 'NOVA ROMA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5214879, 'NOVA IGUACU DE GOIAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5214861, 'NOVA GLORIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5214838, 'NOVA CRIXAS', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5214804, 'NOVA AURORA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5214705, 'NOVA AMERICA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5214606, 'NIQUELANDIA', 'GO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5214507, 'NEROPOLIS', 'GO'); ";
    
    $this->execute($sSql);
  }

  public function down() {
  
    $sSql = "DELETE FROM municipios WHERE uf = 'GO'; ";
    $this->execute($sSql);
  }
}