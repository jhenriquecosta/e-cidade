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


class PopulaTabelaMunicipiosRN extends Ruckusing_Migration_Base {
  
  public function up() {
  
    $sSql  = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2415008, 'VILA FLOR', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2414902, 'VICOSA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2414803, 'VERA CRUZ', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2414753, 'VENHA-VER', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2414704, 'VARZEA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2414605, 'UPANEMA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2414506, 'UMARIZAL', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2414456, 'TRIUNFO POTIGUAR', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2414407, 'TOUROS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2414308, 'TIMBAUBA DOS BATISTAS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2414209, 'TIBAU DO SUL', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2411056, 'TIBAU', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2414159, 'TENENTE LAURENTINO CRUZ', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2414100, 'TENENTE ANANIAS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2414001, 'TANGARA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2413904, 'TAIPU', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2413805, 'TABOLEIRO GRANDE', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2413706, 'SITIO NOVO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2413607, 'SEVERIANO MELO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2413557, 'SERRINHA DOS PINTOS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2413508, 'SERRINHA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2413409, 'SERRA NEGRA DO NORTE', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2413359, 'SERRA DO MEL', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2413300, 'SERRA DE SAO BENTO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2413201, 'SENADOR GEORGINO AVELINO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2413102, 'SENADOR ELOI DE SOUZA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2413003, 'SAO VICENTE', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2411106, 'RUY BARBOSA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2411007, 'RODOLFO FERNANDES', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2408953, 'RIO DO FOGO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2410900, 'RIACHUELO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2410801, 'RIACHO DE SANTANA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2410702, 'RIACHO DA CRUZ', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2410603, 'RAFAEL GODEIRO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2410504, 'RAFAEL FERNANDES', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2410405, 'PUREZA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2410306, 'PRESIDENTE JUSCELINO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2410256, 'PORTO DO MANGUE', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2410207, 'PORTALEGRE', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2410108, 'POCO BRANCO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2410009, 'PILOES', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2409902, 'PENDENCIAS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2409803, 'PEDRO VELHO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2409704, 'PEDRO AVELINO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2409605, 'PEDRA PRETA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2409506, 'PEDRA GRANDE', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2409407, 'PAU DOS FERROS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2409308, 'PATU', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2409209, 'PASSAGEM', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2409100, 'PASSA E FICA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2403251, 'PARNAMIRIM', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2408904, 'PARELHAS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2408805, 'PARAZINHO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2408706, 'PARAU', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2408607, 'PARANA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2408508, 'OURO BRANCO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2408409, 'OLHO-D AGUA DO BORGES', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2408300, 'NOVA CRUZ', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2408201, 'NISIA FLORESTA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2408102, 'NATAL', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2408003, 'MOSSORO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2407906, 'MONTE DAS GAMELEIRAS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2407807, 'MONTE ALEGRE', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2407708, 'MONTANHAS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2407609, 'MESSIAS TARGINO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2407500, 'MAXARANGUAPE', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2407401, 'MARTINS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2407302, 'MARCELINO VIEIRA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2407252, 'MAJOR SALES', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2407203, 'MACAU', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2407104, 'MACAIBA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2407005, 'LUIS GOMES', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2406908, 'LUCRECIA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2406809, 'LAJES PINTADAS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2406700, 'LAJES', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2406601, 'LAGOA SALGADA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2406502, 'LAGOA NOVA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2406403, 'LAGOA DE VELHOS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2406304, 'LAGOA DE PEDRAS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2406205, 'LAGOA D ANTA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2406155, 'JUNDIA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2406106, 'JUCURUTU', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2406007, 'JOSE DA PENHA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2405900, 'JOAO DIAS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2405801, 'JOAO CAMARA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2405702, 'JARDIM DO SERIDO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2405603, 'JARDIM DE PIRANHAS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2405504, 'JARDIM DE ANGICOS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2405405, 'JAPI', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2405306, 'JANUARIO CICCO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2405207, 'JANDUIS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2405108, 'JANDAIRA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2405009, 'JACANA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2404903, 'ITAU', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2404853, 'ITAJA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2404804, 'IPUEIRA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2404705, 'IPANGUACU', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2404606, 'IELMO MARINHO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2404507, 'GUAMARE', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2404408, 'GROSSOS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2404309, 'GOVERNADOR DIX-SEPT ROSADO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2404200, 'GOIANINHA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2404101, 'GALINHOS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2404002, 'FRUTUOSO GOMES', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2403905, 'FRANCISCO DANTAS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2403806, 'FLORANIA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2403756, 'FERNANDO PEDROZA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2403707, 'FELIPE GUERRA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2403608, 'EXTREMOZ', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2403509, 'ESPIRITO SANTO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2403400, 'EQUADOR', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2403301, 'ENCANTO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2403202, 'DOUTOR SEVERIANO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2403103, 'CURRAIS NOVOS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2403004, 'CRUZETA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2402907, 'CORONEL JOAO PESSOA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2402808, 'CORONEL EZEQUIEL', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2402709, 'CERRO CORA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2402600, 'CEARA-MIRIM', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2402501, 'CARNAUBAIS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2402402, 'CARNAUBA DOS DANTAS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2402303, 'CARAUBAS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2402204, 'CANGUARETAMA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2402105, 'CAMPO REDONDO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2402006, 'CAICO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2401909, 'CAICARA DO RIO DO VENTO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2401859, 'CAICARA DO NORTE', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2401800, 'BREJINHO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2401701, 'BOM JESUS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2401651, 'BODO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2401602, 'BENTO FERNANDES', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2401503, 'BARCELONA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2401453, 'BARAUNA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2401404, 'BAIA FORMOSA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2401305, 'AUGUSTO SEVERO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2401206, 'ARES', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2401107, 'AREIA BRANCA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2401008, 'APODI', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2400901, 'ANTONIO MARTINS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2400802, 'ANGICOS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2400703, 'ALTO DO RODRIGUES', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2400604, 'ALMINO AFONSO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2400505, 'ALEXANDRIA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2400406, 'AGUA NOVA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2400307, 'AFONSO BEZERRA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2400208, 'ACU', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2400109, 'ACARI', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2412906, 'SAO TOME', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2412807, 'SAO RAFAEL', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2412708, 'SAO PEDRO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2412609, 'SAO PAULO DO POTENGI', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2412559, 'SAO MIGUEL DO GOSTOSO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2412500, 'SAO MIGUEL', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2412401, 'SAO JOSE DO SERIDO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2412302, 'SAO JOSE DO CAMPESTRE', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2412203, 'SAO JOSE DE MIPIBU', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2412104, 'SAO JOAO DO SABUGI', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2412005, 'SAO GONCALO DO AMARANTE', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2411908, 'SAO FRANCISCO DO OESTE', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2411809, 'SAO FERNANDO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2411700, 'SAO BENTO DO TRAIRI', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2411601, 'SAO BENTO DO NORTE', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2411502, 'SANTO ANTONIO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2411429, 'SANTANA DO SERIDO', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2411403, 'SANTANA DO MATOS', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2409332, 'SANTA MARIA', 'RN'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2411205, 'SANTA CRUZ', 'RN'); ";
    
    $this->execute($sSql);
  }

  public function down() {
    
    $sSql = "DELETE FROM municipios WHERE uf = 'RN'; ";
    $this->execute($sSql);
  }
}