<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2013  DBselller Servicos de Informatica             
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
include("classes/db_cgmerrado_classe.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clcgmerrado = new cl_cgmerrado;
$clcgmerrado->rotulo->label("z11_codigo");
$clcgmerrado->rotulo->label("z11_numcgm");
$clcgmerrado->rotulo->label("z11_codigo");
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
            <td width="4%" align="right" nowrap title="<?=$Tz11_codigo?>">
              <?=$Lz11_codigo?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
           db_input("z11_codigo",10,$Iz11_codigo,true,"text",4,"","chave_z11_codigo");
           ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Tz11_numcgm?>">
              <?=$Lz11_numcgm?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
           db_input("z11_numcgm",8,$Iz11_numcgm,true,"text",4,"","chave_z11_numcgm");
           ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Tz11_codigo?>">
              <?=$Lz11_codigo?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
           db_input("z11_codigo",10,$Iz11_codigo,true,"text",4,"","chave_z11_codigo");
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
          $campos = "cgmerrado.z11_codigo,cgmerrado.z11_numcgm,z01_nome";
        }
        
        if(isset($chave_z11_codigo) && (trim($chave_z11_codigo)!="") ){

           $sql = $clcgmerrado->sql_query($chave_z11_codigo, null, $campos,"z11_codigo");
                        
        } else if (isset($chave_z11_numcgm) && trim($chave_z11_numcgm) != "") {

          $sql = $clcgmerrado->sql_query(null, $chave_z11_numcgm, $campos, "z11_codigo#z11_numcgm", "");
                    
        } else {

					$sql = $clcgmerrado->sql_query(null, null, $campos, "z11_codigo#z11_numcgm", "");
					
				} 
        
        db_lovrot($sql,15,"()","",$funcao_js);
        
      } else{

        if($pesquisa_chave!=null && $pesquisa_chave!=""){
			
          $result = $clcgmerrado->sql_record($clcgmerrado->sql_query(null, $pesquisa_chave));
          
          if($clcgmerrado->numrows != 0){

            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$z01_nome',false);</script>";
            
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