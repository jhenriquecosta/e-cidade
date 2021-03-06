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
require_once(modification("libs/db_stdlib.php"));
require_once(modification("libs/db_utils.php"));
require_once(modification("libs/db_app.utils.php"));
require_once(modification("libs/db_conecta.php"));
require_once(modification("libs/db_sessoes.php"));
require_once(modification("dbforms/db_funcoes.php"));

?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/widgets/DBLookUp.widget.js"></script>
</head>
<body class='body-default'>
  <div class='container'>
    <form name="form1" method="post" action="">
      <fieldset>
        <legend>Cancelamento de Transfer?ncia de Alunos Encerrados</legend>
        <table class="form-container">
          <tr>
            <td class="field-size1">
            <label for="ed60_i_codigo"><a href="#" id='ancoraAluno'>Aluno:</a></label>
            </td>
            <td>
              <input type='hidden' name='ed60_i_codigo'    id='db_ed60_i_codigo' />
              <input type='hidden' name='ed137_sequencial' id='iCodigoTransferencia' />
              <input type='text'   name='ed47_i_codigo'    id='ed47_i_codigo' class="field-size2"  />
              <input type='text'   name='ed47_v_nome'      id='ed47_v_nome'   class="field-size7 readonly " />
            </td>
          </tr>
        </table>
      </fieldset>
      <input type="button" name="anular" id="btnAnular" value="Confirmar Cancelamento" />
    </form>
  </div>
<?php db_menu(); ?>
</body>
<script type="text/javascript">

var oLookUp = new DBLookUp( $('ancoraAluno'), $('ed47_i_codigo'), $('ed47_v_nome'), {
  sArquivo: 'func_transferiralunoencerrado.php',
  sLabel: 'Pesquisa Alunos Transferidos',
  sObjetoLookUp: 'db_iframe_transferiralunoencerrado',
  aCamposAdicionais: ['db_transferencia', 'db_ed60_i_codigo']
});

oLookUp.setCallBack('onClick', function(aCampos) {

  $('iCodigoTransferencia').value = aCampos[2];
  $('db_ed60_i_codigo').value     = aCampos[3];
});

oLookUp.setCallBack('onChange', function(lErro, aCampos) {

  $('ed47_i_codigo').value        = '';
  $('db_ed60_i_codigo').value     = '';
  $('iCodigoTransferencia').value = '';
  if ( !lErro ) {

    $('ed47_v_nome').value          = aCampos[0];
    $('ed47_i_codigo').value        = aCampos[2];
    $('db_ed60_i_codigo').value     = aCampos[3];
    $('iCodigoTransferencia').value = aCampos[4];
  }
});

$('btnAnular').addEventListener('click', function() {

  if ( empty($F('db_ed60_i_codigo')) ) {
    alert('Selecione um aluno.');
    return;
  }
  var oParametros = {
    'exec'           : 'anular',
    'iTransferencia' : $F('iCodigoTransferencia'),
    'iMatricula'     : $F('db_ed60_i_codigo')
  };
  new AjaxRequest("edu4_transferiralunosencerrados.RPC.php", oParametros, function(oRetorno, lErro) {

    alert(oRetorno.sMessage.urlDecode());
    if (lErro) {
      return;
    }
    limparCampos();
  }).setMessage( "Anulando transfer?ncia do aluno, aguarde..." ).execute();
});

function limparCampos() {

  document.form1.reset();
  $$('input[type="hidden"]').each( function(oElement) {
    oElement.value = '';
  });
}
</script>
</html>