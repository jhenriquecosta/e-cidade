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
include("classes/db_plano_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clplano = new cl_plano;
$clplano->rotulo->label("c01_anousu");
$clplano->rotulo->label("c01_estrut");
$clplano->rotulo->label("c01_descr");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table height="100%" border="0"  align="center" cellspacing="0" bgcolor="#CCCCCC">
  <tr> 
    <td height="63" align="center" valign="top">
        <table width="35%" border="0" align="center" cellspacing="0">
	     <form name="form2" method="post" action="" >
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Tc01_anousu?>">
              <?=$Lc01_anousu?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("c01_anousu",0,$Ic01_anousu,true,"text",4,"","chave_c01_anousu");
		       ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Tc01_estrut?>">
              <?=$Lc01_estrut?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("c01_estrut",13,$Ic01_estrut,true,"text",4,"","chave_c01_estrut");
		       ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Tc01_descr?>">
              <?=$Lc01_descr?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("c01_descr",40,$Ic01_descr,true,"text",4,"","chave_c01_descr");
		       ?>
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe.hide();">
             </td>
          </tr>
        </form>
        </table>
      </td>
  </tr>
  <tr> 
    <td align="center" valign="top"> 
      <?
      if(!isset($pesquisa_chave)){
        if(isset($campos)==false){
           $campos = "c01_reduz#c01_estrut#c01_descr";
        }
        if(isset($chave_c01_anousu) && (trim($chave_c01_anousu)!="") ){
	         $sql = $clplano->sql_query($chave_c01_anousu,$chave_c01_estrut,$campos,"c01_anousu");
        }else if(isset($chave_c01_descr) && (trim($chave_c01_descr)!="") ){
	         $sql = $clplano->sql_query("","",$campos,"c01_descr"," c01_descr like '$chave_c01_descr%' ");
        }else{
           $sql = $clplano->sql_query("","",$campos,"c01_anousu#c01_estrut","");
        }
        db_lovrot($sql,15,"()","",$funcao_js);
      }else{
        $result = $clplano->sql_record($clplano->sql_query($pesquisa_chave));
        if($clplano->numrows!=0){
          db_fieldsmemory($result,0);
          echo "<script>".$funcao_js."('$c01_descr',false);</script>";
        }else{
	       echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") n?o Encontrado',true);</script>";
        }
      }
      ?>
     </td>
   </tr>
</table>
</body>
</html>
<?
if(!isset($pesquisa_chave)){
  ?>
  <script>
document.form2.chave_c01_anousu.focus();
document.form2.chave_c01_anousu.select();
  </script>
  <?
}
?>