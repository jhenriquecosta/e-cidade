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


class PopulaTabelaMunicipiosTO extends Ruckusing_Migration_Base {
  
  public function up() {
  
    $sSql  = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1722107, 'XAMBIOA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1722081, 'WANDERLANDIA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1721307, 'TUPIRATINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1721257, 'TUPIRAMA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1721208, 'TOCANTINOPOLIS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1721109, 'TOCANTINIA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1720978, 'TALISMA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1720937, 'TAIPAS DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1720903, 'TAGUATINGA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1720853, 'SUCUPIRA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1720804, 'SITIO NOVO DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1720655, 'SILVANOPOLIS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1720499, 'SAO VALERIO', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1720309, 'SAO SEBASTIAO DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1720259, 'SAO SALVADOR DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1720200, 'SAO MIGUEL DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1720150, 'SAO FELIX DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1720101, 'SAO BENTO DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1720002, 'SANTA TEREZINHA DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1719004, 'SANTA TEREZA DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1718907, 'SANTA ROSA DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1718899, 'SANTA RITA DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1718881, 'SANTA MARIA DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1718865, 'SANTA FE DO ARAGUAIA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1718840, 'SANDOLANDIA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1718808, 'SAMPAIO', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1718758, 'RIO SONO', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1718709, 'RIO DOS BOIS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1718659, 'RIO DA CONCEICAO', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1718550, 'RIACHINHO', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1718501, 'RECURSOLANDIA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1718451, 'PUGMIL', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1718402, 'PRESIDENTE KENNEDY', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1718303, 'PRAIA NORTE', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1718204, 'PORTO NACIONAL', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1718006, 'PORTO ALEGRE DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1717909, 'PONTE ALTA DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1717800, 'PONTE ALTA DO BOM JESUS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1717503, 'PIUM', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1717206, 'PIRAQUE', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1717008, 'PINDORAMA DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1716653, 'PEQUIZEIRO', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1716604, 'PEIXE', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1716505, 'PEDRO AFONSO', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1716307, 'PAU D ARCO', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1716208, 'PARANA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1716109, 'PARAISO DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1715754, 'PALMEIROPOLIS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1713809, 'PALMEIRAS DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1715705, 'PALMEIRANTE', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1721000, 'PALMAS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1715507, 'OLIVEIRA DE FATIMA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1715259, 'NOVO JARDIM', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1715150, 'NOVO ALEGRE', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1715101, 'NOVO ACORDO', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1715002, 'NOVA ROSALANDIA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1714880, 'NOVA OLINDA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1714302, 'NAZARE', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1714203, 'NATIVIDADE', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1713957, 'MURICILANDIA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1713700, 'MONTE SANTO DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1713601, 'MONTE DO CARMO', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1713304, 'MIRANORTE', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1713205, 'MIRACEMA DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1712801, 'MAURILANDIA DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1712702, 'MATEIROS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1712504, 'MARIANOPOLIS DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1712454, 'LUZINOPOLIS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1712405, 'LIZARDA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1712157, 'LAVANDEIRA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1712009, 'LAJEADO', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1711951, 'LAGOA DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1711902, 'LAGOA DA CONFUSAO', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1711803, 'JUARINA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1711506, 'JAU DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1711100, 'ITAPORA DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1710904, 'ITAPIRATINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1710706, 'ITAGUATINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1710508, 'ITACAJA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1709807, 'IPUEIRAS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1709500, 'GURUPI', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1709302, 'GUARAI', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1709005, 'GOIATINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1708304, 'GOIANORTE', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1708254, 'FORTALEZA DO TABOCAO', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1708205, 'FORMOSO DO ARAGUAIA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1707702, 'FILADELFIA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1707652, 'FIGUEIROPOLIS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1707553, 'FATIMA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1707405, 'ESPERANTINA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1707306, 'DUERE', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1707207, 'DOIS IRMAOS DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1707108, 'DIVINOPOLIS DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1707009, 'DIANOPOLIS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1706506, 'DARCINOPOLIS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1706258, 'CRIXAS DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1706100, 'CRISTALANDIA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1706001, 'COUTO MAGALHAES', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1705607, 'CONCEICAO DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1705557, 'COMBINADO', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1716703, 'COLMEIA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1705508, 'COLINAS DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1704600, 'CHAPADA DE AREIA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1705102, 'CHAPADA DA NATIVIDADE', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1704105, 'CENTENARIO', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1703909, 'CASEARA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1703891, 'CARRASCO BONITO', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1703883, 'CARMOLANDIA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1703867, 'CARIRI DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1703842, 'CAMPOS LINDOS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1703826, 'CACHOEIRINHA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1703800, 'BURITI DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1703701, 'BREJINHO DE NAZARE', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1703602, 'BRASILANDIA DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1703305, 'BOM JESUS DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1703206, 'BERNARDO SAYAO', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1703107, 'BARROLANDIA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1703073, 'BARRA DO OURO', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1703057, 'BANDEIRANTES DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1703008, 'BABACULANDIA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1702901, 'AXIXA DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1702703, 'AURORA DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1702554, 'AUGUSTINOPOLIS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1702406, 'ARRAIAS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1702307, 'ARAPOEMA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1702208, 'ARAGUATINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1702158, 'ARAGUANA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1702109, 'ARAGUAINA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1702000, 'ARAGUACU', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1701903, 'ARAGUACEMA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1701309, 'ARAGOMINAS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1701101, 'APARECIDA DO RIO NEGRO', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1701051, 'ANGICO', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1701002, 'ANANAS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1700400, 'ALMAS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1700350, 'ALIANCA DO TOCANTINS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1700301, 'AGUIARNOPOLIS', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1700251, 'ABREULANDIA', 'TO'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1700707, 'ALVORADA', 'TO'); ";
    
    $this->execute($sSql);
  }

  public function down() {
  
    $sSql = "DELETE FROM municipios WHERE uf = 'TO'; ";
    $this->execute($sSql);
  }
}