<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2014  DBselller Servicos de Informatica             
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

//MODULO: cadastro
$cliptudiversos->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");
?>
<form name="form1" method="post" action="">
  <center>
    <fieldset style="width: 600px;">
      <legend class="bold"><?=($db_opcao==1?"Inclus�o":($db_opcao==2||$db_opcao==22?"Altera��o":"Exclus�o"))?> de Diversos IPTU</legend>
      <table border="0">
        <tr>
          <td nowrap title="<?=@$Tj80_matric?>">
             <?
              db_ancora(@$Lj80_matric,"js_pesquisaj80_matric(true);",$db_opcao);
             ?>
          </td>
          <td> 
            <?
              db_input('j80_matric',10,$Ij80_matric,true,'text',$db_opcao," onchange='js_pesquisaj80_matric(false);'")
            ?>
            <?
              db_input('z01_nome',40,$Iz01_nome,true,'text',3,'')
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?=@$Tj80_areatrib?>">
             <?=@$Lj80_areatrib?>
          </td>
          <td> 
            <?
              db_input('j80_areatrib',15,$Ij80_areatrib,true,'text',$db_opcao,"")
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?=@$Tj80_profund?>">
             <?=@$Lj80_profund?>
          </td>
          <td> 
            <?
              db_input('j80_profund',15,$Ij80_profund,true,'text',$db_opcao,"")
            ?>
          </td>
        </tr>
      </table>
    </fieldset>
    <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
    <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
  </center>
</form>
<script>
function js_pesquisaj80_matric(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_iptubase','func_iptubase.php?funcao_js=parent.js_mostraiptubase1|j01_matric|z01_nome','Pesquisa',true);
  }else{
     if(document.form1.j80_matric.value != ''){ 
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_iptubase','func_iptubase.php?pesquisa_chave='+document.form1.j80_matric.value+'&funcao_js=parent.js_mostraiptubase','Pesquisa',false);
     }else{
       document.form1.z01_nome.value = ''; 
     }
  }
}
function js_mostraiptubase(chave,erro){
  document.form1.z01_nome.value = chave; 
  if(erro==true){ 
    document.form1.j80_matric.focus(); 
    document.form1.j80_matric.value = ''; 
  }
}
function js_mostraiptubase1(chave1,chave2){
  document.form1.j80_matric.value = chave1;
  document.form1.z01_nome.value = chave2;
  db_iframe_iptubase.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_iptudiversos','func_iptudiversos.php?funcao_js=parent.js_preenchepesquisa|j80_matric|z01_nome','Pesquisa',true);
}
function js_preenchepesquisa(chave,nome){
  document.form1.z01_nome.value = nome;
  db_iframe_iptudiversos.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>