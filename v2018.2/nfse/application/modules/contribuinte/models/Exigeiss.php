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


/**
  Código de natureza da operação. Códigos definidos pelo banco do e-cidade
  1 - Exigível;
  2 - Não incidência;
  3 - Isenção;
  4 - Exportação;
  5 - Imunidade;
  6 - Exigibilidade Suspensa por Decisão Judicial;
  7 - Exigibilidade Suspensa por Processo Administrativo
  - tcDadosServico
 */
class Contribuinte_Model_Exigeiss extends E2Tecnologia_Model_Enumeration {

    protected static $lista = array(
        23 => "Exigível",
        24 => "Não incidência",
        25 => "Isenção",
        26 => "Exportação",
        27 => "Imunidade",
        28 => "Suspensa por Decisão Judicial",
        29 => "Suspensa por Processo Administrativo"
    );
    protected static $default = "--";

}

?>