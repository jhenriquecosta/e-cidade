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

include("classes/db_pagordem_classe.php");
include("classes/db_empagetipo_classe.php");
include("classes/db_empord_classe.php");
include("classes/db_empagemov_classe.php");
include("classes/db_empagepag_classe.php");
include("classes/db_empageconf_classe.php");
include("classes/db_empageconfche_classe.php");

$clempagetipo = new cl_empagetipo;
$clpagordem   = new cl_pagordem;
$clempord     = new cl_empord;
$clempagemov  = new cl_empagemov;
$clempagepag  = new cl_empagepag;
$clempageconf  = new cl_empageconf;
$clempageconfche  = new cl_empageconfche;

//echo ($HTTP_SERVER_VARS["QUERY_STRING"]);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
//db_postmemory($HTTP_POST_VARS);
$db_opcao = 1;
$db_botao = false;


$clrotulo = new rotulocampo;
$clrotulo->label("e82_codord");
$clrotulo->label("e60_numemp");
$clrotulo->label("e60_codemp");
$clrotulo->label("e60_emiss");
$clrotulo->label("z01_numcgm");
$clrotulo->label("z01_nome");
$clrotulo->label("e83_codtipo");
$clrotulo->label("e81_valor");
$clrotulo->label("e81_codmov");
$clrotulo->label("e86_cheque");

$dbwhere = " e80_instit = " . db_getsession("DB_instit") . " and e81_codage=$e80_codage and e86_correto='t' ";
/*
if(isset($e83_codtipo) && $e83_codtipo != '' ){
  $dbwhere .=" and e83_codtipo=$e83_codtipo ";
}
*/

//"e81_codmov,e83_descr,e60_emiss,e60_codemp,e82_codord,z01_numcgm,z01_nome,e81_valor","","$dbwhere");
$result = $clempageconf->sql_record($clempageconf->sql_query_canc(null,"e81_codmov,e83_descr,e83_conta,e60_emiss,e86_cheque,e60_codemp,e82_codord,z01_numcgm,z01_nome,e81_valor","",$dbwhere));
$numrows= $clempageconf->numrows; 
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<style>
<?$cor="#999999"?>
.bordas02{
  border: 2px solid #cccccc;
  border-top-color: <?=$cor?>;
  border-right-color: <?=$cor?>;
  border-left-color: <?=$cor?>;
  border-bottom-color: <?=$cor?>;
  background-color: #999999;
}
.bordas{
  border: 1px solid #cccccc;
  border-top-color: <?=$cor?>;
  border-right-color: <?=$cor?>;
  border-left-color: <?=$cor?>;
  border-bottom-color: <?=$cor?>;
  background-color: #cccccc;
}
</style>
<script>

function js_marca(obj){ 
  var OBJ = document.form1;
  soma=new Number();
  for(i=0;i<OBJ.length;i++){
    if(OBJ.elements[i].type == 'checkbox' && OBJ.elements[i].disabled==false){
      OBJ.elements[i].checked = !(OBJ.elements[i].checked == true);            
      
      if(OBJ.elements[i].checked==true){
        valor = new Number(eval("document.form1.valor_"+OBJ.elements[i].value+".value"));
        soma = new Number(soma+valor);
      }
    }
  }
  parent.document.form1.total.value = soma.toFixed(2); 
  return false;
}

