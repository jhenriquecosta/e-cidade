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
include("classes/db_itbiformapagamento_classe.php");
include("dbforms/db_funcoes.php");

$oPost = db_utils::postMemory($_POST);

$clitbiformapagamento = new cl_itbiformapagamento;

$db_opcao = 1;
$db_botao = true;
$lSqlErro = false;

if(isset($oPost->incluir)){
	
  db_inicio_transacao();
  
  if ( !$lSqlErro ) {
  	
    $clitbiformapagamento->it27_aliquota         = $oPost->it27_aliquota;
    $clitbiformapagamento->it27_descricao		     = $oPost->it27_descricao;
    $clitbiformapagamento->it27_itbitipoformapag = $oPost->it27_itbitipoformapag;
    $clitbiformapagamento->it27_tipo			       = $oPost->it27_tipo;
    $clitbiformapagamento->incluir($oPost->it27_sequencial);
  
    if ( $clitbiformapagamento->erro_status == 0 ) {
      $lSqlErro = true;
    }
    
  }
  db_fim_transacao($lSqlErro);
    
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table border="0" cellspacing="0" cellpadding="0" style="padding-top:25;" align="center">
  <tr> 
    <td> 
      <center>
	    <?
	  	  include("forms/db_frmitbiformapagamento.php");
	    ?>
      </center>
	</td>
  </tr>
</table>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
js_tabulacaoforms("form1","it27_itbitipoformapag",true,1,"it27_itbitipoformapag",true);
</script>
<?

if(isset($oPost->incluir)){
	
  if($clitbiformapagamento->erro_status=="0"){
    $clitbiformapagamento->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clitbiformapagamento->erro_campo!=""){
      echo "<script> document.form1.".$clitbiformapagamento->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clitbiformapagamento->erro_campo.".focus();</script>";
    }
  }else{
    $clitbiformapagamento->erro(true,true);
  }
}
?>