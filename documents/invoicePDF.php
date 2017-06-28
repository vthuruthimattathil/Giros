<?php

include_once("../session.php");
include_once('../tcpdf//config/lang/fra.php');
include_once('../tcpdf/tcpdf.php');


define("a4rb", 5.0);
define("a4rc", 10.0);
define("a4vb", 5.0);
define("a4vc", 10.0);
define("a3rb", 10.0);
define("a3rc", 20.0);
define("a3vb", 10.0);
define("a3vc", 20.0);

// Setting up document
// A4 595x842pts
// 2cm margin: 57pts
// net: 481x728

$giros = $_SESSION['GIROS'];
$dataClasse = $_SESSION['DOCUMENTS']['INVOICE']['DATA'];
unset($_SESSION['DOCUMENTS']['INVOICE']['DATA']);
$grandTotal = 0;
$grandAdvance = 0;
// table body DATA
foreach ($_SESSION['DOCUMENTS']['INVOICE'] as $key => $value) {
 $line1 = array(array('eleve' => $value['NOME'],
   'empty' => 'Qte.',
   'gratuits' => $value[0] + $value[2] + $value[4] + $value[6] + $value[8] + $value[10] + $value[12] + $value[14],
   'a4rbp' => $value[16],
   'a4rcp' => $value[18],
   'a4vbp' => $value[20],
   'a4vcp' => $value[22],
   'a3rbp' => $value[24],
   'a3rcp' => $value[26],
   'a3vbp' => $value[28],
   'a3vcp' => $value[30]));
 $cash = array('gratuis' => '',
  'a4rbp' => sprintf('%.2f', $value[16] * a4rb / 100),
  'a4rcp' => sprintf('%.2f', $value[18] * a4rc / 100),
  'a4vbp' => sprintf('%.2f', $value[20] * a4vb / 100),
  'a4vcp' => sprintf('%.2f', $value[22] * a4vc / 100),
  'a3rbp' => sprintf('%.2f', $value[24] * a3rb / 100),
  'a3rcp' => sprintf('%.2f', $value[26] * a3rc / 100),
  'a3vbp' => sprintf('%.2f', $value[28] * a3vb / 100),
  'a3vcp' => sprintf('%.2f', $value[30] * a3vc / 100),
  'total' => 0);
 $tot = 0;
 foreach ($cash as $euro) {
  $tot+=$euro;
 }
 $cash['total'] = sprintf(" %.2f€ ", $tot);
 $cash['advance'] = sprintf(" %.2f€ ", $value['CREDIT']);
 $cash['pay'] = sprintf(" %.2f€ ", $tot - $value['CREDIT']);
 $grandTotal+=$tot;
 $grandAdvance+=$value['CREDIT'];
 $line2 = array(
  array_merge(
   array('eleve' => $value['PRENOME'], 'empty' => ' € '), $cash));
 if (!isset($lines)) {
  $lines = $line1;
  $lines = array_merge_recursive($lines, $line2);
 } else {

  $lines = array_merge_recursive($lines, $line1);
  $lines = array_merge_recursive($lines, $line2);
 }
}

// Output
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false, false);
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

