<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2012  DBselller Servicos de Informatica             
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


//MODULO: contabilidade
$clconhistdoc->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<fieldset style="margin-top: 20px;">
<legend><b>Documentos dos Lanšamentos</b></legend>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tc53_coddoc?>">
       <?=@$Lc53_coddoc?>
    </td>
    <td> 
     <? db_input('c53_coddoc',4,$Ic53_coddoc,true,'text',$db_opcao,"") ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc53_descr?>">
       <?=@$Lc53_descr?>
    </td>
    <td> 
     <? db_input('c53_descr',50,$Ic53_descr,true,'text',$db_opcao,"") ?>
    </td>
  </tr>
<!--   
  <tr>
    <td nowrap title="<?=@$Tc53_tipo?>">
       <?=@$Lc53_tipo?>
    </td>
    <td> 
<?

$x = array ('10' => 'Empenho', '11' => 'AnulašŃo de Empenho', '20' => 'LiquidašŃo', '21' => 'AnulašŃo de LiquidašŃo', '30' => 'Pagamento Empenho', '31' => 'Estorno Pagamento ', '40' => 'SuplementašŃo', '41' => 'Estorno SuplementašŃo', '50' => 'TransposišŃo', '51' => 'Estorno TransporsišŃo', '60' => 'RedušŃo', '61' => 'Estorno RedušŃo', '70' => 'RedušŃo TransposišŃo', '71' => 'Estorno RedušŃo Transp.', '100' => 'ArrecadašŃo Receita', '101' => 'Estorno Receita', '110' => 'Previsao Adicional receita', '111' => 'Estorno previsao Adicional', '1000' => 'Encerramento de ExercÝcio','2000' => 'Abertura de ExercÝcio');
db_select('c53_tipo', $x, true, $db_opcao, "");
?>
    </td>
  </tr>
-->  
  
  <tr> 
    <td nowrap title="<?=@$Trh01_regist?>"><b>
      <?
      db_ancora("Tipo de Documento","js_pesquisarh01_regist(true);",$db_opcao);
      ?></b>
    </td>
    <td nowrap>
      <?
      db_input('c53_tipo',6,"",true,'text',$db_opcao,"onchange='js_pesquisarh01_regist(false);'")
      ?>
      <?
      db_input('c57_descricao',40,"",true,'text',3,'')
      ?>
    </td>
  </tr>  
  
  </table>
  </center>
</fieldset>  
<br>
<input name="db_opcao" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>

<script>

function js_pesquisarh01_regist(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_tipodoc','func_conhistdoctipo.php?funcao_js=parent.js_mostratipo1|c57_sequencial|c57_descricao','Pesquisa',true);
  }else{
      js_OpenJanelaIframe('top.corpo','db_iframe_tipodoc','func_conhistdoctipo.php?pesquisa_chave='+document.form1.c53_tipo.value+'&funcao_js=parent.js_mostratipo','Pesquisa',false);
  }
}

function js_mostratipo(chave,erro){
  document.form1.c57_descricao.value = chave; 
  if(erro==true){ 
    document.form1.c53_tipo.focus(); 
    document.form1.c53_tipo.value = ''; 
  }
}

function js_mostratipo1(chave1,chave2){
  document.form1.c53_tipo.value = chave1;
  document.form1.c57_descricao.value   = chave2;
  db_iframe_tipodoc.hide();
}




function js_pesquisa(){
  js_OpenJanelaIframe('top.corpo','db_iframe_conhistdoc','func_conhistdoc.php?funcao_js=parent.js_preenchepesquisa|c53_coddoc','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_conhistdoc.hide();
  <?


if ($db_opcao != 1) {
	echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
}
?>
}
</script>

<?php 
if($db_opcao==2||$db_opcao==22 || $db_opcao==3||$db_opcao==33){
  
  echo "<script>";
  echo "js_OpenJanelaIframe('top.corpo','db_iframe_tipodoc','func_conhistdoctipo.php?pesquisa_chave='+document.form1.c53_tipo.value+'&funcao_js=parent.js_mostratipo','Pesquisa',false);";
  echo "</script>";
}

?>