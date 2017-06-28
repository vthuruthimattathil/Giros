<?php

include_once("../session.php");
include_once('../tcpdf/config/lang/fra.php');
include_once('../tcpdf/tcpdf.php');

class MYPDF extends TCPDF {

 public function Footer() {
  // Position at 15 mm from bottom
  $this->SetY(-15);
  // Set font
  $this->SetFont('times', 'I', 8);
  // Page number
  $today=getdate();
  $footer=sprintf("%s.%s.%s",$today['mday'],$today['mon'],$today['year']);
  $this->Cell(0, 10,$footer, 0, false, 'C', 0, '', 0, false, 'T', 'M');
  $this->SetY(-15);
  $footer=sprintf("%s/%s",$this->getAliasNumPage(),$this->getAliasNbPages());
  $this->Cell(0, 10,$footer, 0, false, 'R', 0, '', 0, false, 'T', 'M');
  $this->SetY(-15);
  $footer="Colonne PR.: Veuillez marquer clairement les absences par un A et les présences par un P."."\n"."Colonne CO: Codes pour la convocation: S: signé, NS: non-signé, M: manque.";
  $this->MultiCell(120, 0,$footer, '',  'L', false,0);
 }
}

$giros=$_SESSION['GIROS'];
$id=$_SESSION['RETENUE']['ID'];
$compact=$_SESSION['RETENUE']['COMPACT'];
$pdf = new MYPDF('L', 'mm', 'A4', true, 'UTF-8', false,false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($giros->getUntis());
$pdf->SetTitle('Relevé retenues');
$pdf->setPrintHeader(true);
$pdf->setPrintFooter(true);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(20,12,12);
$pdf->SetAutoPageBreak(TRUE, 12);
$pdf->setLanguageArray($l);
$pdf->setFontSubsetting(true);
$pdf->SetFont('times', '', 12, '', true);
$giros->sqlConnect();
$query="SELECT DATE_FORMAT(DATER,'%e.%c.%Y à %k:%i') AS FDATER,SALLE,NOM,PRENOM FROM DATESR ";
$query.="LEFT JOIN PROF ON DATESR.SURVEILLANT=PROF.UNTIS WHERE NODATER = '$id'";
$giros->sqlQuery($query);
$row = $giros->sqlData();
$title = sprintf("Retenues du %s Salle: %s Surveillant: %s\n",$row['FDATER'],$row['SALLE'],$row['PRENOM'].' '.$row['NOM']);
$pdf->setHeaderData	($ln='',$lw=0,$title,$hs='');
$pdf->setHeaderFont(Array('times', '', 12, '', true));
$pdf->setHeaderMargin(5);
$pdf->AddPage();
$width=array(70,20,80,75,10,10);
$pdf->SetFont('times', 'B', 12, '', true);
$pdf->MultiCell($width[0],$h=0,"Nom",$border='TBLR',$align = 'L', $fill=false,$ln=0,$x='',$y='',$reseth=true,$stretch=0,$ishtml=false,$autopadding=true,$maxh=0,$valign='T',$fitcell=false);
$pdf->MultiCell($width[1],$h=0,"Classe",$border='TBLR',$align = 'L', $fill=false,$ln=0,$x='',$y='',$reseth=true,$stretch=0,$ishtml=false,$autopadding=true,$maxh=0,$valign='T',$fitcell=false);
$txt="Travail imposé";
if ($compact=="0") {
 $txt="Motif / ".$txt;
}
$pdf->MultiCell($width[2],$h=0,$txt,$border='TBLR',$align = 'L', $fill=false,$ln=0,$x='',$y='',$reseth=true,$stretch=0,$ishtml=false,$autopadding=true,$maxh=0,$valign='T',$fitcell=false);
$pdf->MultiCell($width[3],$h=0,"Titulaire",$border='TBLR',$align = 'L', $fill=false,$ln=0,$x='',$y='',$reseth=true,$stretch=0,$ishtml=false,$autopadding=true,$maxh=0,$valign='T',$fitcell=false);
$pdf->MultiCell($width[4],$h=0,"PR.",$border='TBLR',$align = 'L', $fill=false,$ln=0,$x='',$y='',$reseth=true,$stretch=0,$ishtml=false,$autopadding=true,$maxh=0,$valign='T',$fitcell=false);
$pdf->MultiCell($width[5],$h=0,"CO.",$border='TBLR',$align = 'L', $fill=false,$ln=1,$x='',$y='',$reseth=true,$stretch=0,$ishtml=false,$autopadding=true,$maxh=0,$valign='T',$fitcell=false);

$giros->sqlQuery("SELECT * FROM RETENUE INNER JOIN PROF USING(UNTIS) INNER JOIN ELEVE ON RETENUE.IAM=ELEVE.IAM WHERE NODATER='".$id."' ORDER BY PRESENT,NOME");
while ($row = $giros->sqlData()) {
 $s[0]=$row['NOME'].' '.$row['PRENOME'];
 $s[1]=$row['CODE'];
 $s[2]=$row['TRAVAIL'];
 if ($compact=="0") {
  $s[2]=$row['MOTIF']."\n".$s[2];
 }
 $s[2]=$s[2];
 $s[3]=sprintf("%s %s (%s)",$row['NOM'],$row['PRENOM'],$row['NOCASE']);
 switch ($row['PRESENT']) {
  case -1: $s[4]='';break;
  case  0: $s[4]='A';break;
  case  1: $s[4]='P'; break;
 }
 switch ($row['CO']) {
  case 'X': $s[5]='';break;
  case 'S': $s[5]='s';break;
  case 'NS': $s[5]='n-s';break;
  case 'M': $s[5]='M';break;
}
 $maxheight=0;
 $pdf->SetFont('times', '', 12, '', true);
 foreach ($s as $key => $value) {
  $maxheight=max($maxheight,$pdf->getStringHeight($width[$key],$value));
 }
 $maxheight+=2;
 $y=$pdf->getY();
 $pdf->MultiCell($width[0],$maxheight,$s[0],$border='LRB',$align = 'L', $fill=false,$ln=0,$x='',$y='',$reseth=true,$stretch=0,$ishtml=false,$autopadding=true,$maxh=0,$valign='T',$fitcell=false);
 $pdf->MultiCell($width[1],$maxheight,$s[1],$border='LRB',$align = 'L', $fill=false,$ln=0,$x='',$y='',$reseth=true,$stretch=0,$ishtml=false,$autopadding=true,$maxh=0,$valign='T',$fitcell=false);
 $pdf->MultiCell($width[2],$maxheight,$s[2],$border='LRB',$align = 'L', $fill=false,$ln=0,$x='',$y='',$reseth=true,$stretch=0,$ishtml=false,$autopadding=true,$maxh=0,$valign='T',$fitcell=false);
 $pdf->MultiCell($width[3],$maxheight,$s[3],$border='LRB',$align = 'L', $fill=false,$ln=0,$x='',$y='',$reseth=true,$stretch=0,$ishtml=false,$autopadding=true,$maxh=0,$valign='T',$fitcell=false);
 $pdf->MultiCell($width[4],$maxheight,$s[4],$border='LRB',$align = 'L', $fill=false,$ln=0,$x='',$y='',$reseth=true,$stretch=0,$ishtml=false,$autopadding=true,$maxh=0,$valign='T',$fitcell=false);
 $pdf->MultiCell($width[5],$maxheight,$s[5],$border='LRB',$align = 'L', $fill=false,$ln=1,$x='',$y='',$reseth=true,$stretch=0,$ishtml=false,$autopadding=true,$maxh=0,$valign='T',$fitcell=false);
}
$pdf->Output('Lettre.pdf', 'I');
unset($_SESSION['RETENUE']);
?>




