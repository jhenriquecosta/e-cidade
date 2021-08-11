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


class PopulaTabelaMunicipiosPA extends Ruckusing_Migration_Base {
  
  public function up() {
  
    $sSql  = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1508407, 'XINGUARA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1508357, 'VITORIA DO XINGU', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1508308, 'VISEU', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1508209, 'VIGIA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1508159, 'URUARA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1508126, 'ULIANOPOLIS', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1508100, 'TUCURUI', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1508084, 'TUCUMA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1508050, 'TRAIRAO', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1508035, 'TRACUATEUA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1508001, 'TOME-ACU', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1507979, 'TERRA SANTA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1507961, 'TERRA ALTA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1507953, 'TAILANDIA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1507904, 'SOURE', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1507805, 'SENADOR JOSE PORFIRIO', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1507755, 'SAPUCAIA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1507706, 'SAO SEBASTIAO DA BOA VISTA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1507607, 'SAO MIGUEL DO GUAMA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1507508, 'SAO JOAO DO ARAGUAIA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1507474, 'SAO JOAO DE PIRABAS', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1507466, 'SAO JOAO DA PONTA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1507458, 'SAO GERALDO DO ARAGUAIA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1507409, 'SAO FRANCISCO DO PARA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1507300, 'SAO FELIX DO XINGU', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1507201, 'SAO DOMINGOS DO CAPIM', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1507151, 'SAO DOMINGOS DO ARAGUAIA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1507102, 'SAO CAETANO DE ODIVELAS', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1507003, 'SANTO ANTONIO DO TAUA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1506906, 'SANTAREM NOVO', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1506807, 'SANTAREM', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1506708, 'SANTANA DO ARAGUAIA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1506609, 'SANTA MARIA DO PARA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1506583, 'SANTA MARIA DAS BARREIRAS', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1506559, 'SANTA LUZIA DO PARA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1506500, 'SANTA ISABEL DO PARA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1506401, 'SANTA CRUZ DO ARARI', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1506351, 'SANTA BARBARA DO PARA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1506302, 'SALVATERRA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1506203, 'SALINOPOLIS', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1506195, 'RUROPOLIS', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1506187, 'RONDON DO PARA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1506161, 'RIO MARIA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1506138, 'REDENCAO', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1506112, 'QUATIPURU', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1506104, 'PRIMAVERA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1506005, 'PRAINHA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1505908, 'PORTO DE MOZ', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1504901, 'MUANA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1504802, 'MONTE ALEGRE', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1504703, 'MOJU', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1504604, 'MOCAJUBA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1504505, 'MELGACO', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1504455, 'MEDICILANDIA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1504422, 'MARITUBA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1504406, 'MARAPANIM', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1504307, 'MARACANA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1504208, 'MARABA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1504109, 'MAGALHAES BARATA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1504059, 'MAE DO RIO', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1504000, 'LIMOEIRO DO AJURU', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1503903, 'JURUTI', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1503804, 'JACUNDA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1503754, 'JACAREACANGA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1503705, 'ITUPIRANGA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1503606, 'ITAITUBA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1503507, 'IRITUIA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1503457, 'IPIXUNA DO PARA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1503408, 'INHANGAPI', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1503309, 'IGARAPE-MIRI', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1503200, 'IGARAPE-ACU', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1503101, 'GURUPA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1503093, 'GOIANESIA DO PARA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1503077, 'GARRAFAO DO NORTE', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1503044, 'FLORESTA DO ARAGUAIA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1503002, 'FARO', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1502954, 'ELDORADO DOS CARAJAS', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1502939, 'DOM ELISEU', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1502905, 'CURUCA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1502855, 'CURUA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1502806, 'CURRALINHO', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1502772, 'CURIONOPOLIS', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1502764, 'CUMARU DO NORTE', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1502756, 'CONCORDIA DO PARA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1502707, 'CONCEICAO DO ARAGUAIA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1502608, 'COLARES', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1502509, 'CHAVES', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1502400, 'CASTANHAL', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1502301, 'CAPITAO POCO', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1502202, 'CAPANEMA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1502152, 'CANAA DOS CARAJAS', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1502103, 'CAMETA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1501956, 'CACHOEIRA DO PIRIA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1502004, 'CACHOEIRA DO ARARI', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1501907, 'BUJARU', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1501808, 'BREVES', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1501782, 'BREU BRANCO', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1501758, 'BREJO GRANDE DO ARAGUAIA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1501725, 'BRASIL NOVO', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1501709, 'BRAGANCA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1501600, 'BONITO', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1501576, 'BOM JESUS DO TOCANTINS', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1501501, 'BENEVIDES', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1501451, 'BELTERRA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1501402, 'BELEM', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1501303, 'BARCARENA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1501253, 'BANNACH', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1501204, 'BAIAO', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1501105, 'BAGRE', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1501006, 'AVEIRO', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1500958, 'AURORA DO PARA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1500909, 'AUGUSTO CORREA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1500859, 'ANAPU', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1500800, 'ANANINDEUA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1500701, 'ANAJAS', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1500602, 'ALTAMIRA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1500503, 'ALMEIRIM', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1500404, 'ALENQUER', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1500347, 'AGUA AZUL DO NORTE', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1500305, 'AFUA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1500206, 'ACARA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1500131, 'ABEL FIGUEIREDO', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1500107, 'ABAETETUBA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1505809, 'PORTEL', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1505700, 'PONTA DE PEDRAS', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1505650, 'PLACAS', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1505635, 'PICARRA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1505601, 'PEIXE-BOI', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1505551, 'PAU D ARCO', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1505536, 'PARAUAPEBAS', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1505502, 'PARAGOMINAS', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1505494, 'PALESTINA DO PARA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1505486, 'PACAJA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1505437, 'OURILANDIA DO NORTE', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1505403, 'OUREM', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1505304, 'ORIXIMINA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1505205, 'OEIRAS DO PARA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1505106, 'OBIDOS', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1505064, 'NOVO REPARTIMENTO', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1505031, 'NOVO PROGRESSO', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1505007, 'NOVA TIMBOTEUA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1504976, 'NOVA IPIXUNA', 'PA'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1504950, 'NOVA ESPERANCA DO PIRIA', 'PA'); ";
    
    $this->execute($sSql);
  }

  public function down() {
  
    $sSql = "DELETE FROM municipios WHERE uf = 'PA'; ";
    $this->execute($sSql);
  }
}