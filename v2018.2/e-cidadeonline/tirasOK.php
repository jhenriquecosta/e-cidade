<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2014  DBSeller Servicos de Informatica             
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

  //include("libs/db_conecta.php");
  include("libs/db_stdlib.php");
  define('FPDF_FONTPATH','font/');
  require("fpdf151/fpdf.php");
  $clquery = new cl_query;
  $nova=false;

  $head1 = "";
  $head2 = "";
  $head3 = "";
  $head4 = "";
  $head5 = "";
  $head6 = "";
  $head7 = "";
  $head8 = "";
  $head9 = "";

  $clquery->sql_query("db_config","*",""," codigo = $DB_INSTITUICAO");
  $clquery->sql_record($clquery->sql);
  db_fieldsmemory($clquery->result,0);
// aki ele ta buscando os dados da planilha 
  $clquery->sql_query("issplan","*","","q20_planilha= $planilha");
  $clquery->sql_record($clquery->sql);
  db_fieldsmemory($clquery->result,0);
   
  $matri= array("1"=>"janeiro","2"=>"Fevereiro","3"=>"Mar?o","4"=>"Abril","5"=>"Maio","6"=>"Junho","7"=>"Julho","8"=>"Agosto","9"=>"Setembro","10"=>"Outubro","11"=>"Novembro","12"=>"Dezembro");
  $mesx= $matri[$q20_mes];

  $pdf = new FPDF();
  $pdf->Open();
  $pdf->AliasNbPages();
  $pdf->AddPage("L");
  $clquery->sql_query("cgm","z01_nome",""," z01_numcgm = $q20_numcgm");
  $clquery->sql_record($clquery->sql);
  db_fieldsmemory($clquery->result,0);
//for($i=0;$i<$clquery->numrows;$i++){
  $clquery->sql_query("issplanit","*","","q21_planilha = $planilha and q21_cnpj= '$cnpjprestador'");
  $clquery->sql_record($clquery->sql);
  $linhas =$clquery->numrows;
 // db_fieldsmemory($clquery->result,$i);
  $pdf->SetFont('arial','B',12);
  $pdf->SetFillColor(255,255,255);
  $pdf->Ln(3);
  $pdf->setX(5);
  $yy = $pdf->getY();
  $pdf->Cell(284,8,$nomeinst,"LTR",1,"C",0);
  $pdf->SetFont('arial','B',10);
  $pdf->setX(5);
  $pdf->Cell(284,8,"COMPET?NCIA: ".$mesx."/".$q20_ano."                PLANILHA DE RETEN??O NUMERO: ".$planilha,"LBR",1,"C",1);
  $pdf->Image('imagens/files/logo_boleto.png',7,($yy+1),12);
  $pdf->SetFillColor(220,220,220);
  $pdf->setX(5);
  $pdf->Cell(284,6,"DADOS DO TOMADOR DE SERVI?O",1,1,"C",1);
  $pdf->setX(5);
  $pdf->Cell(160,6,"NOME OU RAZ?O SOCIAL: ".$z01_nome,"LT",0,"L",0);
  $pdf->Cell(124,6,"INSCRI??O MUNICIPAL: ".@$q20_inscr,"TR",1,"L",0);
  $pdf->setX(5);
  $pdf->Cell(160,6,"FONE: ".$q20_fonecontri,"LB",0,"L",0);
  $pdf->Cell(124,6,"CONTATO: ".$q20_nomecontri,"RB",1,"L",0);
  $pdf->SetFont('arial','B',10);
  $pdf->setX(5);
  $pdf->Cell(284,6,"DADOS DO PRESTADOR DE SERVI?O",1,1,"C",1);
  $pdf->setX(5);
  $pdf->SetFont('arial','B',10);
  db_fieldsmemory($clquery->result,0);
  $pdf->Cell(160,6,"NOME OU RAZ?O SOCIAL: ".$q21_nome,"LT",0,"L",0);
  $pdf->Cell(124,6,"CNPJ OU CPF: ".$q21_cnpj,"TR",1,"L",0);
  $pdf->setX(5);
  $pdf->Cell(160,6,"SERVI?O PRESTAFO: ".$q21_servico,"LB",0,"L",0);
  $pdf->Cell(124,6,"INSCRI??O MUNICIPAL: ".$q21_inscr,"RB",1,"L",0);
  
  $pdf->setX(5);
  $pdf->Cell(57,5,"NOTA ",1,0,"C",1);
  $pdf->Cell(57,5,"S?RIE",1,0,"C",1);
  $pdf->Cell(57,5,"VALOR DO SERVI?O",1,0,"C",1);
  $pdf->Cell(56,5,"ALIQUOTA",1,0,"C",1);
  $pdf->Cell(57,5,"IMPOSTO",1,1,"C",1);
  
for($i=0;$i<$linhas;$i++){
  db_fieldsmemory($clquery->result,$i);
  $pdf->setX(5);
  $pdf->Cell(57,5,$q21_nota,1,0,"C",0);
  $pdf->Cell(57,5,$q21_serie,1,0,"C",0);
  $pdf->Cell(57,5,db_formatar($q21_valorser,'f'),1,0,"C",0);
  $pdf->Cell(56,5,$q21_aliq."%",1,0,"C",0);
  $pdf->Cell(57,5,db_formatar($q21_valor,'f'),1,1,"C",0);
  $ny=$pdf->GetY();
  if($ny>=160){
    $pdf->AddPage("L");
    $pdf->setX(5);
  }
}
$pdf->Output();

?>