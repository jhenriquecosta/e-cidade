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


class PopulaTabelaMunicipiosRJ extends Ruckusing_Migration_Base {
  
  public function up() {
  
    $sSql  = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3306305, 'VOLTA REDONDA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3306206, 'VASSOURAS', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3306156, 'VARRE-SAI', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3306107, 'VALENCA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3306008, 'TRES RIOS', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3305901, 'TRAJANO DE MORAES', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3305802, 'TERESOPOLIS', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3305752, 'TANGUA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3305703, 'SUMIDOURO', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3305604, 'SILVA JARDIM', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3305554, 'SEROPEDICA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3305505, 'SAQUAREMA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3305406, 'SAPUCAIA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3305307, 'SAO SEBASTIAO DO ALTO', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3305208, 'SAO PEDRO DA ALDEIA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3305158, 'SAO JOSE DO VALE DO RIO PRETO', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3305133, 'SAO JOSE DE UBA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3305109, 'SAO JOAO DE MERITI', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3305000, 'SAO JOAO DA BARRA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3304904, 'SAO GONCALO', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3304755, 'SAO FRANCISCO DE ITABAPOANA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3304805, 'SAO FIDELIS', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3304706, 'SANTO ANTONIO DE PADUA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3304607, 'SANTA MARIA MADALENA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3304524, 'RIO DAS OSTRAS', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3304508, 'RIO DAS FLORES', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3304409, 'RIO CLARO', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3304300, 'RIO BONITO', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3304201, 'RESENDE', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3304151, 'QUISSAMA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3304144, 'QUEIMADOS', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3304128, 'QUATIS', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3304110, 'PORTO REAL', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3304102, 'PORCIUNCULA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3304003, 'PIRAI', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3303955, 'PINHEIRAL', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3303906, 'PETROPOLIS', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3303856, 'PATY DO ALFERES', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3303807, 'PARATY', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3303708, 'PARAIBA DO SUL', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3303609, 'PARACAMBI', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3303500, 'NOVA IGUACU', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3303401, 'NOVA FRIBURGO', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3303302, 'NITEROI', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3303203, 'NILOPOLIS', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3303104, 'NATIVIDADE', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3303005, 'MIRACEMA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3302908, 'MIGUEL PEREIRA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3302858, 'MESQUITA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3302809, 'MENDES', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3302700, 'MARICA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3302601, 'MANGARATIBA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3302502, 'MAGE', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3302452, 'MACUCO', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3302403, 'MACAE', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3302304, 'LAJE DO MURIAE', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3302270, 'JAPERI', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3302254, 'ITATIAIA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3302205, 'ITAPERUNA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3302106, 'ITAOCARA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3302056, 'ITALVA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3302007, 'ITAGUAI', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3301900, 'ITABORAI', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3301876, 'IGUABA GRANDE', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3301850, 'GUAPIMIRIM', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3301801, 'ENGENHEIRO PAULO DE FRONTIN', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3301702, 'DUQUE DE CAXIAS', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3301603, 'DUAS BARRAS', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3301504, 'CORDEIRO', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3301405, 'CONCEICAO DE MACABU', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3300951, 'COMENDADOR LEVY GASPARIAN', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3301306, 'CASIMIRO DE ABREU', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3301207, 'CARMO', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3301157, 'CARDOSO MOREIRA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3300936, 'CARAPEBUS', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3301108, 'CANTAGALO', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3301009, 'CAMPOS DOS GOYTACAZES', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3300902, 'CAMBUCI', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3300803, 'CACHOEIRAS DE MACACU', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3300704, 'CABO FRIO', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3300605, 'BOM JESUS DO ITABAPOANA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3300506, 'BOM JARDIM', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3300456, 'BELFORD ROXO', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3300407, 'BARRA MANSA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3300308, 'BARRA DO PIRAI', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3300258, 'ARRAIAL DO CABO', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3300233, 'ARMACAO DOS BUZIOS', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3300225, 'AREAL', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3300209, 'ARARUAMA', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3300159, 'APERIBE', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3300100, 'ANGRA DOS REIS', 'RJ'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3304557, 'RIO DE JANEIRO', 'RJ'); ";
    
    $this->execute($sSql);
  }

  public function down() {
  
    $sSql = "DELETE FROM municipios WHERE uf = 'RJ'; ";
    $this->execute($sSql);
  }
}