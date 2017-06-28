<?php

include_once("../session.php");
include_once('../tcpdf/config/lang/fra.php');
include_once('../tcpdf/tcpdf.php');
$giros = $_SESSION['GIROS'];

function pge(&$pdf, $giros, $id) {
 $query = "SELECT NAME,DATE_FORMAT(DATE,'%d.%m.%Y  à %H:%i') AS DATE_F,DATE_FORMAT(DELAI,'%d.%m.%Y') AS DELAI_F,";
 $query.="TYPE,COULEUR,REMARQUE,DONE,NOM,PRENOM,NOCASE,PAGES ";
 $query.="FROM COMMANDE LEFT JOIN PROF USING(UNTIS) ";
 $query.="WHERE NOCOMMANDE=\"$id\"";
 $giros->sqlQuery($query);
 $row = $giros->sqlData();
 $case = "Case: " . $row['NOCASE'];
 $titulaire = sprintf("%s %s", $row['NOM'], $row['PRENOM']);
 $remise = $row['DATE_F'];
 $delai = $row['DELAI_F'];
 $couleur = trim($row['COULEUR']);
 $nom = $row['NAME'];
 if (($row['TYPE'] & 2) == 0) {
  $options = 'Copie N/B ';
 } else {
  $options = 'Copie couleur ';
 }
 if (($row['TYPE'] & 4) == 0) {
  $options.="\t R ";
 } else {
  $options.="\t R/V ";
 }
 if (($row['TYPE'] & 8) == 0) {
  $options.="\t A4 ";
 } else {
  $options.="\t A3 ";
 }
 if (($row['TYPE'] & 16) == 0) {
  $options.="\t Gratuit ";
 } else {
  $options.="\t payant ";
 }
 if (($row['TYPE'] & 32) != 0) {
  $options.="\t trié ";
 }
 if (($row['TYPE'] & 64) != 0) {
  $options.="\t perforé ";
 }
 if (($row['TYPE'] & 128) != 0) {
  $options.="\t agraffé ";
 }
 if (($row['TYPE'] & 256) != 0) {
  $options.="\t copie personnelle ";
 }
 if (($row['TYPE'] & 512) != 0) {
  $options.="\t transparents ";
 }
 $rem = $row['REMARQUE'];
 $query = sprintf("SELECT NOME,PRENOME,CODE FROM COMMANDE_ELEVE LEFT JOIN ELEVE USING(IAM)WHERE NOCOMMANDE=\"%s\" ORDER BY CODE,NOME,PRENOME", $id);
 $giros->sqlQuery($query);
 $qte = $giros->sqlNumRows();
 while ($row = $giros->sqlData()) {
  $ele[] = sprintf("%s %s %s", $row['CODE'], $row['NOME'], $row['PRENOME']);
 }

// Generate PDF
 $pdf->AddPage();
 $pdf->SetFont('times', 'B', 16, '', true);
 // Entête lycée
 $pdf->setJPEGQuality(75);
 $pdf->Image('../logo.jpg', 12, 12, 70, 0, 'jpeg', '', 'N', true);
 // Case
 $pdf->MultiCell(0, 0, $case, $border = '', $align = 'L', $fill = false, $ln = 1, $x = 125, $y = 40, $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 // Titulaire
 $pdf->SetFont('times', '', 12, '', true);
 $pdf->MultiCell(50, 0, 'Titulaire:', $border = '', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->MultiCell(0, 0, $titulaire, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 // Remise
 $pdf->MultiCell(50, 0, 'Remis le:', $border = '', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->MultiCell(0, 0, $remise, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
// Delai
 $pdf->MultiCell(50, 0, 'Delai demandé:', $border = '', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->MultiCell(0, 0, $delai, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
// Clouleur papier
 $pdf->MultiCell(50, 0, 'Couleur papier:', $border = '', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->MultiCell(0, 0, $couleur, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
// Nom document
 $pdf->MultiCell(50, 0, 'Nom du document:', $border = '', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->MultiCell(0, 0, $nom, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
// options
 $pdf->MultiCell(0, 0, $options, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
// remarque
 $pdf->MultiCell(50, 0, 'Remarque:', $border = '', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->MultiCell(0, 0, $rem, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
// Nombre de copies
 $pdf->MultiCell(50, 0, 'Nombre de copies:', $border = '', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->MultiCell(0, 0, $qte, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
// Eleves concernés
 $pdf->SetY($pdf->GetY() + 10);
 if (isset($ele)) {
  $pdf->MultiCell(0, 0, 'Elèves concernés:', $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
  $pdf->SetFont('times', '', 12, '', true);
  $ln = 0;
  foreach ($ele as $value) {
   $pdf->MultiCell(90, 0, $value, $border = '', $align = 'L', $fill = false, $ln, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $ln = ($ln + 1) % 2;
  }
 } else { // copie privée
  $pdf->SetFont('times', '', 12, '', true);
  $pdf->MultiCell(0, 0, $prive, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 }
}

$giros->sqlConnect();
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false, false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($giros->getUntis());
$pdf->SetTitle('Bon');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(12, 12, 12);
$pdf->SetAutoPageBreak(TRUE, 12);
$pdf->setLanguageArray($l);
$pdf->setFontSubsetting(true);
pge($pdf, $giros, $_GET['id']);
$pdf->Output('Bon.pdf', 'I');
?>