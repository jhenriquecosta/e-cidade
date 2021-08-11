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


class PopulaTabelaMunicipiosPB extends Ruckusing_Migration_Base {
  
  public function up() {
  
    $sSql  = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2505105, 'CUITE', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2505006, 'CUBATI', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2504900, 'CRUZ DO ESPIRITO SANTO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2504850, 'COXIXOLA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2504801, 'COREMAS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2504702, 'CONGO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2504603, 'CONDE', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2504504, 'CONDADO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2504405, 'CONCEICAO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2504355, 'CATURITE', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2504306, 'CATOLE DO ROCHA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2504207, 'CATINGUEIRA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2504157, 'CASSERENGUE', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2504108, 'CARRAPATEIRA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2504074, 'CARAUBAS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2504033, 'CAPIM', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2504009, 'CAMPINA GRANDE', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2503902, 'CAMALAU', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2503803, 'CALDAS BRANDAO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2503753, 'CAJAZEIRINHAS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2503704, 'CAJAZEIRAS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2503605, 'CAICARA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2503555, 'CACIMBAS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2503506, 'CACIMBA DE DENTRO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2503407, 'CACIMBA DE AREIA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2503308, 'CACHOEIRA DOS INDIOS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2503209, 'CABEDELO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2503100, 'CABACEIRAS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2503001, 'CAAPORA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2502904, 'BREJO DOS SANTOS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2502805, 'BREJO DO CRUZ', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2502706, 'BORBOREMA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2502508, 'BOQUEIRAO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2502409, 'BONITO DE SANTA FE', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2502300, 'BOM SUCESSO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2502201, 'BOM JESUS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2502151, 'BOA VISTA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2502102, 'BOA VENTURA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2502052, 'BERNARDINO BATISTA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2502003, 'BELEM DO BREJO DO CRUZ', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2501906, 'BELEM', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2501807, 'BAYEUX', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2501708, 'BARRA DE SAO MIGUEL', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2501609, 'BARRA DE SANTA ROSA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2501575, 'BARRA DE SANTANA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2501534, 'BARAUNA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2501500, 'BANANEIRAS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2501401, 'BAIA DA TRAICAO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2501351, 'ASSUNCAO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2501302, 'AROEIRAS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2501203, 'AREIAL', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2501153, 'AREIA DE BARAUNAS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2501104, 'AREIA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2501005, 'ARARUNA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2500908, 'ARARA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2500809, 'ARACAGI', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2500775, 'APARECIDA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2500734, 'AMPARO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2500601, 'ALHANDRA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2500577, 'ALGODAO DE JANDAIRA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2500536, 'ALCANTIL', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2500502, 'ALAGOINHA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2500403, 'ALAGOA NOVA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2500304, 'ALAGOA GRANDE', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2500205, 'AGUIAR', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2500106, 'AGUA BRANCA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2517407, 'ZABELE', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2505501, 'VISTA SERRANA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2517209, 'VIEIROPOLIS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2517100, 'VARZEA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2517001, 'UMBUZEIRO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2516904, 'UIRAUNA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2516805, 'TRIUNFO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2516755, 'TENORIO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2516706, 'TEIXEIRA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2516607, 'TAVARES', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2516508, 'TAPEROA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2516409, 'TACIMA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2516300, 'SUME', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2516201, 'SOUSA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2516151, 'SOSSEGO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2516102, 'SOLEDADE', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2516003, 'SOLANEA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2515971, 'SOBRADO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2515930, 'SERTAOZINHO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2515906, 'SERRARIA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2515807, 'SERRA REDONDA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2515708, 'SERRA GRANDE', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2515609, 'SERRA DA RAIZ', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2515500, 'SERRA BRANCA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2515401, 'SERIDO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2515302, 'SAPE', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2515203, 'SAO SEBASTIAO DO UMBUZEIRO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2515104, 'SAO SEBASTIAO DE LAGOA DE ROCA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2515005, 'SAO MIGUEL DE TAIPU', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2514909, 'SAO MAMEDE', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2514453, 'SAO JOSE DOS RAMOS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2514800, 'SAO JOSE DOS CORDEIROS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2514701, 'SAO JOSE DO SABUGI', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2514651, 'SAO JOSE DO BREJO DO CRUZ', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2514602, 'SAO JOSE DO BONFIM', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2514552, 'SAO JOSE DE PRINCESA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2514503, 'SAO JOSE DE PIRANHAS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2514404, 'SAO JOSE DE ESPINHARAS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2514305, 'SAO JOSE DE CAIANA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2514206, 'SAO JOSE DA LAGOA TAPADA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2514107, 'SAO JOAO DO TIGRE', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2500700, 'SAO JOAO DO RIO DO PEIXE', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2514008, 'SAO JOAO DO CARIRI', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2513984, 'SAO FRANCISCO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2513943, 'SAO DOMINGOS DO CARIRI', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2513968, 'SAO DOMINGOS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2513901, 'SAO BENTO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2513927, 'SAO BENTINHO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2513851, 'SANTO ANDRE', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2513802, 'SANTA TERESINHA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2513703, 'SANTA RITA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2513604, 'SANTANA DOS GARROTES', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2513505, 'SANTANA DE MANGUEIRA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2513406, 'SANTA LUZIA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2513356, 'SANTA INES', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2513307, 'SANTA HELENA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2513208, 'SANTA CRUZ', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2513158, 'SANTA CECILIA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2513109, 'SALGADO DE SAO FELIX', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2513000, 'SALGADINHO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2512903, 'RIO TINTO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2512804, 'RIACHO DOS CAVALOS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2512788, 'RIACHO DE SANTO ANTONIO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2512762, 'RIACHAO DO POCO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2512754, 'RIACHAO DO BACAMARTE', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2512747, 'RIACHAO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2512705, 'REMIGIO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2512606, 'QUIXABA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2512507, 'QUEIMADAS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2512408, 'PUXINANA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2512309, 'PRINCESA ISABEL', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2512200, 'PRATA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2512101, 'POMBAL', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2512077, 'POCO DE JOSE DE MOURA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2512036, 'POCO DANTAS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2512002, 'POCINHOS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2511905, 'PITIMBU', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2511806, 'PIRPIRITUBA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2511707, 'PILOEZINHOS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2511608, 'PILOES', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2511509, 'PILAR', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2511400, 'PICUI', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2511301, 'PIANCO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2512721, 'PEDRO REGIS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2511202, 'PEDRAS DE FOGO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2511103, 'PEDRA LAVRADA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2511004, 'PEDRA BRANCA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2510907, 'PAULISTA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2510808, 'PATOS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2510709, 'PASSAGEM', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2510659, 'PARARI', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2510600, 'OURO VELHO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2510501, 'OLIVEDOS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2510402, 'OLHO D AGUA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2510303, 'NOVA PALMEIRA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2510204, 'NOVA OLINDA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2510105, 'NOVA FLORESTA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2510006, 'NAZAREZINHO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2509909, 'NATUBA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2509800, 'MULUNGU', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2509701, 'MONTEIRO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2509602, 'MONTE HOREBE', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2509503, 'MONTADAS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2509404, 'MOGEIRO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2509396, 'MATUREIA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2509370, 'MATO GROSSO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2509339, 'MATINHAS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2509305, 'MATARACA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2509206, 'MASSARANDUBA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2509156, 'MARIZOPOLIS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2509107, 'MARI', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2509057, 'MARCACAO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2509008, 'MANAIRA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2508901, 'MAMANGUAPE', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2508802, 'MALTA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2508703, 'MAE D AGUA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2508604, 'LUCENA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2508554, 'LOGRADOURO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2508505, 'LIVRAMENTO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2508406, 'LASTRO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2508307, 'LAGOA SECA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2508208, 'LAGOA DE DENTRO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2508109, 'LAGOA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2508000, 'JURU', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2507903, 'JURIPIRANGA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2507804, 'JUNCO DO SERIDO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2507705, 'JUAZEIRINHO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2507606, 'JUAREZ TAVORA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2513653, 'JOCA CLAUDINO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2507507, 'JOAO PESSOA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2507408, 'JERICO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2507309, 'JACARAU', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2507200, 'ITATUBA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2507101, 'ITAPOROROCA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2507002, 'ITAPORANGA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2506905, 'ITABAIANA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2506806, 'INGA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2506707, 'IMACULADA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2502607, 'IGARACY', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2506608, 'IBIARA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2506509, 'GURJAO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2506400, 'GURINHEM', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2506301, 'GUARABIRA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2506251, 'GADO BRAVO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2506202, 'FREI MARTINHO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2506103, 'FAGUNDES', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2506004, 'ESPERANCA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2505907, 'EMAS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2505808, 'DUAS ESTRADAS', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2505709, 'DONA INES', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2505600, 'DIAMANTE', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2505402, 'DESTERRO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2505352, 'DAMIAO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2505303, 'CURRAL VELHO', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2505279, 'CURRAL DE CIMA', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2505204, 'CUITEGI', 'PB'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2505238, 'CUITE DE MAMANGUAPE', 'PB'); ";
    
    $this->execute($sSql);
  }

  public function down() {
  
    $sSql = "DELETE FROM municipios WHERE uf = 'PB'; ";
    $this->execute($sSql);
  }
}