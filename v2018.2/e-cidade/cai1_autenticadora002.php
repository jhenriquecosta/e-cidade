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

parse_str(base64_decode($HTTP_SERVER_VARS['QUERY_STRING']));
if(isset($retorno)) {
  $result = pg_exec("select * from cfautent where k11_id = $retorno and k11_instit = " . db_getsession("DB_instit"));
  db_fieldsmemory($result,0);
} 
if(isset($HTTP_POST_VARS["enviar"])) {
  db_postmemory($HTTP_POST_VARS);
  /*$result = pg_exec("select k11_ipterm 
                     from cfautent 
	             where k11_instit = ".db_getsession("DB_instit")." and k11_ipterm = '".$k11_ipterm."'");
  if(pg_numrows($result) == 0) {
      $flag = true;
  }
  else {
     $flag = false;
  }

  if ($flag==true){*/
       pg_exec("update cfautent set  k11_ident1    = '$k11_ident1',
                                     k11_ident2    = '$k11_ident2',
                                     k11_ident3    = '$k11_ident3',
                                     k11_ipterm    = '$k11_ipterm',
                                     k11_local     = '$k11_local',
     	          		     k11_aut1      = '$k11_aut1',
                                     k11_aut2      = '$k11_aut2',
				     k11_tesoureiro = '$k11_tesoureiro',
				     k11_tipautent = $k11_tipautent,
				     k11_tipoimp   = $k11_tipoimp  
	        where k11_id = $k11_id") or die("Erro(15) alterando cfautent.");
       db_redireciona();
  /*}
  else {
       db_msgbox("Autenticadora j? cadastrada");
  }*/
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
    <td width="360">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table width="790" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
	<?
    if(isset($HTTP_POST_VARS["procurar"]) || isset($HTTP_POST_VARS["priNoMe"]) || isset($HTTP_POST_VARS["antNoMe"]) || isset($HTTP_POST_VARS["proxNoMe"]) || isset($HTTP_POST_VARS["ultNoMe"])) {
      include("cai1_autenticadora005.php");
    } else if(!isset($retorno)) {
	  include("cai1_autenticadora004.php");
    } else { 
	  include("forms/db_frmautenticadora.php");
    }
    ?>
	</td>
  </tr>
</table>
<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>