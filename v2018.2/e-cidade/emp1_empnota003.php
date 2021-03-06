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

require("libs/db_stdlib.php");
require("libs/db_utils.php");
require("std/db_stdClass.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");


include("classes/db_empnota_classe.php");
include("classes/db_empnotaele_classe.php");
include("classes/db_empempenho_classe.php");
include("classes/db_db_usuarios_classe.php");

$cldb_usuarios = new cl_db_usuarios;
$clempnota = new cl_empnota;
$clempnotaele = new cl_empnotaele;
$clempempenho = new cl_empempenho;

$aParametrosEmpenho = db_stdClass::getParametro("empparametro",array(db_getsession("DB_anousu")));
$lUsaNotaLiquidacao = false;
if (isset($aParametrosEmpenho[0])) {
  
   if ($aParametrosEmpenho[0]->e30_notaliquidacao != "") {
     $lUsaNotaLiquidacao = true;
   }
}

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$db_opcao = 33;
$db_botao = false;
if (isset($anular)) {
  
  $db_opcao = 3;
  $sqlerro=false;

  db_inicio_transacao();
  $clempnota->alterar($e69_codnota);
  $erro_msg = $clempnota->erro_msg;
  if($clempnota->erro_status==0){
      $sqlerro=true;
  }

  if($sqlerro==false){

    $result66 = $clempnotaele->sql_record($clempnotaele->sql_query_file($e69_codnota,null,"e70_codele,e70_valor"));   
    $numrows = $clempnotaele->numrows;
    
    for($i=0; $i<$numrows; $i++){
      db_fieldsmemory($result66,$i);
	  $clempnotaele->e70_codnota = $e69_codnota;
	  $clempnotaele->e70_codele  = $e70_codele;
          $clempnotaele->e70_vlranu  = $e70_valor;
	  $clempnotaele->alterar($e69_codnota,$e70_codele);
	  $erro_msg=$clempnotaele->erro_msg;
	  if($clempnotaele->erro_status==0){
	      $sqlerro=true;
	      break;
	  }
    } 	  
  }
  db_fim_transacao($sqlerro);
   $db_opcao = 3;
   $db_botao = true;
}else if(isset($chavepesquisa)){
   $db_opcao = 3;
   $db_botao = true;

   $result = $clempnota->sql_record($clempnota->sql_query_file($chavepesquisa)); 
   db_fieldsmemory($result,0);

   $result = $clempempenho->sql_record($clempempenho->sql_query_empnome($e69_numemp,"z01_nome")); 
   db_fieldsmemory($result,0);

   $result = $cldb_usuarios->sql_record($cldb_usuarios->sql_query_file($e69_id_usuario,"nome")); 
   db_fieldsmemory($result,0);
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
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr> 
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
	<?
	if (!$lUsaNotaLiquidacao) {
	  include("forms/db_frmempnota.php");
	} else {
	  db_msgbox("Para efetuar a anula?ao dessa nota, acesse material -> Procedimentos -> Entrada da Ordem De Compra -> Anula??o");
	}
	?>
    </center>
	</td>
  </tr>
</table>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<?
if(isset($anular)){
  db_msgbox($erro_msg);
    if($clempnota->erro_campo!=""){
      echo "<script> document.form1.".$clempnota->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clempnota->erro_campo.".focus();</script>";
    };
};
if($db_opcao==33){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>