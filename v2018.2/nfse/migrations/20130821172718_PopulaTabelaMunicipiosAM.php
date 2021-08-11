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


class PopulaTabelaMunicipiosAM extends Ruckusing_Migration_Base {
  
  public function up() {
  
    $sSql  = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1304401, 'URUCURITUBA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1304302, 'URUCARA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1304260, 'UARINI', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1304237, 'TONANTINS', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1304203, 'TEFE', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1304104, 'TAPAUA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1304062, 'TABATINGA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1304005, 'SILVES', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1303957, 'SAO SEBASTIAO DO UATUMA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1303908, 'SAO PAULO DE OLIVENCA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1303809, 'SAO GABRIEL DA CACHOEIRA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1303700, 'SANTO ANTONIO DO ICA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1303601, 'SANTA ISABEL DO RIO NEGRO', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1303569, 'RIO PRETO DA EVA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1303536, 'PRESIDENTE FIGUEIREDO', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1303502, 'PAUINI', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1303403, 'PARINTINS', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1303304, 'NOVO ARIPUANA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1303205, 'NOVO AIRAO', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1303106, 'NOVA OLINDA DO NORTE', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1303007, 'NHAMUNDA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1302900, 'MAUES', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1302801, 'MARAA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1302702, 'MANICORE', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1302553, 'MANAQUIRI', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1302504, 'MANACAPURU', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1302405, 'LABREA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1302306, 'JUTAI', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1302207, 'JURUA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1302108, 'JAPURA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1302009, 'ITAPIRANGA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1301951, 'ITAMARATI', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1301902, 'ITACOATIARA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1301852, 'IRANDUBA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1301803, 'IPIXUNA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1301704, 'HUMAITA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1301654, 'GUAJARA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1301605, 'FONTE BOA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1301506, 'ENVIRA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1301407, 'EIRUNEPE', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1301308, 'CODAJAS', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1301209, 'COARI', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1301159, 'CAREIRO DA VARZEA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1301100, 'CAREIRO', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1301001, 'CARAUARI', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1300904, 'CANUTAMA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1300839, 'CAAPIRANGA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1300805, 'BORBA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1300706, 'BOCA DO ACRE', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1300680, 'BOA VISTA DO RAMOS', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1300631, 'BERURI', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1300607, 'BENJAMIN CONSTANT', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1300508, 'BARREIRINHA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1300409, 'BARCELOS', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1300300, 'AUTAZES', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1300201, 'ATALAIA DO NORTE', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1300144, 'APUI', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1300102, 'ANORI', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1300086, 'ANAMA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1300060, 'AMATURA', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1300029, 'ALVARAES', 'AM'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (1302603, 'MANAUS', 'AM'); ";
    
    $this->execute($sSql);
  }

  public function down() {
    
    $sSql = "DELETE FROM municipios WHERE uf = 'AM'; ";
    $this->execute($sSql);
  }
}