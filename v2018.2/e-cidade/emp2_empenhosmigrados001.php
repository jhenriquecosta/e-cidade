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
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
$db_opcao = 1;
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<table width="790" height="18"  border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="360">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<center>
<table>
<table>
  <tr>
     <td>
       <fieldset><legend><b>Empenhos Migrados<b> </legend>
       <table>
           <tr>
					    <td>
								<strong>Detalhar Empenhos :</strong>
							</td>
							<td>
                 <?
								 $aMigrados = array("M"=>"Migrados","N"=>"N?o Migrados"); 
								 db_select("selfiltros",$aMigrados,true,4,"");
               
							 	 ?>
							</td>
					 </tr>	
			 
             <tr>
					    <td>
								<strong>Situa??o :</strong>
							</td>
							<td>
                 <?
								 $aSituacao = array("T"=>"Todos","S"=>"Saldo a Pagar"); 
								 db_select("situacao",$aSituacao,true,4,"");
               
							 	 ?>
							</td>
					 </tr>	
       
			 </table>
       </fieldset>
     </td>
   </tr>
   <tr>
     <td style="text-align:center">
        <input type='button' value='Visualizar' id='Visualizar' onclick='js_visualizar()'>
     </td>
</table>
</center>
</body>
</html>
<? 
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
<script>
function js_visualizar() {
  
  sSituacao = $('situacao').value;
  sFiltro   = $('selfiltros').value; 
  window.open('emp2_empenhosmigrados002.php?selfiltros='+sFiltro+'&situacao='+sSituacao,'','location=0');
  
}
</script>