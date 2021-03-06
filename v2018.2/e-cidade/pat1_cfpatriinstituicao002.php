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
include("libs/db_utils.php");
include("classes/db_cfpatriinstituicao_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clcfpatriinstituicao  = new cl_cfpatriinstituicao;
$db_opcao              = 22;
$db_botao              = false;
$iOpcaoDataDepreciacao = 22;
if (isset($alterar)) {
  
  db_inicio_transacao();
  $db_opcao              = 2;
  $iOpcaoDataDepreciacao = 2;
  $clcfpatriinstituicao->alterar($t59_sequencial);
  db_fim_transacao();
} else if (isset($chavepesquisa)) {
  
   $db_opcao              = 2;
   $iOpcaoDataDepreciacao = 2;
   $result   = $clcfpatriinstituicao->sql_record($clcfpatriinstituicao->sql_query($chavepesquisa)); 
   db_fieldsmemory($result,0);
   $db_botao = true;
}
/**
 * verificamos se j? foi calculado alguma deprecia??o para a institui??o.
 * caso j? foi calculado, n?o podemos modificar a data da deprecia??o.
 */
$sWhereCalculo           = "t57_instituicao = ".db_getsession("DB_instit"); 
$oDaoBemHistoricoCalculo = db_utils::getDao("benshistoricocalculo");
$sSqlCalculosInstituicao = $oDaoBemHistoricoCalculo->sql_query_file(null,  
                                                                    "t57_sequencial",
                                                                    "t57_sequencial limit 1",
                                                                    $sWhereCalculo
                                                                    );
$rsCalculoBem            = $oDaoBemHistoricoCalculo->sql_record($sSqlCalculosInstituicao);
if ($oDaoBemHistoricoCalculo->numrows > 0) {
  $iOpcaoDataDepreciacao = 3;
}
//db_redireciona("pat1_cfpatriinstituicao002.php?chavepesquisa=".$t59_sequencial);
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
<body bgcolor=#CCCCCC >
	<?
	include("forms/db_frmcfpatriinstituicao.php");
	?>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));


?>
</body>
</html>
<?
if(isset($alterar)){
  if($clcfpatriinstituicao->erro_status=="0"){
    $clcfpatriinstituicao->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clcfpatriinstituicao->erro_campo!=""){
      echo "<script> document.form1.".$clcfpatriinstituicao->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clcfpatriinstituicao->erro_campo.".focus();</script>";
    }
  }else{
    $clcfpatriinstituicao->erro(true,true);
  }
}
if($db_opcao==22){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
js_tabulacaoforms("form1","t59_instituicao",true,1,"t59_instituicao",true);
</script>