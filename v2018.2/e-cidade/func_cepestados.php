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
include("classes/db_cepestados_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clcepestados = new cl_cepestados;
$clcepestados->rotulo->label("cp03_sigla");
$clcepestados->rotulo->label("cp03_estado");
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
            <td width="4%" align="right" nowrap title="<?=$Tcp03_sigla?>">
              <?=$Lcp03_sigla?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("cp03_sigla",2,$Icp03_sigla,true,"text",4,"","chave_cp03_sigla");
		       ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Tcp03_estado?>">
              <?=$Lcp03_estado?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("cp03_estado",70,$Icp03_estado,true,"text",4,"","chave_cp03_estado");
		       ?>
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_cepestados.hide();">
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
           if(file_exists("funcoes/db_func_cepestados.php")==true){
             include("funcoes/db_func_cepestados.php");
           }else{
           $campos = "cepestados.*";
           }
        }
        if(isset($chave_cp03_sigla) && (trim($chave_cp03_sigla)!="") ){
	         $sql = $clcepestados->sql_query($chave_cp03_sigla,$campos,"cp03_sigla");
        }else if(isset($chave_cp03_estado) && (trim($chave_cp03_estado)!="") ){
	         $sql = $clcepestados->sql_query("",$campos,"cp03_sigla"," cp03_estado like '$chave_cp03_estado%' ");
        }else{
           $sql = $clcepestados->sql_query("",$campos,"cp03_sigla","");
        }
        $repassa = array();
        if(isset($chave_cp03_sigla)){
          $repassa = array("chave_cp03_sigla"=>$chave_cp03_sigla,"chave_cp03_sigla"=>$chave_cp03_sigla);
        }
        db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $clcepestados->sql_record($clcepestados->sql_query($pesquisa_chave));
          if($clcepestados->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$cp03_estado',false);</script>";
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
<script>
js_tabulacaoforms("form2","chave_cp03_sigla",true,1,"chave_cp03_sigla",true);
</script>