<?php
/*
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

//MODULO: educa��o
require_once("libs/db_stdlibwebseller.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");

db_postmemory( $_POST );
parse_str( $_SERVER["QUERY_STRING"] );

$clturno = new cl_turno;
$clturno->rotulo->label("ed15_i_codigo");
$clturno->rotulo->label("ed15_c_nome");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>
<body bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
  <table height="100%" border="0"  align="center" cellspacing="0" bgcolor="#CCCCCC">
    <tr>
      <td height="63" align="center" valign="top">
        <table width="55%" border="0" align="center" cellspacing="0">
          <form name="form2" method="post" action="" >
            <tr>
              <td width="4%" align="right" nowrap title="<?=$Ted15_i_codigo?>">
                <label for="ed15_i_codigo"><?=$Led15_i_codigo?></label>
              </td>
              <td width="96%" align="left" nowrap>
                <?php
                db_input( "ed15_i_codigo", 10, $Ied15_i_codigo, true, "text", 4, "", "chave_ed15_i_codigo" );
                ?>
              </td>
            </tr>
            <tr>
              <td width="4%" align="right" nowrap title="<?=$Ted15_c_nome?>">
                <label for="ed15_c_nome"><?=$Led15_c_nome?></label>
              </td>
              <td width="96%" align="left" nowrap>
                <?php
                db_input( "ed15_c_nome", 20, $Ied15_c_nome, true, "text", 4, "", "chave_ed15_c_nome" );
                ?>
              </td>
            </tr>
            <tr>
              <td colspan="2" align="center">
                <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
                <input name="limpar" type="reset" id="limpar" value="Limpar" >
                <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_turno.hide();">
              </td>
           </tr>
         </form>
       </table>
      </td>
    </tr>
    <tr>
      <td align="center" valign="top">
        <?php
        if( isset( $turnos ) ) {
          $where1 = " AND ed15_i_codigo not in ($turnos)";
        } else {
          $where1 = "";
        }

        $escola = db_getsession("DB_coddepto");

        if( !isset( $pesquisa_chave ) ) {

          if( isset( $campos ) == false ) {

            if( file_exists( "funcoes/db_func_turno.php" ) == true ) {
              include("funcoes/db_func_turno.php");
            } else {
              $campos = "turno.*";
            }
          }

          if( isset( $chave_ed15_i_codigo ) && ( trim( $chave_ed15_i_codigo ) != "" ) ) {
            $where = " AND ed15_i_codigo = {$chave_ed15_i_codigo}";
          } else if( isset( $chave_ed15_c_nome ) && ( trim( $chave_ed15_c_nome ) != "" ) ) {
            $where = " AND ed15_c_nome like '{$chave_ed15_c_nome}%'";
          } else if( isset( $sEnsino ) && !empty( $sEnsino ) ) {
            $where = " AND ed29_i_ensino IN ({$sEnsino})";
          } else if( isset( $iEscola ) && !empty( $iEscola ) ) {
            $where = " AND ed17_i_escola = {$iEscola}";
          } else {
            $where = "";
          }

          $sql  = "SELECT $campos \n";
          $sql .= "  FROM turno \n";
          $sql .= "       inner join periodoescola on periodoescola.ed17_i_turno = turno.ed15_i_codigo \n";
          $sql .= " WHERE periodoescola.ed17_i_escola = $escola \n";
          $sql .= "       {$where} \n";
          $sql .= "       {$where1} \n";
          $sql .= "GROUP BY {$campos}";

          if ( isset( $lQueryTurno ) ) {

            $sql  = " SELECT {$campos}";
            $sql .= "   FROM turno";
            $sql .= "        inner join cursoturno on cursoturno.ed85_i_turno = turno.ed15_i_codigo";
            $sql .= "        inner join cursoedu   on cursoedu.ed29_i_codigo  = cursoturno.ed85_i_curso";
            $sql .= "  where ed85_i_escola = {$iEscola} ";
            $sql .= " {$where} {$where1} ";
            $sql .= " GROUP BY {$campos}";
          }

          db_lovrot( $sql, 15, "()", "", $funcao_js );
        } else {

          if( file_exists( "funcoes/db_func_turno.php" ) == true ) {
            include("funcoes/db_func_turno.php");
          } else {
            $campos = "turno.*";
          }

          if( $pesquisa_chave != null && $pesquisa_chave != "" ) {

            if( isset( $sEnsino ) && !empty( $sEnsino ) ) {
              $where = " AND ed29_i_ensino IN ({$sEnsino})";
            } else if( isset( $iEscola ) && !empty( $iEscola ) ) {
              $where = " AND ed17_i_escola = {$iEscola}";
            } else {
              $where = "";
            }

            $sql  = "SELECT {$campos} ";
            $sql .= "  FROM turno ";
            $sql .= "       inner join periodoescola on periodoescola.ed17_i_turno = turno.ed15_i_codigo ";
            $sql .= " WHERE periodoescola.ed17_i_escola = {$escola} ";
            $sql .= "   AND turno.ed15_i_codigo = {$pesquisa_chave} ";
            $sql .= "   {$where1} ";
            $sql .= " GROUP BY {$campos}";

            if( isset( $lQueryTurno ) ) {

              $sql  = " SELECT {$campos} ";
              $sql .= "   FROM turno";
              $sql .= "        inner join cursoturno on cursoturno.ed85_i_turno = turno.ed15_i_codigo";
              $sql .= "        inner join cursoedu   on cursoedu.ed29_i_codigo  = cursoturno.ed85_i_curso";
              $sql .= "  where ed85_i_escola = {$iEscola} and turno.ed15_i_codigo = {$pesquisa_chave}";
              $sql .= "        {$where} {$where1} ";
              $sql .= "  GROUP BY {$campos}";
            }

            $result = db_query($sql);
            $linhas = pg_num_rows($result);

            if( $linhas != 0 ) {

              db_fieldsmemory( $result, 0 );
              echo "<script>".$funcao_js."('$ed15_c_nome',false);</script>";
            } else {
              echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") n�o Encontrado',true);</script>";
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