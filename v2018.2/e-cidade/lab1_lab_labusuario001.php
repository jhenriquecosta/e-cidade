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
include("classes/db_lab_labusuario_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$cllab_labusuario = new cl_lab_labusuario;
$db_opcao = 1;
$db_botao = true;

if(isset($opcao)){
  if( $opcao == "alterar"){
    $db_opcao = 2;
    $db_botao1 = true;
  }else{
    if( $opcao=="excluir" || isset($db_opcao) && $db_opcao==3){
       $db_opcao = 3;
       $db_botao1 = true;
    }else{
       if(isset($alterar)){
          $db_opcao = 2;
          $db_botao1 = true;
       }
    }
  }
}


if(isset($incluir)){
   db_inicio_transacao();
   $cllab_labusuario->incluir($la05_i_codigo);
   db_fim_transacao();
}else if(isset($alterar)){
     db_inicio_transacao();
     $db_opcao = 2;
     $cllab_labusuario->alterar($la05_i_codigo);
     db_fim_transacao();
}if(isset($excluir)){
     db_inicio_transacao();
     $db_opcao = 3;
     $cllab_labusuario->excluir($la05_i_codigo);
     db_fim_transacao();
}else if(isset($chavepesquisa)){
     $db_opcao = 2;
     if(isset($la05_i_codigo)){
        $result = $cllab_labusuario->sql_record($cllab_labusuario->sql_query($la05_i_codigo,"*","","" )); 
        if($cllab_labusuario->numrows>0){
           db_fieldsmemory($result,0);
           $db_botao = true;
        }else{
           $la05_i_laboratorio=$chavepesquisa;
           $db_opcao=1;
        }
     }else{
        $la05_i_laboratorio=$chavepesquisa;
        $db_opcao=1;
     }
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
<!-- <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr> 
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>-->
<center>
<br><br>
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
     <fieldset style='width: 95%;'> <legend><b>Lab Usu?rio</b></legend>
	<?
	include("forms/db_frmlab_labusuario.php");
	?>
	</fieldset>
    </center>
	</td>
  </tr>
</table>
</center>
<?
//db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
js_tabulacaoforms("form1","la05_i_laboratorio",true,1,"la05_i_laboratorio",true);
</script>
<?
if( (isset($incluir)) || (isset($alterar)) || (isset($excluir)) ){
  if($cllab_labusuario->erro_status=="0"){
    $cllab_labusuario->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($cllab_labusuario->erro_campo!=""){
      echo "<script> document.form1.".$cllab_labusuario->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cllab_labusuario->erro_campo.".focus();</script>";
    }
  }else{
    $cllab_labusuario->erro(true,false);
    db_redireciona("lab1_lab_labusuario001.php?la05_i_laboratorio=$la05_i_laboratorio&la02_c_descr=$la02_c_descr");
  }
}
?>