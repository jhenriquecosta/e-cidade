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
include("classes/db_matunid_classe.php");
$clrotulo = new rotulocampo;
$clmatunid = new cl_matunid;
$clrotulo->label('m61_codmatunid');
$clrotulo->label('m61_descr');
$clrotulo->label('m61_usaquant');
$clrotulo->label('m61_abrev');

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
//db_postmemory($HTTP_SERVER_VARS,2);exit;

$xordem = '';
if($ordem == 'n'){
  if($tipo_ordem == 'a'){
    $xordem = 'm61_codmatunid asc ';
    $head5 = "ORDEM : NUM?RICA - ASCENDENTE";
  }else{
    $xordem = 'm61_codmatunid desc ';
    $head5 = "ORDEM : NUM?RICA - DESCENDENTE";
  }
}elseif($ordem == 'a'){
  if($tipo_ordem == 'a'){
    $xordem = 'm61_descr asc ';
    $head5 = "ORDEM : ALFAB?TICA - ASCENDENTE";
  }else{
    $xordem = ' m61_descr desc ';
    $head5 = "ORDEM : ALFAB?TICA - DESCENDENTE";
  }
}else{
  if($tipo_ordem == 'a'){
    $xordem = 'm61_abrev asc ';
    $head5 = "ORDEM : ABREVIATURA - ASCENDENTE";
  }else{
    $xordem = ' m61_abrev desc ';
    $head5 = "ORDEM : ABREVIATURA - DESCENDENTE";
  }
}

$head3 = "CADASTRO DE UNIDADES";

$result =  $clmatunid->sql_record($clmatunid->sql_query_file(null,"*",$xordem));
//db_criatabela($result);exit;
$xxnum = pg_numrows($result);

if ($xxnum == 0){
   db_redireciona('db_erros.php?fechar=true&db_erro=N?o existem unidades cadastrados.');

}
$pdf = new PDF(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
$total = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial','b',8);
$troca = 1;
$alt = 4;
for($x = 0; $x < pg_numrows($result);$x++){
   db_fieldsmemory($result,$x);
   if ($pdf->gety() > $pdf->h - 30 || $troca != 0 ){
      $pdf->addpage();
      $pdf->setfont('arial','b',8);
      $pdf->cell(15,$alt,$RLm61_codmatunid,1,0,"C",1);
      $pdf->cell(60,$alt,$RLm61_descr,1,0,"C",1);
      $pdf->cell(20,$alt,$RLm61_usaquant,1,0,"C",1);
      $pdf->cell(20,$alt,$RLm61_abrev,1,1,"R",1);
      $troca = 0;
   }
   $pdf->setfont('arial','',7);
   $pdf->cell(15,$alt,$m61_codmatunid,0,0,"C",0);
   $pdf->cell(60,$alt,$m61_descr,0,0,"L",0);
   $pdf->cell(20,$alt,$m61_usaquant,0,0,"L",0);
   $pdf->cell(20,$alt,$m61_abrev,0,1,"L",0);
   $total ++;
}
$pdf->setfont('arial','b',8);
$pdf->cell(0,$alt,'TOTAL DE REGISTROS  :  '.$total,"T",0,"L",0);

$pdf->Output();
   
?>