function js_calcula(campo){      
  var OBJ = document.form1;
  
  mov   = campo.value;
  conta = mov;
  
  cheque_pri = eval("OBJ.mov_"+mov+".value;");
  conta_pri  = eval("OBJ.conta_"+conta+".value;");
  
  total = new Number(parent.document.form1.total.value);
  soma = 0;
  if(campo.checked == false){
    // quando for evento de desmarcar entao ignoramos
    valor = new Number(eval("document.form1.valor_"+mov+".value"));
    
    tot = new Number(total-valor);
    parent.document.form1.total.value = tot.toFixed(2);    
  } else { 
    if (cheque_pri == 0){
      valor  = new Number(eval("document.form1.valor_"+mov+".value"));
      soma  += js_round(valor,2);
    }

    for(i=0;i<OBJ.length;i++){
      if(OBJ.elements[i].type == 'checkbox' && OBJ.elements[i].disabled==false){
        movs   = OBJ.elements[i].value;
        contas = movs;
        cheque_sec = eval("OBJ.mov_"+movs+".value;");
        conta_sec  = eval("OBJ.conta_"+contas+".value;");
        
        valor = new Number(eval("document.form1.valor_"+OBJ.elements[i].value+".value"));
        
        
        if(cheque_sec == cheque_pri && conta_pri == conta_sec && cheque_pri > 0){
          if(campo.checked == true){
            OBJ.elements[i].checked = true;
            soma = new Number(soma+valor);
          }else{
            OBJ.elements[i].checked = false;
            soma = new Number(soma-valor);
          }
        }				       
        
      }
    }
    tot = new Number(total+soma);
    parent.document.form1.total.value = tot.toFixed(2);      
  }
  
}
</script>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr> 
<td height="100%" align="left" valign="top" bgcolor="#CCCCCC"> 
<form name="form1" method="post" action="">
<center>
<table  class='bordas'>
<tr>
<td class='bordas02' align='center'><a  title='Inverte Marca??o' href='' onclick='return js_marca(this);return false;'>M</a></td>
<td class='bordas02'><small><b><?=$RLe81_codmov?></b></small></td>
<td class='bordas02'><small><b><?=$RLe60_codemp?></b></small></td>
<td class='bordas02'><small><b><?=$RLe82_codord?></b></small></td>
<td class='bordas02'><small><b><?=$RLz01_nome?></b></small></td>
<td class='bordas02'><small><b><?=$RLe60_emiss?></b></small></td>
<td class='bordas02'><small><b><?=$RLe83_codtipo?></b></small></td>
<td class='bordas02'><small><b><?=$RLe86_cheque?></b></small></td>
<td class='bordas02'><small><b><?=$RLe81_valor?></b></small></td>
</tr>
<?

for($i=0; $i<$numrows; $i++){
  db_fieldsmemory($result,$i,true);
  //   echo "<BR><BR>".($clempageconfche->sql_query_cheques_cancelados(null,"k12_codmov","","e81_codmov = $e81_codmov and k12_codmov is not null"));
  $result_cheques_autenticados = $clempageconfche->sql_record($clempageconfche->sql_query_cheques_cancelados(null,"k12_codmov","","e81_codmov = $e81_codmov and k12_codmov is not null"));
  $asteriscos = "";
  if($clempageconfche->numrows > 0){
    $asteriscos = "<font color='red'>*</font>";
  }
  ?>
  <tr>
  <td class='bordas' ><input value="<?=$e81_codmov?>"  name="CHECK_<?=$e81_codmov?>" type='checkbox' onclick="js_calcula(this);"  ></td>
  <td class='bordas' align='center'><small><?=($asteriscos)?><?=$e81_codmov?></small></td>
  <td class='bordas' align='center'><small id="e60_numemp_<?=$e82_codord?>"> <?=$e60_codemp?></small></td>
  <td class='bordas' align='center'><small><?=$e82_codord?></small></td>
  <td class='bordas' align='left'><small label='Numcgm:<?=$z01_numcgm?>'><?=$z01_nome?>  </small></td>
  <td class='bordas' align='center'><small><?=$e60_emiss?>  </small></td>
  <?
  $x= "valor_$e81_codmov";
  $$x = $e81_valor;
  db_input("valor_$e81_codmov",10,'',true,'hidden',1);
  
  $x= "mov_$e81_codmov";
  $$x = $e86_cheque;
  db_input("mov_$e81_codmov",10,'',true,'hidden',1);

  $x  = "conta_$e81_codmov";
  $$x = $e83_conta;
  db_input("conta_$e81_codmov",10,0,true,"hidden",1);
  ?>
  <td class='bordas' align='left'><small><?=$e83_conta . " - " . $e83_descr?></small></td>
  <td class='bordas' align='right'><small><?=$e86_cheque?></small></td>
  <td class='bordas' align='right'><small><?=number_format($e81_valor,"2",".","")?></small></td>
  </tr>
  <?
}
?>
</table>
</center>
</form>
</td>
</tr>
</table>
</body>
</html>
<script>
parent.document.form1.total.value = '0.00'; 
</script>