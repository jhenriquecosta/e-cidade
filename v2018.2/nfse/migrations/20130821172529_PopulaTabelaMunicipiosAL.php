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


class PopulaTabelaMunicipiosAL extends Ruckusing_Migration_Base {
  
  public function up() {

    $sSql  = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2709400, 'VICOSA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2709301, 'UNIAO DOS PALMARES', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2709202, 'TRAIPU', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2709152, 'TEOTONIO VILELA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2709103, 'TAQUARANA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2709004, 'TANQUE D ARCA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2708956, 'SENADOR RUI PALMEIRA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2708907, 'SATUBA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2708808, 'SAO SEBASTIAO', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2708709, 'SAO MIGUEL DOS MILAGRES', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2708600, 'SAO MIGUEL DOS CAMPOS', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2708501, 'SAO LUIS DO QUITUNDE', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2708402, 'SAO JOSE DA TAPERA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2708303, 'SAO JOSE DA LAJE', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2708204, 'SAO BRAS', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2708105, 'SANTANA DO MUNDAU', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2708006, 'SANTANA DO IPANEMA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2707909, 'SANTA LUZIA DO NORTE', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2707800, 'ROTEIRO', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2707701, 'RIO LARGO', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2707602, 'QUEBRANGULO', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2707503, 'PORTO REAL DO COLEGIO', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2707404, 'PORTO DE PEDRAS', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2707305, 'PORTO CALVO', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2707206, 'POCO DAS TRINCHEIRAS', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2707107, 'PIRANHAS', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2707008, 'PINDOBA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2706901, 'PILAR', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2706802, 'PIACABUCU', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2706703, 'PENEDO', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2706604, 'PAULO JACINTO', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2706505, 'PASSO DE CAMARAGIBE', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2706448, 'PARIPUEIRA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2706422, 'PARICONHA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2706406, 'PAO DE ACUCAR', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2706307, 'PALMEIRA DOS INDIOS', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2706208, 'PALESTINA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2706109, 'OURO BRANCO', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2706000, 'OLIVENCA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2705903, 'OLHO D AGUA GRANDE', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2705804, 'OLHO D AGUA DO CASADO', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2705705, 'OLHO D AGUA DAS FLORES', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2705606, 'NOVO LINO', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2705507, 'MURICI', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2705408, 'MONTEIROPOLIS', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2705309, 'MINADOR DO NEGRAO', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2705200, 'MESSIAS', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2705101, 'MATRIZ DE CAMARAGIBE', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2705002, 'MATA GRANDE', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2704906, 'MAR VERMELHO', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2704807, 'MARIBONDO', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2704708, 'MARECHAL DEODORO', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2704609, 'MARAVILHA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2704500, 'MARAGOGI', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2704401, 'MAJOR ISIDORO', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2704302, 'MACEIO', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2704203, 'LIMOEIRO DE ANADIA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2704104, 'LAGOA DA CANOA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2704005, 'JUNQUEIRO', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2703908, 'JUNDIA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2703809, 'JOAQUIM GOMES', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2703759, 'JEQUIA DA PRAIA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2703700, 'JARAMATAIA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2703601, 'JAPARATINGA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2703502, 'JACUIPE', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2703403, 'JACARE DOS HOMENS', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2703304, 'INHAPI', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2703205, 'IGREJA NOVA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2703106, 'IGACI', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2703007, 'IBATEGUARA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2702900, 'GIRAU DO PONCIANO', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2702801, 'FLEXEIRAS', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2702702, 'FELIZ DESERTO', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2702603, 'FEIRA GRANDE', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2702553, 'ESTRELA DE ALAGOAS', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2702504, 'DOIS RIACHOS', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2702405, 'DELMIRO GOUVEIA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2702355, 'CRAIBAS', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2702306, 'CORURIPE', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2702207, 'COQUEIRO SECO', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2702108, 'COLONIA LEOPOLDINA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2702009, 'COITE DO NOIA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2701902, 'CHA PRETA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2701803, 'CARNEIROS', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2701704, 'CAPELA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2701605, 'CANAPI', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2701506, 'CAMPO GRANDE', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2701407, 'CAMPO ALEGRE', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2701357, 'CAMPESTRE', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2701308, 'CAJUEIRO', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2701209, 'CACIMBINHAS', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2701100, 'BRANQUINHA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2701001, 'BOCA DA MATA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2700904, 'BELO MONTE', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2700805, 'BELEM', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2700706, 'BATALHA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2700607, 'BARRA DE SAO MIGUEL', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2700508, 'BARRA DE SANTO ANTONIO', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2700409, 'ATALAIA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2700300, 'ARAPIRACA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2700201, 'ANADIA', 'AL'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (2700102, 'AGUA BRANCA', 'AL'); ";
    
    $this->execute($sSql);
  }

  public function down() {

    $sSql = "DELETE FROM municipios WHERE uf = 'AL'; ";
    $this->execute($sSql);
  }
}