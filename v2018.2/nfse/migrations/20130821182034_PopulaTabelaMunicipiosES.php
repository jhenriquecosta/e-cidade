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


class PopulaTabelaMunicipiosES extends Ruckusing_Migration_Base {
  
  public function up() {
    
    $sSql  = "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3205309, 'VITORIA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3205200, 'VILA VELHA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3205176, 'VILA VALERIO', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3205150, 'VILA PAVAO', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3205101, 'VIANA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3205069, 'VENDA NOVA DO IMIGRANTE', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3205036, 'VARGEM ALTA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3205010, 'SOORETAMA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3205002, 'SERRA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3204955, 'SAO ROQUE DO CANAA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3204906, 'SAO MATEUS', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3204807, 'SAO JOSE DO CALCADO', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3204708, 'SAO GABRIEL DA PALHA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3204658, 'SAO DOMINGOS DO NORTE', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3204609, 'SANTA TERESA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3204559, 'SANTA MARIA DE JETIBA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3204500, 'SANTA LEOPOLDINA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3204401, 'RIO NOVO DO SUL', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3204351, 'RIO BANANAL', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3204302, 'PRESIDENTE KENNEDY', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3204252, 'PONTO BELO', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3204203, 'PIUMA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3204104, 'PINHEIROS', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3204054, 'PEDRO CANARIO', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3204005, 'PANCAS', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3203908, 'NOVA VENECIA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3203809, 'MUQUI', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3203700, 'MUNIZ FREIRE', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3203601, 'MUCURICI', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3203502, 'MONTANHA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3203403, 'MIMOSO DO SUL', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3203353, 'MARILANDIA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3203346, 'MARECHAL FLORIANO', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3203320, 'MARATAIZES', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3203304, 'MANTENOPOLIS', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3203205, 'LINHARES', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3203163, 'LARANJA DA TERRA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3203130, 'JOAO NEIVA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3203106, 'JERONIMO MONTEIRO', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3203056, 'JAGUARE', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3203007, 'IUNA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3202900, 'ITARANA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3202801, 'ITAPEMIRIM', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3202702, 'ITAGUACU', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3202652, 'IRUPI', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3202603, 'ICONHA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3202553, 'IBITIRAMA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3202504, 'IBIRACU', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3202454, 'IBATIBA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3202405, 'GUARAPARI', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3202306, 'GUACUI', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3202256, 'GOVERNADOR LINDENBERG', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3202207, 'FUNDAO', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3202108, 'ECOPORANGA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3202009, 'DORES DO RIO PRETO', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3201902, 'DOMINGOS MARTINS', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3201803, 'DIVINO DE SAO LOURENCO', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3201704, 'CONCEICAO DO CASTELO', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3201605, 'CONCEICAO DA BARRA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3201506, 'COLATINA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3201407, 'CASTELO', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3201308, 'CARIACICA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3201209, 'CACHOEIRO DE ITAPEMIRIM', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3201159, 'BREJETUBA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3201100, 'BOM JESUS DO NORTE', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3201001, 'BOA ESPERANCA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3200904, 'BARRA DE SAO FRANCISCO', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3200805, 'BAIXO GUANDU', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3200706, 'ATILIO VIVACQUA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3200607, 'ARACRUZ', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3200508, 'APIACA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3200409, 'ANCHIETA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3200359, 'ALTO RIO NOVO', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3200300, 'ALFREDO CHAVES', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3200201, 'ALEGRE', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3200136, 'AGUIA BRANCA', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3200169, 'AGUA DOCE DO NORTE', 'ES'); ";
    $sSql .= "INSERT INTO municipios (cod_ibge, nome, uf) VALUES (3200102, 'AFONSO CLAUDIO', 'ES'); ";
    
    $this->execute($sSql);
  }

  public function down() {
    
    $sSql = "DELETE FROM municipios WHERE uf = 'ES'; ";
    $this->execute($sSql);
  }
}