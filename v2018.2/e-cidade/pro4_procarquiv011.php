<?
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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_protprocesso_classe.php");
include("classes/db_procvar_classe.php");
include("classes/db_proctipovar_classe.php");
include("classes/db_db_syscampo_classe.php");
include("dbforms/db_funcoes.php");
$clprotprocesso = new cl_protprocesso;
$rotulo = new rotulocampo();
$rotulo->label("p58_codproc");
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<script>
function js_processa(){
}
</script>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr> 
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<center>
  <form method="post" name="form1" action="pro4_procarquiv022.php">
  <table>
	  <tr>
	    <td>
	      <fieldset>
	        <legend><b>Datas para Pesquisa</b></legend>
	        <table>
	          <tr>
	            <td colspan=3 >
	              <b>De</b> 
	               <?
                   db_inputdata('data1',@$dia1,@$mes1,@$ano1,true,'text',1,"")
                 ?>
	              <b>a</b>
                 <?
                  db_inputdata('data2',@$dia2,@$mes2,@$ano2,true,'text',1,"")
                 ?>
	            </td>
	          </tr>
	        </table>
	      </fieldset>
	    </td>
	  </tr>
    <tr>
      <td colspan=3 align='center'>
	      <input type="submit" value="Processar" onclick='return js_testadata();' >
      </td>
    </tr>
  </table>
</form>
</center>
</body>
</html>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
<script>
function js_testadata(){
  if ((document.form1.data1_ano.value!=""&&document.form1.data1_mes.value!=""&&document.form1.data1_dia.value!="")||(document.form1.data2_ano.value!=""&&document.form1.data2_mes.value!=""&&document.form1.data2_dia.value!="")){    
    return true
  }else{
    alert('Preencha algum per?odo para prosseguir!!');
    return false; 
  }
    
}
</script>