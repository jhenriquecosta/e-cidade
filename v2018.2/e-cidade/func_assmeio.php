<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2012  DBselller Servicos de Informatica             
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
include("classes/db_assmeio_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$classmeio = new cl_assmeio;
$classmeio->rotulo->label("h22_codigo");
$classmeio->rotulo->label("h22_regist");
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
            <td width="4%" align="right" nowrap title="<?=$Th22_codigo?>">
              <?=$Lh22_codigo?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("h22_codigo",6,$Ih22_codigo,true,"text",4,"","chave_h22_codigo");
		       ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Th22_regist?>">
              <?=$Lh22_regist?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("h22_regist",6,$Ih22_regist,true,"text",4,"","chave_h22_regist");
		       ?>
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_assmeio.hide();">
             </td>
          </tr>
        </form>
        </table>
      </td>
  </tr>
  <tr> 
    <td align="center" valign="top"> 
      <?
      $dbwhere = "";
      if(isset($bloqueia_assenta)){
        $dbwhere = ((isset($chave_h22_codigo) || isset($chave_h22_regist) || isset($pesquisa_chave)) ? " and "  : "") . "  h22_data is null ";
      }
      if(!isset($pesquisa_chave)){
        if(isset($campos)==false){
           if(file_exists("funcoes/db_func_assmeio.php")==true){
             include("funcoes/db_func_assmeio.php");
           }else{
           $campos = "assmeio.*";
           }
        }
        if(isset($chave_h22_codigo) && (trim($chave_h22_codigo)!="") ){
	         $sql = $classmeio->sql_query(null,$campos,"h22_codigo"," h22_codigo = ".$chave_h22_codigo.$dbwhere);
        }else if(isset($chave_h22_regist) && (trim($chave_h22_regist)!="") ){
	         $sql = $classmeio->sql_query(null,$campos,"h22_regist"," h22_regist like '".$chave_h22_regist."%' ".$dbwhere);
        }else{
           $sql = $classmeio->sql_query(null,$campos,"h22_codigo",$dbwhere);
        }
        $repassa = array();
        if(isset($chave_h22_regist)){
          $repassa = array("chave_h22_codigo"=>$chave_h22_codigo,"chave_h22_regist"=>$chave_h22_regist);
        }
        db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa, false);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $classmeio->sql_record($classmeio->sql_query(null, " * ", "", " h22_codigo = ".$pesquisa_chave.$dbwhere));
          if($classmeio->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$h22_regist',false);</script>";
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
js_tabulacaoforms("form2","chave_h22_regist",true,1,"chave_h22_regist",true);
</script>