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


class PopulaTabelaPaises extends Ruckusing_Migration_Base {
  
  public function up() {

    $sSql  = "INSERT INTO paises (cod_bacen, nome) VALUES ('00132', 'AFEGANISTAO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00175', 'ALBANIA, REPUBLICA  DA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00230', 'ALEMANHA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00310', 'BURKINA FASO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00370', 'ANDORRA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00400', 'ANGOLA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00418', 'ANGUILLA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00434', 'ANTIGUA E BARBUDA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00477', 'ANTILHAS HOLANDESAS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00531', 'ARABIA SAUDITA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00590', 'ARGELIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00639', 'ARGENTINA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00647', 'ARMENIA, REPUBLICA DA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00655', 'ARUBA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00698', 'AUSTRALIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00728', 'AUSTRIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00736', 'AZERBAIJAO, REPUBLICA DO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00779', 'BAHAMAS, ILHAS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00809', 'BAHREIN, ILHAS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00817', 'BANGLADESH'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00833', 'BARBADOS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00850', 'BELARUS, REPUBLICA DA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00876', 'BELGICA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00884', 'BELIZE'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00906', 'BERMUDAS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00930', 'MIANMAR (BIRMANIA)'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00973', 'BOLIVIA, ESTADO PLURINACIONAL DA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('00981', 'BOSNIA-HERZEGOVINA (REPUBLICA DA)'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01015', 'BOTSUANA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01058', 'BRASIL'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01082', 'BRUNEI'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01112', 'BULGARIA, REPUBLICA DA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01155', 'BURUNDI'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01198', 'BUTAO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01279', 'CABO VERDE, REPUBLICA DE'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01376', 'CAYMAN, ILHAS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01414', 'CAMBOJA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01457', 'CAMAROES'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01490', 'CANADA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01504', 'GUERNSEY, ILHA DO CANAL (INCLUI ALDERNEY E SARK)'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01508', 'JERSEY, ILHA DO CANAL'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01511', 'CANARIAS, ILHAS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01538', 'CAZAQUISTAO, REPUBLICA DO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01546', 'CATAR'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01589', 'CHILE'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01600', 'CHINA, REPUBLICA POPULAR'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01619', 'FORMOSA (TAIWAN)'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01635', 'CHIPRE'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01651', 'COCOS(KEELING),ILHAS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01694', 'COLOMBIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01732', 'COMORES, ILHAS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01775', 'CONGO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01830', 'COOK, ILHAS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01872', 'COREIA (DO NORTE), REP.POP.DEMOCRATICA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01902', 'COREIA (DO SUL), REPUBLICA DA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01937', 'COSTA DO MARFIM'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01953', 'CROACIA (REPUBLICA DA)'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01961', 'COSTA RICA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01988', 'COVEITE'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('01996', 'CUBA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('02291', 'BENIN'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('02321', 'DINAMARCA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('02356', 'DOMINICA,ILHA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('02399', 'EQUADOR'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('02402', 'EGITO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('02437', 'ERITREIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('02445', 'EMIRADOS ARABES UNIDOS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('02453', 'ESPANHA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('02461', 'ESLOVENIA, REPUBLICA DA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('02470', 'ESLOVACA, REPUBLICA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('02496', 'ESTADOS UNIDOS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('02518', 'ESTONIA, REPUBLICA DA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('02534', 'ETIOPIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('02550', 'FALKLAND (ILHAS MALVINAS)'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('02593', 'FEROE, ILHAS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('02674', 'FILIPINAS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('02712', 'FINLANDIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('02755', 'FRANCA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('02810', 'GABAO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('02852', 'GAMBIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('02895', 'GANA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('02917', 'GEORGIA, REPUBLICA DA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('02933', 'GIBRALTAR'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('02976', 'GRANADA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03018', 'GRECIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03050', 'GROENLANDIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03093', 'GUADALUPE'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03131', 'GUAM'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03174', 'GUATEMALA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03255', 'GUIANA FRANCESA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03298', 'GUINE'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03310', 'GUINE-EQUATORIAL'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03344', 'GUINE-BISSAU'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03379', 'GUIANA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03417', 'HAITI'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03450', 'HONDURAS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03514', 'HONG KONG'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03557', 'HUNGRIA, REPUBLICA DA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03573', 'IEMEN'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03595', 'MAN, ILHA DE'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03611', 'INDIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03654', 'INDONESIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03697', 'IRAQUE'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03727', 'IRA, REPUBLICA ISLAMICA DO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03751', 'IRLANDA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03794', 'ISLANDIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03832', 'ISRAEL'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03867', 'ITALIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03913', 'JAMAICA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03964', 'JOHNSTON, ILHAS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('03999', 'JAPAO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04030', 'JORDANIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04111', 'KIRIBATI'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04200', 'LAOS, REP.POP.DEMOCR.DO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04235', 'LEBUAN,ILHAS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04260', 'LESOTO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04278', 'LETONIA, REPUBLICA DA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04316', 'LIBANO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04340', 'LIBERIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04383', 'LIBIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04405', 'LIECHTENSTEIN'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04421', 'LITUANIA, REPUBLICA DA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04456', 'LUXEMBURGO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04472', 'MACAU'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04499', 'MACEDONIA, ANT.REP.IUGOSLAVA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04502', 'MADAGASCAR'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04525', 'MADEIRA, ILHA DA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04553', 'MALASIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04588', 'MALAVI'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04618', 'MALDIVAS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04642', 'MALI'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04677', 'MALTA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04723', 'MARIANAS DO NORTE'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04740', 'MARROCOS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04766', 'MARSHALL,ILHAS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04774', 'MARTINICA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04855', 'MAURICIO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04880', 'MAURITANIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04885', 'MAYOTTE (ILHAS FRANCESAS)'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04901', 'MIDWAY, ILHAS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04936', 'MEXICO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04944', 'MOLDAVIA, REPUBLICA DA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04952', 'MONACO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04979', 'MONGOLIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04985', 'MONTENEGRO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('04995', 'MICRONESIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('05010', 'MONTSERRAT,ILHAS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('05053', 'MOCAMBIQUE'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('05070', 'NAMIBIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('05088', 'NAURU'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('05118', 'CHRISTMAS,ILHA (NAVIDAD)'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('05177', 'NEPAL'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('05215', 'NICARAGUA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('05258', 'NIGER'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('05282', 'NIGERIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('05312', 'NIUE,ILHA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('05355', 'NORFOLK,ILHA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('05380', 'NORUEGA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('05428', 'NOVA CALEDONIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('05452', 'PAPUA NOVA GUINE'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('05487', 'NOVA ZELANDIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('05517', 'VANUATU'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('05568', 'OMA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('05665', 'PACIFICO,ILHAS DO (POSSESSAO DOS EUA)'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('05738', 'PAISES BAIXOS (HOLANDA)'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('05754', 'PALAU'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('05762', 'PAQUISTAO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('05800', 'PANAMA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('05860', 'PARAGUAI'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('05894', 'PERU'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('05932', 'PITCAIRN,ILHA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('05991', 'POLINESIA FRANCESA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('06033', 'POLONIA, REPUBLICA DA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('06076', 'PORTUGAL'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('06114', 'PORTO RICO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('06238', 'QUENIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('06254', 'QUIRGUIZ, REPUBLICA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('06289', 'REINO UNIDO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('06408', 'REPUBLICA CENTRO-AFRICANA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('06475', 'REPUBLICA DOMINICANA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('06602', 'REUNIAO, ILHA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('06653', 'ZIMBABUE'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('06700', 'ROMENIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('06750', 'RUANDA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('06769', 'RUSSIA, FEDERACAO DA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('06777', 'SALOMAO, ILHAS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('06858', 'SAARA OCIDENTAL'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('06874', 'EL SALVADOR'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('06904', 'SAMOA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('06912', 'SAMOA AMERICANA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('06955', 'SAO CRISTOVAO E NEVES,ILHAS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('06971', 'SAN MARINO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07005', 'SAO PEDRO E MIQUELON'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07056', 'SAO VICENTE E GRANADINAS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07102', 'SANTA HELENA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07153', 'SANTA LUCIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07200', 'SAO TOME E PRINCIPE, ILHAS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07285', 'SENEGAL'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07315', 'SEYCHELLES'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07358', 'SERRA LEOA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07370', 'SERVIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07412', 'CINGAPURA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07447', 'SIRIA, REPUBLICA ARABE DA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07480', 'SOMALIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07501', 'SRI LANKA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07544', 'SUAZILANDIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07560', 'AFRICA DO SUL'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07595', 'SUDAO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07641', 'SUECIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07676', 'SUICA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07706', 'SURINAME'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07722', 'TADJIQUISTAO, REPUBLICA DO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07765', 'TAILANDIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07803', 'TANZANIA, REP.UNIDA DA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07820', 'TERRITORIO BRIT.OC.INDICO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07838', 'DJIBUTI'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07889', 'CHADE'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07919', 'TCHECA, REPUBLICA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('07951', 'TIMOR LESTE'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('08001', 'TOGO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('08052', 'TOQUELAU,ILHAS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('08109', 'TONGA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('08150', 'TRINIDAD E TOBAGO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('08206', 'TUNISIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('08230', 'TURCAS E CAICOS,ILHAS'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('08249', 'TURCOMENISTAO, REPUBLICA DO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('08273', 'TURQUIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('08281', 'TUVALU'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('08311', 'UCRANIA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('08338', 'UGANDA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('08451', 'URUGUAI'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('08478', 'UZBEQUISTAO, REPUBLICA DO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('08486', 'VATICANO, EST.DA CIDADE DO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('08508', 'VENEZUELA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('08583', 'VIETNA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('08630', 'VIRGENS,ILHAS (BRITANICAS)'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('08664', 'VIRGENS,ILHAS (E.U.A.)'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('08702', 'FIJI'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('08737', 'WAKE, ILHA'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('08885', 'CONGO, REPUBLICA DEMOCRATICA DO'); ";
    $sSql .= "INSERT INTO paises (cod_bacen, nome) VALUES ('08907', 'ZAMBIA'); ";

    $this->execute($sSql);
    
  }

  public function down() {
    
    $sSql = "DELETE FROM paises; ";
    $this->execute($sSql);
  }
}