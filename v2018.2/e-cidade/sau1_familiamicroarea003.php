<?php
/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2016  DBSeller Servicos de Informatica
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
include(modification("classes/db_familiamicroarea_classe.php"));
include(modification("dbforms/db_funcoes.php"));

parse_str( $_SERVER["QUERY_STRING"] );
db_postmemory( $_POST );

$clfamiliamicroarea = new cl_familiamicroarea;
$db_botao           = false;
$db_opcao           = 33;

if(isset($excluir)) {

  db_inicio_transacao();

  $db_opcao = 3;
  $clfamiliamicroarea->excluir($sd35_i_codigo);

  db_fim_transacao();
} else if(isset($chavepesquisa)) {

  $db_opcao = 3;
  $result   = $clfamiliamicroarea->sql_record($clfamiliamicroarea->sql_query($chavepesquisa));
  db_fieldsmemory($result,0);
  $db_botao = true;
}
?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
  <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body class="body-deafult">
  <?php
    include(modification("forms/db_frmfamiliamicroarea.php"));
    db_menu();
  ?>
</body>
</html>
<?php
  if(isset($excluir)) {

    if($clfamiliamicroarea->erro_status == "0") {
      $clfamiliamicroarea->erro(true,false);
    } else {
      $clfamiliamicroarea->erro(true,true);
    }
  }

  if($db_opcao == 33) {
    echo "<script>document.form1.pesquisar.click();</script>";
  }
?>
<script>
js_tabulacaoforms("form1","excluir",true,1,"excluir",true);
</script>