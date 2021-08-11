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


class PopulaTabelaMunicipiosMS extends Ruckusing_Migration_Base {
  
  public function up() {
  
    $sSql  = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5004908, 'JARAGUARI', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5004809, 'JAPORA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5004700, 'IVINHEMA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5004601, 'ITAQUIRAI', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5004502, 'ITAPORA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5004403, 'INOCENCIA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5004304, 'IGUATEMI', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5004106, 'GUIA LOPES DA LAGUNA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5004007, 'GLORIA DE DOURADOS', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5003900, 'FIGUEIRAO', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5003801, 'FATIMA DO SUL', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5003751, 'ELDORADO', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5003702, 'DOURADOS', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5003504, 'DOURADINA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5003488, 'DOIS IRMAOS DO BURITI', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5003454, 'DEODAPOLIS', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5003306, 'COXIM', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5003256, 'COSTA RICA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5003207, 'CORUMBA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5003157, 'CORONEL SAPUCAIA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5003108, 'CORGUINHO', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5002951, 'CHAPADAO DO SUL', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5002902, 'CASSILANDIA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5002803, 'CARACOL', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5002704, 'CAMPO GRANDE', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5002605, 'CAMAPUA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5002407, 'CAARAPO', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5002308, 'BRASILANDIA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5008404, 'VICENTINA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5008305, 'TRES LAGOAS', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5008008, 'TERENOS', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5007976, 'TAQUARUSSU', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5007950, 'TACURU', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5007935, 'SONORA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5007901, 'SIDROLANDIA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5007703, 'SETE QUEDAS', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5007802, 'SELVIRIA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5007695, 'SAO GABRIEL DO OESTE', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5007554, 'SANTA RITA DO PARDO', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5007505, 'ROCHEDO', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5007406, 'RIO VERDE DE MATO GROSSO', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5007307, 'RIO NEGRO', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5007208, 'RIO BRILHANTE', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5007109, 'RIBAS DO RIO PARDO', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5006903, 'PORTO MURTINHO', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5006606, 'PONTA PORA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5006408, 'PEDRO GOMES', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5006358, 'PARANHOS', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5006309, 'PARANAIBA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5006259, 'NOVO HORIZONTE DO SUL', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5006200, 'NOVA ANDRADINA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5006002, 'NOVA ALVORADA DO SUL', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5005806, 'NIOAQUE', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5005707, 'NAVIRAI', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5005681, 'MUNDO NOVO', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5005608, 'MIRANDA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5005400, 'MARACAJU', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5005251, 'LAGUNA CARAPA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5005202, 'LADARIO', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5005152, 'JUTI', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5005103, 'JATEI', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5005004, 'JARDIM', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5002209, 'BONITO', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5002159, 'BODOQUENA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5002100, 'BELA VISTA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5002001, 'BATAYPORA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5001904, 'BATAGUASSU', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5001508, 'BANDEIRANTES', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5001243, 'ARAL MOREIRA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5001102, 'AQUIDAUANA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5001003, 'APARECIDA DO TABOADO', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5000906, 'ANTONIO JOAO', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5000856, 'ANGELICA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5000807, 'ANAURILANDIA', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5000708, 'ANASTACIO', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5000609, 'AMAMBAI', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5000252, 'ALCINOPOLIS', 'MS'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (5000203, 'AGUA CLARA', 'MS'); ";
    
    $this->execute($sSql);
  }

  public function down() {
    
    $sSql = "DELETE FROM municipios WHERE uf = 'MS'; ";
    $this->execute($sSql);
  }
}