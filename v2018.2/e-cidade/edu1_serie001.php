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

require_once ("libs/db_stdlibwebseller.php");
require_once ("libs/db_stdlib.php");
require_once ("libs/db_conecta.php");
require_once ("libs/db_sessoes.php");
require_once ("libs/db_usuariosonline.php");
require_once ("dbforms/db_funcoes.php");

db_postmemory($_POST);

$clserie  = new cl_serie;
$clensino = new cl_ensino;
$db_opcao = 1;
$db_botao = true;

if( isset( $incluir ) ) {

  db_inicio_transacao();

  $sSqlSerie = $clserie->sql_query_file( "", "max(ed11_i_sequencia)", "", "ed11_i_ensino = {$ed11_i_ensino}" );
  $result    = $clserie->sql_record( $sSqlSerie );

  if( $clserie->numrows > 0 ) {

    db_fieldsmemory( $result, 0 );

    if( $max == "" ) {
      $max = 0;
    }
  } else {
    $max = 0;
  }

  $clserie->ed11_i_codcenso  = 'null';
  $clserie->ed11_i_sequencia = ($max + 1);
  $clserie->incluir($ed11_i_codigo);

  db_fim_transacao();
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
<body class="body-default">
  <?php
  include("forms/db_frmserie.php");
  ?>
</body>
</html>
<script>
 js_tabulacaoforms("form1","ed11_i_ensino",true,1,"ed11_i_ensino",true);
</script>
<?php
if( isset( $incluir ) ) {

  if( $clserie->erro_status == "0" ) {

    $clserie->erro( true, false );
    $db_botao = true;

    echo "<script> document.form1.db_opcao.disabled=false;</script>";

    if( $clserie->erro_campo != "" ) {

      echo "<script> document.form1.".$clserie->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clserie->erro_campo.".focus();</script>";
    }
  } else {

    $clserie->erro( true, false );
    ?>
    <script>
      parent.mo_camada("a2");
    </script>
    <?php
    db_redireciona("edu1_serie002.php?chavepesquisa=".$clserie->ed11_i_codigo);
  }
}