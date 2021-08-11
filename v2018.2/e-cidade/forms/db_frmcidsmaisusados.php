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

require("../libs/db_stdlib.php");
require("../libs/db_conecta.php");
include("../libs/db_sessoes.php");
include("../libs/db_usuariosonline.php");

include("../classes/db_medicocid_classe.php");


include("../dbforms/db_funcoes.php");

db_postmemory($HTTP_POST_VARS);

$clmedicocid   = new cl_medicocid;
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="../scripts/scripts.js"></script>
<link href="../estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
			
     <table size='10' border="1" class="tab">

					<tr>
						<td><b>CIDs</b></td>
						<td><b>Descri��o</b></td>
					</tr>

<?
//						   echo "<BR> ".$clmedicocid->sql_query("","*","sd56_i_codigo limit 10","sd56_i_profissional = $chaveprofissional") ;
						   $result = $clmedicocid->sql_record( $clmedicocid->sql_query("","*","sd56_i_codigo limit 10","sd56_i_profissional = $chaveprofissional") );
						   $intLinhas = $clmedicocid->numrows;
						   if( $intLinhas > 0 ){
						   	 for( $intX = 0; $intX < $intLinhas; $intX++){
						   	 	db_fieldsmemory( $result, $intX);
						   	 	?>
						   	 		<tr> 
						   	 	  	      <td><a onclick="parent.js_cidsmaisusados('<?=$sd70_c_cid?>');"> <?=$sd70_c_cid?></a></td>
						   	 	  	      <td><a onclick="parent.js_cidsmaisusados('<?=$sd70_c_cid?>');"><?=$sd70_c_nome?></a></td>
						   	 	  	</tr>
						   	 	<?						   	 
						   	 }
						   }	
?>
</table>
</body>
</html>