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
include("dbforms/db_funcoes.php");
include("classes/db_certbaixanumero_classe.php");
db_postmemory($HTTP_SERVER_VARS);
db_postmemory($HTTP_POST_VARS);
$clcertbaixanumero = new cl_certbaixanumero;

$db_botao = false;
$anousu=db_getsession("DB_anousu");
$result = $clcertbaixanumero->sql_record($clcertbaixanumero->sql_query(null,"q79_sequencial",null,"q79_anousu=$anousu"));
if ( $clcertbaixanumero->numrows>0){
$db_opcao = 2;
}else{
$db_opcao = 1;
}


if(isset($alterar)){
   db_inicio_transacao();
   $result = $clcertbaixanumero->sql_record($clcertbaixanumero->sql_query(null,"q79_sequencial",null,"q79_anousu=$anousu"));
   if($result==true || $clcertbaixanumero->numrows>0){
     db_fieldsmemory($result,0);
     $clcertbaixanumero->q79_sequencial=$q79_sequencial;
     $clcertbaixanumero->q79_anousu=$q79_anousu;
     $clcertbaixanumero->q79_ultcodcertbaixa=$q79_ultcodcertbaixa;
     $clcertbaixanumero->alterar($clcertbaixanumero->q79_sequencial);
   }
   db_fim_transacao();
}

$result = $clcertbaixanumero->sql_record($clcertbaixanumero->sql_query(null,"*",null,"q79_anousu=$anousu"));

if($result!=false && $clcertbaixanumero->numrows>0){
  db_fieldsmemory($result,0);
}

if (isset($incluir)){
$result = $clcertbaixanumero->sql_record($clcertbaixanumero->sql_query(null,"q79_sequencial,q79_anousu",null,"q79_anousu=$anousu"));
if ( $clcertbaixanumero->numrows>0){
    db_msgbox("J? existe numera??o para o ano $anousu");
    $erro=true;
}else{
    $clcertbaixanumero->q79_anousu         = $q79_anousu;
    $clcertbaixanumero->q79_ultcodcertbaixa= $q79_ultcodcertbaixa;
    $clcertbaixanumero->incluir(null);
    $db_opcao = 2;
}

}

$db_botao = true;

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
	include("forms/db_frmcertbaixanumero.php");
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
if(isset($alterar) || isset($incluir)){
  if($clcertbaixanumero->erro_status=="0"){
    $clcertbaixanumero->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clcertbaixanumero->erro_campo!=""){
      echo "<script> document.form1.".$clcertbaixanumero->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clcertbaixanumero->erro_campo.".focus();</script>";
    }
  }else{
    $clcertbaixanumero->erro(true,true);
  }
}
?>