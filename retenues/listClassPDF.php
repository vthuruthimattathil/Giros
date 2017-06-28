<?php

include_once("../session.php");
include_once('../tcpdf/config/lang/fra.php');
include_once('../tcpdf/tcpdf.php');

function pge(&$pdf, $giros, $classe) {
 unset($data);
 $query = "SELECT NOME,PRENOME,CODE,DATE_FORMAT(DATER,'%d.%m') AS DATER_F,MOTIF,PRESENT,DATEI,NOREPORT,NOM,PRENOM,NOCASE ";
 $query.="FROM RETENUE LEFT JOIN PROF USING(UNTIS) LEFT JOIN ELEVE  ON RETENUE.IAM=ELEVE.IAM LEFT JOIN DATESR USING(NODATER) ";
 $query.=sprintf("WHERE ELEVE.CODE='%s' ORDER BY ELEVE.CODE, NOME, PRENOME,DATER", $classe);
 $giros->sqlQuery($query);
 $title = 'Classe: ' . $classe;
 while ($row = $giros->sqlData()) {
  $s[0] = $row['NOM'] . ' ' . $row['PRENOM'];
  switch ($row['PRESENT']) {
   case -1: $s[1] = '?';
    break;
   case 0: $s[1] = 'A';
    break;
   case 1: $s[1] = 'P';
    break;
  }
  if (strlen($row['NOREPORT']) != 0) {
   $s[2].='R';
  }
  $date = $row['DATER_F'];
  // nom prénom élève / date / motif / Titulaire / Present
  $line = array(array($row['NOME'] . ' ' . $row['PRENOME'], $date, $row['MOTIF'], $s[0], $s[1]));
  if (!isset($data)) {
   $data = $line;
  } else {
   $data = array_merge_recursive($data, $line);
  }
 }

 function getMaxHeight(&$pdf, $line, $width) {
  $height = 0;
  $pdf->startTransaction();
  $pdf->AddPage();
  foreach ($line as $key => $data) {
   $startY = $pdf->getY();
   $pdf->MultiCell($width[$key], 0, $data, $border = 'TBLR', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $height = max($height, $pdf->getY() - $startY);
  }
  $pdf->rollbackTransaction(true);
  return $height;
 }

 function renderLine(&$pdf, $line, $width, $height) {
  foreach ($line as $key => $data) {
   if ($key == 4) {
    $ln = 1;
   } else {
    $ln = 0;
   }
   $pdf->MultiCell($width[$key], $height, $data, $border = 'TBLR', $align = 'L', $fill = false, $ln, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
  }
 }

 $pdf->AddPage();
 $margins = $pdf->getMargins();
 $pdf->SetFont('times', 'B', 12, '', true);
 $width[0] = $pdf->GetStringWidth('Elève');
 $width[1] = $pdf->GetStringWidth('Date');
 $width[3] = $pdf->GetStringWidth('Titulaire');
 $width[4] = $pdf->GetStringWidth('Prés.');
 $pdf->SetFont('times', '', 12, '', true);
 foreach ($data as $line) {
  $width[0] = max($width[0], $pdf->GetStringWidth($line[0]));
  $width[1] = max($width[1], $pdf->GetStringWidth($line[1]));
  $width[3] = max($width[3], $pdf->GetStringWidth($line[3]));
 }
 $width[0]+=4;
 $width[1]+=4;
 $width[3]+=4;
 $width[4]+=4;
 $width[2] = $pdf->getPageWidth() - $margins['left'] - $margins['right'] - $width[0] - $width[1] - $width[3] - $width[4];
 $pdf->SetFont('times', 'B', 14, '', true);
 $pdf->MultiCell(0, 0, $title, $border = '', $align = 'C', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'M', $fitcell = false);
 $pdf->SetFont('times', 'B', 12, '', true);
 $pdf->MultiCell($width[0], 0, 'Elève', $border = 'TLBR', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'M', $fitcell = false);
 $pdf->MultiCell($width[1], 0, 'Date', $border = 'TLBR', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'M', $fitcell = false);
 $pdf->MultiCell($width[2], 0, 'Motif', $border = 'TLBR', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'M', $fitcell = false);
 $pdf->MultiCell($width[3], 0, 'Titulaire', $border = 'TLBR', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'M', $fitcell = false);
 $pdf->MultiCell($width[4], 0, 'Prés', $border = 'TLBR', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'M', $fitcell = false);
 $pdf->SetFont('times', '', 12, '', true);
 foreach ($data as $line) {
  $height = getMaxHeight($pdf, $line, $width);
  $pdf->startTransaction();
  $start_page = $pdf->getPage();
  renderLine($pdf, $line, $width, $height);
  $end_page = $pdf->getPage();
  $log.=$start_page . " " . $end_page . "<br>";
  if ($start_page != $end_page) {
   $pdf->rollbackTransaction(true);
   $pdf->AddPage();
   renderLine($pdf, $line, $width, $height);
  }
 }
 //die($log);
}

$giros = $_SESSION['GIROS'];
$classe = $_SESSION['RETREL'];
unset($_SESSION['RETREL']);
$giros->sqlConnect();
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false, false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($giros->getUntis());
$pdf->SetTitle('Relevé classe');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(12, 12, 12);
$pdf->SetAutoPageBreak(TRUE, 12);
$pdf->setLanguageArray($l);
$pdf->setFontSubsetting(true);
pge($pdf, $giros, $classe);
$pdf->Output('Lettre.pdf', 'I');
?>
