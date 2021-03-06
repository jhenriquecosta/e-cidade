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
include("classes/db_orcimpactomov_classe.php");
include("classes/db_orcimpacto_classe.php");
include("classes/db_orcorgao_classe.php");
include("classes/db_orcunidade_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clorcimpactomov = new cl_orcimpactomov;
$clorcimpacto = new cl_orcimpacto;
$clorcorgao = new cl_orcorgao;
$clorcunidade = new cl_orcunidade;
$clorcimpactomov->rotulo->label("o63_codimpmov");
$clorcimpactomov->rotulo->label("o63_anoexe");
$clorcimpactomov->rotulo->label("o63_orgao");
$clorcimpactomov->rotulo->label("o63_unidade");

    $dbwhere01 = " 1=1 ";
    $dbwhere02 = " 1=1 ";
    
    if(isset($o63_codperiodo)){
      $dbwhere01 .= " and o63_codperiodo = $o63_codperiodo ";
      $dbwhere02 .= " and o90_codperiodo = $o63_codperiodo ";
    }
    if(isset($o63_orgao) && $o63_orgao != ''){
      $dbwhere01 .= " and o63_orgao = $o63_orgao ";   
      $dbwhere02 .= " and o90_orgao = $o63_orgao ";   
    }
    if(isset($o63_unidade) && $o63_unidade != ''){
      $dbwhere01 .= " and o63_unidade = $o63_unidade ";   
      $dbwhere02 .= " and o90_unidade = $o63_unidade ";   
    }
    if(isset($o63_funcao) && $o63_funcao != ''){
      $dbwhere01 .= " and o63_funcao = $o63_funcao ";   
      $dbwhere02 .= " and o90_funcao = $o63_funcao ";   
    }
    if(isset($o63_subfuncao) && $o63_subfuncao != ''){
      $dbwhere01 .= " and o63_subfuncao = $o63_subfuncao ";   
      $dbwhere02 .= " and o90_subfuncao = $o63_subfuncao ";   
    }
    if(isset($o63_programa) && $o63_programa != ''){
      $dbwhere01 .= " and o63_programa = $o63_programa ";   
      $dbwhere02 .= " and o90_programa = $o63_programa ";   
    }
    if(isset($o63_acao) && $o63_acao != ''){
      $dbwhere01 .= " and o63_acao = $o63_acao ";   
      $dbwhere02 .= " and o90_acao = $o63_acao ";   
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
            <td  align="left" nowrap title="<?=$To63_codimpmov?>">
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <?=$Lo63_codimpmov?>
            </td>
	    <td>
              <?
		       db_input("o63_codimpmov",5,$Io63_codimpmov,true,"text",4,"","chave_o63_codimpmov");
		       ?>
              <?=$Lo63_anoexe?>

              <?
		       db_input("o63_anoexe",4,$Io63_anoexe,true,"text",4,"","chave_o63_anoexe");
		       ?>
            </td>
          </tr>
	  <tr>
	    <td align='center'>
	    
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	    <?=$Lo63_orgao?>
            </td>
	    <td >
	  <?
	  $result = $clorcorgao->sql_record($clorcorgao->sql_query(null,null,"o40_orgao,o40_descr","o40_orgao","o40_anousu=".db_getsession("DB_anousu")." and o40_instit=".db_getsession("DB_instit")));
	  db_selectrecord("o63_orgao",$result,true,2,"","chave_o63_orgao","","0","document.form1.submit();");
	  ?>
	    </td>
	  </tr>
	  <tr>
	    <td>
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	    <?=$Lo63_unidade?></td>
	    <td>
	      <?
		if(isset($chave_o63_orgao) && $chave_o63_orgao != 0){
		  $result = $clorcunidade->sql_record($clorcunidade->sql_query(null,null,null,"o41_unidade,o41_descr||' -'||o41_anousu as o41_descr","o41_unidade","o41_anousu=".db_getsession("DB_anousu")."  and o41_orgao=$chave_o63_orgao " ));
	          db_selectrecord("o63_unidade",$result,true,2,"","chave_o63_unidade","",($clorcunidade->numrows>1?"0":""),"document.form1.submit();");
		}else{
		  db_input("o63_unidade",6,0,true,"text",3);
		}
	       ?>
	    </td>
    	  </tr>


          <tr> 
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_orcimpactomov.hide();">
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
	
	$campos_impactomov  = "'I' as DB_tipo,'Impacto' ,o63_codimpmov,o63_codperiodo,o63_anoexe,o63_orgao,o63_unidade,o63_funcao,";
	$campos_impactomov .= "o63_subfuncao,o63_programa,o63_programatxt,o63_acao,o63_acaotxt,o63_unimed,o63_produto";

	$campos_impacto    = "'P' as DB_tipo,'Previs?o',orcimpacto.*";

	
        if(isset($chave_o63_codimpmov) && (trim($chave_o63_codimpmov)!="") ){
	         $sql01 = $clorcimpactomov->sql_query_compl(null,$campos_impactomov,"o63_codimpmov"," o63_codimpmov = $chave_o63_codimpmov and $dbwhere01");
	         $sql02 = $clorcimpacto->sql_query_compl(null,$campos_impacto,"o90_codimp","o90_codimp = $chave_o63_codimpmov and $dbwhere02");
        }else if(isset($chave_o63_anoexe) && (trim($chave_o63_anoexe)!="") ){
	         $sql01 = $clorcimpactomov->sql_query_compl("",$campos_impactomov,"o63_anoexe"," o63_anoexe like '$chave_o63_anoexe%' and $dbwhere01 ");
	         $sql02 = $clorcimpacto->sql_query_compl("",$campos_impacto,"o90_anoexe"," o90_anoexe like '$chave_o63_anoexe%' and $dbwhere02 ");
        }else if(isset($chave_o63_orgao) && (trim($chave_o63_orgao)!="") && (trim($chave_o63_orgao)!="0") ){
	      $dbw01 ='';  
	      $dbw02 ='';  
              if(isset($chave_o63_unidade) && (trim($chave_o63_unidade)!="0") ){
		$dbw01 = " and o63_unidade = $chave_o63_unidade ";
		$dbw02 = " and o90_unidade = $chave_o63_unidade ";
	      } 	
	      $sql01 = $clorcimpactomov->sql_query_compl("",$campos_impactomov,"o63_anoexe"," o63_orgao = $chave_o63_orgao and $dbwhere01 $dbw01");
	      $sql02 = $clorcimpacto->sql_query_compl("",$campos_impacto,"o90_anoexe"," o90_orgao = $chave_o63_orgao and $dbwhere02 $dbw02");
	      	 
        }else{
           $sql01 = $clorcimpactomov->sql_query_compl("","$campos_impactomov","o63_codimpmov","$dbwhere01");
           $sql02 = $clorcimpacto->sql_query_compl("","$campos_impacto","o90_codimp","$dbwhere02");
        }
	$sql = "($sql01) union ($sql02)";
        db_lovrot($sql,15,"()","",$funcao_js);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $clorcimpactomov->sql_record($clorcimpactomov->sql_query_compl($pesquisa_chave));
          if($clorcimpactomov->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$o63_anoexe',false);</script>";
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