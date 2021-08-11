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


class PopulaTabelaMunicipiosMT extends Ruckusing_Migration_Base {
  
  public function up() {
  
    $sSql  = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5108600, 'VILA RICA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5105507, 'VILA BELA DA SANTISSIMA TRINDADE', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5108501, 'VERA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5108402, 'VARZEA GRANDE', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5108352, 'VALE DE SAO DOMINGOS', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5108303, 'UNIAO DO SUL', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5108204, 'TORIXOREU', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5108105, 'TESOURO', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5108055, 'TERRA NOVA DO NORTE', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5108006, 'TAPURAH', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107958, 'TANGARA DA SERRA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107941, 'TABAPORA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107925, 'SORRISO', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107909, 'SINOP', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107883, 'SERRA NOVA DOURADA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107875, 'SAPEZAL', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107404, 'SAO PEDRO DA CIPA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107354, 'SAO JOSE DO XINGU', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107107, 'SAO JOSE DOS QUATRO MARCOS', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107305, 'SAO JOSE DO RIO CLARO', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107297, 'SAO JOSE DO POVO', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107859, 'SAO FELIX DO ARAGUAIA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107800, 'SANTO ANTONIO DO LEVERGER', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107792, 'SANTO ANTONIO DO LESTE', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107263, 'SANTO AFONSO', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107776, 'SANTA TEREZINHA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107768, 'SANTA RITA DO TRIVELATO', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107743, 'SANTA CRUZ DO XINGU', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107248, 'SANTA CARMEM', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107750, 'SALTO DO CEU', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107701, 'ROSARIO OESTE', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107602, 'RONDONOPOLIS', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107578, 'RONDOLANDIA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107206, 'RIO BRANCO', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107198, 'RIBEIRAOZINHO', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107180, 'RIBEIRAO CASCALHEIRA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107156, 'RESERVA DO CABACAL', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107065, 'QUERENCIA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107040, 'PRIMAVERA DO LESTE', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5107008, 'POXOREO', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106851, 'PORTO ESTRELA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106828, 'PORTO ESPERIDIAO', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106802, 'PORTO DOS GAUCHOS', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106778, 'PORTO ALEGRE DO NORTE', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106752, 'PONTES E LACERDA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106703, 'PONTE BRANCA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106653, 'PONTAL DO ARAGUAIA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106505, 'POCONE', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106455, 'PLANALTO DA SERRA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106422, 'PEIXOTO DE AZEVEDO', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106372, 'PEDRA PRETA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106307, 'PARANATINGA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106299, 'PARANAITA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106281, 'NOVO SAO JOAQUIM', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106315, 'NOVO SANTO ANTONIO', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106265, 'NOVO MUNDO', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106273, 'NOVO HORIZONTE DO NORTE', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106257, 'NOVA XAVANTINA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106240, 'NOVA UBIRATA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106190, 'NOVA SANTA HELENA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106232, 'NOVA OLIMPIA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106174, 'NOVA NAZARE', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106224, 'NOVA MUTUM', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5108956, 'NOVA MONTE VERDE', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5108907, 'NOVA MARINGA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5108857, 'NOVA MARILANDIA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106182, 'NOVA LACERDA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5108808, 'NOVA GUARITA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106216, 'NOVA CANAA DO NORTE', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106208, 'NOVA BRASILANDIA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106158, 'NOVA BANDEIRANTES', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106109, 'NOSSA SENHORA DO LIVRAMENTO', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5106000, 'NORTELANDIA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5105903, 'NOBRES', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5105622, 'MIRASSOL D OESTE', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5105606, 'MATUPA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5105580, 'MARCELANDIA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5105309, 'LUCIARA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5105259, 'LUCAS DO RIO VERDE', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5105234, 'LAMBARI D OESTE', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5105200, 'JUSCIMEIRA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5105176, 'JURUENA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5105150, 'JUINA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5105101, 'JUARA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5105002, 'JAURU', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5104906, 'JANGADA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5104807, 'JACIARA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5104609, 'ITIQUIRA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5104559, 'ITAUBA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5104542, 'ITANHANGA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5104526, 'IPIRANGA DO NORTE', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5104500, 'INDIAVAI', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5104203, 'GUIRATINGA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5104104, 'GUARANTA DO NORTE', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5103957, 'GLORIA D OESTE', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5103908, 'GENERAL CARNEIRO', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5103858, 'GAUCHA DO NORTE', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5103809, 'FIGUEIROPOLIS D OESTE', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5103700, 'FELIZ NATAL', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5103601, 'DOM AQUINO', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5103502, 'DIAMANTINO', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5103452, 'DENISE', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5103437, 'CURVELANDIA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5103403, 'CUIABA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5103379, 'COTRIGUACU', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5103361, 'CONQUISTA D OESTE', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5103353, 'CONFRESA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5103304, 'COMODORO', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5103254, 'COLNIZA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5103205, 'COLIDER', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5103106, 'COCALINHO', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5103056, 'CLAUDIA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5103007, 'CHAPADA DOS GUIMARAES', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5102850, 'CASTANHEIRA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5102793, 'CARLINDA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5102702, 'CANARANA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5102694, 'CANABRAVA DO NORTE', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5102678, 'CAMPO VERDE', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5102686, 'CAMPOS DE JULIO', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5102637, 'CAMPO NOVO DO PARECIS', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5102603, 'CAMPINAPOLIS', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5102504, 'CACERES', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5101902, 'BRASNORTE', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5101852, 'BOM JESUS DO ARAGUAIA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5101803, 'BARRA DO GARCAS', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5101704, 'BARRA DO BUGRES', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5101605, 'BARAO DE MELGACO', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5101407, 'ARIPUANA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5101308, 'ARENAPOLIS', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5101258, 'ARAPUTANGA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5101209, 'ARAGUAINHA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5101001, 'ARAGUAIANA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5100805, 'APIACAS', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5100607, 'ALTO TAQUARI', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5100508, 'ALTO PARAGUAI', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5100409, 'ALTO GARCAS', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5100359, 'ALTO BOA VISTA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5100300, 'ALTO ARAGUAIA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5100250, 'ALTA FLORESTA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5100201, 'AGUA BOA', 'MT'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5100102, 'ACORIZAL', 'MT'); ";
    
    $this->execute($sSql);
  }

  public function down() {
  
    $sSql = "DELETE FROM municipios WHERE uf = 'MT'; ";
    $this->execute($sSql);
  }
}