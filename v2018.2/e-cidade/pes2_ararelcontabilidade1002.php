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

include("fpdf151/pdf.php");
include("libs/db_sql.php");
include("classes/db_rhlocaltrab_classe.php");
$clrhlocaltrab = new cl_rhlocaltrab;

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
//db_postmemory($HTTP_SERVER_VARS,2);exit;

if($tipoarq == 's'){
  $arquivo = 'gerfsal';
  $sigla   = 'r14';
}elseif($tipoarq == 'd'){
  $arquivo = 'gerfs13';
  $sigla   = 'r35';
}elseif($tipoarq == 'c'){
  $arquivo = 'gerfcom';
  $sigla   = 'r48';
}


$result_local = $clrhlocaltrab->sql_record($clrhlocaltrab->sql_query_file($local,db_getsession('DB_instit'), "rh55_codigo, rh55_codigo||'-'||rh55_descr as rh55_descr", "rh55_descr" ));
db_fieldsmemory($result_local,0);

$head2 = $rh55_descr;
$head4 = "PERIODO : ".$mes." / ".$ano;

$where_banco = '';
if($xbanco == 'b' && $xconta == 'cc'){
  $head6 = "BANCO DO BRASIL - COM CONTA ";
  $where_banco = " and trim(rh44_codban) = '001' and rh02_fpagto = 3 ";
}elseif($xbanco == 'c' && $xconta == 'cc'){
  $head6 = "CAIXA ECONOMICA FEDERAL - COM CONTA ";
  $where_banco = " and trim(rh44_codban) = '104' and rh02_fpagto = 3 ";
}elseif($xconta == 'sc'){
  $head6 = "SEM CONTA";
  $where_banco = " and rh02_fpagto <> 3 ";
}




$where_local = " and rh56_localtrab = $local";


$select_campos = "
                  rh01_regist,
                  z01_nome,
                  lpad(z01_cgccpf,11,'0') as z01_cgccpf,
                  rh37_descr,
                 ";
$group_ordem = "
                group by rh01_regist,
                         z01_nome,
                         z01_cgccpf,
                         rh37_descr
                order by z01_nome
";

if($local == 1){
$select_campos = "
                  rh01_regist,
                  z01_nome,
                  lpad(z01_cgccpf,11,'0') as z01_cgccpf,
                  rh37_descr,
                  r70_estrut as quebra,
                  r70_descr  as descr_quebra,
                 ";
  $group_ordem = "
                  group by r70_estrut,
                           r70_descr,
                           rh01_regist,
                           z01_nome,
                           z01_cgccpf,
                           rh37_descr
                  order by r70_estrut, z01_nome
                 ";
}elseif($local == 2){
$select_campos = "
                  rh01_regist,
                  z01_nome,
                  lpad(z01_cgccpf,11,'0') as z01_cgccpf,
                  rh37_descr,
                  o40_orgao as quebra,
                  o40_descr as descr_quebra,
                 ";
  $group_ordem = "
                  group by o40_orgao,
                           o40_descr,
                           rh01_regist,
                           z01_nome,
                           z01_cgccpf,
                           rh37_descr
                  order by o40_orgao, z01_nome
                 ";
}


$sql_basico = 
"
select  $select_campos
        round(sum(case when ".$sigla."_pd = 1 then ".$sigla."_valor else 0 end),2) as provento,
        round(sum(case when ".$sigla."_pd = 2 then ".$sigla."_valor else 0 end),2) as desconto,
        round(sum(case when ".$sigla."_pd = 1 then ".$sigla."_valor else ".$sigla."_valor *(-1) end),2) as liquido
 from ".$arquivo." 
      inner join rhrubricas     on rh27_rubric = ".$sigla."_rubric
      inner join rhpessoal      on ".$sigla."_regist  = rh01_regist 
      inner join cgm            on rh01_numcgm = z01_numcgm 
      inner join rhpessoalmov   on rh01_regist = rh02_regist 
                               and rh02_anousu = ".$sigla."_anousu 
                               and rh02_mesusu = ".$sigla."_mesusu 
      left  join rhpeslocaltrab on rh02_seqpes = rh56_seqpes 
                               and rh56_princ  = true  
      left join rhlocaltrab     on rh56_localtrab = rh55_codigo
                               and rh55_instit = rh02_instit
      inner join rhfuncao       on rh37_funcao = rh01_funcao
      inner join rhlota         on r70_codigo  = rh02_lota 
      left  join rhlotaexe      on rh26_codigo = r70_codigo
                               and rh26_anousu = rh02_anousu
      left  join orcorgao       on o40_anousu  = rh26_anousu
                               and o40_orgao   = rh26_orgao
      inner join rhregime       on rh02_codreg = rh30_codreg 
      left  join rhpesbanco     on rh44_seqpes = rh02_seqpes 
      where ".$sigla."_anousu  = $ano and 
            ".$sigla."_mesusu  = $mes and 
            ".$sigla."_pd     != 3
            $where_banco
            $where_local
      $group_ordem 
";

//echo $sql_basico;exit;
$res_basico = pg_query($sql_basico);



