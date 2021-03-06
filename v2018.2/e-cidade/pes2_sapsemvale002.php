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
$clrotulo->label('r01_regist');
$clrotulo->label('z01_nome');

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
//db_postmemory($HTTP_SERVER_VARS,2);exit;

$head3 = "FUNCION?RIOS SEM VALE NO PONTO";
$head5 = "PER?ODO : ".$mes." / ".$ano;

$sql = "
   select rh02_regist as r01_regist,
	        z01_nome 
   from rhpessoalmov
				 inner join rhpessoal    on rh01_regist = rh02_regist
         left join rhpesrescisao on rh05_seqpes = rh02_seqpes
	       inner join cgm          on rh01_numcgm = z01_numcgm  
	 where rh02_anousu = $ano 
	   and rh02_mesusu = $mes
	   and rh02_instit = ".db_getsession("DB_instit")."
	   and trim(rh01_clas1) not in ('6','10') 
	   and rh02_regist not in (select r21_regist 
	                          from pontofa 
                   				  where r21_anousu = $ano
                   				    and r21_mesusu = $mes
                   						and r21_instit = ".db_getsession("DB_instit")."
                  				  group by r21_regist) 
	   and rh05_recis is null 
	 order by rh02_regist
       ";
//echo $sql ; exit;

$result = pg_exec($sql);
$xxnum = pg_numrows($result);
if ($xxnum == 0){
   db_redireciona('db_erros.php?fechar=true&db_erro=N?o existem Funcion?rios Sem Vale Cadastrado no per?odo de '.$mes.' / '.$ano);

}

$pdf = new PDF(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
$total = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial','b',8);
$troca = 1;
$alt   = 4;
$func  = 0;
for($x = 0; $x < pg_numrows($result);$x++){
   db_fieldsmemory($result,$x);
   if ($pdf->gety() > $pdf->h - 30 || $troca != 0 ){
      $pdf->addpage();
      $pdf->setfont('arial','b',8);
      $pdf->cell(15,$alt,$RLr01_regist,1,0,"C",1);
      $pdf->cell(60,$alt,$RLz01_nome,1,1,"C",1);
      $total = 0;
      $troca = 0;
   }
   $pdf->setfont('arial','',7);
   $pdf->cell(15,$alt,$r01_regist,0,0,"C",0);
   $pdf->cell(60,$alt,$z01_nome,0,1,"L",0);
   $func += 1;
}
$pdf->setfont('arial','b',8);
$pdf->cell(80,$alt,'TOTAL :  '.$func,"T",0,"C",0);

$pdf->Output();
   
?>