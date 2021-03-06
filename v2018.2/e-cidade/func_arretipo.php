<?php
/**
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2014  DBSeller Servicos de Informatica             
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

require_once(modification("libs/db_stdlib.php"));
require_once(modification("libs/db_conecta.php"));
require_once(modification("libs/db_sessoes.php"));
require_once(modification("libs/db_usuariosonline.php"));
require_once(modification("dbforms/db_funcoes.php"));
require_once(modification("classes/db_arretipo_classe.php"));

db_postmemory($_POST);
parse_str($_SERVER["QUERY_STRING"]);

$oGet   = db_utils::postMemory($_GET);
$aWhere = array();

$clarretipo = new cl_arretipo();
$clarretipo->rotulo->label("k00_tipo"); 
$clarretipo->rotulo->label("k00_descr");

if (isset($chave_k00_tipo) && !DBNumber::isInteger($chave_k00_tipo)) {
  $chave_k00_tipo = '';
}

if(isset($oGet->k03_tipo)){
  $aWhere[] = "arretipo.k03_tipo in({$oGet->k03_tipo})";
}

$chave_k00_descr = isset($chave_k00_descr) ? stripslashes($chave_k00_descr) : '';

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
            <td width="4%" align="right" nowrap title="<?php echo $Tk00_tipo; ?>">
              <?php echo $Lk00_tipo; ?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?php
		            db_input("k00_tipo", 4, $Ik00_tipo, true, "text", 4, "", "chave_k00_tipo");
		          ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?php echo $Tk00_descr; ?>">
              <?php echo $Lk00_descr; ?>
            </td>
            <td width="96%" align="left" nowrap>
              <?php
                db_input("k00_descr", 40, $Ik00_descr, true, "text", 4, "", "chave_k00_descr");
		          ?>
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_arretipo.hide();">
            </td>
          </tr>
        </form>
      </table>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top"> 
      <?php

      $chave_k00_descr = addslashes($chave_k00_descr);

      if (!isset($pesquisa_chave)) {

        if (!isset($campos)) {

          if (file_exists("funcoes/db_func_arretipo.php")) {
            include(modification("funcoes/db_func_arretipo.php"));
          } else {
            $campos = "arretipo.*";
          }
        }

        if (isset($chave_k00_tipo) && (trim($chave_k00_tipo) != "")) {
          $aWhere[] = "k00_tipo = {$chave_k00_tipo}";
        }

        if (isset($chave_k00_descr) && (trim($chave_k00_descr) != "") ) {
          $aWhere[] = "k00_descr like '{$chave_k00_descr}%'";
        }

        $sql = $clarretipo->sql_query("", $campos, "k00_descr", implode(' AND ', $aWhere));

        $repassa = array();
        if (isset($chave_k00_descr) && isset($chave_k00_tipo)) {
          $repassa = array("chave_k00_tipo" => $chave_k00_tipo, "chave_k00_descr" => $chave_k00_descr);
        }

        db_lovrot($sql, 15, "()", "", $funcao_js, "", "NoMe", $repassa);
      } else {

        if ($pesquisa_chave != null && $pesquisa_chave != "") {

          $aWhere[] = "k00_tipo = {$pesquisa_chave}";

          $sSql   = $clarretipo->sql_query(null, '*', null, implode(' AND ', $aWhere));
          $result = $clarretipo->sql_record($sSql);
          if ($clarretipo->numrows != 0) {

            db_fieldsmemory($result, 0);
            echo "<script>".$funcao_js."('$k00_descr', false);</script>";
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
<script>
  js_tabulacaoforms("form2", "chave_k00_descr", true, 1, "chave_k00_descr", true);
</script>
<script type="text/javascript">
(function() {
  var query = frameElement.getAttribute('name').replace('IF', ''), input = document.querySelector('input[value="Fechar"]');
  input.onclick = parent[query] ? parent[query].hide.bind(parent[query]) : input.onclick;
})();
</script>