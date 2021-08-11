<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBselller Servicos de Informatica             
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

require_once('libs/db_stdlib.php');
require_once('libs/db_conecta.php');
require_once('libs/db_sessoes.php');
require_once('libs/db_usuariosonline.php');
require_once('dbforms/db_funcoes.php');

db_postmemory($HTTP_POST_VARS);
?>

<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>

<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">

<br><br><br>
<center>
  <form name="form1" method="post" action="">
    <table width="70%">
      <tr>
        <td align="center">
          <fieldset style="width:30%"><legend><b>Consultas / Exames Solicitados</b></legend>
            <table width='100%' border='0'>
              <tr>
                <td align="left" style="padding-bottom: 2px;" nowrap> 
                  <b>Per�odo:</b>
                  <?
                  db_inputdata('dataini', @$dataini_dia, @$dataini_mes, @$dataini_ano, true, 'text', 1, '');
                  ?>
                  <b>a</b>
                  <?
                  db_inputdata('datafim', @$datafim_dia, @$datafim_mes, @$datafim_ano, true, 'text', 1, '');
                  ?>
                </td>
              </tr>
              <tr>
                <td align="center">
                  <br>
                  <input name="gerar" id="gerar" type="button" value="Gerar Relat�rio" onclick="js_mandaDados();">
                </td>
              </tr>
            </table>
          </fieldset>
        </td>
      </tr>
    </table>

  </form>
</center>
<?
db_menu(db_getsession('DB_id_usuario'), db_getsession('DB_modulo'), 
        db_getsession('DB_anousu'), db_getsession('DB_instit')
       );
?>

<script>

function js_validaEnvio() {

  if (document.form1.dataini.value == '' || document.form1.datafim.value == '') {

    alert('Informe o per�odo.');
    return false;

  }

  aIni = document.form1.dataini.value.split('/');
  aFim = document.form1.datafim.value.split('/');
  dIni = new Date(aIni[2], aIni[1], aIni[0]);
  dFim = new Date(aFim[2], aFim[1], aFim[0]);

  if (dFim < dIni) {
  			
    alert('Data final n�o pode ser menor que a data inicial.');
    document.form1.datafim.value = '';
    document.form1.datafim.focus();
    return false;
  
  }

  return true;						

}

function js_mandaDados() {
 
  if (js_validaEnvio()) {

    var sGet = '&dIni='+$F('dataini')+'&dFim='+$F('datafim');

    oJan = window.open('tfd2_solicitacoesprofissional002.php?'+sGet, '',
                       'width='+(screen.availWidth - 5)+',height='+(screen.availHeight - 40)+
                       ',scrollbars=1,location=0 '
                      );
    oJan.moveTo(0, 0);

  }

}

</script>
</body>
</html>