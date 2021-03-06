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

require_once "libs/db_stdlib.php";
require_once "libs/db_conecta.php";
require_once "libs/db_sessoes.php";
require_once "libs/db_usuariosonline.php";
require_once "dbforms/db_funcoes.php";

?>
<html>
  <head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <script>
      function abre(){
          vini = document.form1.p58_codproc.value;
          vfim = document.form1.p58_codprocfin.value
         if (vfim == "" && vini == "" ){
            alert("campo protocolo n?o pode ser vazio!");
         }else if (vfim < vini ){
             alert("O Protocolo final ? maior que o protocolo inicial!");
         }else{
             url = 'pro4_impetiqueta002.php?vini='+vini+'&vfim='+vfim;
             window.open(url,'','location=0');
         }
      }
    </script>
  </head>
  <body class="body-default">
    <div class="container">
      <form method="post" name="form1" onsubmit="abre()">
        <fieldset>
          <legend>Impress?o de Etiquetas</legend>
          <table>
            <tr>
              <td>
                <label class="bold" for="p58_codproc" id="lbl_p58_codproc">Protocolo inicial:</label>
              </td>
              <td>
                <input type="text" size="10" name="p58_codproc" onKeyPress="return teclas(event);">
              </td>
            </tr>
            <tr>
              <td>
                <label class="bold" for="p58_codprocfin" id="lbl_p58_codprocfin">Protocolo final:</label>
              </td>
              <td>
                <input type="text" size="10" name="p58_codprocfin" onKeyPress="return teclas(event);">
              </td>
            </tr>
          </table>
        </fieldset>
        <input type="button" value="Imprimir" onclick="abre()"></td>
      </form>
    </div>
    <?php
      db_menu( db_getsession("DB_id_usuario"),
               db_getsession("DB_modulo"),
               db_getsession("DB_anousu"),
               db_getsession("DB_instit"));
    ?>
  </body>
</html>