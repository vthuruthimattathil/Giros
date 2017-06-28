<?php

include_once("../session.php");
include_once('../tcpdf//config/lang/fra.php');
include_once('../tcpdf/tcpdf.php');

function pge(&$pdf,$class,$amount) {
 $style = array(
   'position' => '',
   'align' => 'C',
   'stretch' => false,
   'fitwidth' => true,
   'cellfitalign' => '',
   'border' => false,
   'hpadding' => '6',
   'vpadding' => '6',
   'fgcolor' => array(0,0,0),
   'bgcolor' => false, //array(255,255,255),
   'text' => false,
   'font' => 'helvetica',
   'fontsize' => 8,
   'stretchtext' => 4
 );
 $pdf->AddPage();
 $pdf->SetFont('times', '', 14, '', true);
 $giros=$_SESSION['GIROS'];
 $query=sprintf("SELECT * FROM CLASSE LEFT JOIN PROF ON REGENT=UNTIS WHERE CODE ='%s'",$class);
 $giros->sqlQuery($query);
 $row=$giros->sqlData();
 $txt=sprintf("Classe: %s Régent: %s %s (%s)",$row['CODE'],$row['NOM'],$row['PRENOM'],$row['NOCASE']);
 $pdf->MultiCell($w=0,$h=0,$txt,$border='',$align = 'C', $fill=false,$ln=1,$x='',$y='',$reseth=true,$stretch=0,$ishtml=false,$autopadding=true,$maxh=0,$valign='T',$fitcell=false);
 $width[0]=90;
 $width[1]=20;
 $width[2]=20;
 $pdf->MultiCell($width[0],0,"Nom et prénom",$border='TLR',$align = 'L', $fill=false,$ln=0,$x=62,$y='',$reseth=true,$stretch=0,$ishtml=false,$autopadding=true,$maxh=0,$valign='M',$fitcell=false);
 $pdf->MultiCell($width[1],0,"Montant",$border='TLR',$align = 'l', $fill=false,$ln=0,$x='',$y='',$reseth=true,$stretch=0,$ishtml=false,$autopadding=true,$maxh=0,$valign='M',$fitcell=false);
 $pdf->MultiCell($width[2],0,"Payé?",$border='TLR',$align = 'L', $fill=false,$ln=1,$x='',$y='',$reseth=true,$stretch=0,$ishtml=false,$autopadding=true,$maxh=0,$valign='M',$fitcell=false);
 $total+=$amount; 
 $query=sprintf("SELECT * FROM ELEVE WHERE CODE ='%s' ORDER BY NOME, PRENOME",$class);
 $giros->sqlQuery($query);
 $total=0;
 $pdf->SetFont('times', '', 12, '', true);
 while ($row=$giros->sqlData()) {
  $s[0]=$row['NOME']." ".$row['PRENOME'];
  $s[1]=sprintf("%01.2f €",$amount);
  $s[2]="";
  $maxheight=0;
  $pdf->SetFont('times', '', 12, '', true);
  foreach ($s as $key => $value) {
   $maxheight=max($maxheight,$pdf->getStringHeight($width[$key],$value));
  }
  $maxheight+=5;
  $y=$pdf->getY();
  $pdf->write1DBarcode($row['IAM'], 'C128B', $x='',$y='',$w=50, $maxheight, 0.4, $style, 'T');
  $pdf->MultiCell($width[0],$maxheight,$s[0],$border='TBLR',$align = 'L', $fill=false,$ln=0,$x=62,$y='',$reseth=true,$stretch=0,$ishtml=false,$autopadding=true,$maxh=0,$valign='M',$fitcell=false);
  $pdf->MultiCell($width[1],$maxheight,$s[1],$border='TBLR',$align = 'C', $fill=false,$ln=0,$x='',$y='',$reseth=true,$stretch=0,$ishtml=false,$autopadding=true,$maxh=0,$valign='M',$fitcell=false);
  $pdf->MultiCell($width[2],$maxheight,$s[2],$border='TBLR',$align = 'L', $fill=false,$ln=1,$x='',$y='',$reseth=true,$stretch=0,$ishtml=false,$autopadding=true,$maxh=0,$valign='M',$fitcell=false);
  $total+=$amount;
 }
 $pdf->MultiCell(50,0,"Signature & date:",$border='',$align = 'L', $fill=false,$ln=0,$x='',$y='',$reseth=true,$stretch=0,$ishtml=false,$autopadding=true,$maxh=0,$valign='M',$fitcell=false);
 $pdf->MultiCell($width[0],0,"Total:",$border='',$align = 'R', $fill=false,$ln=0,$x='',$y='',$reseth=true,$stretch=0,$ishtml=false,$autopadding=true,$maxh=0,$valign='M',$fitcell=false);
 $pdf->MultiCell($width[1],0,sprintf("%01.2f €",$total),$border='',$align = 'l', $fill=false,$ln=0,$x='',$y='',$reseth=true,$stretch=0,$ishtml=false,$autopadding=true,$maxh=0,$valign='M',$fitcell=false);
 $pdf->MultiCell($width[2],0,"",$border='',$align = 'L', $fill=false,$ln=1,$x='',$y='',$reseth=true,$stretch=0,$ishtml=false,$autopadding=true,$maxh=0,$valign='M',$fitcell=false);
}


// MAIN

$giros=$_SESSION['GIROS'];
$giros->sqlConnect();
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false,false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($giros->getUntis());
$pdf->SetTitle('Accomptes');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(12, 12, 12);
$pdf->SetAutoPageBreak(TRUE, 12);
$pdf->setLanguageArray($l);
$pdf->setFontSubsetting(true);
foreach ($_SESSION['DOCUMENTS']['ADVANCE']['class'] as  $class) {
 pge($pdf,$class,$_SESSION['DOCUMENTS']['ADVANCE']['amount']);
}
$pdf->Output('Accompte.pdf', 'I');
//unset($_SESSION['DOCUEMENTS']);
?>
