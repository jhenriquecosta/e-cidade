<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2012  DBselller Servicos de Informatica             
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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_classesgenericas.php");
include("dbforms/db_funcoes.php");

db_postmemory($HTTP_POST_VARS);

$clcriaabas = new cl_criaabas;
$lEnterByFrame = false;
$margin = "18px";
if (isset($lInFrame)) {
	
	$lEnterByFrame = true;
	$margin        = "0px";
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table valign="top" marginwidth="0" width="790" border="0" cellspacing="0" cellpadding="0" style="margin-top: <? echo $margin; ?>;">
   <tr>
       <td>
        <?
          $clcriaabas->identifica = array("tipoprocesso"=>"Tipo de Processo",
                                          "departamento"=>"Departamentos",
                                          "formreclamacao"=>"Formas de Reclama??o",
                                          "andamentopadrao"=>"Andamento Padr?o");
          
          $clcriaabas->title 	  = array("tipoprocesso"=>"Tipo de Processo",
                                          "departamento"=>"Departamentos",
                                          "formreclamacao"=>"Formas de Reclama??o",
                                          "andamentopadrao"=>"Andamento Padr?o");
          
          $clcriaabas->src 		  = array("tipoprocesso"=>"ouv1_aba1tipoproc004.php?lFrame={$lEnterByFrame}",
                                          "departamento"=>"ouv1_aba2depto004.php?lFrame={$lEnterByFrame}",
                                          "formreclamacao"=>"ouv1_aba3formrecl004.php?lFrame={$lEnterByFrame}",
                                          "andamentopadrao"=>"pro1_andpadrao001.php?lFrame={$lEnterByFrame}");
          
          $clcriaabas->disabled   = array("tipoprocesso"=>"false",
                                          "departamento"=>"true",
                                          "formreclamacao"=>"true",
                                          "andamentopadrao"=>"true");
          
	      $clcriaabas->cria_abas();
        ?>
       </td>
   </tr>
   <tr>
  </tr>
</table>
<?
if (!$lEnterByFrame) {
	db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),
	        db_getsession("DB_anousu"),db_getsession("DB_instit"));
}
?>
</body>
<script>
  document.formaba.tipoprocesso.size    = 25;
  document.formaba.departamento.size    = 25;
  document.formaba.formreclamacao.size  = 25;
  document.formaba.andamentopadrao.size = 25;
</script>
</html>