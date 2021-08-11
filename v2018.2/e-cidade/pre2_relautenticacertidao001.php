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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_utils.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");

$oPost = db_utils::postMemory($_POST,0);
$oGet  = db_utils::postMemory($_GET,0);
//
//$cldb_ordemorigem = new cl_db_ordemorigem;
//
//$db_opcao = 1;
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>

<script>
function js_emite(){
  var obj = document.form1;
  var data_ini =  obj.dtini_ano.value+'-'+obj.dtini_mes.value+'-'+obj.dtini_dia.value;
  var data_fim =  obj.dtfim_ano.value+'-'+obj.dtfim_mes.value+'-'+obj.dtfim_dia.value;
  var ordem    =  obj.ordem.value;

  if (data_ini == "--" && data_fim != "--") {
    alert('ATEN��O! \n - Preencha a Data de Inicio.');
  } else {
    if (data_fim < data_ini) {
       if (data_fim == "--") {
         alert('ATEN��O! \n - Preencha a Data de Fim.');     
       } else {
         alert('ATEN��O! \n - Data de Fim menor que a Data de Inicio.');
       }
       return false;  
    } else {
      jan = window.open('pre2_relautenticacertidao002.php?&dtini='+data_ini+'&dtfim='+data_fim+'&ordem='+ordem,
                        '',
                        'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
      jan.moveTo(0,0);
    }  
  }
}  
</script>  
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<form name="form1" method="post" action="">
   <table align="center" border="0">
      <tr>
         <td >&nbsp;</td>
         <td >&nbsp;</td>
      </tr>
      <tr>
         <td >&nbsp;</td>
         <td >&nbsp;</td>
      </tr>      
      <tr>
        <td align='left'>
         <b>Intervalo de Datas&nbsp;:&nbsp;</b>
        </td>
        <td>
         <? 
           db_inputdata('dtini','','','',true,'text',1,"");   		          
           echo "<b> a </b> ";
           db_inputdata('dtfim','','','',true,'text',1,"");
         ?>
        </td>
      </tr>
      <tr align='left'>
         <td >
           <b>Ordenado por&nbsp;:&nbsp;</b>
         </td>
         <td >
	       <select name=ordem>
	         <option value="data">Data</option>
             <option value="origem">Origem</option>
           </select>
	     </td>
      </tr>
      <tr>
         <td >&nbsp;</td>
         <td >&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align = "center"> 
          <input  name="emite2" id="emite2" type="button" value="Processar" onclick="js_emite();" >
        </td>
      </tr>
   </table>
</form>
<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>