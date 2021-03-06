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

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
//db_postmemory($HTTP_SERVER_VARS,2);exit;

$head3 = "RELAT?RIO DE CONFERENCIA DO CADASTRO";
$head5 = "PER?ODO : ".$mes." / ".$ano;

if($tipo == 'a'){
  $conect = pg_connect("host='192.168.78.250' dbname=sam30 user=postgres");
  $xwhere = " and r01_anoexe = ".$ano." and r01_mesexe = ".$mes;
  $head7  = "ANTIGO";
}else{
  $xwhere = " and r01_anousu = ".$ano." and r01_mesusu = ".$mes;
  $head7  = "NOVO";
//  include("libs/db_conecta.php");
}

$xdemi = '';

if($demitidos == 'n'){
  $xdemi = ' and r01_recis is null ';
}

$sql = "
select r01_regist,
       z01_nome,
       r01_regime,
       r01_tpvinc,
       z01_ident,
       z01_cgccpf,
       r01_ctps,
       r01_pis
from pessoal
     inner join cgm on r01_numcgm = z01_numcgm
where r01_instit = ".db_getsession("DB_instit")."
      $xwhere
      $xdemi
order by r01_regime,z01_nome

       ";
//echo $sql ; exit;

//db_criatabela($result);exit;
//$xxnum = pg_numrows($result);




$result = pg_exec($sql);
$xxnum = pg_numrows($result);
if ($xxnum == 0){
   db_redireciona('db_erros.php?fechar=true&db_erro=N?o existem dfuncionarios no periodo: '.$mes.' / '.$ano);

}

$pdf = new PDF(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
$func   = 0;
$func_c = 0;
$tot_c  = 0;
$total  = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial','b',8);
$troca = 1;
$alt = 4;

for($x = 0; $x < pg_numrows($result);$x++){
   db_fieldsmemory($result,$x);
   if ($pdf->gety() > $pdf->h - 30 || $troca != 0 ){
      $pdf->addpage();
      $pdf->setfont('arial','b',8);
      $pdf->cell(15,$alt,'MATR?C.',1,0,"C",1);
      $pdf->cell(60,$alt,'NOME',1,0,"C",1);
      $pdf->cell(15,$alt,'REGIME',1,0,"R",1);
      $pdf->cell(10,$alt,'VINC.',1,0,"R",1);
      $pdf->cell(20,$alt,'IDENTIDADE',1,0,"R",1);
      $pdf->cell(25,$alt,'CPF',1,0,"R",1);
      $pdf->cell(25,$alt,'CTPS',1,0,"R",1);
      $pdf->cell(25,$alt,'PIS',1,1,"R",1);
      $troca = 0;
      $pre = 1;
   }
   if($pre == 1)
      $pre = 0;
   else
      $pre = 1;
   $pdf->setfont('arial','',7);
   $pdf->cell(15,$alt,$r01_regist,0,0,"C",$pre);
   $pdf->cell(60,$alt,$z01_nome,0,0,"L",$pre);
   $pdf->cell(15,$alt,$r01_regime,0,0,"L",$pre);
   $pdf->cell(10,$alt,$r01_tpvinc,0,0,"L",$pre);
   $pdf->cell(20,$alt,$z01_ident,0,0,"L",$pre);
   $pdf->cell(25,$alt,$z01_cgccpf,0,0,"L",$pre);
   $pdf->cell(25,$alt,$r01_ctps,0,0,"L",$pre);
   $pdf->cell(25,$alt,$r01_pis,0,1,"L",$pre);
   $func   += 1;
}

$pdf->ln(3);
$pdf->cell(115,$alt,'Total da Geral  :  '.$func.'  FUNCIONARIOS',0,0,"L",0);

$pdf->Output();
   
?>