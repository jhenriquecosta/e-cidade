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

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_usuariosonline.php");

$iAnoSessao = db_getsession("DB_anousu");
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta http-equiv="Expires" CONTENT="0">
	<script type="text/javascript" src="scripts/scripts.js"></script>
	<script type="text/javascript" src="scripts/strings.js"></script>
	<script type="text/javascript" src="scripts/prototype.js"></script>
	<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC>
<form class="container" name="form1">
	<fieldset>
		<legend>Relat?rio de Deprecia??es Processadas</legend>
    <table class="form-container">
      <tr>
        <td>Ano:</td>
        <td>
          <?php 
            db_input("iAno", 8, null, true, "text", 1, "", "", "", "", 4);
          ?>
        </td>
      </tr>
    </table>
	</fieldset>
  <input type="button" name="btnProcessar" id="btnProcessar" value="Emitir">
</form>	
</body>
</html>
<?php 
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
<script>

  $("btnProcessar").observe("click", function() {

    var iAno = $F("iAno");
    if (iAno == "") {

      alert(_M("patrimonial.patrimonio.pat1_relatoriodepreciacaoprocessada001.informe_ano"));
      return false;
    }

    var sLocation = "pat1_relatoriodepreciacaoprocessada002.php?iAno="+iAno;
    jan = window.open(sLocation,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0');
    jan.moveTo(0,0);
  });

  $("iAno").value = <?=$iAnoSessao;?>;
</script>

<script>

$("iAno").addClassName("field-size2");

</script>