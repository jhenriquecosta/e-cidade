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

include("libs/db_stdlib.php");
postmemory($HTTP_POST_VARS);
?>

<html>
<head>
<title>xxx</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<script>
 
</script>

<body >
<table width='300px' align='center' border='1' cellpadding='2' cellspacing='2'  >
	<form name="form2" method="post" target="">
	<tr><td> tipo pedido</td></tr>
	<tr>
		<td>
			<input name="xx" type="texto" value="<?=$xx++; ?>" id="xx" >
		<?php
		//$xx++;
		echo "xxxx= $xx";
		?> 
		</td>
		
	</tr>
	
	</form>
</table>
<table>
<tr>
	<td >
	<iframe  name="kk" src="contador.php">
	</td>
	</tr>
</table>
</html>