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
include("classes/db_gerfcom_classe.php");
$clgerfcom = new cl_gerfcom;
$clrotulo = new rotulocampo;
$clrotulo->label('DBtxt23');
$clrotulo->label('DBtxt25');
$clrotulo->label('DBtxt27');
$clrotulo->label('DBtxt28');
$clrotulo->label('r48_semest');
db_postmemory($HTTP_POST_VARS);
?>

<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>

<script>
function js_verifica(){
  var anoi = new Number(document.form1.datai_ano.value);
  var anof = new Number(document.form1.dataf_ano.value);
  if(anoi.valueOf() > anof.valueOf()){
    alert('Intervalo de data invalido. Velirique !.');
    return false;
  }
  return true;
}


function js_emite(){
  qry = "";
  if(document.form1.r48_semest){
    qry = "&semest="+document.form1.r48_semest.value;
  }
  jan = window.open('pes2_aleresumoc002.php?ordem='+document.form1.ordem.value+qry+'&vinc='+document.form1.vinculo.value+'&folha='+document.form1.folha.value+'&tipo='+document.form1.tipo.value+'&ano='+document.form1.DBtxt23.value+'&mes='+document.form1.DBtxt25.value+'&lotaini='+document.form1.DBtxt27.value+'&lotafin='+document.form1.DBtxt28.value,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
  jan.moveTo(0,0);
}
</script>  
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
  <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>

  <table  align="center">
    <form name="form1" method="post" action="" onsubmit="return js_verifica();">
      <tr>
         <td >&nbsp;</td>
         <td >&nbsp;</td>
      </tr>
      <tr >
        <td align="right" nowrap title="Digite o Ano / Mes de compet?ncia" >
        <strong>Ano / Mes:</strong>
        </td>
        <td>
          <?
	  if(!isset($DBtxt23) || (isset($DBtxt23) && (trim($DBtxt23) == "" || $DBtxt23 == 0))){
            $DBtxt23 = db_anofolha();
	  }
            db_input('DBtxt23',4,$IDBtxt23,true,'text',2,'onchange="js_anomes();"')
          ?>
	  &nbsp;/&nbsp;
          <?
	  if(!isset($DBtxt25) || (isset($DBtxt25) && trim($DBtxt25) == "" || $DBtxt25 == 0)){
            $DBtxt25 = db_mesfolha();
	  }
            db_input('DBtxt25',2,$IDBtxt25,true,'text',2,'onchange="js_anomes();"')
          ?>
        </td>
      </tr>
      <tr> 
        <td align="right" nowrap title="<?=@$TDBtxt27?>" >
        <?=$LDBtxt27?>
        </td>
        <td>
          <?
            db_input('DBtxt27',4,$IDBtxt27,true,'text',2,'')
          ?>
	</td>
      </tr>
      <tr> 
        <td align="right" nowrap title="<?=@$TDBtxt28?>" >
        <?=$LDBtxt28?>
        </td>
        <td>
          <?
            db_input('DBtxt28',4,$IDBtxt28,true,'text',2,'')
          ?>
	</td>
      </tr>
      <tr>
        <td align="right"><strong>Tipo de Resumo:</strong>
        </td>
        <td>
          <select name="tipo">
            <option value = 'G' <?=((isset($tipo)&&$tipo=="G")?"selected":"")?>>Geral
            <option value = 'L' <?=((isset($tipo)&&$tipo=="L")?"selected":"")?>>Lota��o
        </td>
      </tr>
      <tr>
        <td align="right"><strong>Tipo de Folha :</strong>
        </td>
        <td>
           <select name="folha" onchange="js_tipofolha();">
             <option value = 'r14' <?=((isset($folha)&&$folha=="r14")?"selected":"")?>>Sal�rio
             <option value = 'r48' <?=((isset($folha)&&$folha=="r48")?"selected":"")?>>Complementar
             <option value = 'r20' <?=((isset($folha)&&$folha=="r20")?"selected":"")?>>Rescis�o
             <option value = 'r35' <?=((isset($folha)&&$folha=="r35")?"selected":"")?>>13o. Sal�rio
             <option value = 'r22' <?=((isset($folha)&&$folha=="r22")?"selected":"")?>>Adiantamento
       </td>
     </tr>
     <?
     if(isset($folha) && $folha == "r48"){
       $result_semest = $clgerfcom->sql_record($clgerfcom->sql_query_file($DBtxt23,$DBtxt25,null,null,"distinct r48_semest"));
       if($clgerfcom->numrows > 0){
	 echo "
	  <tr>
	    <td align='left' title='".$Tr48_semest."'><strong>Nro. Complementar:</strong></td>
            <td>
	      <select name='r48_semest'>
		<option value = '0'>Todos
	      ";
	      for($i=0; $i<$clgerfcom->numrows; $i++){
		db_fieldsmemory($result_semest, $i);
		echo "<option value = '$r48_semest'>$r48_semest";
	      }
	 echo "
	    </td>
	  </tr>
	      ";
       }else{
       ?>
       <tr>
         <td colspan="2" align="center">
           <font color="red">Sem complementar para este per�odo.</font>
           <?
           $r48_semest = 0;
           db_input("r48_semest", 2,0, true, 'hidden', 3);
           ?>
         </td>
       </tr>
       <?
       }
     }
     ?>
     </tr>
      <tr >
        <td align="right" nowrap title="Vinculo" ><strong>Vinculo :</strong>
        </td>
        <td align="left">
          <?
          $v = array("g"=>"Geral", "a"=>"Ativo", "i"=>"Inativo", "p"=>"Pensionista");
          db_select('vinculo',$v,true,4,"");
          ?>
        </td>
      </tr>
														       
      <tr >
        <td align="right" nowrap title="Ordem" ><strong>Ordem</strong>
        </td>
        <td align="left">
          <?
          $o = array("n"=>"Numerica","a"=>"Alfabetica");
          db_select('ordem',$o,true,4,"");
          ?>
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

  </form>
    </table>
<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
function js_tipofolha(){
  if(document.form1.folha.value == "r48" || document.form1.r48_semest){
    document.form1.submit();
  }
}
function js_anomes(){
  if(document.form1.folha.value == "r48"){
    document.form1.submit();
  }
}
function js_pesquisatabdesc(mostra){
     if(mostra==true){
       db_iframe.jan.location.href = 'func_tabdesc.php?funcao_js=parent.js_mostratabdesc1|0|2';
       db_iframe.mostraMsg();
       db_iframe.show();
       db_iframe.focus();
     }else{
       db_iframe.jan.location.href = 'func_tabdesc.php?pesquisa_chave='+document.form1.codsubrec.value+'&funcao_js=parent.js_mostratabdesc';
     }
}
function js_mostratabdesc(chave,erro){
  document.form1.k07_descr.value = chave;
  if(erro==true){
     document.form1.codsubrec.focus();
     document.form1.codsubrec.value = '';
  }
}
function js_mostratabdesc1(chave1,chave2){
     document.form1.codsubrec.value = chave1;
     document.form1.k07_descr.value = chave2;
     db_iframe.hide();
}
</script>


<?
if(isset($ordem)){
  echo "<script>
       // js_emite();
       </script>";  
}
$func_iframe = new janela('db_iframe','');
$func_iframe->posX=1;
$func_iframe->posY=20;
$func_iframe->largura=780;
$func_iframe->altura=430;
$func_iframe->titulo='Pesquisa';
$func_iframe->iniciarVisivel = false;
$func_iframe->mostrar();

?>