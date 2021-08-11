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


class PopulaTabelaMunicipiosCE extends Ruckusing_Migration_Base {
  
  public function up() {
  
    $sSql  = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2310209, 'PARACURU', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2310100, 'PALMACIA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2310001, 'PALHANO', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2309904, 'PACUJA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2309805, 'PACOTI', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2309706, 'PACATUBA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2309607, 'PACAJUS', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2309508, 'OROS', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2309458, 'OCARA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2309409, 'NOVO ORIENTE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2309300, 'NOVA RUSSAS', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2309201, 'NOVA OLINDA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2309102, 'MULUNGU', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2309003, 'MUCAMBO', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2308906, 'MORRINHOS', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2308807, 'MORAUJO', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2308708, 'MORADA NOVA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2308609, 'MONSENHOR TABOSA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2308500, 'MOMBACA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2308401, 'MISSAO VELHA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2308377, 'MIRAIMA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2308351, 'MILHA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2308302, 'MILAGRES', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2308203, 'MERUOCA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2308104, 'MAURITI', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2308005, 'MASSAPE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2307908, 'MARTINOPOLE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2307809, 'MARCO', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2307700, 'MARANGUAPE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2307650, 'MARACANAU', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2307635, 'MADALENA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2307601, 'LIMOEIRO DO NORTE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2307502, 'LAVRAS DA MANGABEIRA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2307403, 'JUCAS', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2307304, 'JUAZEIRO DO NORTE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2307254, 'JIJOCA DE JERICOACOARA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2307205, 'JATI', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2307106, 'JARDIM', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2307007, 'JAGUARUANA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2306900, 'JAGUARIBE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2306801, 'JAGUARIBARA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2306702, 'JAGUARETAMA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2306603, 'ITATIRA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2306553, 'ITAREMA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2306504, 'ITAPIUNA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2306405, 'ITAPIPOCA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2306306, 'ITAPAGE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2306256, 'ITAITINGA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2306207, 'ITAICABA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2306108, 'IRAUCUBA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2306009, 'IRACEMA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2305902, 'IPUEIRAS', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2305803, 'IPU', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2305704, 'IPAUMIRIM', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2305654, 'IPAPORANGA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2305605, 'INDEPENDENCIA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2305506, 'IGUATU', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2305407, 'ICO', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2305357, 'ICAPUI', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2305332, 'IBICUITINGA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2305308, 'IBIAPINA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2305266, 'IBARETAMA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2305233, 'HORIZONTE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2305209, 'HIDROLANDIA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2305100, 'GUARAMIRANGA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2305001, 'GUARACIABA DO NORTE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2304954, 'GUAIUBA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2304905, 'GROAIRAS', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2304806, 'GRANJEIRO', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2304707, 'GRANJA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2304657, 'GRACA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2304608, 'GENERAL SAMPAIO', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2304509, 'FRECHEIRINHA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2304459, 'FORTIM', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2304350, 'FORQUILHA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2304301, 'FARIAS BRITO', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2304285, 'EUSEBIO', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2304277, 'ERERE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2304269, 'DEPUTADO IRAPUAN PINHEIRO', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2304251, 'CRUZ', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2304236, 'CROATA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2304202, 'CRATO', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2304103, 'CRATEUS', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2304004, 'COREAU', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2303956, 'CHOROZINHO', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2303931, 'CHORO', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2303907, 'CHAVAL', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2303808, 'CEDRO', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2303709, 'CAUCAIA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2303659, 'CATUNDA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2303600, 'CATARINA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2303501, 'CASCAVEL', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2303402, 'CARNAUBAL', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2303303, 'CARIUS', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2303204, 'CARIRIACU', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2303105, 'CARIRE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2303006, 'CARIDADE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2302909, 'CAPISTRANO', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2302800, 'CANINDE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2302701, 'CAMPOS SALES', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2302602, 'CAMOCIM', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2302503, 'BREJO SANTO', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2302404, 'BOA VIAGEM', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2302305, 'BELA CRUZ', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2302206, 'BEBERIBE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2302107, 'BATURITE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2302057, 'BARROQUINHA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2302008, 'BARRO', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2301950, 'BARREIRA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2301901, 'BARBALHA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2301851, 'BANABUIU', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2301802, 'BAIXIO', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2301703, 'AURORA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2301604, 'ASSARE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2301505, 'ARNEIROZ', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2301406, 'ARATUBA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2301307, 'ARARIPE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2301257, 'ARARENDA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2301208, 'ARACOIABA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2301109, 'ARACATI', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2301000, 'AQUIRAZ', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2300903, 'APUIARES', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2300804, 'ANTONINA DO NORTE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2300754, 'AMONTADA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2300705, 'ALTO SANTO', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2300606, 'ALTANEIRA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2300507, 'ALCANTARAS', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2300408, 'AIUABA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2300309, 'ACOPIARA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2300200, 'ACARAU', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2300150, 'ACARAPE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2300101, 'ABAIARA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2313104, 'TABULEIRO DO NORTE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2313005, 'SOLONOPOLE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2312908, 'SOBRAL', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2312809, 'SENADOR SA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2312700, 'SENADOR POMPEU', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2312601, 'SAO LUIS DO CURU', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2312502, 'SAO JOAO DO JAGUARIBE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2312403, 'SAO GONCALO DO AMARANTE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2312304, 'SAO BENEDITO', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2312205, 'SANTA QUITERIA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2312106, 'SANTANA DO CARIRI', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2312007, 'SANTANA DO ACARAU', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2311959, 'SALITRE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2311900, 'SABOEIRO', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2311801, 'RUSSAS', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2311702, 'RERIUTABA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2314102, 'VICOSA DO CEARA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2314003, 'VARZEA ALEGRE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2313955, 'VARJOTA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2313906, 'URUOCA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2313807, 'URUBURETAMA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2313757, 'UMIRIM', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2313708, 'UMARI', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2313609, 'UBAJARA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2313559, 'TURURU', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2313500, 'TRAIRI', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2313401, 'TIANGUA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2313351, 'TEJUCUOCA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2313302, 'TAUA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2313252, 'TARRAFAS', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2313203, 'TAMBORIL', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2311603, 'REDENCAO', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2311504, 'QUIXERE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2311405, 'QUIXERAMOBIM', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2311355, 'QUIXELO', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2311306, 'QUIXADA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2311264, 'QUITERIANOPOLIS', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2311231, 'POTIRETAMA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2311207, 'POTENGI', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2311108, 'PORTEIRAS', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2311009, 'PORANGA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2310951, 'PIRES FERREIRA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2310902, 'PIQUET CARNEIRO', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2310852, 'PINDORETAMA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2310803, 'PEREIRO', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2310704, 'PENTECOSTE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2310605, 'PENAFORTE', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2310506, 'PEDRA BRANCA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2310407, 'PARAMOTI', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2310308, 'PARAMBU', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2310258, 'PARAIPABA', 'CE'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2304400, 'FORTALEZA', 'CE'); ";
    
    $this->execute($sSql);
  }

  public function down() {
    
    $sSql = "DELETE FROM municipios WHERE uf = 'CE'; ";
    $this->execute($sSql);
  }
}