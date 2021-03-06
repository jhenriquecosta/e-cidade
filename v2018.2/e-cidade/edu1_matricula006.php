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

require("libs/db_stdlibwebseller.php");
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_matricula_classe.php");
include("classes/db_matriculamov_classe.php");
include("classes/db_logmatricula_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clmatricula    = new cl_matricula;
$clmatriculamov = new cl_matriculamov;
$cllogmatricula = new cl_logmatricula;
$clmatricula->rotulo->label();
$db_opcao = 1;

$sWhere   = "     ed60_matricula  = {$matricula}";
$sWhere  .= " and ed60_c_ativa    = 'S'";
$sWhere  .= " and ed60_c_situacao = 'MATRICULADO'";
$result   = $clmatricula->sql_record($clmatricula->sql_query(null, "*", null, $sWhere));
db_fieldsmemory($result,0);
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<style>
.titulo{
 font-size: 11px;
 color: #DEB887;
 background-color:#444444;
 font-weight: bold;
 border: 1px solid #f3f3f3;
}
.cabec1{
 font-size: 11px;
 color: #000000;
 background-color:#999999;
 font-weight: bold;
}
.aluno{
 color: #000000;
 font-family : Tahoma;
 font-size: 10px;
 font-weight: bold;
}
.aluno1{
 color: #000000;
 font-family : Tahoma;
 font-weight: bold;
 text-align: center;
 font-size: 10px;
}
.aluno2{
 color: #000000;
 font-family : Verdana;
 font-size: 10px;
 font-weight: bold;
}
</style>
</head>
<body bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table align="left" width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td align="left" valign="top" bgcolor="#CCCCCC">
   <br>
   <center>
   <fieldset style="width:97%;background:#EAEAEA;"><legend><b>Aluno</b></legend>
   <table border="0" cellspacing="0" width="100%" height="100%" cellpadding="2">
   <tr>
    <td align="center" valign="top">
     <table border='0' width="100%" bgcolor="#EAEAEA" cellspacing="0px">
      <tr>
       <td><?=$ed47_i_codigo?> - <?=$ed47_v_nome?></td>
      </tr>
     </table>
     <br>
    </td>
   </tr>
   <tr>
    <td valign="top" >
     <table border="1" width="100%" bgcolor="#f3f3f3" cellspacing="0" cellpading="0">
      <?
      $array_mov = array();
      $sCamposResult  = " ed229_i_codigo,ed229_d_dataevento,ed18_i_codigo,ed18_c_nome,ed60_i_codigo,ed57_c_descr,";
      $sCamposResult .= " ed52_i_ano,ed11_c_descr,ed229_c_procedimento,ed229_t_descr,nome, ed60_matricula";
      $sOrderResult   = " ed229_d_dataevento,ed229_i_codigo";
      $sWhereResult   = " ed60_matricula = $matricula AND ";
      $sWhereResult  .= " ed229_c_procedimento NOT LIKE  'CANCELAR ENCERRAMENTO%'";
      $sWhereResult  .= " AND ed229_c_procedimento NOT LIKE  'ENCERRAR%'";
      $result         = $clmatriculamov->sql_record($clmatriculamov->sql_query2("",
                                                                               $sCamposResult,
                                                                               $sOrderResult,
                                                                               $sWhereResult
                                                                              )
                                                   );
      
      if ($clmatriculamov->numrows > 0) {
      	
        for ($f = 0; $f < $clmatriculamov->numrows; $f++) {
        	
          db_fieldsmemory($result,$f);
          $array_mov[]  = str_replace("-","",$ed229_d_dataevento).$ed229_i_codigo;
          $iContador = count($array_mov)-1; 
          $array_mov[$iContador] .= "|".db_formatar($ed229_d_dataevento,'d');
          $array_mov[$iContador] .= "#".$ed18_i_codigo." - ".substr($ed18_c_nome,0,30);
          $array_mov[$iContador] .= "#".$ed60_matricula."#".$ed57_c_descr."#".$ed52_i_ano."#".$ed11_c_descr;
          $array_mov[$iContador] .= "#".$ed229_c_procedimento."#".$ed229_t_descr."#".$nome;   
             
        }
      }
      
      $sCamposResult1  = " ed229_i_codigo,ed229_d_dataevento,ed18_i_codigo,ed18_c_nome,ed60_i_codigo,ed57_c_descr,";
      $sCamposResult1 .= " ed52_i_ano,ed11_c_descr,ed229_c_procedimento,ed229_t_descr,nome, ed60_matricula";
      $sOrderResult1   = "ed229_d_dataevento DESC,ed229_i_codigo DESC LIMIT 1";
      $sWhereResult1   = " ed60_matricula = $matricula AND ed229_c_procedimento LIKE  'CANCELAR ENCERRAMENTO%'";
      $result1         = $clmatriculamov->sql_record($clmatriculamov->sql_query("",
                                                                                $sCamposResult1,
                                                                                $sOrderResult1,
                                                                                $sWhereResult1 
                                                                               )
                                                    );
      if ($clmatriculamov->numrows > 0) {
      	
        db_fieldsmemory($result1,0);
        $array_mov[]  = str_replace("-","",$ed229_d_dataevento).$ed229_i_codigo;
        $iContador = count($array_mov)-1; 
        $array_mov[$iContador] .= "|".db_formatar($ed229_d_dataevento,'d');
        $array_mov[$iContador] .= "#".$ed18_i_codigo." - ".substr($ed18_c_nome,0,30);
        $array_mov[$iContador] .= "#".$ed60_matricula."#".$ed57_c_descr."#".$ed52_i_ano."#".$ed11_c_descr;
        $array_mov[$iContador] .= "#".$ed229_c_procedimento."#".$ed229_t_descr."#".$nome;      
        
      }
      
      $sCamposResult2  = " ed229_i_codigo,ed229_d_dataevento,ed18_i_codigo,ed18_c_nome,ed60_i_codigo,ed57_c_descr,";
      $sCamposResult2 .= " ed52_i_ano,ed11_c_descr,ed229_c_procedimento,ed229_t_descr,nome, ed60_matricula";
      $sOrderResult2   = " ed229_d_dataevento DESC,ed229_i_codigo DESC LIMIT 1";
      $sWhereResult2  = " ed60_matricula = $matricula AND ed229_c_procedimento LIKE  'ENCERRAR%'";
      $result2         = $clmatriculamov->sql_record($clmatriculamov->sql_query("",
                                                                                $sCamposResult2,
                                                                                $sOrderResult2,
                                                                                $sWhereResult2
                                                                               )
                                                    );
      if ($clmatriculamov->numrows > 0) {
      	
        db_fieldsmemory($result2,0);
        $array_mov[]  = str_replace("-","",$ed229_d_dataevento).$ed229_i_codigo;
        $iContador = count($array_mov)-1; 
        $array_mov[$iContador] .= "|".db_formatar($ed229_d_dataevento,'d');
        $array_mov[$iContador] .= "#".$ed18_i_codigo." - ".substr($ed18_c_nome,0,30);
        $array_mov[$iContador] .= "#".$ed60_matricula."#".$ed57_c_descr."#".$ed52_i_ano."#".$ed11_c_descr;
        $array_mov[$iContador] .= "#".$ed229_c_procedimento."#".$ed229_t_descr."#".$nome;  
            
      }
      array_multisort($array_mov,SORT_ASC);
      if (count($array_mov) > 0) {
        ?>
        <tr class="titulo" align="center">
         <td>Data</td>
         <td>Escola</td>
         <td>Matr.</td>
         <td>Turma</td>
         <td>Ano</td>
         <td>Etapa</td>
         <td>Procedimento</td>
        </tr>
        <?
        for ($f = 0; $f < count($array_mov); $f++) {
        	
          $array_mov1 = explode("|",$array_mov[$f]);
          $array_mov2 = explode("#",$array_mov1[1]);
          if ($f > 0) {
          	
          ?>
	        <tr> 
	         <td height="1" bgcolor="black" colspan="7">
	         </td>
	        </tr>
          <?
         
          } 
         ?>
         <tr bgcolor="#dbdbdb">
          <td class="aluno2" align="center"><?=$array_mov2[0]?></td>
          <td class="aluno2"><?=$array_mov2[1]?></td>
          <td class="aluno2" align="center"><?=$array_mov2[2]?></td>
          <td class="aluno2" align="center"><?=$array_mov2[3]?></td>
          <td class="aluno2" align="center"><?=$array_mov2[4]?></td>
          <td class="aluno2" align="center"><?=$array_mov2[5]?></td>
          <td class="aluno2"><?=$array_mov2[6]?></td>
	     </tr>
	     <tr>
          <td>&nbsp;</td>
          <td bgcolor="#f3f3f3" colspan="6" class="aluno2">
           <table width="100%" cellspacing="0" cellpading="0">
            <tr>
             <td width="60%">
              <?=$array_mov2[7]?>
             </td>
             <td align="right" valign="top">
              <b>Usu?rio: </b><?=$array_mov2[8]?>
             </td>
            </tr>
           </table>
          </td>
         </tr>
        <?
        }
      } else {
        ?>
        <tr>
         <td>
          Nenhum registro.
         </td>
        </tr>
        <?
      }
      ?>
      </table><?
       $result_log = $cllogmatricula->sql_record($cllogmatricula->sql_query("","*","ed248_d_data,ed248_c_hora"," ed248_i_aluno = $ed47_i_codigo"));
       if($cllogmatricula->numrows>0){
        ?>
        <br>
        <table border="0" width="100%" bgcolor="#f3f3f3" cellspacing="0" cellpading="0" style="border:2px solid #999999">
         <tr>
          <td colspan="2">
           <b>Outras Movimenta??es:</b>
          </td>
         </tr>
         <tr><td colspan="2" height="1" bgcolor="#999999"></td></tr>
         <?for ($q= 0; $q < $cllogmatricula->numrows; $q++) {
             db_fieldsmemory($result_log,$q);
             ?>
             <tr>
              <td colspan="2">
              <?
               if ($ed248_c_tipo == "E") {
                 $descrlog = "Matr?cula Exclu?da";
               } else if ($ed248_c_tipo == "R") {
                 $descrlog = "Reativa??o de Matr?cula";
               } else if ($ed248_c_tipo == "T") {
                 $descrlog = "Cancelamento de Transfer?ncia";
               }
               ?>
               <b><?=$descrlog?></b>
              </td>
             </tr>
             <tr>
              <td width="10"></td>
              <td>
               <?=$ed248_t_origem?><br>
               <?=$ed248_t_obs?><br>
               Data/Hora: <?=db_formatar($ed248_d_data,'d')."&nbsp;&nbsp;".$ed248_c_hora?>&nbsp;&nbsp;&nbsp;
               Usu?rio: <?=$nome?><br>
               <?=$ed248_c_tipo=="E"?"Motivo: ".($ed249_c_motivo==""?"N?o Informado":$ed249_c_motivo):""?><br>
               <?=trim($ed248_t_obs)!=""?"Observa??es: $ed248_t_obs":""?>
              </td>
             </tr>
          <?
           }
        ?>
        </table>
        <?
       }
     ?>
    </td>
   </tr>
   <tr>
    <td align="center">
     <input name="fechar" type="button" value="Fechar" onclick="parent.db_iframe_historico.hide();">
    </td>
   </tr>
   </table>
   </fieldset>
   </center>
  </td>
 </tr>
</table>
</body>
</html>