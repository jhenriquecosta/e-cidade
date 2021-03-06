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

//MODULO: biblioteca
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_leitor_classe.php");
include("classes/db_cgm_classe.php");
include("classes/db_aluno_classe.php");
include("classes/db_leitorcategoria_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clleitor = new cl_leitor;
$clleitorcategoria = new cl_leitorcategoria;
$clcgm = new cl_cgm;
$claluno = new cl_aluno;
$clleitor->rotulo->label("bi10_codigo");
$clcgm->rotulo->label("z01_nome");
$claluno->rotulo->label("ed47_i_codigo");
$clleitorcategoria->rotulo->label("bi07_biblioteca");
$depto = db_getsession("DB_coddepto");
$result_bib = pg_query("SELECT bi17_codigo as codbiblioteca,bi17_nome as nomebiblioteca FROM biblioteca WHERE bi17_coddepto = $depto");
db_fieldsmemory($result_bib,0);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>
<body bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table height="100%" border="0"  align="center" cellspacing="0" bgcolor="#CCCCCC">
 <tr>
  <td height="63" align="center" valign="top">
   <table width="35%" border="0" align="center" cellspacing="0">
    <form name="form2" method="post" action="" >
    <tr>
     <td width="4%" align="right" nowrap title="<?=$Tbi10_codigo?>">
      <?=$Lbi10_codigo?>
     </td>
     <td width="96%" align="left" nowrap>
      <?db_input("bi10_codigo",6,$Ibi10_codigo,true,"text",4,"","chave_bi10_codigo");?>
     </td>
    </tr>
    <tr>
     <td width="4%" align="right" nowrap title="<?=$Ted47_i_codigo?>">
      <b>C?digo do Aluno:</b>
     </td>
     <td width="96%" align="left" nowrap>
      <?db_input("ed47_i_codigo",6,@$Ied47_i_codigo,true,"text",4,"","chave_ed47_i_codigo");?>
     </td>
    </tr>
    <tr>
     <td width="4%" align="right" nowrap title="<?=$Tz01_nome?>">
      <?=$Lz01_nome?>
     </td>
     <td width="96%" align="left" nowrap>
      <?db_input("z01_nome",40,$Iz01_nome,true,"text",4,"","chave_z01_nome");?>
     </td>
    </tr>
    <tr>
     <td width="4%" align="right" nowrap title="">
      <b>Leitores de:</b>
     </td>
     <td width="96%" align="left" nowrap>
      <select name="chave_bi07_biblioteca">
       <option value="">TODOS</option>
       <option value="<?=$codbiblioteca?>" <?=!isset($chave_bi07_biblioteca)||@$chave_bi07_biblioteca!=""?"selected":""?>><?=$nomebiblioteca?></option>
      </select> 
     </td>
    </tr>
    <tr>
     <td colspan="2" align="center">
      <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
      <input name="limpar" type="reset" id="limpar" value="Limpar" >
      <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_leitor.hide();">
     </td>
    </tr>
    </form>
   </table>
  </td>
 </tr>
 <tr>
  <td align="center" valign="top">
   <?
   if(isset($chave_bi07_biblioteca) && (trim($chave_bi07_biblioteca)!="") ){
    $restricao = " exists(select * from carteira
                           inner join leitorcategoria on bi07_codigo = bi16_leitorcategoria
                          where bi16_leitor = bi10_codigo
                          and bi07_biblioteca = $chave_bi07_biblioteca) AND";
   }else{
    $restricao = "";
   }
   if(isset($chave_bi10_codigo) && (trim($chave_bi10_codigo)!="") ){
    $condicao = " $restricao bi10_codigo = '$chave_bi10_codigo'";
   }else if(isset($chave_z01_nome) && (trim($chave_z01_nome)!="") ){
    $condicao = " $restricao (cgmrh.z01_nome like '$chave_z01_nome%' OR
                              cgmcgm.z01_nome like '$chave_z01_nome%' OR
                              cgmpub.z01_nome like '$chave_z01_nome%' OR
                              aluno.ed47_v_nome like '$chave_z01_nome%')";
   }else if(isset($chave_ed47_i_codigo) && (trim($chave_ed47_i_codigo)!="") ){
    $condicao = " $restricao ed47_i_codigo='$chave_ed47_i_codigo'";
   }else{
    $condicao = " $restricao bi10_codigo > 0";
   }
   if(isset($pesquisa_chave) && $pesquisa_chave!=""){
    $condicao = " $restricao bi10_codigo = '$pesquisa_chave'";
   }elseif(isset($pesquisa_chave2) && $pesquisa_chave2!=""){
    $condicao = " $restricao bi10_codigo = '$pesquisa_chave2'";
   }
   $campos = "bi10_codigo,ed47_i_codigo as dl_codigoaluno,
              case
               when aluno.ed47_i_codigo is not null
                then aluno.ed47_v_nome
               when cgmrh.z01_numcgm is not null
                then cgmrh.z01_nome
               when cgmcgm.z01_numcgm is not null
                then cgmcgm.z01_nome
               else
                cgmpub.z01_nome
              end as z01_nome,
              case
               when aluno.ed47_i_codigo is not null
                then escola.ed18_c_nome
               else
                '--'
              end as dl_escola,
              case
               when aluno.ed47_i_codigo is not null
                then 'ALUNO'
               when cgmrh.z01_numcgm is not null OR cgmcgm.z01_numcgm is not null
                then 'FUNCIONARIO'
               else
                'PUBLICO'
              end as dl_tipo
           ";
   $sql = $clleitor->sql_query("",$campos,"z01_nome",$condicao);
   if(!isset($pesquisa_chave) && !isset($pesquisa_chave2)){
    $repassa = array();
    if(isset($chave_bi10_codigo)){
      $repassa = array("chave_bi10_codigo"=>$chave_bi10_codigo,"chave_z01_nome"=>$chave_z01_nome,"chave_ed47_i_codigo"=>$chave_ed47_i_codigo,"chave_bi07_biblioteca"=>$chave_bi07_biblioteca);
    }
    if(isset($chave_bi10_codigo)){
     db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);
    }
   }elseif(isset($pesquisa_chave) && $pesquisa_chave!=""){
    $result = pg_query($sql);
    $linhas = pg_num_rows($result);
    if($linhas!=0){
     db_fieldsmemory($result,0);
     echo "<script>".$funcao_js."('$ed47_v_nome',false);</script>";
    }else{
     echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") n?o Encontrado',true);</script>";
    }
   }elseif(isset($pesquisa_chave2) && $pesquisa_chave2!=""){
    $result = pg_query($sql);
    $linhas = pg_num_rows($result);
    if($linhas!=0){
     db_fieldsmemory($result,0);
     echo "<script>".$funcao_js."('$ed47_v_nome','$bi07_tempo','$bi07_qtdlivros',false);</script>";
    }else{
     echo "<script>".$funcao_js."('Chave(".$pesquisa_chave2.") n?o Encontrado','','',true);</script>";
    }
   }
   ?>
  </td>
 </tr>
</table>
</body>
</html>
<script>
js_tabulacaoforms("form2","chave_z01_nome",true,1,"chave_z01_nome",true);
</script>