$pdf = new PDF(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
$pdf->setfont('arial','b',8);
$pdf->setfillcolor(235);
$troca_pag = 1;
$troca     = 0;
$alt       = 4;
$total     = 0;
$total_quebra    = 0;
$tot_prov_quebra = 0;
$tot_desc_quebra = 0;
$tot_liq_quebra  = 0;
$tot_prov  = 0;
$tot_desc  = 0;
$tot_liq   = 0;
$pre = 0;
for($x = 0; $x < pg_numrows($res_basico);$x++){
   db_fieldsmemory($res_basico,$x);
   if(isset($quebra)){  
     if($troca != $quebra){
      $pdf->setfont('arial','b',7);
       $pdf->cell(14,$alt,db_formatar($tot_prov_quebra,'f'),1,0,"R",$pre);
       $pdf->cell(14,$alt,db_formatar($tot_desc_quebra,'f'),1,0,"R",$pre);
       $pdf->cell(14,$alt,db_formatar($tot_liq_quebra,'f'),1,0,"R",$pre);
       $pdf->cell(150,$alt,'TOTAL --> '.$total_quebra,1,1,"C",$pre);

       $total_quebra    = 0;
       $tot_prov_quebra = 0;
       $tot_desc_quebra = 0;
       $tot_liq_quebra  = 0;
       $troca           = $quebra;
       $troca_pag       = 1;
     }
   }
   if ($pdf->gety() > $pdf->h - 30 || $troca_pag != 0 ){
      $pdf->addpage();
      $pdf->setfont('arial','b',7);
      $pdf->cell(14,$alt,'BRUTO',1,0,"C",1);
      $pdf->cell(14,$alt,'DESC.',1,0,"C",1);
      $pdf->cell(14,$alt,'LIQ.',1,0,"C",1);
      $pdf->cell(11,$alt,'CONTR',1,0,"C",1);
      $pdf->cell(11,$alt,'CHEQUE',1,0,"C",1);
      $pdf->cell(11,$alt,'MATRIC.',1,0,"C",1);
      $pdf->cell(18,$alt,'C.P.F.',1,0,"C",1);
      $pdf->cell(58,$alt,'NOME DO FUNCION?RIO',1,0,"C",1);
      $pdf->cell(60,$alt,'ASSINATURA',1,1,"C",1);
      if(isset($quebra)){  
        $pdf->cell(60,$alt,$quebra." - ".$descr_quebra,0,1,"L",0);
      }
      $troca_pag = 0;
      $pre = 1;
      $pdf->ln(4);
   }
   $pre = 0;
   //if($pre == 1){
   //  $pre = 0;
   //}else{
   //  $pre = 1;
   //}
   $pdf->setfont('arial','',7);
   $pdf->cell(14,$alt,db_formatar($provento,'f'),0,0,"R",$pre);
   $pdf->cell(14,$alt,db_formatar($desconto,'f'),0,0,"R",$pre);
   $pdf->cell(14,$alt,db_formatar($liquido,'f'),0,0,"R",$pre);
   $pdf->cell(11,$alt,'',0,0,"C",$pre);
   $pdf->cell(11,$alt,'',0,0,"C",$pre);
   $pdf->cell(11,$alt,$rh01_regist,0,0,"C",$pre);
   $pdf->cell(20,$alt,db_formatar($z01_cgccpf,'cpf'),0,0,"C",$pre);
   $pdf->cell(60,$alt,$z01_nome,0,0,"L",$pre);
   $pdf->cell(60,$alt,'_______________________________________________________',0,1,"L",$pre);
   $pdf->cell(95,$alt,'',0,0,"L",$pre);
   $pdf->cell(60,$alt,$rh37_descr,0,1,"L",$pre);
   $pdf->ln(4);
   $total += 1;
   $tot_prov += $provento;
   $tot_desc += $desconto;
   $tot_liq  += $liquido;
   $total_quebra    += 1;
   $tot_prov_quebra += $provento;
   $tot_desc_quebra += $desconto;
   $tot_liq_quebra  += $liquido;
}
$pdf->setfont('arial','b',7);
if(isset($quebra)){  
  $pdf->cell(14,$alt,db_formatar($tot_prov_quebra,'f'),1,0,"R",$pre);
  $pdf->cell(14,$alt,db_formatar($tot_desc_quebra,'f'),1,0,"R",$pre);
  $pdf->cell(14,$alt,db_formatar($tot_liq_quebra,'f'),1,0,"R",$pre);
  $pdf->cell(150,$alt,'TOTAL --> '.$total_quebra,1,1,"C",$pre);
}
$pdf->cell(14,$alt,db_formatar($tot_prov,'f'),1,0,"R",$pre);
$pdf->cell(14,$alt,db_formatar($tot_desc,'f'),1,0,"R",$pre);
$pdf->cell(14,$alt,db_formatar($tot_liq,'f'),1,0,"R",$pre);
$pdf->cell(150,$alt,'TOTAL GERAL --> '.$total,1,1,"C",$pre);


$pdf->Output();
?>