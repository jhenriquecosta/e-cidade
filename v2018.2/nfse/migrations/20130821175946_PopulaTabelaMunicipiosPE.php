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


class PopulaTabelaMunicipiosPE extends Ruckusing_Migration_Base {
  
  public function up() {
  
    $sSql  = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2611533, 'QUIXABA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2611507, 'QUIPAPA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2611408, 'PRIMAVERA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2611309, 'POMBOS', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2611200, 'POCAO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2611101, 'PETROLINA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2611002, 'PETROLANDIA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2610905, 'PESQUEIRA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2610806, 'PEDRA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2610707, 'PAULISTA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2610608, 'PAUDALHO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2610509, 'PASSIRA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2610400, 'PARNAMIRIM', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2610301, 'PARANATAMA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2610202, 'PANELAS', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2610103, 'PALMEIRINA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2610004, 'PALMARES', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2609907, 'OURICURI', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2609808, 'OROCO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2608206, 'JOAQUIM NABUCO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2608107, 'JOAO ALFREDO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2608057, 'JATOBA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2608008, 'JATAUBA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2607950, 'JAQUEIRA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2607901, 'JABOATAO DOS GUARARAPES', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2607802, 'ITAQUITINGA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2607752, 'ITAPISSUMA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2607703, 'ITAPETIM', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2607653, 'ITAMBE', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2607505, 'ITAIBA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2607406, 'ITACURUBA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2607307, 'IPUBI', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2607208, 'IPOJUCA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2607109, 'INGAZEIRA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2607000, 'INAJA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2607604, 'ILHA DE ITAMARACA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2606903, 'IGUARACI', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2606804, 'IGARASSU', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2606705, 'IBIRAJUBA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2606606, 'IBIMIRIM', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2606507, 'IATI', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2606408, 'GRAVATA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2606309, 'GRANITO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2606200, 'GOIANA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2606101, 'GLORIA DO GOITA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2606002, 'GARANHUNS', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2605905, 'GAMELEIRA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2605806, 'FREI MIGUELINHO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2605707, 'FLORESTA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2605608, 'FLORES', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2605509, 'FERREIROS', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2605459, 'FERNANDO DE NORONHA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2605400, 'FEIRA NOVA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2605301, 'EXU', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2605202, 'ESCADA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2605152, 'DORMENTES', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2605103, 'CUSTODIA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2605004, 'CUPIRA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2604908, 'CUMARU', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2604809, 'CORTES', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2604700, 'CORRENTES', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2604601, 'CONDADO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2604502, 'CHA GRANDE', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2604403, 'CHA DE ALEGRIA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2604304, 'CEDRO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2604205, 'CATENDE', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2604155, 'CASINHAS', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2604106, 'CARUARU', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2604007, 'CARPINA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2603926, 'CARNAUBEIRA DA PENHA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2603900, 'CARNAIBA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2603801, 'CAPOEIRAS', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2603702, 'CANHOTINHO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2603603, 'CAMUTANGA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2603504, 'CAMOCIM DE SAO FELIX', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2603454, 'CAMARAGIBE', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2603405, 'CALUMBI', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2603306, 'CALCADO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2603207, 'CAETES', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2603108, 'CACHOEIRINHA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2603009, 'CABROBO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2602902, 'CABO DE SANTO AGOSTINHO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2602803, 'BUIQUE', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2602704, 'BUENOS AIRES', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2602605, 'BREJO DA MADRE DE DEUS', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2602506, 'BREJINHO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2602407, 'BREJAO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2602308, 'BONITO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2602209, 'BOM JARDIM', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2602100, 'BOM CONSELHO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2602001, 'BODOCO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2601904, 'BEZERROS', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2601805, 'BETANIA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2601706, 'BELO JARDIM', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2601607, 'BELEM DO SAO FRANCISCO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2601508, 'BELEM DE MARIA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2601409, 'BARREIROS', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2601300, 'BARRA DE GUABIRABA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2601201, 'ARCOVERDE', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2601102, 'ARARIPINA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2601052, 'ARACOIABA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2601003, 'ANGELIM', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2600906, 'AMARAJI', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2600807, 'ALTINHO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2600708, 'ALIANCA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2600609, 'ALAGOINHA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2600500, 'AGUAS BELAS', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2600401, 'AGUA PRETA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2600302, 'AGRESTINA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2600203, 'AFRANIO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2600104, 'AFOGADOS DA INGAZEIRA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2600054, 'ABREU E LIMA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2616506, 'XEXEU', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2616407, 'VITORIA DE SANTO ANTAO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2616308, 'VICENCIA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2616209, 'VERTENTES', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2616183, 'VERTENTE DO LERIO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2616100, 'VERDEJANTE', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2616001, 'VENTUROSA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2615904, 'TUPARETAMA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2615805, 'TUPANATINGA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2615706, 'TRIUNFO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2615607, 'TRINDADE', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2615508, 'TRACUNHAEM', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2615409, 'TORITAMA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2615300, 'TIMBAUBA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2615201, 'TERRA NOVA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2615102, 'TEREZINHA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2615003, 'TAQUARITINGA DO NORTE', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2614857, 'TAMANDARE', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2614808, 'TACARATU', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2614709, 'TACAIMBO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2614600, 'TABIRA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2614501, 'SURUBIM', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2614402, 'SOLIDAO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2614204, 'SIRINHAEM', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2614105, 'SERTANIA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2614006, 'SERRITA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2613909, 'SERRA TALHADA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2613800, 'SAO VICENTE FERRER', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2613701, 'SAO LOURENCO DA MATA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2613602, 'SAO JOSE DO EGITO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2613503, 'SAO JOSE DO BELMONTE', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2613404, 'SAO JOSE DA COROA GRANDE', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2613305, 'SAO JOAQUIM DO MONTE', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2613206, 'SAO JOAO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2613107, 'SAO CAITANO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2613008, 'SAO BENTO DO UNA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2612901, 'SAO BENEDITO DO SUL', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2612802, 'SANTA TEREZINHA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2612703, 'SANTA MARIA DO CAMBUCA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2612604, 'SANTA MARIA DA BOA VISTA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2612554, 'SANTA FILOMENA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2612505, 'SANTA CRUZ DO CAPIBARIBE', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2612471, 'SANTA CRUZ DA BAIXA VERDE', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2612455, 'SANTA CRUZ', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2612406, 'SANHARO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2612307, 'SALOA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2612208, 'SALGUEIRO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2612109, 'SALGADINHO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2612000, 'SAIRE', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2611903, 'RIO FORMOSO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2611804, 'RIBEIRAO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2611705, 'RIACHO DAS ALMAS', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2611606, 'RECIFE', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2609709, 'OROBO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2609600, 'OLINDA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2609501, 'NAZARE DA MATA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2609402, 'MORENO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2614303, 'MOREILANDIA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2609303, 'MIRANDIBA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2609204, 'MARAIAL', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2609154, 'MANARI', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2609105, 'MACHADOS', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2609006, 'MACAPARANA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2608909, 'LIMOEIRO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2608800, 'LAJEDO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2608750, 'LAGOA GRANDE', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2608701, 'LAGOA DOS GATOS', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2608602, 'LAGOA DO OURO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2608453, 'LAGOA DO CARRO', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2608503, 'LAGOA DE ITAENGA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2608404, 'JUREMA', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2608305, 'JUPI', 'PE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2608255, 'JUCATI', 'PE'); ";
    
    $this->execute($sSql);
  }

  public function down() {
    
    $sSql = "DELETE FROM municipios WHERE uf = 'PE'; ";
    $this->execute($sSql);
  }
}