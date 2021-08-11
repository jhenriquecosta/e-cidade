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
include("classes/db_rhelementoemp_classe.php");
include("classes/db_rhelementoemppcmater_classe.php");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$clrhelementoemp        = new cl_rhelementoemp;
$clrhelementoemppcmater = new cl_rhelementoemppcmater;

$db_opcao = 22;
$db_botao = false;
if(isset($alterar)){
  db_inicio_transacao();
  $db_opcao = 2;
  $sqlerro = false;
  if (isset($rh36_pcmater) && trim(@$rh36_pcmater)!=""){
    $res_elementopcmater = $clrhelementoemppcmater->sql_record($clrhelementoemppcmater->sql_query_file(null,"rh36_sequencial,rh36_pcmater as pc01_codmater","","rh36_rhelementoemp = $rh38_seq"));
    if ($clrhelementoemppcmater->numrows > 0){
      db_fieldsmemory($res_elementopcmater,0);

      if ($rh36_pcmater != $pc01_codmater){
        $clrhelementoemppcmater->rh36_sequencial = $rh36_sequencial;
        $clrhelementoemppcmater->rh36_pcmater    = $rh36_pcmater;

        $clrhelementoemppcmater->alterar($rh36_sequencial);
      }
    } else {  // Nao existia material associado ao elemento
     $clrhelementoemppcmater->rh36_pcmater       = $rh36_pcmater;
     $clrhelementoemppcmater->rh36_rhelementoemp = $rh38_seq;

     $clrhelementoemppcmater->incluir(null);
    }

    $erro_msg = $clrhelementoemppcmater->erro_msg;
    if ($clrhelementoemppcmater->erro_status == "0"){
      $sqlerro = true;
    }
  } else {
    $res_elementopcmater = $clrhelementoemppcmater->sql_record($clrhelementoemppcmater->sql_query_file(null,"rh36_sequencial","","rh36_rhelementoemp = $rh38_seq"));
    if ($clrhelementoemppcmater->numrows > 0){
      db_fieldsmemory($res_elementopcmater,0);

      $clrhelementoemppcmater->excluir($rh36_sequencial);
    }
  }
  db_fim_transacao($sqlerro);
}else if(isset($chavepesquisa)){
   $db_opcao = 2;

   $result = $clrhelementoemp->sql_record($clrhelementoemp->sql_query($chavepesquisa)); 
   if ($clrhelementoemp->numrows > 0){
     db_fieldsmemory($result,0);
   }

   $result = $clrhelementoemppcmater->sql_record($clrhelementoemppcmater->sql_query(null,"rhelementoemppcmater.*,pcmater.*",null,"rh38_seq=$chavepesquisa"));
   if ($clrhelementoemppcmater->numrows > 0){
     db_fieldsmemory($result,0);
   }

   $db_botao = true;
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
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr> 
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="100%" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
	<?
	include("forms/db_frmrhelementoemp.php");
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
if(isset($alterar)){
  if (trim(@$erro_msg) != ""){
    db_msgbox($erro_msg);
  }

  if($sqlerro==true){
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clrhelementoemp->erro_campo!=""){
      echo "<script> document.form1.".$clrhelementoemp->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clrhelementoemp->erro_campo.".focus();</script>";
    }
  }

  $db_opcao = 22;
}
if($db_opcao==22){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>