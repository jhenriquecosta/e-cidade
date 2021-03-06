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

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_habitinscricao_classe.php");

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

$clhabitinscricao = new cl_habitinscricao;
$clhabitinscricao->rotulo->label("ht15_sequencial");
$clhabitinscricao->rotulo->label("ht15_candidato");

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
            <td width="4%" align="right" nowrap title="<?=$Tht15_sequencial?>">
              <b>C?digo Inscri??o:</b>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		            db_input("ht15_sequencial", 10, $Iht15_sequencial, true, "text", 4, "", "chave_ht15_sequencial");
		          ?>
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_habitinscricao.hide();">
             </td>
          </tr>
        </form>
        </table>
      </td>
  </tr>
  <tr> 
    <td align="center" valign="top"> 
      <?
        
        $sWhere = ' habitcandidatointeresse.ht20_ativo is true ';
        
	      if (!isset($pesquisa_chave)) {
	      	
	        if (isset($campos) == false) {
	        	
	          if(file_exists("funcoes/db_func_habitinscricao.php")==true){
	            include("funcoes/db_func_habitinscricao.php");
	          } else {
	            $campos = "habitinscricao.*";
	          }
	        }
	        
	        if (isset($desistencia) && $desistencia == 'true') {
	        	
	        	$campos  = " habitinscricao.ht15_sequencial,                     ";
            $campos .= " habitinscricao.ht15_datalancamento,                 ";
	        	$campos .= " habitcandidatointeresse.ht20_habitcandidato,        "; 
            $campos .= " cgm.z01_nome,                                       ";
            $campos .= " habitcandidatointeresseprograma.ht13_habitprograma, "; 
	        	$campos .= " habitprograma.ht01_descricao                        ";
	        }
	        
	        if (isset($chave_ht15_sequencial) && (trim($chave_ht15_sequencial) != "")) {
	        	
	        	$sWhere .= " habitinscricao.ht15_sequencial = {$chave_ht15_sequencial} ";
		        $sql     = $clhabitinscricao->sql_query(null, $campos, "ht15_sequencial", $sWhere);
		        
	        } else if (isset($chave_ht15_candidato) && (trim($chave_ht15_candidato) != "")) {
	        	
	        	$sWhere .= " ht15_candidato like '{$chave_ht15_candidato}%' ";
		        $sql     = $clhabitinscricao->sql_query(null, $campos, "ht15_candidato", $sWhere);
		        
	        } else {
	          $sql = $clhabitinscricao->sql_query(null, $campos, "ht15_sequencial", $sWhere);
	        }
	        
	        $repassa = array();
	        if (isset($chave_ht15_candidato)) {
	        	
	          $repassa = array("chave_ht15_sequencial" => $chave_ht15_sequencial,
	                           "chave_ht15_candidato"  => $chave_ht15_candidato);
	        }

	        db_lovrot($sql, 15, "()", "", $funcao_js, "", "NoMe", $repassa);
	      } else {
	      	
	        if ($pesquisa_chave != null && $pesquisa_chave != "") {
	        	
	          $result = $clhabitinscricao->sql_record($clhabitinscricao->sql_query("","*","","ht15_sequencial = $pesquisa_chave"));
	         // echo $clhabitinscricao->sql_query("","*","","ht15_sequencial = $pesquisa_chave");
	          //die();
	          
	          if ($clhabitinscricao->numrows != 0) {
	          	
	            db_fieldsmemory($result,0);
	            echo "<script>".$funcao_js."('{$pesquisa_chave}', '{$z01_nome}',false);</script>";
	          } else {
		          echo "<script>".$funcao_js."('','Chave(".$pesquisa_chave.") n?o Encontrado',true);</script>";
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
<script>
js_tabulacaoforms("form2","chave_ht15_candidato",true,1,"chave_ht15_candidato",true);
</script>