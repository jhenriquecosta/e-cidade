<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBselller Servicos de Informatica             
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

require("libs/db_stdlibwebseller.php");
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_turmaac_classe.php");
include("classes/db_turmaacmatricula_classe.php");
include("classes/db_turmaacativ_classe.php");
include("classes/db_turmaachorario_classe.php");
include("classes/db_turmalogac_classe.php");
include("classes/db_escola_classe.php");
include("classes/db_escolaestrutura_classe.php");
include("dbforms/db_funcoes.php");
include("libs/db_jsplibwebseller.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clturmaac          = new cl_turmaac;
$clescola           = new cl_escola;
$clturmaacmatricula = new cl_turmaacmatricula;
$clturmaacativ      = new cl_turmaacativ;
$clturmaachorario   = new cl_turmaachorario;
$clturmalogac         = new cl_turmalogac;
$clescolaestrutura  = new cl_escolaestrutura;
$db_botao           = false;
$db_botao2          = true;
$db_opcao           = 33;
$db_opcao1          = 3;
$codigoescola       = db_getsession("DB_coddepto");

if (isset($excluir)) {
	
  $db_opcao  = 3;
  $db_opcao1 = 3;
  db_inicio_transacao();
  $clturmaacmatricula->excluir(""," ed269_i_turmaac = $ed268_i_codigo"); 
  $clturmaachorario->excluir(""," ed270_i_turmaac   = $ed268_i_codigo"); 
  $clturmaacativ->excluir(""," ed267_i_turmaac      = $ed268_i_codigo");
  $clturmalogac->excluir(""," ed288_i_turmaac         = $ed268_i_codigo");   
  $clturmaac->excluir($ed268_i_codigo);
  db_fim_transacao();
  
} else if(isset($chavepesquisa)) {
	
  $db_opcao  = 3;
  $db_opcao1 = 3;
  $result    = $clturmaac->sql_record($clturmaac->sql_query($chavepesquisa));
  db_fieldsmemory($result,0);
  $db_botao  = true;
  
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
<body bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
   <br>
   <center>
   <fieldset style="width:95%"><legend><b>Exclus?o de Turma com Atividade Complementar / AEE</b></legend>
    <?include("forms/db_frmturmaac.php");?>
   </fieldset>
   </center>
  </td>
 </tr>
</table>
</body>
</html>
<?
if (isset($excluir)) {
	
  if ($clturmaac->erro_status == "0") {
    $clturmaac->erro(true,false);
  } else {
  	
    $clturmaac->erro(true,false);
    ?>    
    <script>parent.document.form2.teste.click();</script>
    <?
    
  }
}

if ($db_opcao == 33) {
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>