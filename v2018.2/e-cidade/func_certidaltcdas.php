<?php
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

  require_once ("libs/db_stdlib.php");
  require_once ("libs/db_conecta.php");
  require_once ("libs/db_sessoes.php");
  require_once ("libs/db_usuariosonline.php");
  require_once ("dbforms/db_funcoes.php");
  require_once ("classes/db_certid_classe.php");
  
  db_postmemory($HTTP_POST_VARS);
  parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
  
  $clcertid = new cl_certid;
  
  $clcertid->rotulo->label("v13_certid");
  $clcertid->rotulo->label("v13_dtemis");
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
          <form name="form2" method="post" action="" >
            <table width="35%" border="0" align="center" cellspacing="0">
              <tr> 
                <td width="4%" align="right" nowrap title="<?php echo $Tv13_certid; ?>">
                  <?php echo $Lv13_certid; ?>
                </td>
                <td width="96%" align="left" nowrap> 
                  <?php
                    db_input("v13_certid", 10, $Iv13_certid, true, "text", 4, "", "chave_v13_certid");
                  ?>
                </td>
              </tr>
              <tr> 
                <td width="4%" align="right" nowrap title="<?php echo $Tv13_dtemis;?>">
                  <?php echo $Lv13_dtemis; ?>
                </td>
                <td width="96%" align="left" nowrap> 
                  <?php
                    db_inputdata('v13_dtemis', @$v13_dtemis_dia, @$v13_dtemis_mes, @$v13_dtemis_ano, true,
                                 'text', 4, "", "chave_v13_dtemis");
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
            </table>
          </form>
        </td>
      </tr>
      <tr> 
        <td align="center" valign="top"> 
          <?php
            $sWhere  = "         v13_instit = ".db_getsession('DB_instit')."                                         \n";
            $sWhere .= " and (   v51_certidao is null                                                                \n";
            $sWhere .= "      or v51_certidao not in ( select v51_certidao                                           \n";
            $sWhere .= "                                 from inicial                                                \n";
            $sWhere .= "                                      inner join inicialcert on v51_inicial = v50_inicial    \n";
            $sWhere .= "                                where v50_situacao = 1 ))                                    \n";
            $sWhere .= " and (   exists ( select 1                                                                   \n";
            $sWhere .= "                    from inicialnomes                                                        \n";
            $sWhere .= "                         inner join arrenumcgm on arrenumcgm.k00_numpre = termo.v07_numpre   \n";
            $sWhere .= "                   where inicialnomes.v58_inicial = {$v50_inicial}                           \n";
            $sWhere .= "                     and inicialnomes.v58_numcgm  = arrenumcgm.k00_numcgm)                   \n";
            $sWhere .= "      or exists ( select 1                                                                   \n";
            $sWhere .= "                    from inicialnomes                                                        \n";
            $sWhere .= "                         inner join arrenumcgm on arrenumcgm.k00_numpre = divida.v01_numpre  \n";
            $sWhere .= "                   where inicialnomes.v58_inicial = {$v50_inicial}                           \n";
            $sWhere .= "                     and inicialnomes.v58_numcgm  = arrenumcgm.k00_numcgm ) )                \n";
            
            if (!isset($pesquisa_chave)) {
              
              if (isset($campos) == false) {
                $campos = "distinct certid.*";
              }
              
              if (isset($chave_v13_certid) && (trim($chave_v13_certid) != "")) {
                
                $sSql = $clcertid->sql_query_inicial_cda($chave_v13_certid, $campos, "v13_certid", 
                                                        "v13_certid=$chave_v13_certid and $sWhere");
              
              } else if (isset($chave_v13_dtemis) && (trim($chave_v13_dtemis) != "")) {
                
                $chave_v13_dtemis = implode("-", array_reverse( explode("/", trim( $chave_v13_dtemis ) )));
                
                $sSql = $clcertid->sql_query_inicial_cda("", $campos, "v13_dtemis",
                                                        " v13_dtemis = '{$chave_v13_dtemis}' and $sWhere ");
              } else {
                
                $sSql = $clcertid->sql_query_inicial_cda("",$campos,"v13_certid","$sWhere");
              }
            
              db_lovrot($sSql, 15, "()", "", $funcao_js);
            } else {
              
              if ($pesquisa_chave != null && $pesquisa_chave != "") {
                
                $result = $clcertid->sql_record($clcertid->sql_query_inicial_cda(null, "*", null, 
                                                "v13_certid=$pesquisa_chave and $sWhere"));
                
                if ($clcertid->numrows != 0) {
                  
                  db_fieldsmemory($result, 0);
                  
                  echo "<script>" . $funcao_js . "('$v13_dtemis',false);</script>";
                } else {
                  
                  echo "<script>" . $funcao_js . "('Chave(" . $pesquisa_chave . ") n?o Encontrado',true);</script>";
                }
              } else {
                
                echo "<script>" . $funcao_js . "('',false);</script>";
              }
            }
          ?>
        </td>
      </tr>
    </table>
  </body>
</html>
<?php
  if(!isset($pesquisa_chave)){
?>
  <script>
    document.form2.chave_v13_certid.focus();
    document.form2.chave_v13_certid.select();
  </script>
<?php
  }
?>