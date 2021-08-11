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

require_once ("libs/db_stdlib.php");
require_once ("libs/db_conecta.php");
require_once ("libs/db_sessoes.php");
require_once ("libs/db_utils.php");
require_once ("libs/db_usuariosonline.php");
require_once ("libs/db_app.utils.php");
require_once ("dbforms/db_funcoes.php");
?>
<html>
<head>
	<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta http-equiv="Expires" CONTENT="0">
	<?
	db_app::load("scripts.js, prototype.js, strings.js, datagrid.widget.js");
	db_app::load("estilos.css, grid.style.css");
	?>
</head>
<body bgcolor="#cccccc" style="margin-top: 25px" onload="">
<center>
  <fieldset>
    <legend><b>Visitas Realizadas</b></legend>
     <div id='gridContainer'></div>
  </fieldset>
  <input id="btnImprimir" name="btnImprimir" type="button" value="Imprimir Relat�rio" disabled />
</center>
</body>
</html>
<script type="text/javascript">
var oUrl                      = js_urlToObject();
var sUrlRpc                   = 'soc3_consultafamilia.RPC.php';
var oGridVisitas              = new DBGrid('gridVisitas');
    oGridVisitas.nameInstance = "oGridVisitas"; 

var aHeaders  = new Array("Data", "Hora", "Profissional que Visitou", "Observa��o");
oGridVisitas.setCellWidth(new Array('7%', '5%', '38%', '50%'));
oGridVisitas.setCellAlign(new Array('center', 'center', 'left', 'left'));
oGridVisitas.setHeader(aHeaders);
oGridVisitas.setHeight(220);
oGridVisitas.show($('gridContainer'));

/**
 * Busca as visitas realizadas a familia
 */
function js_buscaVisitas() {

  var oParametro          = new Object();
      oParametro.exec     = 'buscaVisitas';
      oParametro.iFamilia = oUrl.familia;

  var oDadosRequisicao            = new Object();
      oDadosRequisicao.method     = 'post';
      oDadosRequisicao.parameters = 'json='+Object.toJSON(oParametro);
      oDadosRequisicao.onComplete = js_retornoBuscaVisitas;

  js_divCarregando("Aguarde, buscando as visitas realizadas a fam�lia.", "msgBox");
  new Ajax.Request(sUrlRpc, oDadosRequisicao);
}

/**
 * Retorna os dados da visita e monta na Grid
 */
function js_retornoBuscaVisitas(oResponse) {

  js_removeObj("msgBox");
  var oRetorno = eval('('+oResponse.responseText+')');

  if (oRetorno.aVisitas.length > 0) {

    oGridVisitas.clearAll(true);
    oRetorno.aVisitas.each(function(oVisita, iLinha) {

      var aLinha    = new Array();
          aLinha[0] = oVisita.dtVisita.urlDecode();
          aLinha[1] = oVisita.sHora.urlDecode();
          aLinha[2] = oVisita.sProfissional.urlDecode();
          aLinha[3] = oVisita.sObservacao.urlDecode();

      oGridVisitas.addRow(aLinha);
    });

    oGridVisitas.renderRows();
    $('btnImprimir').disabled = false;
  }
}

$('btnImprimir').observe("click", function(event) {

  var sLocation  = "soc2_visitafamilia002.php?";
      sLocation += "&sOrigem=relatorio";
      sLocation += "&iFamilia="+oUrl.familia;

  jan = window.open(sLocation, 
                    '', 
                    'width='+(screen.availWidth-5)+
                    ',height='+(screen.availHeight-40)+
                    ',scrollbars=1,location=0');
  jan.moveTo(0,0);
});

js_buscaVisitas();
</script>