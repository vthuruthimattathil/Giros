<?php

include_once("../session.php");

include_once '../tcpdf/config/lang/fra.php';
include_once '../tcpdf/tcpdf.php';
include_once 'convocationFct.php';

function pge(&$pdf, $noretenue) {
 $pdf->AddPage();
 $pdf->SetFont('times', '', 12, '', true);
 // get informations
 $giros = $_SESSION['GIROS'];
 $giros->sqlConnect();
 $query = "SELECT * FROM RETENUE LEFT JOIN ELEVE USING(IAM) LEFT JOIN DATESR USING(NODATER) ";
 $query.=sprintf(" WHERE NORETENUE ='%s'", $noretenue);
 $giros->sqlQuery($query);
 $row = $giros->sqlData();
 $datereport = '';
 if ($row['NOREPORT'] != '') {
  $tmpnorep = explode(' ', $row['NOREPORT']);
  $tmp = implode('", "', $tmpnorep);
  $tmp = '"' . $tmp . '"';
  $datereport = "Pour information: Report de la retenue du";
  $query = "SELECT DATE_FORMAT(DATER,'%e.%c.%y à %k:%i') DATEF FROM  DATESR ";
  $query.=sprintf("WHERE NODATER IN (%s) ", $tmp);
  $query.="ORDER BY DATER";
  $giros->sqlQuery($query);
  while ($report = $giros->sqlData()) {
   $datereport.=sprintf(" %s / ", $report['DATEF']);
  }
  $datereport = substr($datereport, 0, -3);
 }
 // Entête lycée
 $pdf->setJPEGQuality(75);
 $pdf->Image('../logo.jpg', 12, 12, 70, 0, 'jpeg', '', 'N', true);
 // Tic
 $pdf->Line(0, 100, 10, 100);
 // Adresse Tuteur
 $txt = stripslashes($row['CIVILITE'] . "\n" . $row['PRENOMT'] . " " . $row['NOMT'] . "\n" . $row['RUE'] . "\n" . $row['CP'] . " " . $row['LOCALITE']);
 $pdf->MultiCell($w = 0, $h = 15, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '107', $y = '38', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 // Date
 $date = explode(' ', $row['DATEI']);
 $date = explode('-', $date[0]);
 $year = $date[0];
 $month = txtmonth($date[1]);
 $day = $date[2];
 $pdf->setXY(107, 75);
 if ($giros->getSite() == 'L') {
  $pdf->Write($h = 0, 'Lamadelaine, le ' . $day . ' ' . $month . ' ' . $year, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
 } else {
  $pdf->Write($h = 0, 'Differdange, le ' . $day . ' ' . $month . ' ' . $year, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
 }
 // Titre
 $pdf->setY(93);
 $txt = stripslashes($row['CIVILITE'] . ',');
 $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
 // 1. alignea
 if ($row['SEXE']=='F') {
  $accord = 'e';
  $s1 = 'fille';
  $sujet = 'Elle';
 } else {
  $accord = '';
  $s1 = 'fils';
  $sujet = 'Il';
 }
 $s2 = stripslashes($row['NOME'] . ' ' . $row['PRENOME']);
 $s3 = stripslashes($row['CODE']);
 $temp = explode(' ', $row['DATER']);
 $date = explode('-', $temp[0]);
 $s5 = $date[2] . ' ' . txtmonth($date[1]) . ' ' . $date[0];
 $time = explode(':', $temp[1]);
 $s6 = $time[0] . ':' . $time[1];
 $time[0] = (int) $time[0] + 2;
 $s7 = $time[0] . ':' . $time[1];
 $str = sprintf("J'ai le regret de vous informer que l'élève %s de la classe %s, sera mis%s en retenue le %s de %s heures à %s heures.", $s2, $s3, $accord, $s5, $s6, $s7);
 $pdf->setY(104);
 $pdf->Write($h = 0, $str, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
 // rang
 $giros->sqlQuery("SELECT COUNT(*) AS RANG FROM RETENUE WHERE IAM='" . $row['IAM'] . "' AND DATEI <= '" . $row['DATEI'] . "'");
 $data = $giros->sqlData();
 $rang = $data['RANG'];
 $str = sprintf("Il s'agit de sa %s retenue pour cette année scolaire.", rang($rang));
 $pdf->setY($pdf->getY() + 2);
 $pdf->Write($h = 0, $str, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
 // Motif
 $y = $pdf->getY() + 2;
 $pdf->setY($y);
 $pdf->Write($h = 0, "Motif de la retenue: ", $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
 $pdf->setXY(80, $y);
 $txt = stripslashes($row['MOTIF']);
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '80', $y, $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->Write($h = 0, "", $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
 // Salle
 $y = $pdf->getY();
 $pdf->Write($h = 0, "Lieu de la retenue:", $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
 $pdf->setXY(80, $y);
 $txt = stripslashes($row['SALLE']);
 $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
 $pdf->Write($h = 0, "", $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
 // Travail
 $txt = 'Le travail à faire sera communiqué par le surveillant au début de la retenue.';
 $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
 $pdf->Write($h = 0, "", $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
 $txt = 'Cette convocation est à présenter, dûment signée, au surveillant le jour de la retenue.';
 $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
 $txt = sprintf("%s devra s'identifier moyennant sa carte d'élève.", stripslashes($row['PRENOME']));
 $pdf->Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
 // Signatures
 $pdf->setXY(110, 205);
 $pdf->Write($h = 0, 'Vu,', $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
 switch ($giros->getUntis()) {
  case 'MARPA': $title = 'Directeur,';
   break;
  case 'MULED': $title = 'Le directeur,';
   break;
  case 'awagner': $title = 'Attaché à la Direction,';
   break;
  case 'EICJC': $title = 'Directeur adjoint,';
   break;
  case 'PIEMY': $title = 'Directrice adjointe,';
   break;
  case 'DILAN': $title = 'Directrice adjointe,';
   break;
  default:
   if ($row['REGENT'] == 0) {
    if ($giros->getSexe()=='F')
     $title = "L'enseignante";
    else
     $title = "L'enseignant";
   }
   else {
    if ($giros->getSexe()=='F')
     $title = "La régente";
    else
     $title = "Le régent";
   }
   break;
 }
 $y = $pdf->getY();
 $pdf->Write($h = 0, $title, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
 $pdf->setXY(90, $y);
 $pdf->Write($h = 0, "La tutrice", $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
 $pdf->setXY(140, $y);
 $pdf->Write($h = 0, "Le tuteur", $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
 $pdf->Write($h = 0, $giros->getCName() . ' ' . $giros->getName(), $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
 $y = $pdf->getY() + 20;
 $pdf->SetFont('times', 'I', 12, '', true);
 $pdf->MultiCell($w = 35, $h = 0, "signature", $border = 'T', $align = 'C', $fill = false, $ln = 1, $x = '25', $y, $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->MultiCell($w = 35, $h = 0, "signature", $border = 'T', $align = 'C', $fill = false, $ln = 1, $x = '90', $y, $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->MultiCell($w = 35, $h = 0, "signature", $border = 'T', $align = 'C', $fill = false, $ln = 1, $x = '140', $y, $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->setY($pdf->getY() + 10);
 if ($datereport != '') {
  $pdf->SetFont('times', '', 9, '', true);
  $pdf->Write($h = 0, $datereport, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
 }
 $pdf->SetFont('times', 'B', 12, '', true);
 $y = $pdf->getY();
 $pdf->Write($h = 0, "NB:", $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
 $txt = "Si le travail imposé n'est pas terminé, il doit être fini à la maison et rendu le lendemain au titulaire.";
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '37', $y, $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
}

// MAIN

$giros = $_SESSION['GIROS'];
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false, false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($giros->getUntis());
$pdf->SetTitle('Lettre retenue');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(25, 25, 25);
$pdf->SetAutoPageBreak(TRUE, 25);
$pdf->setLanguageArray($l);
$pdf->setFontSubsetting(true);
foreach ($_SESSION['RETENUE']['DATA'] as $noretenue) {
 pge($pdf, $noretenue);
}
$pdf->Output('Lettre.pdf', 'I');
unset($_SESSION['RETENUE']);
?>
