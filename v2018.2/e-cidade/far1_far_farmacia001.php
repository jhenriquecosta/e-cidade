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
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_far_farmacia_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clfar_farmacia = new cl_far_farmacia;
$db_opcao = 1;
$db_botao = true;
$db_opcao1=1;
if(isset($incluir)){
  db_inicio_transacao();
  $clfar_farmacia->incluir($fa13_i_codigo);  
  db_fim_transacao();  
}
if(isset($alterar)){
	db_inicio_transacao();		
    $clfar_farmacia->alterar($fa13_i_codigo);
    db_fim_transacao();		
}
$result = $clfar_farmacia->sql_record($clfar_farmacia->sql_query("","*","",""));
if($clfar_farmacia->numrows==0){
 $db_opcao = 1;
}else{
 $db_opcao = 2;
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
<center>
<br><br><br>
<table border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td align="left" valign="top" bgcolor="#CCCCCC"> 
    <fieldset style="width:100%"><legend><b>Dados da Farm?cia</b></legend>
	<? include("forms/db_frmfar_farmacia.php");?>
	</fieldset>
	</td>
  </tr>
</table>
</center>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
js_tabulacaoforms("form1","descrdepto",true,1,"descrdepto",true);
</script>
<?
if(isset($incluir)){
  if($clfar_farmacia->erro_status=="0"){
    $clfar_farmacia->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clfar_farmacia->erro_campo!=""){
      echo "<script> document.form1.".$clfar_farmacia->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clfar_farmacia->erro_campo.".focus();</script>";
    }
  }else{
	$clfar_farmacia->erro(true,false);
    $result = @pg_query("select last_value from far_farmacia_fa13_codigo_seq");
    $ultimo = pg_result($result,0,0);
    db_redireciona("far1_far_farmacia002.php?chavepesquisa=$ultimo");
  }
}
?>