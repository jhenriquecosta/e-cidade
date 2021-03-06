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

//MODULO: educa??o
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_rhpessoal_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clrhpessoal = new cl_rhpessoal;
$clrotulo = new rotulocampo;
$clrhpessoal->rotulo->label("rh01_regist");
$clrhpessoal->rotulo->label("rh01_numcgm");
$clrotulo->label("z01_nome");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script>
nextfield = "campo1"; // nome do primeiro campo
netscape  = "";
ver       = navigator.appVersion;
len       = ver.length;
for (iln = 0; iln < len; iln++)
  if (ver.charAt(iln) == "(")
    break;
netscape = (ver.charAt(iln+1).toUpperCase() != "C");
function keyDown(DnEvents) {
    
 k = (netscape) ? DnEvents.which : window.event.keyCode;
 if (k == 13) { // pressiona tecla enter
   if (nextfield == 'done') {
     return true; // envia quando termina os campos
   } else {
     eval(" document.getElementById('"+nextfield+"').focus()" );
     return false;
   }
  }
}
document.onkeydown = keyDown;
if(netscape)
 document.captureEvents(Event.KEYDOWN|Event.KEYUP);
</script>
</head>
<body bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table height="100%" border="0"  align="center" cellspacing="0" bgcolor="#CCCCCC">
 <tr>
  <td height="63" align="center" valign="top">
   <table width="35%" border="0" align="center" cellspacing="0">
    <form name="form2" method="post" action="" >
    <tr>
     <td width="4%" align="right" nowrap title="<?=$Trh01_regist?>">
      <?=$Lrh01_regist?>
     </td>
     <td width="96%" align="left" nowrap>
      <?db_input("rh01_regist",10,$Irh01_regist,true,"text",4,"onFocus=\"nextfield='pesquisar2'\"","chave_rh01_regist");?>
     </td>
    </tr>
    <tr>
     <td width="4%" align="right" nowrap title="<?=$Trh01_numcgm?>">
      <?=$Lrh01_numcgm?>
     </td>
     <td width="96%" align="left" nowrap>
      <?db_input("rh01_numcgm",10,$Irh01_numcgm,true,"text",4,"onFocus=\"nextfield='pesquisar2'\"","chave_rh01_numcgm");?>
     </td>
    </tr>
    <tr>
     <td width="4%" align="right" nowrap title="<?=$Tz01_nome?>">
      <?=$Lz01_nome?>
     </td>
     <td width="96%" align="left" nowrap colspan='3'>
      <?db_input("z01_nome",80,$Iz01_nome,true,"text",4,"onFocus=\"nextfield='pesquisar2'\"","chave_z01_nome");?>
     </td>
    </tr>
    <tr>
     <td colspan="2" align="center">
      <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar" onFocus="nextfield='done'">
      <input name="limpar" type="reset" id="limpar" value="Limpar" >
      <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_rhpessoal.hide();">
     </td>
    </tr>
    </form>
   </table>
  </td>
 </tr>
 <tr>
  <td align="center" valign="top">
   <?
   $instit = db_getsession("DB_instit");
   $ano = db_anofolha();
   $mes = db_mesfolha();
   $where = " where rh05_seqpes is null and rh30_vinculo = 'A' ";

   if(!isset($pesquisa_chave)){
    $sql = "SELECT DISTINCT rh01_regist,z01_nome,rh37_descr as rh01_funcao,rh01_admiss
            FROM rhpessoal
                 inner join rhpessoalmov    on rh02_anousu  = $ano
                                           and rh02_mesusu  = $mes
                                           and rh02_regist  = rh01_regist
                                           and rh02_instit  = $instit
                 inner join cgm             on z01_numcgm   = rhpessoal.rh01_numcgm
                 inner join rhfuncao        on rh37_funcao  = rhpessoal.rh01_funcao
                                           and rh37_instit  = rh02_instit
                 left  join rhpesrescisao   on rh05_seqpes  = rh02_seqpes
                 inner join rhregime        on rh30_codreg  = rh02_codreg
                                           and rh30_instit  = rh02_instit
           ";
    if(isset($chave_rh01_regist)){
     $repassa = array("chave_rh01_regist"=>$chave_rh01_regist,"chave_rh01_numcgm"=>$chave_rh01_numcgm,"chave_z01_nome"=>$chave_z01_nome);
    }
    if(isset($chave_rh01_regist) && (trim($chave_rh01_regist)!="") ){
      $sql .= " $where AND rh01_regist = $chave_rh01_regist ORDER BY z01_nome";
      db_lovrot(@$sql,15,"()","",$funcao_js,"","NoMe",$repassa);
    }else if(isset($chave_rh01_numcgm) && (trim($chave_rh01_numcgm)!="") ){
      $sql .= " $where AND rh01_numcgm = $chave_rh01_numcgm ORDER BY z01_nome";
      db_lovrot(@$sql,15,"()","",$funcao_js,"","NoMe",$repassa);
    }else if(isset($chave_z01_nome) && (trim($chave_z01_nome)!="") ){
      $sql .= " $where AND z01_nome like '$chave_z01_nome%' ORDER BY z01_nome";
      db_lovrot(@$sql,15,"()","",$funcao_js,"","NoMe",$repassa);
    }

   }
   ?>
   </td>
  </tr>
</table>
</body>
</html>
<script>
js_tabulacaoforms("form2","chave_z01_nome",true,1,"chave_z01_nome",true);
</script>