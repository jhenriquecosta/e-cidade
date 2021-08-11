<?
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

require_once(modification("libs/db_stdlibwebseller.php"));
require_once(modification("libs/db_stdlib.php"));
require_once(modification("libs/db_conecta.php"));
require_once(modification("libs/db_sessoes.php"));
require_once(modification("libs/db_usuariosonline.php"));
require_once(modification("dbforms/db_funcoes.php"));
require_once(modification("libs/db_utils.php"));
db_postmemory($HTTP_POST_VARS);
$oDaoAtividadeRh     = db_utils::getdao('atividaderh');
$oDaoRelacaoTrabalho = db_utils::getdao('relacaotrabalho');
$db_opcao            = 1;
$db_botao            = true;
$sNomeEscola         = db_getsession("DB_nomedepto");
$iModulo             = db_getsession("DB_modulo");
?>
<html>
 <head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/webseller.js"></script>
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <style>
   .cabec {

     font-size: 11;
     font-weight: bold;
     color: #DEB887;
     background-color:#444444;
     border:1px solid #CCCCCC;

   }

   .aluno{
      font-size: 11;
   }
  </style>
 </head>
 <body class="body-default" >
  <?MsgAviso(db_getsession("DB_coddepto"),"escola");?>
  <a name="topo"></a>
  <div class="container">
    <form name="form1" method="post" action="">
      <fieldset style="width:95%"><legend><b>Relatório de Recursos Humanos</b></legend>
        <table class="form-container">
          <tr>
            <?
              if ($iModulo == 7159) {

                echo ' <td align="left">';
                echo '  <label for="escola">Selecione a escola:</label>';
                echo ' </td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>';
                       $oDaoEscola     = db_utils::getdao('escola');
                       $sSqlEscola     = $oDaoEscola->sql_query_file("","ed18_i_codigo,ed18_c_nome","","");
                       $rsResultEscola = $oDaoEscola->sql_record($sSqlEscola);
                       $iLinhas        = $oDaoEscola->numrows;
                       echo '<select name="escola" id="escola">';
                       echo ' <option value="">Selecione a Escola</option>';
                              for ($iCont = 0; $iCont < $iLinhas; $iCont++) {
                                $oDadosEscola = db_utils::fieldsmemory($rsResultEscola,$iCont);
                                echo " <option value='$oDadosEscola->ed18_i_codigo'>$oDadosEscola->ed18_c_nome</option>";
                              }
                       echo ' </select>';
                       echo '</td>';
              } else {

                $iEscola = db_getsession("DB_coddepto");
                echo "<input type= 'hidden' id ='escola' value = '$iEscola' >";

              }
            ?>
          </tr>
          <tr>
            <td align="left">
              <fieldset class="separator">
                <legend >Selecione a atividade</legend>
                <?
                  $sSql = $oDaoAtividadeRh->sql_query("","*","ed01_c_descr","");
                  $rs   = $oDaoAtividadeRh->sql_record($sSql);?>
                <select id = "atividade" name="atividade" size="15" multiple>
                  <?
                    for ($iCont = 0; $iCont < $oDaoAtividadeRh->numrows; $iCont++) {
                      $oDadosRh = db_utils::fieldsmemory($rs, $iCont);
                  ?>
                    <option value = "<?= $oDadosRh->ed01_i_codigo?> " <?= @$iAtividade == $oDadosRh->ed01_i_codigo
                     ? "selected" : ""?> ><?= trim($oDadosRh->ed01_c_descr)?></option>
                  <?
                    }
                  ?>
                </select>
              </fieldset>
            </td>
          </tr>
          <tr>
            <td>
             <fieldset style="text-align:center">
               Para selecionar mais de uma atividade<br>mantenha pressionada a tecla CTRL
               <br>e clique sobre o nome da atividade.
             </fieldset>
            </td>
          </tr>
          <tr>
            <td>
              <label for="ordem">Ordenar por:</label>
              <br>
              <select id = "ordem" name="ordem">
                <option value="z01_nome">NOME</option>
                <option value="ed01_c_descr">ATIVIDADE</option>
              </select>
            </td>
          </tr>
        </table>
      </fieldset>
      <input type="button" name="procurar" value="Processar" onclick="js_procurar(document.form1.atividade.value)">
    </form>
  </div>
  <?
    db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),
            db_getsession("DB_anousu"),db_getsession("DB_instit")
           );
  ?>
 </body>
</html>
<script>
function js_procurar(atividade) {

  atividades = "";
  sep        = "";

  for (i = 0; i < $('atividade').length; i++) {

    if ($('atividade').options[i].selected == true) {

      atividades += sep+$('atividade').options[i].value;
      sep         = ",";

    }

  }

  if (atividades == "") {

    alert("Selecione alguma atividade!");
    return false;

  }

  jan = window.open('edu2_rechumano002.php?atividades='+atividades+'&ordem='+$('ordem').value+'&iEscola='+$('escola').value,
	  	            '','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 '
		           );
  jan.moveTo(0,0);

}
</script>