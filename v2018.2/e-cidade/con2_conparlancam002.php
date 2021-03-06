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
include("classes/db_conparlancam_classe.php");

$clconparlancam = new cl_conparlancam;
$clconparlancam->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label('o56_codele');
$clrotulo->label('o56_descr');
$clrotulo->label('c60_codcon');
$clrotulo->label('c60_descr');

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
//db_postmemory($HTTP_SERVER_VARS,2);exit;

$head3 = "CONFIGURAÇÃO DOS LANÇAMENTOS DO PASSIVO";

//echo $clconparlancam->sql_query();exit;
$result = $clconparlancam->sql_record($clconparlancam->sql_query());
//db_criatabela($result);
//echo $sql ; exit;

$xxnum = pg_numrows($result);
if ($xxnum == 0){
   db_redireciona('db_erros.php?fechar=true&db_erro=Não existem Lotações cadastrados no período de '.$mes.' / '.$ano);

}

$pdf = new PDF(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
$total = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial','b',8);
$troca = 1;
$alt = 4;
$registros = 0;
for($x = 0; $x < pg_numrows($result);$x++){
   db_fieldsmemory($result,$x);
   if ($pdf->gety() > $pdf->h - 30 || $troca != 0 ){
      $pdf->addpage();
      $pdf->setfont('arial','b',8);
      $pdf->cell(12,$alt,$RLo56_codele,1,0,"C",1);
      $pdf->cell(85,$alt,$RLo56_descr,1,0,"C",1);
      $pdf->cell(12,$alt,$RLc60_codcon,1,0,"C",1);
      $pdf->cell(85,$alt,$RLc60_descr,1,1,"C",1);
      $total = 0;
      $troca = 0;
   }
   $pdf->setfont('arial','',7);
   $pdf->cell(12,$alt,$o56_codele,0,0,"C",0);
   $pdf->cell(85,$alt,$o56_descr,0,0,"L",0);
   $pdf->cell(12,$alt,$c60_codcon,0,0,"L",0);
   $pdf->cell(85,$alt,$c60_descr,0,1,"L",0);
   $registros += 1;
}
$pdf->setfont('arial','b',8);
$pdf->cell(0,$alt,'TOTAL DE REGISTROS :  '.$registros,"T",0,"L",0);

$pdf->Output();
   
?>