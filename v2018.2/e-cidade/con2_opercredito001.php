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

require(modification("libs/db_stdlib.php"));
require(modification("libs/db_conecta.php"));
include(modification("libs/db_sessoes.php"));
include(modification("libs/db_usuariosonline.php"));
include(modification("dbforms/db_funcoes.php"));
include(modification("libs/db_liborcamento.php"));
include(modification("dbforms/db_classesgenericas.php"));

$clcriaabas      = new cl_criaabas;

$clrotulo = new rotulocampo;
$clrotulo->label('DBtxt21');
$clrotulo->label('DBtxt22');


db_postmemory($HTTP_POST_VARS);

$abas    = array();
$titulos = array();
$fontes  = array();
$sizecp  = array();

/*
 * Definimos alguns paramentros para o relat�rio, conforme o ano.
 */
$iAnoAtual = db_getsession("DB_anousu");
if ($iAnoAtual < 2008){

  $iCodRel          = 6;
  $sFonteParametros = "con2_conrelparametros.php";
  $sTituloParametro = "Parametros";
} else if ($iAnoAtual == 2008){

  $iCodRel          = 32;
  $sFonteParametros = "con2_orcparamrelopcre001.php";
  $sTituloParametro = "Preenchimento";
} else if ($iAnoAtual <= 2009) {

  $iCodRel          = 63;
  $sFonteParametros = "con2_conrelparametros.php";
  $sTituloParametro = "Parametros";
} else if ($iAnoAtual >= 2010 && $iAnoAtual < 2017) {

  $iCodRel          = 92;
  $sFonteParametros = "con4_parametrosrelatorioslegais001.php?c83_codrel={$iCodRel}";
  $sTituloParametro = "Parametros";
} else if ($iAnoAtual >= 2017) {

  $iCodRel          = 168;
  $sFonteParametros = "con4_parametrosrelatorioslegais001.php?c83_codrel={$iCodRel}";
  $sTituloParametro = "Par�metros";
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
  <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
    <center>
    <?
    if (db_getsession("DB_anousu") <= 2009) {
      $clcriaabas->identifica = array(
                                      "relatorio" => "Relatorio",
                                      "variaveis" => "Vari�veis",
                                      "parametro" => $sTituloParametro,
                                      "notas"     => "Notas Explicativas"
                                     );
      $clcriaabas->title      = array(
                                      "relatorio" => "Relatorio",
                                      "variaveis" => "Vari�veis",
                                      "parametro" => $sTituloParametro,
                                      "notas"     => "Notas Explicativas"
                                     );
      $clcriaabas->src        = array(
                                      "relatorio" => "con2_opercredito011.php",
                                      "variaveis" => "con2_conrelinfo001.php?c83_codrel=$iCodRel",
                           			      "parametro" => "{$sFonteParametros}?c83_codrel=$iCodRel",
                                      "notas"     => "con2_conrelnotas.php?c83_codrel=$iCodRel",
                                     );
      $clcriaabas->sizecampo  = array(
                                      "relatorio" => "23",
                                      "variaveis" => "23",
                                      "parametro" => "23",
                                      "notas"     => 23
                                     );
    } else {

      $clcriaabas->identifica = array(
                                      "relatorio" => "Relat�rio",
                                      "parametro" => $sTituloParametro,
                                      "notas"     => "Notas Explicativas"
                                     );
      $clcriaabas->title      = array(
                                      "relatorio" => "Relat�rio",
                                      "parametro" => $sTituloParametro,
                                      "notas"     => "Notas Explicativas"
                                     );
      $clcriaabas->src        = array(
                                      "relatorio" => "con2_opercredito011.php?c83_codrel=$iCodRel",
                                      "parametro" => "{$sFonteParametros}",
                                      "notas"     => "con2_conrelnotas.php?c83_codrel=$iCodRel",
                                     );
      $clcriaabas->sizecampo  = array(
                                      "relatorio" => "23",
                                      "parametro" => "23",
                                      "notas"     => 23
                                     );
    }
    $clcriaabas->cria_abas();
    ?>
    </center>
  </td>
  </tr>
</table>
<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>