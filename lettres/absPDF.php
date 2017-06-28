<?php

include_once("../session.php");
include_once('../tcpdf/config/lang/fra.php');
include_once('../tcpdf/tcpdf.php');
include_once ('../fct.php');

function pge(&$pdf, $id) {
// get information
 $giros = $_SESSION['GIROS'];
 $error = 0;
 $pdf->AddPage();
 $giros->sqlConnect();
 $query = "SELECT NOLETTRE,DATEI,DATA,NOTYPE,ELEVE.IAM,NOME,PRENOME,NOMT,PRENOMT,RUE,CP,LOCALITE,CIVILITE,SEXE, CODE,UNTIS FROM LETTRE ";
 $query.="LEFT JOIN ELEVE USING(IAM) ";
 $query.=sprintf("WHERE NOLETTRE='%s'", $id);
 $giros->sqlQuery($query);
 if ($giros->sqlNumRows() == 0) {
// id not found
  $error+=1;
 }
 $row = $giros->sqlData();
 if (($row['NOTYPE'] != 0)) {
// wrong type of letter
  $error+=2;
 }
 if ($error != 0) {
  $pdf->Write($h = 0, 'Abs / Error:' . $error, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
  ;
 } else {
// seems everything OK
//Logo
  $pdf->setJPEGQuality(75);
  $pdf->Image('../logo.jpg', 12, 12, 70, 0, 'jpeg', '', 'N', true);
//Ref
  $pdf->setY(34);
  $pdf->SetFont('times', '', 12, '', true);
  $year = substr($row['NOLETTRE'], 0, 2);
  $current = substr($row['NOLETTRE'], 2, 4);
  $ref = sprintf("G/%s/20%s-%s", $row['UNTIS'], $year, $current);
  $txt = sprintf("Réf.:%s", $ref);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
// Recommande
  $txt = "Recommandé";
  $pdf->setXY(120, 35);
  $pdf->SetFont('times', 'bu', 12, '', true);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
// Adresse
  $txt = stripslashes($row['CIVILITE'] . "\n" . $row['PRENOMT'] . " " . $row['NOMT'] . "\n" . $row['RUE'] . "\n" . $row['CP'] . " " . $row['LOCALITE']);
  $pdf->SetFont('times', '', 12, '', true);
  $pdf->MultiCell($w = 0, $h = 15, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '120', $y = '43', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
// Date
  if ($giros->getSite() == 'P') {
   $txt = sprintf("Differdange, le %s", utf8_encode(fr_date_format($row['DATEI'])));
  } else {
   $txt = sprintf("Lamadelaine, le %s", utf8_encode(fr_date_format($row['DATEI'])));
  }
  $pdf->setXY(120, 78);
  $pdf->SetFont('times', '', 12, '', true);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
// Title
  $txt = $row['CIVILITE'] . ",";
  $pdf->setY(100);
  $pdf->SetFont('times', '', 12, '', true);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
// 1 paragraph
  $data = explode('#', $row['DATA']);
  if ($row['SEXE'] == 'F') {
   $accord = 'e';
  } else {
   $accord = '';
  }
  $txt = sprintf("Par la présente, je vous signale que l'élève %s %s de la classe %s est absent%s du", $row['PRENOME'], $row['NOME'], $row['CODE'], $accord);
  $txt.=sprintf(" %s jusqu'à ce jour, sans certificat médical.\n", utf8_encode(fr_date_format($data[0], true)));
  $pdf->setY(110);
  $pdf->SetFont('times', '', 12, '', true);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'J', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
// 2 paragraph
  $txt = "Je tiens à attirer votre attention sur le fait que d'après le règlement grand-ducal du 23 décembre 2004, concernant l'ordre ";
  $txt.="intérieur et la discipline dans les lycées et lycées techniques...\n";
  $pdf->SetFont('times', '', 12, '', true);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'J', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
//liste
  $html = <<<EOF
<ul>
    <li>... pour toute absence sup&eacute;rieure &agrave; 3 jours, il y a lieu de remettre un certificat m&eacute;dical au r&eacute;gent,<br></li>
    <li>... qu'en cas d'absence de l'&eacute;l&egrave;ve, le lyc&eacute;e en doit &ecirc;tre inform&eacute; par &eacute;crit dans les trois jours de calendrier,<br></li>
    <li>... que l'&eacute;l&egrave;ve absent pendant 15 jours cons&eacute;cutifs sans excuse ou sans motif reconnu valable est consid&eacute;r&eacute;
    comme ayant quitt&eacute; d&eacute;finitivement l'&eacute;tablissement, avec effet &agrave; partir du premier jour de son absence.</li>
<ul>
EOF;
  $pdf->setY($pdf->getY() + 2);
  $pdf->SetFont('times', '', 12, '', true);
  $pdf->writeHTML($html, true, false, true, false, '');
//  greetings
  $txt = sprintf("Je vous prie d'agréer, %s, l'expression de mes sentiments distingués.", $row['CIVILITE']);
  $pdf->SetFont('times', '', 12, '', true);
  $pdf->setY(190);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
// signature
  if ($giros->getSite() == 'P') {
   $pdf->setXY(120, 220);
   $txt = "Andrea Di Leo";
   $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
   $pdf->setXY(120, $pdf->getY() + 2);
   $txt = "Directrice adjointe du\n";
   $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
  } else {
   $pdf->setXY(120, 220);
   $txt = "Pascal Marin";
   $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
   $pdf->setXY(120, $pdf->getY() + 2);
   $txt = "Directeur du\n";
   $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
  }
  $pdf->setX(120);
  $txt = "Lycée Technique Mathias Adam\n";
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
//Footer
  $pdf->setY(250);
  $txt = "Adresse";
  $txt = utf8_encode($txt);
  $pdf->SetFont('times', 'b', 9, '', true);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
  $txt = "avenue de l'Europe\nL-4802 Lamadelaine";
  $pdf->SetFont('times', '', 9, '', true);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
  $txt = "50 87 30 - 209";
  $pdf->SetFont('times', '', 9, '', true);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
  $txt = "Secrétariat du directeur";
  $pdf->SetFont('times', '', 9, '', true);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
  $pdf->setY(250);
  $txt = "Adresse postale";
  $pdf->SetFont('times', 'b', 9, '', true);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'R', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
  $txt = "B.P. 25\nL-4701 Pétange";
  $pdf->SetFont('times', '', 9, '', true);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'R', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
  if ($giros->getSite() == 'P') {
   $txt = "58 44 79 - 240";
   $pdf->SetFont('times', '', 9, '', true);
   $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'R', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
   $txt = "Secrétariat de la directrice adjointe";
   $pdf->SetFont('times', '', 9, '', true);
   $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'R', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
  } else {
   $txt = "50 87 30 - 207";
   $pdf->SetFont('times', '', 9, '', true);
   $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'R', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
   $txt = "Secrétariat du directeur adjoint";
   $pdf->SetFont('times', '', 9, '', true);
   $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'R', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
  }
//Tic
  $pdf->Line(5, 95, 10, 95);
  $pdf->Line(25, 250, 185, 250);
 }
}

$giros = $_SESSION['GIROS'];
if (isset($_SESSION['LETTRES']['ID'])) {
 $ref = $_SESSION['LETTRES']['ID'];
 $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false, false);
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
 pge($pdf, $ref);
 $pdf->Output('Lettre.pdf', 'I');
 unset($_SESSION['LETTRES']);
}
?>