$pdf->AddPage();
$pdf->SetFont('times', '', 14, '', true);
//entête document
$title = sprintf("Décompte photocopies: %s %s %s", $dataClasse['CODE'], $dataClasse['NOM'], $dataClasse['PRENOM']);
$title.=' du ' . date_format(date_create($dataClasse['START']), 'd-m-Y');
$title.=' au ' . date_format(date_create($dataClasse['END']), 'd-m-Y');
$title.=sprintf(' case:%s', $dataClasse['NOCASE']);
$pdf->MultiCell($w = 0, $h = 0, $title, $border = '', $align = 'C', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
// header table 1st. line
$pdf->SetFont('helvetica', '', 7, '', true);
$pdf->MultiCell($w = 55, $h = 0, "", $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
$pdf->MultiCell($w = 8, $h = 0, "", $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
$pdf->MultiCell($w = 15, $h = 0, "Gratuits", $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
$pdf->MultiCell($w = 72, $h = 0, "Payants", $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
$pdf->MultiCell($w = 36, $h = 0, "", $border = 'TBLR', $align = 'C', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
// header table 2nd. line
$pdf->MultiCell($w = 55, $h = 0, "", $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
$pdf->MultiCell($w = 8, $h = 0, "", $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
$pdf->MultiCell($w = 15, $h = 0, "", $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
$pdf->MultiCell($w = 9, $h = 0, "A4RN", $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
$pdf->MultiCell($w = 9, $h = 0, "A4RC", $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
$pdf->MultiCell($w = 9, $h = 0, "A4VN", $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
$pdf->MultiCell($w = 9, $h = 0, "A4VC", $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
$pdf->MultiCell($w = 9, $h = 0, "A3RN", $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
$pdf->MultiCell($w = 9, $h = 0, "A3RC", $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
$pdf->MultiCell($w = 9, $h = 0, "A3VN", $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
$pdf->MultiCell($w = 9, $h = 0, "A3VC", $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
$pdf->MultiCell($w = 12, $h = 0, "Tot.", $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
$pdf->MultiCell($w = 12, $h = 0, "Acompte", $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
$pdf->MultiCell($w = 12, $h = 0, "A payer", $border = 'TBLR', $align = 'C', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
// table body
$lnnb = 0;
$brd = array(
 'TLR' => array('color' => array(0, 0, 0)),
 'B' => array('color' => array(255, 255, 255)));
foreach ($lines as $line) {
 $pdf->MultiCell($w = 55, $h = 0, $line['eleve'], $brd, $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $brd = array('TLRB' => array('color' => array(0, 0, 0)));
 $pdf->MultiCell($w = 8, $h = 0, $line['empty'], $brd, $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->MultiCell($w = 15, $h = 0, $line['gratuits'], $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->MultiCell($w = 9, $h = 0, $line['a4rbp'], $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->MultiCell($w = 9, $h = 0, $line['a4rcp'], $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->MultiCell($w = 9, $h = 0, $line['a4vbp'], $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->MultiCell($w = 9, $h = 0, $line['a4vcp'], $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->MultiCell($w = 9, $h = 0, $line['a3rbp'], $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->MultiCell($w = 9, $h = 0, $line['a3rcp'], $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->MultiCell($w = 9, $h = 0, $line['a3vbp'], $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->MultiCell($w = 9, $h = 0, $line['a3vcp'], $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->MultiCell($w = 12, $h = 0, $line['total'], $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->MultiCell($w = 12, $h = 0, $line['advance'], $border = 'TBLR', $align = 'C', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->MultiCell($w = 12, $h = 0, $line['pay'], $border = 'TBLR', $align = 'C', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 if ($lnnb == 1) {
  $brd = array(
   'B' => array('color' => array(255, 255, 255)),
   'TLR' => array('color' => array(0, 0, 0))
  );
  $lnnb = 0;
 } else {
  $brd = array(
   'T' => array('color' => array(255, 255, 255)),
   'BLR' => array('color' => array(0, 0, 0))
  );
  $lnnb = 1;
 }
}
//table footer
$pay = $grandTotal - $grandAdvance;
if ($pay >= 0) {
 $msg = "A payer:";
} else {
 $msg = "A rembourser:";
}
$txt = sprintf("Total: %.2f€  Acomptes: %.2f€  %s %.2f€", $grandTotal, $grandAdvance, $msg, abs($pay));
$pdf->SetFont('times', '', 10, '', true);
$pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'R', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
$txt = "Codes: R: recto, V: recto/verso, N: noir/blanc C:couleur";
$pdf->SetFont('times', '', 8, '', true);
$pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'C', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
$pdf->Output($dataClasse['CODE'].'.pdf', 'I');
// $pdf->Output('Accompte.pdf', 'I');
?>
