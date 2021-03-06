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

require_once("libs/db_app.utils.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <?
  db_app::load("scripts.js, prototype.js, strings.js, arrays.js, dbcomboBox.widget.js"); 
  db_app::load("estilos.css");
  ?>
</head>
<body style='margin-top: 25px' bgcolor="#cccccc">
<center>      
<div style="width: 300px;" >
  <form name="form1" id='frmFichaAcompanhamento' method="post">
    <fieldset>
      <legend style="font-weight: bold">Familias por Zona</legend>
      <table>
        <tr>
          <td ><b>Zona:</b></td>
          <td id='ctnZona'></td>
        </tr>
      </table>
    </fieldset>
    <input type="button" value="Imprimir" id="imprimir"/>
  </form>
</div>
</center>
</body>
<? 
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</html>
<script type="text/javascript">

var sUrlRPC  = "soc4_importabasemunicipio.RPC.php";
var oCboZona = new DBComboBox("cboZona", "oCboZona", null, "200px");
oCboZona.show($('ctnZona'));

oCboZona.addItem(1, "Urbana");
oCboZona.addItem(2, "Rural");
oCboZona.addItem(3, "Todas");

/**
 * Pesquisamos se existem familias sem avaliacao processada
 */
function js_pesquisaFamiliasSemAvaliacao() {

  var oParametro  = new Object();
  oParametro.exec = 'getTotalCidadoesFamiliasSemAvaliacao';

  var oAjax = new Ajax.Request(sUrlRPC,
                               {
                                 method:     'post',
                                 parameters: 'json='+Object.toJSON(oParametro),
                                 onComplete: js_retornaPesquisaFamiliasSemAvaliacao
                               }
                              );
}

/**
 * Caso existam familias ou cidadaos com avaliacoes nao processadas, apresenta a mensagem ao usuario
 */
function js_retornaPesquisaFamiliasSemAvaliacao(oResponse) {

  var oRetorno = eval('('+oResponse.responseText+')');

  if (oRetorno.qtdFamiliaSemAvaliacao > 0 || oRetorno.qtdCidadaoSemAvaliacao > 0) {

    sMsg  = 'Existem avalia??es ainda n?o processadas.';
    sMsg += '\nAvalia??es de Fam?lias: '+oRetorno.qtdFamiliaSemAvaliacao;
    sMsg += '\nAvalia??es de Cidad?os: '+oRetorno.qtdCidadaoSemAvaliacao;
    sMsg += '\nPara um relat?rio completo, processe as demais avalia??es em: ';
    sMsg += '\nProcedimentos -> Cadastro ?nico -> Processar Avalia??o S?cio Econ?mica';
    alert(sMsg);
  }
}

$('imprimir').observe('click', function () {

  var sLocation  = "soc2_familiaporzona002.php?";
	sLocation     += "&iZona="+oCboZona.getValue();
	jan            = window.open(sLocation, '', 
	  	             'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0');
	jan.moveTo(0,0);
});

js_pesquisaFamiliasSemAvaliacao();
</script>