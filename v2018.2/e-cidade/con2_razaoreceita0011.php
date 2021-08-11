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
include("libs/db_usuariosonline.php");
include("classes/db_lote_classe.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
include("classes/db_empempenho_classe.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clempempenho = new cl_empempenho;
$aux = new cl_arquivo_auxiliar;
$clempempenho->rotulo->label();
$cllote = new cl_lote;
$cliframe_seleciona = new cl_iframe_seleciona;
$cllote->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<script>
variavel = 1;
function js_imprimir() {
  var data1 = new Date(document.form1.data1_ano.value,document.form1.data1_mes.value,document.form1.data1_dia.value,0,0,0);
  var data2 = new Date(document.form1.data2_ano.value,document.form1.data2_mes.value,document.form1.data2_dia.value,0,0,0);
  if(data1.valueOf() > data2.valueOf()){
    alert('Data inicial maior que data final. Verifique!');
    return false;
  }
  for(i=0;i<document.form1.length;i++){
    if(document.form1.elements[i].name == "lista[]"){
      for(x=0;x< document.form1.elements[i].length;x++){
        document.form1.elements[i].options[x].selected = true;
      }
    }
  }
  // seleciona recursos
  vir="";
  listarec="";
  for(x=0;x<parent.iframe_g2.document.form1.recurso.length;x++){
    listarec+=vir+parent.iframe_g2.document.form1.recurso.options[x].value;
    vir=",";
  }
  document.form1.listarec.value=listarec;
  document.form1.verrec.value= parent.iframe_g2.document.form1.ver.value;
  //--
  jan = window.open('','safo' + variavel,'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0');
  document.form1.target = 'safo' + variavel++;
  setTimeout("document.form1.submit()",1000);
  return true;
}
</script>
</head>
<body bgcolor=#CCCCCC bgcolor="#CCCCCC"  >
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>  &nbsp; </td>
  </tr>  
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
       <form name="form1" method="post" action="con2_razaoreceita002.php" >
       <input type="hidden" name="listarec" >
       <input type="hidden" name="verrec" >
       <table border="0" >
       <tr> 
           <td align="center">
                <strong>Op��es:</strong>
                <select name="ver">
                    <option name="condicao" value="com">Com as Receitas selecionados</option>
                    <option name="condicao" value="sem">Sem as Receitas selecionadas</option>
                </select>
          </td>
       </tr>
       <tr>
          <td nowrap width="50%">
               <?
                 // $aux = new cl_arquivo_auxiliar;
                 $aux->cabecalho = "<strong>Receitas</strong>";
                 $aux->codigo = "o70_codrec"; //chave de retorno da func
                 $aux->descr  = "o57_descr";   //chave de retorno
                 $aux->nomeobjeto = 'lista';
                 $aux->funcao_js = 'js_mostra';
                 $aux->funcao_js_hide = 'js_mostra1';
                 $aux->sql_exec  = "";
	         $aux->func_arquivo = "func_orcreceita.php";
                 $aux->nomeiframe = "db_iframe_orcreceita";
                 $aux->localjan = "";
                 $aux->onclick = "";
                 $aux->db_opcao = 2;
                 $aux->tipo = 2;
                 $aux->top = 0;
                 $aux->linhas = 10;
                 $aux->vwhidth = 400;
                 $aux->funcao_gera_formulario();
              ?>    
          </td>
       </tr>
       </table>
      <table border="0" width="48%">
      <tr>
          <td nowrap colspan=3>
               <b> Per�odo </b>
               <? 
	          $dia= date("d",db_getsession("DB_datausu"));
		  $mes= date("m",db_getsession("DB_datausu"));
		  $ano= db_getsession("DB_anousu");
		  $dia2= date("d",db_getsession("DB_datausu"));
		  $mes2= date("m",db_getsession("DB_datausu"));
		  $ano2= db_getsession("DB_anousu");
	          db_inputdata('data1',@$dia,@$mes,@$ano,true,'text',1,"");   		          
                  echo " a ";
                  db_inputdata('data2',@$dia2,@$mes2,@$ano2,true,'text',1,"");
               ?>
          </td>
       </tr>
           <td nowrap>
               <b>  Tipo : </b>
               <select name="tipo">
                      <option name="tipo" value="s">Sint�tico </option>
                      <option name="tipo" value="a">Analitico </option>
               </select>
           </td>
           <td nowrap>
                    <b> Quebra:</b>
                    <select name="quebra">
                         <option name="quebra" value="g">Geral   </option>
                         <!--<option name="quebra" value="o">Org�o   </option>-->
                    </select>
           </td>
           <td>
               <input type="button" id="emite" value="Emite" onClick="js_imprimir()">
           </td>
       </tr> 
       </table>
       </center>
       </form>

    </td>
  </tr>
</table>
  </body>
</html>