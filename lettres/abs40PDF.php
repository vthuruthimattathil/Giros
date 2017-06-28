<?php

include_once("../session.php");
include_once('../tcpdf//config/lang/fra.php');
include_once('../tcpdf/tcpdf.php');
include_once ('../fct.php');

function pge(&$pdf, $id) {
 // get information
 $giros = $_SESSION['GIROS'];
 $error = 0;
 $pdf->AddPage();
 $giros->sqlConnect();
 $query = "SELECT NOLETTRE,DATEI,NOTYPE,ELEVE.IAM,NOME,PRENOME,NOMT,PRENOMT,RUE,CP,LOCALITE,CIVILITE,CODE,UNTIS FROM LETTRE ";
 $query.="LEFT JOIN ELEVE USING(IAM) ";
 $query.=sprintf("WHERE NOLETTRE='%s'", $id);
 $giros->sqlQuery($query);
 if ($giros->sqlNumRows() == 0) {
  // id not found
  $error+=1;
 }
 $row = $giros->sqlData();
 if (($row['NOTYPE'] != 3)) {
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
  // $txt=utf8_encode($txt);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
  // Recommande
  $txt = "Recommandé";
//  $txt=utf8_encode($txt);
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
  // $txt=utf8_encode($txt);
  $pdf->setXY(120, 78);
  $pdf->SetFont('times', '', 12, '', true);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
  // Title
  $txt = $row['CIVILITE'] . ",";
  // $txt=utf8_encode($txt);
  $pdf->setY(95);
  $pdf->SetFont('times', '', 12, '', true);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
  // 1 paragraph
  $txt = sprintf("Par la présente, nous sommes au regret de devoir vous signaler que l'élève %s %s de la classe %s ", $row['PRENOME'], $row['NOME'], $row['CODE']);
  $txt.="a accumulé des absences non-excusées excédant les 40 leçons, ce qui correspond à 10 demi-journées de cours.\n";
  // $txt=utf8_encode($txt);
  $pdf->setY($pdf->getY() + 2);
  $pdf->SetFont('times', '', 12, '', true);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'J', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
  // 2 paragraph
  $txt = "Je tiens à attirer votre attention sur le fait que d'après le règlement grand-ducal du 23 décembre 2004, concernant l'ordre ";
  $txt.="intérieur et la discipline dans les lycées et lycées techniques...\n";
  // $txt=utf8_encode($txt);
  $pdf->SetFont('times', '', 12, '', true);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'J', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
  //liste
  $html = <<<EOF
<ul>
    <li>... pour toute absence sup&eacute;rieure &agrave; 3 jours, il y a lieu de remettre un certificat m&eacute;dical au r&eacute;gent,</li>
    <li>... qu'en cas d'absence de l'&eacute;l&egrave;ve, le lyc&eacute;e en doit &ecirc;tre inform&eacute; par &eacute;crit dans les trois jours de calendrier,</li>
    <li>... que l'&eacute;l&egrave;ve absent pendant 15 jours cons&eacute;cutifs sans excuse ou sans motif reconnu valable est consid&eacute;r&eacute;
    comme ayant quitt&eacute; d&eacute;finitivement l'&eacute;tablissement, avec effet &agrave; partir du premier jour de son absence.</li>
<ul>
EOF;
  $pdf->setY($pdf->getY() + 2);
  $pdf->SetFont('times', '', 12, '', true);
  $pdf->writeHTML($html, true, false, true, false, '');
  // 3 paragraphe
  $txt = "En outre, un motif de renvoi définitif, d'après la loi du 25 juin 2004 portant organisation des lycées et lycées techniques, est constitué par ";
  $txt.="l'absence injustifiée des cours durant au plus vingt demi-journées au cours d'une même année scolaire.\n";
  // $txt=utf8_encode($txt);
  $pdf->setY($pdf->getY() + 2);
  $pdf->SetFont('times', '', 12, '', true);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'J', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
  //  greetings
  $txt = sprintf("Je vous prie d'agréer, %s, l'expression de mes sentiments distingués.", $row['CIVILITE']);
  //$txt=utf8_encode($txt);
  $pdf->SetFont('times', '', 12, '', true);
  $pdf->setY($pdf->getY() + 2);
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
  } $pdf->setX(120);
  $txt = "Lycée Technique Mathias Adam\n";
  // $txt=utf8_encode($txt);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
  //Footer
  $pdf->setY(250);
  $txt = "Adresse";
  $txt = utf8_encode($txt);
  $pdf->SetFont('times', 'b', 9, '', true);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
  $txt = "avenue de l'Europe\nL-4802 Lamadelaine";
  // $txt=utf8_encode($txt);
  $pdf->SetFont('times', '', 9, '', true);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
  $txt = "50 87 30 - 209";
  // $txt=utf8_encode($txt);
  $pdf->SetFont('times', '', 9, '', true);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
  $txt = "Secrétariat du directeur";
  // $txt=utf8_encode($txt);
  $pdf->SetFont('times', '', 9, '', true);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
  $pdf->setY(250);
  $txt = "Adresse postale";
  // $txt=utf8_encode($txt);
  $pdf->SetFont('times', 'b', 9, '', true);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'R', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
  $txt = "B.P. 25\nL-4701 Pétange";
  // $txt=utf8_encode($txt);
  $pdf->SetFont('times', '', 9, '', true);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'R', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
  $txt = "50 87 30 - 207";
  //$txt=utf8_encode($txt);
  $pdf->SetFont('times', '', 9, '', true);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'R', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
  $txt = "Secrétariat du directeur adjoint";
  // $txt=utf8_encode($txt);
  $pdf->SetFont('times', '', 9, '', true);
  $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'R', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
  //Tic
  $pdf->Line(5, 95, 10, 95);
  $pdf->Line(25, 250, 185, 250);
  // $pdf->Rect(25,25,160,247);
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
