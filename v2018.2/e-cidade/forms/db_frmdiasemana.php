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

//MODULO: educa??o
include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$cldiasemana->rotulo->label();
$db_botao1 = false;
if(isset($opcao) && $opcao=="alterar"){
 $db_opcao = 2;
 $db_botao1 = true;
}elseif(isset($opcao) && $opcao=="excluir" || isset($db_opcao) && $db_opcao==3){
 $db_botao1 = true;
 $db_opcao = 3;
}else{
 if(isset($alterar)){
  $db_opcao = 2;
  $db_botao1 = true;
 }else{
  $result = $cldiasemana->sql_record($cldiasemana->sql_query("","ed32_i_codigo as nada","",""));
  if($cldiasemana->numrows>=7){
   $db_botao = false;
  }else{
   $db_botao = true;
  }
  $db_opcao = 1;
 }
}
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
 <tr>
  <td nowrap title="<?=@$Ted32_i_codigo?>">
   <?=@$Led32_i_codigo?>
  </td>
  <td>
   <?db_input('ed32_i_codigo',10,$Ied32_i_codigo,true,'text',3,"")?>
  </td>
 </tr>
 <tr>
  <td nowrap title="<?=@$Ted32_c_descr?>">
   <?=@$Led32_c_descr?>
  </td>
  <td>
   <?db_input('ed32_c_descr',15,$Ied32_c_descr,true,'text',$db_opcao,"")?>
  </td>
 </tr>
 <tr>
  <td nowrap title="<?=@$Ted32_c_abrev?>">
   <?=@$Led32_c_abrev?>
  </td>
  <td>
   <?db_input('ed32_c_abrev',3,$Ied32_c_abrev,true,'text',$db_opcao,"")?>
  </td>
 </tr>
</table>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="cancelar" type="submit" value="Cancelar" <?=($db_botao1==false?"disabled":"")?> >
<table width="100%">
 <tr>
  <td valign="top">
  <?
   $chavepri= array("ed32_i_codigo"=>@$ed32_i_codigo,"ed32_c_descr"=>@$ed32_c_descr,"ed32_c_abrev"=>@$ed32_c_abrev);
   $cliframe_alterar_excluir->chavepri=$chavepri;
   @$cliframe_alterar_excluir->sql = $cldiasemana->sql_query($ed32_i_codigo,"*","ed32_i_codigo");
   $cliframe_alterar_excluir->campos  ="ed32_i_codigo,ed32_c_descr,ed32_c_abrev";
   $cliframe_alterar_excluir->legenda="Registros";
   $cliframe_alterar_excluir->msg_vazio ="N?o foi encontrado nenhum registro.";
   $cliframe_alterar_excluir->textocabec ="#DEB887";
   $cliframe_alterar_excluir->textocorpo ="#444444";
   $cliframe_alterar_excluir->fundocabec ="#444444";
   $cliframe_alterar_excluir->fundocorpo ="#eaeaea";
   $cliframe_alterar_excluir->iframe_height ="200";
   $cliframe_alterar_excluir->iframe_width ="100%";
   $cliframe_alterar_excluir->tamfontecabec = 9;
   $cliframe_alterar_excluir->tamfontecorpo = 9;
   $cliframe_alterar_excluir->formulario = false;
   $cliframe_alterar_excluir->iframe_alterar_excluir($db_opcao);
  ?>
  </td>
 </tr>
</table>
</form>
</center>