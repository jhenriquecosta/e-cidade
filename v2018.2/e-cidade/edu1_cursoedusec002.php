<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
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

require_once(modification("libs/db_stdlibwebseller.php"));
require_once(modification("libs/db_stdlib.php"));
require_once(modification("libs/db_conecta.php"));
require_once(modification("libs/db_sessoes.php"));
require_once(modification("libs/db_usuariosonline.php"));
require_once(modification("dbforms/db_funcoes.php"));
require_once(modification("dbforms/db_classesgenericas.php"));
require_once(modification("classes/db_cursoescola_classe.php"));
require_once(modification("classes/db_cursoedu_classe.php"));
parse_str($_SERVER["QUERY_STRING"]);
db_postmemory($_POST);
$clcurso                  = new cl_curso;
$clcursoescola            = new cl_cursoescola;
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$db_opcao                 = 22;
$db_opcao1                = 3;
$db_botao                 = false;

if (isset($alterar)) {

  $db_opcao  = 2;
  $db_opcao1 = 3;
  $db_botao  = true;
  db_inicio_transacao();
  $clcurso->alterar($ed29_i_codigo);
  db_fim_transacao();

} else if (isset($chavepesquisa)) {

  $db_opcao  = 2;
  $db_opcao1 = 3;
  $db_botao  = true;
  $sSql      = $clcurso->sql_query($chavepesquisa);
  $rs        = $clcurso->sql_record($sSql);
  db_fieldsmemory($rs,0);
}
$sTitulo = 'Altera??o de Curso';
?>
<html>
  <head>
   <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
   <meta http-equiv="Expires" CONTENT="0">
   <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
   <link href="estilos.css" rel="stylesheet" type="text/css">
  </head>
  <body >

    <?php
      MsgAviso(db_getsession("DB_coddepto"),"escola");
      include(modification("forms/db_frmcursoedu.php"));
      db_menu();
    ?>
 </body>
</html>
<?
if (isset($alterar)) {

  if ($clcurso->erro_status == "0") {

    $clcurso->erro(true,false);
    $db_botao = true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";

    if ($clcurso->erro_campo != "") {

      echo "<script> document.form1.".$clcurso->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clcurso->erro_campo.".focus();</script>";
    }
  } else {
    $clcurso->erro(true,true);
  }
}

if ($db_opcao == 22) {
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>