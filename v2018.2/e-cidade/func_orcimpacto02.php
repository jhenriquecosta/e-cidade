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
include("classes/db_orcimpacto_classe.php");
include("classes/db_orcorgao_classe.php");
include("classes/db_orcunidade_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clorcimpacto = new cl_orcimpacto;
$clorcorgao = new cl_orcorgao;
$clorcunidade = new cl_orcunidade;
$clorcimpacto->rotulo->label("o90_codimp");
$clorcimpacto->rotulo->label("o90_anoexe");
$clorcimpacto->rotulo->label("o90_orgao");
$clorcimpacto->rotulo->label("o90_unidade");

$dbwhere = " o90_codperiodo = $o90_codperiodo ";
if(isset($o90_orgao) && $o90_orgao != ''){
  $dbwhere .= " and o90_orgao = $o90_orgao ";   
}
if(isset($o90_unidade) && $o90_unidade != ''){
  $dbwhere .= " and o90_unidade = $o90_unidade ";   
}
if(isset($o90_funcao) && $o90_funcao != ''){
  $dbwhere .= " and o90_funcao = $o90_funcao ";   
}
if(isset($o90_subfuncao) && $o90_subfuncao != ''){
  $dbwhere .= " and o90_subfuncao = $o90_subfuncao ";   
}
if(isset($o90_programa) && $o90_programa != ''){
  $dbwhere .= " and o90_programa = $o90_programa ";   
}
if(isset($o90_acao) && $o90_acao != ''){
  $dbwhere .= " and o90_acao = $o90_acao ";   
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table  border="0" height='90%'  align="center" cellspacing="0" bgcolor="#CCCCCC">
  <tr> 
    <td height="63" width="60%" align="left" valign="top">
        <table  border="0" align="left" cellspacing="0">
	     <form name="form1" method="post" action="" >
          <tr> 
            <td  align="left" nowrap title="<?=$To90_codimp?>">
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <?=$Lo90_codimp?>
            </td>
	    <td>
              <?
		       db_input("o90_codimp",5,$Io90_codimp,true,"text",4,"","chave_o90_codimp");
		       ?>
              <?=$Lo90_anoexe?>

              <?
		       db_input("o90_anoexe",4,$Io90_anoexe,true,"text",4,"","chave_o90_anoexe");
		       ?>
            </td>
          </tr>
	  <tr>
	    <td align='center'>
	    
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	    <?=$Lo90_orgao?>
            </td>
	    <td >
	  <?
	  $result = $clorcorgao->sql_record($clorcorgao->sql_query(null,null,"o40_orgao,o40_descr","o40_orgao","o40_anousu=".db_getsession("DB_anousu")." and o40_instit=".db_getsession("DB_instit")));
	  db_selectrecord("o90_orgao",$result,true,2,"","chave_o90_orgao","","0","document.form1.submit();");
	  ?>
	    </td>
	  </tr>
	  <tr>
	    <td>
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	    <?=$Lo90_unidade?></td>
	    <td>
	      <?
		if(isset($chave_o90_orgao) && $chave_o90_orgao != 0){
		  $result = $clorcunidade->sql_record($clorcunidade->sql_query(null,null,null,"o41_unidade,o41_descr||' -'||o41_anousu as o41_descr","o41_unidade","o41_anousu=".db_getsession("DB_anousu")."  and o41_orgao=$chave_o90_orgao " ));
	          db_selectrecord("o90_unidade",$result,true,2,"","chave_o90_unidade","",($clorcunidade->numrows>1?"0":""),"document.form1.submit();");
		}else{
		  db_input("o90_unidade",6,0,true,"text",3);
		}
	       ?>
	    </td>
    	  </tr>


          <tr> 
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_orcimpacto.hide();">
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
           $campos = "orcimpacto.*";
        }
        if(isset($chave_o90_codimp) && (trim($chave_o90_codimp)!="") ){
	         $sql = $clorcimpacto->sql_query_compl(null,$campos,"o90_codimp","o90_codimp=$chave_o90_codimp and $dbwhere ");
        }else if(isset($chave_o90_anoexe) && (trim($chave_o90_anoexe)!="") ){
	         $sql = $clorcimpacto->sql_query_compl("",$campos,"o90_anoexe"," o90_anoexe like '$chave_o90_anoexe%' and $dbwhere  ");
        }else if(isset($chave_o90_orgao) && (trim($chave_o90_orgao)!="") ){
	      $dbw ='';  
              if(isset($chave_o90_unidade) && (trim($chave_o90_unidade)!="0") ){
		$dbw = " and o90_unidade = $chave_o90_unidade ";
	      } 	
	      $sql = $clorcimpacto->sql_query_compl("",$campos,"o90_anoexe"," o90_orgao = $chave_o90_orgao $dbw  and $dbwhere ");
	      	 
        }else{
           $sql = $clorcimpacto->sql_query_compl("",$campos,"o90_codimp"," $dbwhere ");
        }
        db_lovrot($sql,15,"()","",$funcao_js);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $sql = $clorcimpacto->sql_query_compl(null,$campos,"o90_codimp","o90_codimp=$pesquisa_chave and $dbwhere ");
          $result = $clorcimpacto->sql_record($sql);
          if($clorcimpacto->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$o90_anoexe',false);</script>";
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