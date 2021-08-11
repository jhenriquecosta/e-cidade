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

//MODULO: material
$clmatestoqueinimei->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("coddepto");
$clrotulo->label("m60_descr");
$clrotulo->label("m70_codmatmater");
$clrotulo->label("m71_codmatestoque");
$clrotulo->label("m80_matestoqueitem");
$clrotulo->label("m80_obs");

$teste = date('Y-m-d', db_getsession("DB_datausu"))." ".date("H:i:s");
if(isset($m70_codmatmater) && trim($m70_codmatmater)!="") {
   $where_deptodestino = "and m70_coddepto=".db_getsession("DB_coddepto");
   $sSqlSaidas = $clmatestoqueini->sql_query_mater(null,
                                                          "matestoqueini.m80_codigo,
                                                           m71_codlanc,
                                                           nome,                                                           
                                                           m60_descr,
                                                           m70_codmatmater,
                                                           descrdepto,
                                                           m77_lote,
                                                           matestoqueini.m80_data,
                                                           matestoqueini.m80_obs,
                                                           m82_codigo,
                                                           m82_quant",
                                                           "matestoqueini.m80_codigo",
                                                           "m70_codmatmater={$m70_codmatmater}
                                                            {$where_deptodestino} and to_timestamp
                                                            (matestoqueini.m80_data || ' ' ||matestoqueini.m80_hora, 'YYYY-MM-DD HH:MI:SS') 
                                                             <=to_timestamp ('{$teste}', 'YYYY-MM-DD HH:MI:SS') 
                                                           and matestoqueini.m80_codtipo=5 
                                                           and (b.m80_codtipo<>6 or b.m80_codigo is null)  ");
   $result_matestoque  = $clmatestoqueini->sql_record($sSqlSaidas);
  $numrows_matestoque= $clmatestoqueini->numrows;
  $db_botao = true;
}

?>
<form name="form1" method="post" action="">
<center>
<table>
<tr>
  <td>
    <fieldset>
      <legend>
        <b>Saida de Materiais</b>
      </legend>
      <table border="0">
        <tr>
          <td nowrap title="<?=@$Tm70_codmatmater?>" align="right" >
          <?
           db_ancora(@$Lm70_codmatmater,"js_pesquisam70_codmatmater(true);",
           ((isset($m70_codmatmater) && trim($m70_codmatmater)!="" && (isset($numrows_matestoque) && $numrows_matestoque>0))?"3":"1"));
           ?>
          </td>
          <td align="left" nowrap>     
           <? 
           db_input('m70_codmatmater',10,$Im70_codmatmater,true,"text",
           ((isset($m70_codmatmater) && trim($m70_codmatmater)!="" && (isset($numrows_matestoque) && $numrows_matestoque>0))?"3":"1"),"onchange='js_pesquisam70_codmatmater(false);'");
           db_input('m60_descr',40,$Im60_descr,true,"text",3);
           ?>
          </td>
         </tr>
          <tr>
          <td nowrap class='bordas' align='right' colspan='1'>
            <b>Obs.:</b>
          </td>
          <td>
          <?php
             db_textarea('m80_obs',2,109,$Im80_obs,true,'text',1,"");
          ?>
          </td>
        </tr>
      </table>
    </fieldset>
   </td>
</tr>
<tr>
   <td colspan="2">
     <fieldset>
       <legend>
         <b>Sa�das Manuais do Material</b>
       </legend>
        <table  cellspacing=0 cellpadding=0 width='100%' style='border:2px inset white'>
          <tr>
            <th class='table_header'><input type='checkbox' checked style='display:none'
                id='mtodos' onclick='js_marca()'>
            <a onclick='js_marca("mtodos","chkmarca","linha")' style='cursor:pointer'>M</a></b></th>
            <th class='table_header'>C�digo</th>
            <th class='table_header'>Material</th>
            <th class='table_header'>Depto</th>
            <th class='table_header'>Sa�da</th>
            <th class='table_header'>Lote</th>
            <th class='table_header'>Devolver</th>
            <th class='table_header' width='18px'>&nbsp;</th>
          </tr>
          <tbody id='dadosrequisicao' style='height:80;width:95%;overflow:scroll;overflow-x:hidden;background-color:white'>
          <?

          if (isset($numrows_matestoque) && $numrows_matestoque > 0) {
            
            for ($i = 0; $i < $numrows_matestoque; $i++){
              
              $oSaldoMaterial = db_utils::fieldsMemory($result_matestoque, $i);
              echo "<tr class='marcado' id='linhachk{$oSaldoMaterial->m82_codigo}'>";
              echo "   <td class='linhagrid'>";
              echo "    <input type='checkbox' id='chk{$oSaldoMaterial->m82_codigo}' onclick=\"js_marcaLinha(this,'linha');\""; 
              echo "            value='{$oSaldoMaterial->m82_codigo}' class='chkmarca' checked style='height:12px'>";
              echo "  <td class='linhagrid'>{$oSaldoMaterial->m82_codigo}-";
              echo     $oSaldoMaterial->m70_codmatmater;
              echo "  </td>";
              echo "  <td class='linhagrid'width='40%'>";
              echo     $oSaldoMaterial->m60_descr;
              echo "  </td>";
              echo "  <td class='linhagrid'>";
              echo     $oSaldoMaterial->descrdepto;
              echo "  </td>";
              echo "  <td class='linhagrid' id='saldo{$oSaldoMaterial->m70_codmatmater}'>";
              echo     $oSaldoMaterial->m82_quant;
              echo "  </td>";
              echo "  <td class='linhagrid'>";
              echo    $oSaldoMaterial->m77_lote;
              echo "  &nbsp;</td>";
              echo "  <td class='linhagrid' style='width:6%'>";
              echo "   <input type='text' style='width:100%;text-align:right' class='valores' ";
              echo "   id='saida{$oSaldoMaterial->m82_codigo}' value='{$oSaldoMaterial->m82_quant}' onblur='js_valDev(this.value, this.id)'>";
              echo "  </td>";
              echo "</tr>";
              
            }
            
          } else {
            echo "<tr><td colspan=10>N�o Existe saldo para esse Item";
            $db_botao = false;
          }
          ?>
          <tr style='height:auto'><td>&nbsp;</td></tr> 
          </tbody>
        </table>         
     </fieldset>
   </td>
 </tr>
</table>
</center>
<input name="confirmar" type="button" id="db_opcao" value="Confirmar" 
 <?=($db_botao==false?"disabled":"")?> 
 onclick='js_cancelarSaidaMaterial();'>
<input name="voltar" type="button" id="voltar" value="Voltar" onclick="document.location.href='mat1_matestoquesai00<?=(isset($mostraiframeexclui)?"3":"1")?>.php'" >
</form>
<script>
function js_verificarcampos(){
  x = iframe_matestoquesai.document.form1;
  virg = "";
  x.valores.value = "";
  for(i=0;i<x.length;i++){
    if(x.elements[i].type == 'checkbox'){
      if(x.elements[i].checked == true){
	x.valores.value += virg + x.elements[i].name;
	virg = ",";
      }
    }
  }
  if(iframe_matestoquesai.document.form1.valores.value!=""){
    obj= iframe_matestoquesai.document.createElement('input');
    obj.setAttribute('name','incluir');
    obj.setAttribute('type','hidden');
    obj.setAttribute('value','incluir');
    iframe_matestoquesai.document.form1.appendChild(obj);
    iframe_matestoquesai.document.form1.submit();
  }else{
    alert('Informe a quantidade de sa�da dos itens.');
    iframe_matestoquesai.document.form1.elements[1].focus();
  }
}
function js_pesquisam70_codmatmater(mostra){
  qry  = "&setdepart=true";
  qry += "&codigododepartamento=<?=(db_getsession("DB_coddepto"))?>";
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_matmater','func_matmaterdepto.php?funcao_js=parent.js_mostramatmater1|m60_codmater|m60_descr'+qry,'Pesquisa',true);
  }else{
     if(document.form1.m70_codmatmater.value != ''){ 
        js_OpenJanelaIframe('top.corpo','db_iframe_matmater','func_matmaterdepto.php?pesquisa_chave='+document.form1.m70_codmatmater.value+'&funcao_js=parent.js_mostramatmater'+qry,'Pesquisa',false);
     }else{
       document.form1.m60_descr.value = ''; 
     }
  }
}
function js_mostramatmater(chave,erro){
  document.form1.m60_descr.value = chave; 
  if(erro==true){ 
    document.form1.m70_codmatmater.focus(); 
    document.form1.m70_codmatmater.value = '';    
  }else{
    document.form1.submit();
  }
}
function js_mostramatmater1(chave1,chave2){
  document.form1.m70_codmatmater.value = chave1;
  document.form1.m60_descr.value = chave2;
  db_iframe_matmater.hide();
  document.form1.submit();
}
function js_pesquisam82_matestoqueini(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_matestoqueini','func_matestoqueini.php?funcao_js=parent.js_mostramatestoqueini1|m80_codigo|m80_matestoqueitem','Pesquisa',true);
  }else{
     if(document.form1.m82_matestoqueini.value != ''){ 11
        js_OpenJanelaIframe('top.corpo','db_iframe_matestoqueini','func_matestoqueini.php?pesquisa_chave='+document.form1.m82_matestoqueini.value+'&funcao_js=parent.js_mostramatestoqueini','Pesquisa',false);
     }else{
       document.form1.m80_matestoqueitem.value = ''; 
     }
  }
}
function js_mostramatestoqueini(chave,erro){
  document.form1.m80_matestoqueitem.value = chave; 
  if(erro==true){ 
    document.form1.m82_matestoqueini.focus(); 
    document.form1.m82_matestoqueini.value = ''; 
  }
}
function js_mostramatestoqueini1(chave1,chave2){
  document.form1.m82_matestoqueini.value = chave1;
  document.form1.m80_matestoqueitem.value = chave2;
  db_iframe_matestoqueini.hide();
}
function js_pesquisam82_matestoqueitem(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_matestoqueitem','func_matestoqueitem.php?funcao_js=parent.js_mostramatestoqueitem1|m71_codlanc|m71_codmatestoque','Pesquisa',true);
  }else{
     if(document.form1.m82_matestoqueitem.value != ''){ 
        js_OpenJanelaIframe('top.corpo','db_iframe_matestoqueitem','func_matestoqueitem.php?pesquisa_chave='+document.form1.m82_matestoqueitem.value+'&funcao_js=parent.js_mostramatestoqueitem','Pesquisa',false);
     }else{
       document.form1.m71_codmatestoque.value = ''; 
     }
  }
}
function js_mostramatestoqueitem(chave,erro){
  document.form1.m71_codmatestoque.value = chave; 
  if(erro==true){ 
    document.form1.m82_matestoqueitem.focus(); 
    document.form1.m82_matestoqueitem.value = ''; 
  }
}
function js_mostramatestoqueitem1(chave1,chave2){
  document.form1.m82_matestoqueitem.value = chave1;
  document.form1.m71_codmatestoque.value = chave2;
  db_iframe_matestoqueitem.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('top.corpo','db_iframe_matestoqueinimei','func_matestoqueinimei.php?funcao_js=parent.js_preenchepesquisa|m82_codigo','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_matestoqueinimei.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
function js_marca(idObjeto, sClasse, sLinha){
  
   obj = document.getElementById(idObjeto);
   if (obj.checked){
     obj.checked = false;
   }else{
     obj.checked = true;
   }
   itens = js_getElementbyClass(form1, sClasse);
   for (i = 0;i < itens.length;i++){
     
     if (itens[i].disabled == false){
        if (obj.checked == true){
          
          itens[i].checked=true;
          js_marcaLinha(itens[i],sLinha);
          
       }else{
         
          itens[i].checked=false;
          js_marcaLinha(itens[i],sLinha);
          
       }
     }
   }
}

function js_marcaLinha(obj, linha) {
 
  if (obj.checked) {
  
    $(linha+obj.id).className='marcado';
    
  } else {
  
    $(linha+obj.id).className='normal';
    
  }
}

function js_cancelarSaidaMaterial () {

  aItens     = js_getElementbyClass(form1,"chkmarca","checked==true");
  sJsonItens = '';
  sVirgula   = '';
  for (var i = 0; i < aItens.length; i++) {
     
     var nValor = new Number($("saida"+aItens[i].value).value);
     if (nValor <= 0 ) {
       
       alert('H� itens com valores inv�lidos. Confira.\nOpera��o Cancelada.');
       return false;
       
     }
     sJsonItens += sVirgula+'{"iCodMater":'+$('m70_codmatmater').value+',"nQuantidade":"'+nValor+'",';
     sJsonItens += '"sObs":"'+$F('m80_obs')+'","iCodEstoqueIni":'+aItens[i].value+'}';
     sVirgula    = ",";
  }
  if (confirm('Confirma cancelamento da sa�da do material?')) {
    
    js_divCarregando("Aguarde, efetuando cancelamento saida","msgBox");
    sJson = '{"exec":"cancelarSaidaMaterial","params":[{"itens":['+sJsonItens+']}]}';
    var url     = 'mat4_requisicaoRPC.php';
    var oAjax   = new Ajax.Request(
                            url, 
                              {
                               method: 'post', 
                               parameters: 'json='+sJson, 
                               onComplete: js_saidaAtendimento
                              }
                             );
    }
}
function js_saidaAtendimento(oAjax) {

  js_removeObj("msgBox");
  var obj               = eval("(" + oAjax.responseText + ")");
  if (obj.status == 2) {
  
    alert(obj.message.urlDecode());
    return false;
    
  } else {
  
   alert(obj.message.urlDecode());
   $('voltar').click();
   
  }
}

function js_valDev(quantidade_retirada, campo){
	
	  var quantidade_estoque  = new Number($(campo.replace("saida","saldo")).innerHTML);
	  var quantidade_retirada = new Number(quantidade_retirada);
	  
	  if ( quantidade_retirada > quantidade_estoque ){
	   alert('A quantidade de retirada n�o pode ser maior que a de estoque!');
	   $(campo).value = '';
	   $(campo).focus();
	  }
  
}
</script>