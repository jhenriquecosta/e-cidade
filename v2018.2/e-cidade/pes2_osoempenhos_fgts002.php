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

include("fpdf151/pdf.php");
include("libs/db_sql.php");

$clrotulo = new rotulocampo;
$clrotulo->label('r06_codigo');
$clrotulo->label('r06_descr');
$clrotulo->label('r06_elemen');
$clrotulo->label('r06_pd');

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
//db_postmemory($HTTP_SERVER_VARS,2);exit;
//$ano = 2006;
//$mes = 3;

$head3 = "EMPENHOS DO FGTS";
$head5 = "PER?ODO : ".$mes." / ".$ano;

$sql = "

select 
       rh26_orgao,
       o40_descr,
       rh26_unidade,
       o41_descr,
       rh25_projativ,
       o55_descr,
       rh25_recurso,
       o15_descr,
       fgts
from 
(
select 
       rh26_orgao,
       o41_descr,
       rh26_unidade,
       o40_descr,
       rh25_projativ,
       o55_descr,
       rh25_recurso,
       o15_descr,
       round(sum(inss),2) as fgts 
from 

(
select rh02_lota,
       case when r14_rubric = 'R991' then r14_valor else 0 end as inss
from gerfsal 
     inner join rhpessoalmov on rh02_anousu = r14_anousu 
		                        and rh02_mesusu = r14_mesusu 
											      and rh02_regist = r14_regist
		                        and rh02_instit = r14_instit                
where r14_anousu = $ano 
  and r14_mesusu = $mes
  and r14_instit = ".db_getsession("DB_instit")."                
  and r14_rubric in ('R991')

union all

select rh02_lota,
       case when r48_rubric = 'R991' then r48_valor else 0 end as inss
from gerfcom
     inner join rhpessoalmov on rh02_anousu = r48_anousu 
		                        and rh02_mesusu = r48_mesusu 
											      and rh02_regist = r48_regist
		                        and rh02_instit = r48_instit               
where r48_anousu = $ano
  and r48_mesusu = $mes
  and r48_instit = ".db_getsession("DB_instit")."                
  and r48_rubric in ('R991')
						     
union all

select rh02_lota,
       case when r20_rubric = 'R991' then r20_valor else 0 end as inss
from gerfres
     inner join rhpessoalmov on rh02_anousu = r20_anousu 
		                        and rh02_mesusu = r20_mesusu 
											      and rh02_regist = r20_regist
		                        and rh02_instit = r20_instit               
where r20_anousu = $ano
  and r20_mesusu = $mes
  and r20_instit = ".db_getsession("DB_instit")."                
  and r20_rubric in ('R991')
						     
) as x
inner join rhlota on rh02_lota = r70_codigo
                 and r70_instit = ".db_getsession("DB_instit")."
left join (select distinct rh25_projativ, rh25_codigo, rh25_recurso from rhlotavinc where rh25_anousu = $ano) as rhlotavinc on rh25_codigo = r70_codigo 
left  join rhlotaexe  on r70_codigo = rh26_codigo and rh26_anousu = $ano
left  join orcprojativ on o55_anousu = $ano 
                      and o55_projativ = rh25_projativ
left  join orcorgao    on o40_orgao = rh26_orgao
                      and o40_anousu = $ano
											and o40_instit = ".db_getsession("DB_instit")."
left join orcunidade   on o41_anousu = $ano
                      and o41_orgao = rh26_orgao
                      and o41_unidade = rh26_unidade
left join orctiporec   on o15_codigo = rh25_recurso
		      
group by 
       rh26_orgao,
       o40_descr,
       rh26_unidade,
       o41_descr,
       rh25_projativ,
       rh25_recurso,
       o15_descr,
       o55_descr
) as xxxx
order by 
       rh26_orgao,
       o40_descr,
       rh26_unidade,
       o41_descr,
       rh25_projativ,
       rh25_recurso,
       o15_descr,
       o55_descr
       ";
//echo $sql ; exit;

