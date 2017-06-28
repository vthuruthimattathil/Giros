<?php

include_once("../session.php");
include_once('../tcpdf//config/lang/fra.php');
include_once('../tcpdf/tcpdf.php');
include_once ('../fct.php');

function rang($nb) {
 $temp = array(1 => 'première', 2 => 'deuxième', 3 => 'troisième', 4 => 'quatrième', 5 => 'cinquième', 6 => 'sixième',
  7 => 'septième', 8 => 'huitième', 9 => 'neuvième', 10 => 'dixième', 11 => 'onzième', 12 => 'douzième', 13 => 'treizième',
  14 => 'quatorzième', 15 => 'quinzième', 16 => 'seizième', 17 => 'dix-septième', 18 => 'dix-huitième', 19 => 'dix-neuvième', 20 => 'vingtième'
 );
 return $temp[(int) $nb];
}

function pge(&$pdf,$id) {
  // get information
 $giros=$_SESSION['GIROS'];
 $error=0;
 $pdf->AddPage();
 $giros->sqlConnect();
 $query="SELECT LETTRE.IAM,NOLETTRE,DATEI,DATA,NOTYPE,NOME,PRENOME,CODE,ELEVE.SEXE,UNTIS, PROF.NOM,PROF.PRENOM FROM LETTRE ";
 $query.="LEFT JOIN ELEVE USING(IAM) LEFT JOIN PROF USING(UNTIS)";
 $query.=sprintf("WHERE NOLETTRE='%s'",$id);
 $giros->sqlQuery($query);
 if ($giros->sqlNumRows()==0) {
  // id not found
  $error+=1;
 }
 $row=$giros->sqlData();
 if (($row['NOTYPE']!=2)) {
  // wrong type of letter
  $error+=2;
 }
 if ($error!=0) {
  $pdf->Write($h=0,'Cert med / Error:'.$error, $link='', $fill=false, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);;
 }
 else {
  // seems everything OK
  // data
  $data=explode('#',$row['DATA']); //0:dateabs 1: startTime 2: endTime 3: qte 4: idchambre
  if ($row['SEXE']=='F') {
   $accord='e';
   $sujet='elle';
  }
  else {
   $accord='';
   $sujet='il';
  }
  $startTime=array("8:10","9:05","10:10","11:05","12:00","12:55","13:50","14:55","15:50");
  $endTime=array("9:00","9:55","11:00","11:55","12:50","13:45","14:40","15:45","16:40");
  $query=sprintf("SELECT * FROM CHAMBRE WHERE ID='%s'",$data[4]);
  $giros->sqlQuery($query);
  $chambre=$giros->sqlData();
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
  $pdf->setXY(120,35);
  $pdf->SetFont('times', 'bu', 12, '', true);
//  $pdf->Write($h=0, $txt, $link='', $fill=false, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
  // Adresse
  $txt=stripslashes($chambre['L1']."\n".$chambre['L2']."\n".$chambre['L3']."\n".$chambre['L4']);
  $pdf->SetFont('times','', 12, '', true);
  $pdf->MultiCell($w=0,$h=15,$txt,$border='',$align = 'L', $fill=false,$ln=1,$x='120',$y='43',$reseth=true,$stretch=0,$ishtml=false,$autopadding=true,$maxh=0,$valign='T',$fitcell=false);
  // Date
  $txt=sprintf("Lamadelaine, le %s",utf8_encode(fr_date_format($row['DATEI'])));
//  $txt=utf8_encode($txt);
  $pdf->setXY(120,78);
  $pdf->SetFont('times','', 12, '', true);
  $pdf->Write($h=0, $txt, $link='', $fill=false, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
  // Objet
  $txt="Objet: Absence non justifiée";
  $pdf->setY(100);
  $pdf->SetFont('times','B', 12, '', true);
  $pdf->Write($h=0, $txt, $link='', $fill=false, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
  // Title
  $tmp=explode(' ',$chambre['L2']);
  $title=$tmp[0];
  $txt=$title.",";
//  $txt=utf8_encode($txt);
  $pdf->setY(110);
  $pdf->SetFont('times','', 12, '', true);
  $pdf->Write($h=0, $txt, $link='', $fill=false, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
// 1 paragraph
  $txt=sprintf("Par la présente, j'ai le regret de vous informer que l'élève %s %s de la classe %s n'a pas fréquenté les cours du",$row['PRENOME'],$row['NOME'],$row['CODE']);
  $txt.=sprintf(" %s de %s à %s.",utf8_encode(fr_date_format($data[0],true)),$startTime[$data[1]],$endTime[$data[2]]);
  $txt.=sprintf(" Par ailleurs, %s n'a pas fourni de certificat médical afin de justifier son absence.\n",$sujet);
 // $txt=utf8_encode($txt);
  $pdf->setY(120);
  $pdf->SetFont('times','', 12, '', true);
  $pdf->Write($h=0, $txt, $link='', $fill=false, $align='J', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
// rang
  $txt=sprintf("Il s'agit de la %s absence non justifiée pour cette année scolaire.\n",rang($data[3]));
 // $txt=utf8_encode($txt);
  $pdf->setY($pdf->getY()+5);
  $pdf->SetFont('times','', 12, '', true);
  $pdf->Write($h=0, $txt, $link='', $fill=false, $align='J', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
// Salutations
  // rang
  $txt=sprintf("Je vous prie d'agréer, %s, l'expression de mes sentiments distingués.\n",$title);
// $txt=utf8_encode($txt);
  $pdf->setY($pdf->getY()+5);
  $pdf->SetFont('times','', 12, '', true);
  $pdf->Write($h=0, $txt, $link='', $fill=false, $align='J', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
// signatures
  $pdf->setXY(25,200);
  $txt=$row['PRENOM']." ".$row['NOM'];
//  $txt=utf8_encode($txt);
  $pdf->Write($h=0, $txt, $link='', $fill=false, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
  $pdf->setXY(25,$pdf->getY()+2);
  $txt=sprintf("Régent de la classe %s",$row['CODE']);
//  $txt=utf8_encode($txt);
  $pdf->Write($h=0, $txt, $link='', $fill=false, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
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
 //unset($_SESSION['LETTRES']);
}
?>
