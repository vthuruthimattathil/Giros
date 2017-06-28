<?php

include_once("../session.php");
include_once('../tcpdf//config/lang/fra.php');
include_once('../tcpdf/tcpdf.php');

class MYPDF extends TCPDF {

 public function Footer() {
  // Position at 15 mm from bottom
  $this->SetY(-15);
  // Set font
  $this->SetFont('times', 'I', 8);
  // Page number
  $today = getdate();
  $footer = sprintf("%s.%s.%s", $today['mday'], $today['mon'], $today['year']);
  $this->Cell(0, 10, $footer, 0, false, 'C', 0, '', 0, false, 'T', 'M');
  $this->SetY(-15);
  $footer = sprintf("%s/%s", $this->getAliasNumPage(), $this->getAliasNbPages());
  $this->Cell(0, 10, $footer, 0, false, 'R', 0, '', 0, false, 'T', 'M');
  $this->SetY(-15);
  $footer = "Veuillez marquer clairement les absences par un A et les présences par un P.";
  $this->Cell(0, 10, $footer, 0, false, 'L', 0, '', 0, false, 'T', 'M');
 }

}

$giros = $_SESSION['GIROS'];
$id = $_SESSION['COMPOSITION']['ID'];
$pdf = new MYPDF('L', 'mm', 'A4', true, 'UTF-8', false, false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($giros->getUntis());
$pdf->SetTitle('Relevé compositions');
$pdf->setPrintHeader(true);
$pdf->setPrintFooter(true);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(20, 12, 12);
$pdf->SetAutoPageBreak(TRUE, 12);
$pdf->setLanguageArray($l);
$pdf->setFontSubsetting(true);
$pdf->SetFont('times', '', 12, '', true);
$giros->sqlConnect();
$query = "SELECT DATE_FORMAT(DATED,'%d.%m.%Y à %H:%i') AS FDATED,SALLE,NOM,PRENOM FROM DATESD ";
$query.="LEFT JOIN PROF ON DATESD.SURVEILLANT=PROF.UNTIS WHERE NODATED = '$id'";
$giros->sqlQuery($query);
$row = $giros->sqlData();
$title = sprintf("Compositions du %s Salle: %s Surveillant: %s\n", $row['FDATED'], $row['SALLE'], $row['PRENOM'] . ' ' . $row['NOM']);
$pdf->setHeaderData($ln = '', $lw = 0, $title, $hs = '');
$pdf->setHeaderFont(Array('times', '', 12, '', true));
$pdf->setHeaderMargin(5);
$pdf->AddPage();
$pdf->SetFont('times', 'B', 12, '', true);
$width = array(70, 20, 70, 15, 75, 15);
$pdf->MultiCell($width[0], $h = 0, "Nom", $border = 'TBLR', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
$pdf->MultiCell($width[1], $h = 0, "Classe", $border = 'TBLR', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
$pdf->MultiCell($width[2], $h = 0, "Branche", $border = 'TBLR', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
$pdf->MultiCell($width[3], $h = 0, "Durée", $border = 'TBLR', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
$pdf->MultiCell($width[4], $h = 0, "Titulaire", $border = 'TBLR', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
$pdf->MultiCell($width[5], $h = 0, "Prés.", $border = 'TBLR', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
$giros->sqlQuery("SELECT * FROM DEVOIR LEFT JOIN PROF USING(UNTIS) LEFT JOIN ELEVE ON ELEVE.IAM=DEVOIR.IAM WHERE NODATED='" . $id . "' ORDER BY PRESENT,NOME");
while ($row = $giros->sqlData()) {
 $s[0] = $row['NOME'] . ' ' . $row['PRENOME'];
 $s[1] = $row['CODE'];
 $s[2] = $row['BRANCHE'];
 $s[3] = $row['DUREE'];
 $s[4] = sprintf("%s %s (%s)", $row['NOM'], $row['PRENOM'], $row['NOCASE']);
 switch ($row['PRESENT']) {
  case -1: $s[5] = '';
   break;
  case 0: $s[5] = 'A';
   break;
  case 1: $s[5] = 'P';
   break;
 }
 $pdf->SetFont('times', '', 12, '', true);
 $maxheight = 0;
 foreach ($s as $key => $value) {
  $maxheight = max($maxheight, $pdf->getStringHeight($width[$key], $value));
 }
 $maxheight+=2;
 $y = $pdf->getY();
 $pdf->MultiCell($width[0], $maxheight, $s[0], $border = 'LRB', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->MultiCell($width[1], $maxheight, $s[1], $border = 'LRB', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->MultiCell($width[2], $maxheight, $s[2], $border = 'LRB', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->MultiCell($width[3], $maxheight, $s[3], $border = 'LRB', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->MultiCell($width[4], $maxheight, $s[4], $border = 'LRB', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->MultiCell($width[5], $maxheight, $s[5], $border = 'LRB', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
}
$pdf->Output('Lettre.pdf', 'I');
unset($_SESSION['COMPOSITION']);
?>




