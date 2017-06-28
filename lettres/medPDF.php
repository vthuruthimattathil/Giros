<?php
include_once("../session.php");
include_once('../tcpdf//config/lang/fra.php');
include_once('../tcpdf/tcpdf.php');
include_once ('../fct.php');

function pge(&$pdf,$id) {
 // get information
 $giros=$_SESSION['GIROS'];
 $error=0;
 $pdf->AddPage();
 $giros->sqlConnect();
 $query="SELECT NOLETTRE,DATEI,DATA,NOTYPE,NOME,PRENOME,CODE,NOMT,PRENOMT,RUE,CP,LOCALITE,CIVILITE,NOM,PRENOM,UNTIS FROM LETTRE ";
 $query.="LEFT JOIN ELEVE USING(IAM) LEFT JOIN PROF USING(UNTIS)";
 $query.=sprintf("WHERE NOLETTRE='%s'",$id);
 $giros->sqlQuery($query);
 if ($giros->sqlNumRows()==0) {
  // id not found
  $error+=1;
 }
 $row=$giros->sqlData();
 if (($row['NOTYPE']!=1)) {
  // wrong type of letter
  $error+=2;
 }
 if ($error!=0) {
  $pdf->Write($h=0,'Cert med / Error:'.$error, $link='', $fill=false, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);;
 }
 else {
  // seems everything OK
  //Logo
  $pdf->setJPEGQuality(75);
  $pdf->Image('../logo.jpg',12,12,70,0,'jpeg','','N',true);
  //Ref
  $pdf->setY(34);
  $pdf->SetFont('times', '', 12, '', true);
  $year=substr($row['NOLETTRE'], 0,2);
  $current=substr($row['NOLETTRE'], 2,4);
  $ref=sprintf("G/%s/20%s-%s",$row['UNTIS'],$year,$current);
  $txt=sprintf("Réf.:%s",$ref);
//  $txt=utf8_encode($txt);
  $pdf->Write($h=0, $txt, $link='', $fill=false, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
  // Recommande
  $txt="Recommandé";
//  $txt=utf8_encode($txt);
  $pdf->setXY(120,35);
  $pdf->SetFont('times', 'bu', 12, '', true);
  $pdf->Write($h=0, $txt, $link='', $fill=false, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
  // Adresse
  $txt=stripslashes($row['CIVILITE']."\n".$row['PRENOMT']." ".$row['NOMT']."\n".$row['RUE']."\n".$row['CP']." ".$row['LOCALITE']);
  $pdf->SetFont('times','', 12, '', true);
  $pdf->MultiCell($w=0,$h=15,$txt,$border='',$align = 'L', $fill=false,$ln=1,$x='120',$y='43',$reseth=true,$stretch=0,$ishtml=false,$autopadding=true,$maxh=0,$valign='T',$fitcell=false);
  // Date
  $txt=sprintf("Lamadelaine, le %s",utf8_encode(fr_date_format($row['DATEI'])));
//  $txt=utf8_encode($txt);
  $pdf->setXY(120,78);
  $pdf->SetFont('times','', 12, '', true);
  $pdf->Write($h=0, $txt, $link='', $fill=false, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
  // Title
  $txt=$row['CIVILITE'].",";
//  $txt=utf8_encode($txt);
  $pdf->setY(100);
  $pdf->SetFont('times','', 12, '', true);
  $pdf->Write($h=0, $txt, $link='', $fill=false, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
  // 1 paragraph
  $txt=sprintf("Suite aux nombreuses absences de l'élève %s %s de la classe %s, nous nous voyons forcés d'exiger, ",$row['PRENOME'],$row['NOME'],$row['CODE']);
  $txt.="d'après l'article 12 du règlement grand-ducal du 23 décembre 2004 concernant l'ordre intérieur et de la discipline dans les lycées et ";
  $txt.=sprintf("lycées techniques, un certificat médical justifiant chaque absence de %s %s à l'avenir, ",$row['PRENOME'],$row['NOME']);
  $txt.="et ce jusqu'à la fin de l'année scolaire 2016-2017.\n";
//  $txt=utf8_encode($txt);
  $pdf->setY(120);
  $pdf->SetFont('times','', 12, '', true);
  $pdf->Write($h=0, $txt, $link='', $fill=false, $align='J', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
  //  greetings
  $txt=sprintf("Veuillez agréer, %s, l'expression de nos sentiments distingués.",$row['CIVILITE']);
//  $txt=utf8_encode($txt);
  $pdf->SetFont('times','', 12, '', true);
  $pdf->setY(155);
  $pdf->Write($h=0, $txt, $link='', $fill=false, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
  // signatures
  if($row['UNTIS']!='MARPA') {
    $pdf->setXY(25,200);
    $txt=$row['PRENOM']." ".$row['NOM'];
    //  $txt=utf8_encode($txt);
    $pdf->Write($h=0, $txt, $link='', $fill=false, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
    $pdf->setXY(25,$pdf->getY()+2);
    $txt=sprintf("Régent de la classe %s",$row['CODE']);
//  $txt=utf8_encode($txt);
    $pdf->Write($h=0, $txt, $link='', $fill=false, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
  }
  $pdf->setXY(120,200);
  $txt="Pascal Marin";
//  $txt=utf8_encode($txt);
  $pdf->Write($h=0, $txt, $link='', $fill=false, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
  $pdf->setXY(120,$pdf->getY()+2);
  $txt="Directeur du\n";
//  $txt=utf8_encode($txt);
  $pdf->Write($h=0, $txt, $link='', $fill=false, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
  $pdf->setX(120);
  $txt="Lycée Technique Mathias Adam\n";
// $txt=utf8_encode($txt);
  $pdf->Write($h=0, $txt, $link='', $fill=false, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
  //Footer
  $pdf->setY(250);
  $txt="Adresse";
  $txt=utf8_encode($txt);
  $pdf->SetFont('times','b', 9, '', true);
  $pdf->Write($h=0, $txt, $link='', $fill=false, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
  $txt="avenue de l'Europe\nL-4802 Lamadelaine";
//  $txt=utf8_encode($txt);
  $pdf->SetFont('times','', 9, '', true);
  $pdf->Write($h=0, $txt, $link='', $fill=false, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
  $txt="50 87 30 - 209";
//  $txt=utf8_encode($txt);
  $pdf->SetFont('times','', 9, '', true);
  $pdf->Write($h=0, $txt, $link='', $fill=false, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
  $txt="Secrétariat du directeur";
//  $txt=utf8_encode($txt);
  $pdf->SetFont('times','', 9, '', true);
  $pdf->Write($h=0, $txt, $link='', $fill=false, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
  $pdf->setY(250);
  $txt="Adresse postale";
//  $txt=utf8_encode($txt);
  $pdf->SetFont('times','b', 9, '', true);
  $pdf->Write($h=0, $txt, $link='', $fill=false, $align='R', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
  $txt="B.P. 25\nL-4701 Pétange";
//  $txt=utf8_encode($txt);
  $pdf->SetFont('times','', 9, '', true);
  $pdf->Write($h=0, $txt, $link='', $fill=false, $align='R', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
  $txt="50 87 30 - 207";
//  $txt=utf8_encode($txt);
  $pdf->SetFont('times','', 9, '', true);
  $pdf->Write($h=0, $txt, $link='', $fill=false, $align='R', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
  $txt="Secrétariat du directeur adjoint";
//  $txt=utf8_encode($txt);
  $pdf->SetFont('times','', 9, '', true);
  $pdf->Write($h=0, $txt, $link='', $fill=false, $align='R', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
  //Tic
  $pdf->Line(5,95,10,95);
  $pdf->Line(25,250,185,250);
  // $pdf->Rect(25,25,160,247);
 }
}
$giros=$_SESSION['GIROS'];
if (isset($_SESSION['LETTRES']['ID'])){
 $ref=$_SESSION['LETTRES']['ID'];
 $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false,false);
 $pdf->SetCreator(PDF_CREATOR);
 $pdf->SetAuthor($giros->getUntis());
 $pdf->SetTitle('Lettres absences');
 $pdf->setPrintHeader(false);
 $pdf->setPrintFooter(false);
 $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 $pdf->SetMargins(25, 25, 25);
 $pdf->SetAutoPageBreak(TRUE, 25);
 $pdf->setLanguageArray($l);
 $pdf->setFontSubsetting(true);
 pge($pdf,$ref);
 $pdf->Output('Lettre.pdf', 'I');
 unset($_SESSION['LETTRES']);
}
?>
