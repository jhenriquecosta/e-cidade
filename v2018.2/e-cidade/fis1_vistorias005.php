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
include("classes/db_sanitario_classe.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
db_postmemory($HTTP_POST_VARS);
$clcriaabas = new cl_criaabas;
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
$calculopage = "";
$arr = array("vistorias"=>"Vistorias","fiscais"=>"Fiscais","testem"=>"Testemunhas"); 
$src = "";
$junto = "";
if(isset($cgm)){
  $junto = "cgm=1";
}elseif(isset($matric)){
  $junto = "matric=1";
}elseif(isset($inscr)){
  $junto = "inscr=1";
  $arr = array("vistorias"=>"Vistorias","fiscais"=>"Fiscais","testem"=>"Testemunhas","calculo"=>"C?lculo"); 
  $src = array("vistorias"=>"fis1_vistorias001.php?abas=1&$junto","fiscais"=>"fis1_vistusuario001.php","testem"=>"fis1_vistestem001.php","calculo"=>"fis1_calculo001.php");  
}elseif(isset($sani)){
  $junto = "sani=1";
  $arr = array("vistorias"=>"Vistorias","fiscais"=>"Fiscais","testem"=>"Testemunhas","calculo"=>"C?lculo"); 
  $src = array("vistorias"=>"fis1_vistorias001.php?abas=1&$junto","fiscais"=>"fis1_vistusuario001.php","testem"=>"fis1_vistestem001.php","calculo"=>"fis1_calculo001.php");  
}
if($src == ""){
  $src = array("vistorias"=>"fis1_vistorias001.php?abas=1&$junto","fiscais"=>"fis1_vistusuario001.php","testem"=>"fis1_vistestem001.php");  
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
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr> 
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table valign="top" marginwidth="0" width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
     <td>
     <?
       $clcriaabas->identifica = $arr;
       $clcriaabas->title = $arr;    
       $clcriaabas->src = $src;  
       $clcriaabas->scrolling="auto";  
       $clcriaabas->cria_abas();    
     ?> 
     </td>
  </tr>
<tr>
</tr>
</table>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<?
if(isset($db_opcao) && $db_opcao==2){
  echo "
         <script>
	   function js_src(){
            iframe_vistorias.location.href='fis1_vistorias002.php?abas=1';\n
	   }
	   js_src();
         </script>
       ";
       exit;
}else if(isset($db_opcao) && $db_opcao==3){
echo "
         <script>
	   function js_src(){
            iframe_vistorias.location.href='fis1_vistorias003.php?abas=1';\n
	    document.formaba.fiscais.disabled=true; 
	    document.formaba.testem.disabled=true; 
	   }
	   js_src();
         </script>
       ";
exit; 
}
  echo "
	 <script>
	    document.formaba.fiscais.disabled=true; 
	    document.formaba.testem.disabled=true; 
         </script>
       "; 
       exit;
?>