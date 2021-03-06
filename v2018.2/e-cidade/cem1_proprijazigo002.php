<?
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

require(modification("libs/db_stdlib.php"));
require(modification("libs/db_conecta.php"));
include(modification("libs/db_sessoes.php"));
include(modification("libs/db_usuariosonline.php"));
include(modification("classes/db_proprijazigo_classe.php"));
include(modification("dbforms/db_funcoes.php"));
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clproprijazigo = new cl_proprijazigo;
$db_opcao = 22;
$db_botao = false;

if(isset($alterar)){
  db_inicio_transacao();

  $db_opcao = 2;
  $clproprijazigo->alterar($cm29_i_codigo);
  db_fim_transacao();
}else if(isset($chavepesquisa)){
   $db_opcao = 2;
   $result = $clproprijazigo->sql_record($clproprijazigo->sql_query("","*","","cm29_i_propricemit=$chavepesquisa"));
   db_fieldsmemory($result,0);
   $db_botao = true;
}

define("ARQUIVO_MENSAGEM_JAZIGO002", "tributario.cemiterio.cem1_proprijazigo002.");
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="100%" align="left" valign="top" bgcolor="#CCCCCC">
    <center>
     <?
     include(modification("forms/db_frmproprijazigo.php"));
     ?>
    </center>
     </td>
  </tr>
</table>
</body>
</html>
<?
if(isset($alterar)){
  if($clproprijazigo->erro_status=="0"){

    db_msgbox($chavepesquisa);

    $clproprijazigo->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clproprijazigo->erro_campo!=""){
      echo "<script> document.form1.".$clproprijazigo->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clproprijazigo->erro_campo.".focus();</script>";
    }
  }else{

      db_msgbox(_M(ARQUIVO_MENSAGEM_JAZIGO002 . "jazigo_alterado"));

      echo "<script>";
      echo " parent.document.formaba.a2.disabled=false; ";
      echo " (window.CurrentWindow || parent.CurrentWindow).corpo.iframe_a2.location.href='cem1_proprijazigo002.php?cm28_i_codigo=$cm29_i_propricemit&cm28_i_ossoariojazigo=$cm28_i_ossoariojazigo&cm28_i_proprietario=$cm28_i_proprietario&z01_nome=$z01_nome&chavepesquisa=$cm28_i_codigo';";
      echo " parent.document.formaba.a3.disabled=false; ";
      echo " (window.CurrentWindow || parent.CurrentWindow).corpo.iframe_a3.location.href='cem1_itenserv111.php?cm28_i_ossoariojazigo=$cm28_i_ossoariojazigo&cm28_i_proprietario=$cm28_i_proprietario&z01_nome=$z01_nome';";
      echo " parent.mo_camada('a3'); ";
      echo "</script>";

  }
}
if($db_opcao==22){
  //echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
js_tabulacaoforms("form1","cm29_i_propricemit",true,1,"cm29_i_propricemit",true);
</script>