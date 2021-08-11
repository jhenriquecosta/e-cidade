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


class PopulaTabelaMunicipiosSC extends Ruckusing_Migration_Base {
  
  public function up() {
  
    $sSql  = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4211009, 'MONDAI', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4210902, 'MODELO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4210852, 'MIRIM DOCE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4210803, 'MELEIRO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4210704, 'MATOS COSTA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4210605, 'MASSARANDUBA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4210555, 'MAREMA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4210506, 'MARAVILHA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4210407, 'MARACAJA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4210308, 'MAJOR VIEIRA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4210209, 'MAJOR GERCINO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4210100, 'MAFRA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4210050, 'MACIEIRA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4210035, 'LUZERNA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4210001, 'LUIZ ALVES', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4209904, 'LONTRAS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4209854, 'LINDOIA DO SUL', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4209805, 'LEOBERTO LEAL', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4209706, 'LEBON REGIS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4209607, 'LAURO MULLER', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4209508, 'LAURENTINO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4209458, 'LAJEADO GRANDE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4209409, 'LAGUNA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4209300, 'LAGES', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4209201, 'LACERDOPOLIS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4209177, 'JUPIA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4209151, 'JOSE BOITEUX', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4209102, 'JOINVILLE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4209003, 'JOACABA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4208955, 'JARDINOPOLIS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4208906, 'JARAGUA DO SUL', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4208807, 'JAGUARUNA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4208708, 'JACINTO MACHADO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4208609, 'JABORA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4208500, 'ITUPORANGA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4208450, 'ITAPOA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4208401, 'ITAPIRANGA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4208302, 'ITAPEMA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4208203, 'ITAJAI', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4208104, 'ITAIOPOLIS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4208005, 'ITA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4207908, 'IRINEOPOLIS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4207858, 'IRATI', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4207809, 'IRANI', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4207759, 'IRACEMINHA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4207700, 'IPUMIRIM', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4207684, 'IPUACU', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4207650, 'IPORA DO OESTE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4207601, 'IPIRA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4207577, 'IOMERE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4207502, 'INDAIAL', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4207403, 'IMBUIA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4207304, 'IMBITUBA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4207205, 'IMARUI', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4207106, 'ILHOTA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4207007, 'ICARA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4206900, 'IBIRAMA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4206801, 'IBICARE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4206751, 'IBIAM', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4206702, 'HERVAL D OESTE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4206652, 'GUATAMBU', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4206603, 'GUARUJA DO SUL', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4206504, 'GUARAMIRIM', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4206405, 'GUARACIABA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4206306, 'GUABIRUBA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4206108, 'GRAO PARA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4206009, 'GOVERNADOR CELSO RAMOS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4205902, 'GASPAR', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4205803, 'GARUVA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4205704, 'GAROPABA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4205605, 'GALVAO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4205555, 'FREI ROGERIO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4205506, 'FRAIBURGO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4205456, 'FORQUILHINHA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4205431, 'FORMOSA DO SUL', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4205407, 'FLORIANOPOLIS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4205357, 'FLOR DO SERTAO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4205308, 'FAXINAL DOS GUEDES', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4205209, 'ERVAL VELHO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4205191, 'ERMO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4205175, 'ENTRE RIOS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4205159, 'DOUTOR PEDRINHO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4205100, 'DONA EMMA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4205001, 'DIONISIO CERQUEIRA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4204905, 'DESCANSO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4204806, 'CURITIBANOS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4204756, 'CUNHATAI', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4204707, 'CUNHA PORA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4204608, 'CRICIUMA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4204509, 'CORUPA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4204558, 'CORREIA PINTO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4204459, 'CORONEL MARTINS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4204400, 'CORONEL FREITAS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4204350, 'CORDILHEIRA ALTA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4204301, 'CONCORDIA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4204251, 'COCAL DO SUL', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4204202, 'CHAPECO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4204194, 'CHAPADAO DO LAGEADO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4204178, 'CERRO NEGRO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4204152, 'CELSO RAMOS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4204103, 'CAXAMBU DO SUL', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4204004, 'CATANDUVAS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4203956, 'CAPIVARI DE BAIXO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4203907, 'CAPINZAL', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4202453, 'BOMBINHAS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4202438, 'BOCAINA DO SUL', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4202404, 'BLUMENAU', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4202305, 'BIGUACU', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4202206, 'BENEDITO NOVO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4202156, 'BELMONTE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4202131, 'BELA VISTA DO TOLDO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4202107, 'BARRA VELHA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4202099, 'BARRA BONITA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4202081, 'BANDEIRANTE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4212809, 'BALNEARIO PICARRAS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4202073, 'BALNEARIO GAIVOTA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4202008, 'BALNEARIO CAMBORIU', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4202057, 'BALNEARIO BARRA DO SUL', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4201950, 'BALNEARIO ARROIO DO SILVA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4201901, 'AURORA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4201802, 'ATALANTA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4201703, 'ASCURRA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4201653, 'ARVOREDO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4201604, 'ARROIO TRINTA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4201505, 'ARMAZEM', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4201406, 'ARARANGUA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4201307, 'ARAQUARI', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4201273, 'ARABUTA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4201257, 'APIUNA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4201208, 'ANTONIO CARLOS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4201109, 'ANITAPOLIS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4201000, 'ANITA GARIBALDI', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4200903, 'ANGELINA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4200804, 'ANCHIETA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4200754, 'ALTO BELA VISTA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4200705, 'ALFREDO WAGNER', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4200606, 'AGUAS MORNAS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4200556, 'AGUAS FRIAS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4200507, 'AGUAS DE CHAPECO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4200408, 'AGUA DOCE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4200309, 'AGRONOMICA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4200200, 'AGROLANDIA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4200101, 'ABELARDO LUZ', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4200051, 'ABDON BATISTA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4219853, 'ZORTEA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4219705, 'XAXIM', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4219606, 'XAVANTINA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4219507, 'XANXERE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4219408, 'WITMARSUM', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4219358, 'VITOR MEIRELES', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4219309, 'VIDEIRA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4219200, 'VIDAL RAMOS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4219176, 'VARGEM BONITA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4219150, 'VARGEM', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4219101, 'VARGEAO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4219002, 'URUSSANGA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4218954, 'URUPEMA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4218905, 'URUBICI', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4218855, 'UNIAO DO OESTE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4218806, 'TURVO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4218756, 'TUNAPOLIS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4218707, 'TUBARAO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4218608, 'TROMBUDO CENTRAL', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4218509, 'TREZE TILIAS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4218400, 'TREZE DE MAIO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4218350, 'TREVISO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4218301, 'TRES BARRAS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4218251, 'TIMBO GRANDE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4218202, 'TIMBO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4218103, 'TIMBE DO SUL', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4218004, 'TIJUCAS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4217956, 'TIGRINHOS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4217907, 'TANGARA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4217808, 'TAIO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4217758, 'SUL BRASIL', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4217709, 'SOMBRIO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4217600, 'SIDEROPOLIS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4217550, 'SERRA ALTA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4217501, 'SEARA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4217402, 'SCHROEDER', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4217303, 'SAUDADES', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4217253, 'SAO PEDRO DE ALCANTARA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4217204, 'SAO MIGUEL DO OESTE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4217154, 'SAO MIGUEL DA BOA VISTA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4217105, 'SAO MARTINHO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4217006, 'SAO LUDGERO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4216909, 'SAO LOURENCO DO OESTE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4216800, 'SAO JOSE DO CERRITO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4216701, 'SAO JOSE DO CEDRO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4216602, 'SAO JOSE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4216503, 'SAO JOAQUIM', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4216404, 'SAO JOAO DO SUL', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4216255, 'SAO JOAO DO OESTE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4216354, 'SAO JOAO DO ITAPERIU', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4216305, 'SAO JOAO BATISTA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4216206, 'SAO FRANCISCO DO SUL', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4216107, 'SAO DOMINGOS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4216057, 'SAO CRISTOVAO DO SUL', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4216008, 'SAO CARLOS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4215901, 'SAO BONIFACIO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4215752, 'SAO BERNARDINO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4215802, 'SAO BENTO DO SUL', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4215703, 'SANTO AMARO DA IMPERATRIZ', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4215695, 'SANTIAGO DO SUL', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4215687, 'SANTA TEREZINHA DO PROGRESSO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4215679, 'SANTA TEREZINHA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4215653, 'SANTA ROSA DO SUL', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4215604, 'SANTA ROSA DE LIMA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4215554, 'SANTA HELENA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4215505, 'SANTA CECILIA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4215455, 'SANGAO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4215406, 'SALTO VELOSO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4215356, 'SALTINHO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4215307, 'SALETE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4215208, 'ROMELANDIA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4215109, 'RODEIO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4215075, 'RIQUEZA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4215059, 'RIO RUFINO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4215000, 'RIO NEGRINHO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4214904, 'RIO FORTUNA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4214805, 'RIO DO SUL', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4214706, 'RIO DOS CEDROS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4214607, 'RIO DO OESTE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4214508, 'RIO DO CAMPO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4214409, 'RIO DAS ANTAS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4214300, 'RANCHO QUEIMADO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4214201, 'QUILOMBO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4214151, 'PRINCESA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4214102, 'PRESIDENTE NEREU', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4214003, 'PRESIDENTE GETULIO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4213906, 'PRESIDENTE CASTELLO BRANCO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4213807, 'PRAIA GRANDE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4213708, 'POUSO REDONDO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4213609, 'PORTO UNIAO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4213500, 'PORTO BELO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4213401, 'PONTE SERRADA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4213351, 'PONTE ALTA DO NORTE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4213302, 'PONTE ALTA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4213203, 'POMERODE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4213153, 'PLANALTO ALEGRE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4213104, 'PIRATUBA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4213005, 'PINHEIRO PRETO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4212908, 'PINHALZINHO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4212700, 'PETROLANDIA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4212601, 'PERITIBA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4212502, 'PENHA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4212403, 'PEDRAS GRANDES', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4212304, 'PAULO LOPES', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4212270, 'PASSOS MAIA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4212254, 'PASSO DE TORRES', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4212239, 'PARAISO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4212205, 'PAPANDUVA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4212106, 'PALMITOS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4212056, 'PALMEIRA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4212007, 'PALMA SOLA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4211900, 'PALHOCA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4211892, 'PAINEL', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4211876, 'PAIAL', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4211850, 'OURO VERDE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4211801, 'OURO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4211751, 'OTACILIO COSTA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4211702, 'ORLEANS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4211652, 'NOVO HORIZONTE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4211603, 'NOVA VENEZA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4211504, 'NOVA TRENTO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4211454, 'NOVA ITABERABA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4211405, 'NOVA ERECHIM', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4211306, 'NAVEGANTES', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4211256, 'MORRO GRANDE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4211207, 'MORRO DA FUMACA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4211108, 'MONTE CASTELO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4211058, 'MONTE CARLO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4203253, 'CAPAO ALTO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4203808, 'CANOINHAS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4203709, 'CANELINHA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4203600, 'CAMPOS NOVOS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4203501, 'CAMPO ERE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4203402, 'CAMPO BELO DO SUL', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4203303, 'CAMPO ALEGRE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4203204, 'CAMBORIU', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4203154, 'CALMON', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4203105, 'CAIBI', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4203006, 'CACADOR', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4202909, 'BRUSQUE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4202875, 'BRUNOPOLIS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4202859, 'BRACO DO TROMBUDO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4202800, 'BRACO DO NORTE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4202701, 'BOTUVERA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4202602, 'BOM RETIRO', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4202578, 'BOM JESUS DO OESTE', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4202537, 'BOM JESUS', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4202503, 'BOM JARDIM DA SERRA', 'SC'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (4206207, 'GRAVATAL', 'SC'); ";
    
    $this->execute($sSql);
  }

  public function down() {
  
    $sSql = "DELETE FROM municipios WHERE uf = 'SC'; ";
    $this->execute($sSql);
  }
}