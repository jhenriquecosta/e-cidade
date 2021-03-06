<?php
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
require_once(modification("libs/db_utils.php"));

$lAcessadoEscola = isModuloEscola();

db_postmemory($_POST);

$oDaoProcedimento   = new cl_procedimento;
$oDaoFormaAvaliacao = new cl_formaavaliacao;
$oDaoProcEscola     = new cl_procescola;
$db_opcao           = 1;
$db_opcao1          = 1;
$db_botao           = true;

?>
<html>
 <head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
  <link href="estilos.css" rel="stylesheet" type="text/css">
 </head>
 <body bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
    <td align="left" valign="top" bgcolor="#CCCCCC">
     <br>
     <center>
      <fieldset style="width:95%"><legend><b>Inclus?o de Procedimento de Avalia??o</b></legend>
        <?include(modification("forms/db_frmprocedimento.php"));?>
      </fieldset>
     </center>
    </td>
   </tr>
  </table>
 </body>
</html>
<script>
js_tabulacaoforms("form1","ed40_i_formaavaliacao",true,1,"ed40_i_formaavaliacao",true);
</script>
<?php
if ( isset($incluir) ) {

  db_inicio_transacao();
  try {

    $oDaoProcedimento->ed40_c_contrfreqmpd = "I";
    $oDaoProcedimento->incluir(null);

    if ($oDaoProcedimento->erro_status == 0 ) {
      throw new Exception($oDaoProcedimento->erro_msg);
    }
    if ( $lAcessadoEscola ) {

      $oDaoProcEscola->ed86_i_escola       = db_getsession("DB_coddepto");
      $oDaoProcEscola->ed86_i_procedimento = $oDaoProcedimento->ed40_i_codigo;
      $oDaoProcEscola->incluir(null);

      if ($oDaoProcEscola->erro_status == 0 ) {
        throw new Exception($oDaoProcEscola->erro_msg);
      }
    }
    db_fim_transacao();

    db_msgbox("Inclus?o efetuada com sucesso.\nValores : {$oDaoProcedimento->ed40_i_codigo}");
    db_redireciona("edu1_procedimento002.php?chavepesquisa={$oDaoProcedimento->ed40_i_codigo}");

  } catch (Exception $e) {

    db_fim_transacao(true);
    echo "<script>alert('" . $e->getMessage() . "');</script>";
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
  }
}
?>