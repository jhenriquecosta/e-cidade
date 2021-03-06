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
include("classes/db_orcparamrel_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clorcparamrel = new cl_orcparamrel;
$clorcparamrel->rotulo->label("o42_codparrel");
$clorcparamrel->rotulo->label("o42_descrrel");
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
            <td width="4%" align="right" nowrap title="<?=$To42_codparrel?>">
              <?=$Lo42_codparrel?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("o42_codparrel",8,$Io42_codparrel,true,"text",4,"","chave_o42_codparrel");
		       ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$To42_descrrel?>">
              <?=$Lo42_descrrel?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("o42_descrrel",100,$Io42_descrrel,true,"text",4,"","chave_o42_descrrel");
		       ?>
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_orcparamrel.hide();">
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
				  if (file_exists("funcoes/db_func_orcparamrel.php")==true) {
             include("funcoes/db_func_orcparamrel.php");
          } else {
					  $campos = "orcparamrel.*";
				  }
        }
				
        if(isset($chave_o42_codparrel) && (trim($chave_o42_codparrel)!="") ){
	         $sql = $clorcparamrel->sql_query($chave_o42_codparrel,$campos,"o42_codparrel");
        }else if(isset($chave_o42_descrrel) && (trim($chave_o42_descrrel)!="") ){
				   $sql = $clorcparamrel->sql_query("",$campos,"o42_descrrel"," o42_descrrel like '$chave_o42_descrrel%' ");
        }else{
					 $sql = $clorcparamrel->sql_query(null,$campos,"o42_codparrel","");
        }
        $repassa = array();
        if(isset($chave_o42_descrrel)){
          $repassa = array("chave_o42_codparrel"=>$chave_o42_codparrel,"chave_o42_descrrel"=>$chave_o42_descrrel);
        }
        db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!="") {
          $result = $clorcparamrel->sql_record($clorcparamrel->sql_query($pesquisa_chave));
          if($clorcparamrel->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$o42_descrrel','$o69_codseq',false);</script>";
          }else{
	         echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") n?o Encontrado',true);</script>";
          }
        }else{
	       echo "<script>".$funcao_js."('',false);</script>";
        }
      }
			
			if (isset($chave_composta)) {

				$campos = "orcparamrel.o42_codparrel,
				 orcparamrel.o42_orcparamrelgrupo,
				 orcparamrel.o42_descrrel,
				 (coalesce((select max(o69_codseq) 
				    from orcparamseq 
				 	 where orcparamseq.o69_codparamrel= orcparamrel.o42_codparrel),0)+1) as o69_codseq";
				
        $sSql   = $clorcparamrel->sql_query($chave_composta,$campos);
				$result = $clorcparamrel->sql_record($sSql);

        if ($clorcparamrel->numrows > 0) {
          db_fieldsmemory($result,0);
				  echo "<script>".$funcao_js."('$o69_codseq','$o42_descrrel',false);</script>";
				} else {
	        echo "<script>".$funcao_js."('','Chave(".$pesquisa_chave.") n?o Encontrado',true);</script>";
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
js_tabulacaoforms("form2","chave_o42_descrrel",true,1,"chave_o42_descrrel",true);
</script>