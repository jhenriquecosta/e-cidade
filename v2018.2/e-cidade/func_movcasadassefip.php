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
include("classes/db_movcasadassefip_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clmovcasadassefip = new cl_movcasadassefip;
$clmovcasadassefip->rotulo->label("r67_anousu");
$clmovcasadassefip->rotulo->label("r67_mesusu");
$clmovcasadassefip->rotulo->label("r67_afast");
$clmovcasadassefip->rotulo->label("r67_reto");
$clmovcasadassefip->rotulo->label("r67_reto");
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
            <td width="4%" align="right" nowrap title="<?=$Tr67_mesusu?>">
              <?=$Lr67_mesusu?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("r67_mesusu",2,$Ir67_mesusu,true,"text",4,"","chave_r67_mesusu");
		       ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Tr67_afast?>">
              <?=$Lr67_afast?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("r67_afast",2,$Ir67_afast,true,"text",4,"","chave_r67_afast");
		       ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Tr67_reto?>">
              <?=$Lr67_reto?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("r67_reto",2,$Ir67_reto,true,"text",4,"","chave_r67_reto");
		       ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Tr67_reto?>">
              <?=$Lr67_reto?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("r67_reto",2,$Ir67_reto,true,"text",4,"","chave_r67_reto");
		       ?>
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_movcasadassefip.hide();">
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
           if(file_exists("funcoes/db_func_movcasadassefip.php")==true){
             include("funcoes/db_func_movcasadassefip.php");
           }else{
           $campos = "movcasadassefip.*";
           }
        }
        if(isset($chave_r67_mesusu) && (trim($chave_r67_mesusu)!="") ){
	         $sql = $clmovcasadassefip->sql_query(db_getsession('DB_anousu'),$chave_r67_mesusu,$chave_r67_afast,$chave_r67_reto,$campos,"r67_mesusu");
        }else if(isset($chave_r67_reto) && (trim($chave_r67_reto)!="") ){
	         $sql = $clmovcasadassefip->sql_query(db_getsession('DB_anousu'),"","","",$campos,"r67_reto"," r67_reto like '$chave_r67_reto%' ");
        }else{
           $sql = $clmovcasadassefip->sql_query(db_getsession('DB_anousu'),"","","",$campos,"r67_anousu#r67_mesusu#r67_afast#r67_reto","");
        }
        db_lovrot($sql,15,"()","",$funcao_js);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $clmovcasadassefip->sql_record($clmovcasadassefip->sql_query(db_getsession("DB_anousu"),$pesquisa_chave));
          if($clmovcasadassefip->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$r67_reto',false);</script>";
          }else{
	         echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") n?o Encontrado',true);</script>";
          }
        }else{
	       echo "<script>".$funcao_js."('',false);</script>";
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
  </script>
  <?
}
?>