$result = pg_exec($sql);
//db_criatabela($result);
$xxnum = pg_numrows($result);
if ($xxnum == 0){
   db_redireciona('db_erros.php?fechar=true&db_erro=N?o existem movimentos no per?odo de '.$mes.' / '.$ano);

}

$pdf = new PDF(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
$total = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial','b',8);
$troca = 1;
$alt = 4;
$orgao = '';
$unidade = '';
$proj = '';
$val_fgts     = 0;
$val_fgts_seg = 0;
$val_fgts_pad = 0;
$val_fgts_tot = 0;
$tot_fgts_seg = 0;
$val_ded      = 0;
$val_pat      = 0;
$fgts1        = 0;
$fgts1_seg    = 0;
$fgts1_pad    = 0;
$pat60        = 0;
$pat40        = 0;
$pat          = 0;

for($x = 0; $x < pg_numrows($result);$x++){
   db_fieldsmemory($result,$x);
   if ($pdf->gety() > $pdf->h - 30 || $troca != 0 ){
      $pdf->addpage();
      $pdf->setfont('arial','B',8);
      $pdf->cell(105,$alt,'DESCRI??O',1,0,"C",0);
      $pdf->cell(20,$alt,'BASE',1,0,"R",0);
      $pdf->cell(20,$alt,'SEG. 8%',1,0,"R",0);
//      $pdf->cell(20,$alt,'PATR. 0.5%',1,0,"R",0);
      $pdf->cell(20,$alt,'TOTAL',1,1,"R",0);
      $troca = 0;
   }
   $pdf->setfont('arial','B',8);
   if($orgao != $rh26_orgao){
     $pdf->cell(15,$alt,db_formatar($rh26_orgao,'orgao'),0,0,"C",1);
     $pdf->cell(0,$alt,$o40_descr,0,1,"L",1);
     $orgao = $rh26_orgao;
   }
   if($unidade != $rh26_orgao.$rh26_unidade){
     $pdf->cell(5,$alt,'',0,0,"C",1);
     $pdf->cell(15,$alt,db_formatar($rh26_orgao,'orgao').db_formatar($rh26_unidade,'orgao'),0,0,"C",1);
     $pdf->cell(0,$alt,$o41_descr,0,1,"L",1);
     $unidade = $rh26_orgao.$rh26_unidade;
   }
   if($proj != $rh25_projativ){
     $pdf->cell(5,$alt,'',0,0,"C",1);
     $pdf->cell(15,$alt,$rh25_projativ,0,0,"C",1);
     $pdf->cell(0,$alt,$o55_descr,0,1,"L",1);
     $proj= $rh25_projativ;
   }
   $pdf->setfont('arial','',7);
   
   $fgts1         = db_formatar($fgts,'p')+0;
   $fgts1_seg     = db_formatar($fgts/100*8,'p')+0;  
   $fgts1_pad     = db_formatar($fgts/100*0.5,'p')+0;
   
   $val_fgts     += $fgts1;
   $val_fgts_seg += $fgts1_seg;  
   $val_fgts_pad += $fgts1_pad;
   $val_fgts_tot += $fgts1_seg ;
   
   $pdf->cell(10,$alt,'',0,0,"C",0);
   $pdf->cell(15,$alt,$rh25_recurso,0,0,"C",0);
   $pdf->cell(80,$alt,$o15_descr,0,0,"L",0);
   $pdf->cell(20,$alt,db_formatar($fgts,'f'),0,0,"R",0);
   $pdf->cell(20,$alt,db_formatar($fgts1_seg,'f'),0,0,"R",0);
//   $pdf->cell(20,$alt,db_formatar($fgts1_pad,'f'),0,0,"R",0);
   $pdf->cell(20,$alt,db_formatar(($fgts1_seg ),'f'),0,1,"R",0);
}
$pdf->setfont('arial','B',8);
$pdf->cell(105,$alt,'TOTAL ',0,0,"C",0);
$pdf->cell(20,$alt,db_formatar($val_fgts,'f'),0,0,"R",0);
$pdf->cell(20,$alt,db_formatar($val_fgts_seg,'f'),0,0,"R",0);
//$pdf->cell(20,$alt,db_formatar($val_fgts_pad,'f'),0,0,"R",0);
$pdf->cell(20,$alt,db_formatar($val_fgts_tot,'f'),0,1,"R",0);


/////TOTALIZACOES

$sql2 = "

select 
       rh25_recurso,
       o15_descr,
       fgts
from 
(
select 
       rh25_recurso,
       o15_descr,
       round(sum(inss),2) as fgts 
from 

(
select r14_lotac as r01_lotac,
			 r14_instit as r01_instit,
       case when r14_rubric = 'R991' then r14_valor else 0 end as inss
from gerfsal 
where r14_anousu = $ano 
  and r14_mesusu = $mes
	and r14_instit = ".db_getsession("DB_instit")."
  and r14_rubric in ('R991')

union all

select r48_lotac as r01_lotac,
			 r48_instit as r01_instit,
       case when r48_rubric = 'R991' then r48_valor else 0 end as inss
from gerfcom
where r48_anousu = $ano
  and r48_mesusu = $mes
	and r48_instit = ".db_getsession("DB_instit")."
  and r48_rubric in ('R991')
						     
union all

select r20_lotac as r01_lotac,
			 r20_instit as r01_instit,
       case when r20_rubric = 'R991' then r20_valor else 0 end as inss
from gerfres
where r20_anousu = $ano
  and r20_mesusu = $mes
	and r20_instit = ".db_getsession("DB_instit")."
  and r20_rubric in ('R991')
						     
) as x
inner join rhlota on to_number(r01_lotac,'9999') = r70_codigo
                 and r70_instit = x.r01_instit 
left join (select distinct rh25_projativ, rh25_codigo, rh25_recurso from rhlotavinc where rh25_anousu = $ano) as rhlotavinc on rh25_codigo = r70_codigo 
left  join rhlotaexe  on r70_codigo = rh26_codigo and rh26_anousu = $ano
left  join orcprojativ on o55_anousu = $ano 
                      and o55_projativ = rh25_projativ
left  join orcorgao    on o40_orgao = rh26_orgao
                      and o40_anousu = $ano
											and o40_instit = x.r01_instit
left join orcunidade   on o41_anousu = $ano
                      and o41_orgao = rh26_orgao
                      and o41_unidade = rh26_unidade
left join orctiporec   on o15_codigo = rh25_recurso
		      
group by 
       rh25_recurso,
       o15_descr
) as xxxx
order by 
       rh25_recurso
       ";

$result2 = pg_query($sql2);

$numrows2 = pg_numrows($result2);

$tot_fgts    = 0;
$tot_fgtsseg = 0;
$tot_fgtstot = 0;

$alt = 5;

$pdf->setfont('arial','b',9);
$pdf->ln(5);
$pdf->cell(0,$alt,"TOTAL POR RECURSO",0,1,"L",0);

$pdf->setfont('arial','',9);

for($xi=0;$xi<$numrows2;$xi++){
  db_fieldsmemory($result2,$xi); 
  $fgts_seg = $fgts*8/100;
  $pdf->cell(10,$alt,'',0,0,"R",0);
  $pdf->cell(15,$alt,$rh25_recurso,0,0,"R",0);
  $pdf->cell(80,$alt,$o15_descr,0,0,"L",0);
  $pdf->cell(20,$alt,db_formatar($fgts,"f"),0,0,"R",0);
  $pdf->cell(20,$alt,db_formatar($fgts_seg,"f"),0,0,"R",0);
  $pdf->cell(20,$alt,db_formatar($fgts_seg,"f"),0,1,"R",0);

  $tot_fgts_seg  += (($fgts)/100)*8;
  $tot_fgts      += $fgts;
}

//echo $teste;exit;

$pdf->setfont('arial','B',8);
$pdf->cell(105,$alt,'TOTAL ',0,0,"C",0);
$pdf->cell(20,$alt,db_formatar($tot_fgts,'f'),0,0,"R",0);
$pdf->cell(20,$alt,db_formatar($tot_fgts_seg,'f'),0,0,"R",0);
$pdf->cell(20,$alt,db_formatar($tot_fgts_seg,'f'),0,1,"R",0);


$pdf->Output();
   
?>