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
include("classes/db_fiscal_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clfiscal = new cl_fiscal;
$clfiscal->rotulo->label("y30_codnoti");
$clfiscal->rotulo->label("y30_data");
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
            <td width="4%" align="right" nowrap title="<?=$Ty30_codnoti?>">
              <?=$Ly30_codnoti?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("y30_codnoti",20,$Iy30_codnoti,true,"text",4,"","chave_y30_codnoti");
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
if (!isset($pesquisa_chave)) {
  $campos="y30_codnoti,identifica as dl_Identificacao,codigo as dl_Codigo_Ident,z01_nome,y30_numbloco";
  if (isset($chave_y30_codnoti) && (trim($chave_y30_codnoti)!="") ) {
    $sql = $clfiscal->sql_query_info($chave_y30_codnoti,$campos," y30_instit = ".db_getsession('DB_instit')." and y30_codnoti = $chave_y30_codnoti and  y30_setor=".db_getsession("DB_coddepto")."");
  } else if (isset($chave_y30_numbloco) && (trim($chave_y30_numbloco)!="") ) {
    $sql = $clfiscal->sql_query_info(null,$campos," y30_instit = ".db_getsession('DB_instit')." and y30_numbloco = '$chave_y30_numbloco' and  y30_setor=".db_getsession("DB_coddepto"));
  } else {
    $sql = $clfiscal->sql_query_info("",$campos," y30_instit = ".db_getsession('DB_instit')." and y30_setor=".db_getsession("DB_coddepto"));
  }
  
  db_lovrot($sql,15,"()","",$funcao_js);
} else {
  if ($pesquisa_chave!=null && $pesquisa_chave!="") {
    $result = $clfiscal->sql_record($clfiscal->sql_query_info($pesquisa_chave,"*"," y30_instit = ".db_getsession('DB_instit')." and y30_codnoti = $pesquisa_chave and y30_setor=".db_getsession("DB_coddepto")));
    if ($clfiscal->numrows!=0) {
      db_fieldsmemory($result,0);
      echo "<script>".$funcao_js."('$z01_nome',false);</script>";
    } else {
      echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") n?o Encontrado',true);</script>";
    }
  } else {
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