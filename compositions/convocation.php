<?php

include_once("../session.php");

include_once '../tcpdf/config/lang/fra.php';
include_once '../tcpdf/tcpdf.php';
include_once 'convocationFct.php';

function pge(&$pdf, $nodevoir) {
 $pdf->AddPage();
 $pdf->SetFont('times', '', 12, '', true);
 // get informations
 $giros = $_SESSION['GIROS'];
 $giros->sqlConnect();
 $query = "SELECT DEVOIR.*,ELEVE.*,PROF.NOM,PROF.PRENOM,DATESD.* FROM DEVOIR LEFT JOIN ELEVE USING(IAM) LEFT JOIN DATESD USING(NODATED) LEFT JOIN PROF USING(UNTIS)";
 $query.=sprintf(" WHERE NODEVOIR ='%s'", $nodevoir);
 $giros->sqlQuery($query);
 $row = $giros->sqlData();
 // DateI
 $temp = explode(' ', $row['DATEI']);
 $temp = explode('-', $temp[0]);
 $dateI = $temp[2] . ' ' . txtmonth($temp[1]) . ' ' . $temp[0];
 // DateC
 $temp = explode(' ', $row['DATEC']);
 $temp = explode('-', $temp[0]);
 $dateC = $temp[2] . ' ' . txtmonth($temp[1]) . ' ' . $temp[0];
 // Sexe - accords
 if ($row['SEXE'] == 'F') {
  $accord = 'e';
  $sexe = 'fille';
  $sujet = 'Elle';
  $sujet2 = 'elle';
 } else {
  $accord = '';
  $sexe = 'fils';
  $sujet = 'Il';
  $sujet2 = 'il';
 }
 // Nom & prenom 
 $nomE = stripslashes($row['NOME'] . ' ' . $row['PRENOME']);
 //classe
 $classe = stripslashes($row['CODE']);
 //civilite
 $civilite = stripslashes($row['CIVILITE'] . ',');
 //Dated
 $temp = explode(' ', $row['DATED']);
 $tempD = explode('-', $temp[0]);
 $dateD = $tempD[2] . ' ' . txtmonth($tempD[1]) . ' ' . $tempD[0];
 $tempT = explode(':', $temp[1]);
 $dateDT = $tempT[0] . ':' . $tempT[1];
// Branche
 $branche = $row['BRANCHE'];
// Salle
 $salle = $row['SALLE'];
// titulaire
 $titulaire = $row['NOM'] . ' ' . $row['PRENOM'];
// Entête lycée
 $pdf->setJPEGQuality(75);
 $pdf->Image('../logo.jpg', 12, 12, 70, 0, 'jpeg', '', 'N', true);
 // Tic
 $pdf->Line(0, 100, 10, 100);
 // Adresse Tuteur
 $txt = stripslashes($row['CIVILITE'] . "\n" . $row['PRENOMT'] . " " . $row['NOMT'] . "\n" . $row['RUE'] . "\n" . $row['CP'] . " " . $row['LOCALITE']);
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '107', $y = '38', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
// Date
 $pdf->setXY(107, 75);
 if ($giros->getSite() == 'L') {
  $pdf->Write($h = 0, 'Lamadelaine, le ' . $dateI, $link = '', $fill = false, $align = 'L', $ln = 1, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
 } else {
  $pdf->Write($h = 0, 'Differdange, le ' . $dateI, $link = '', $fill = false, $align = 'L', $ln = 1, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
 }
 // Titre
 $pdf->setY(93);
 $pdf->Write($h = 0, $civilite, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
 // 1. alignea
 $txt = sprintf("Par la présente je vous informe que l'élève %s de la classe %s, n'a pas participé au devoir en classe en %s annoncé pour le %s.", $nomE, $classe, $branche, $dateC);
 $pdf->SetY($pdf->GetY() + 5);
 $pdf->Write($h = 0, $txt . "\n", $link = '', $fill = false, $align = 'J', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
 // 2. alignea
 $txt = sprintf(("Afin d'être évalué%s pour la matière imposée pour ce devoir, %s est convoqué%s à se soumettre à un devoir de repêchage le %s à %s heures dans la salle %s."), $accord, $nomE, $accord, $dateD, $dateDT, $salle);
 $txt.=sprintf(" %s devra s'identifier moyennant sa carte d'élève.", $sujet);
 $pdf->SetY($pdf->GetY() + 5);
 $pdf->Write($h = 0, $txt . "\n", $link = '', $fill = false, $align = 'J', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
// Dispo reg.
 $txt = sprintf("Selon des dispositions réglementaires de l'instruction ministérielle du 6 juin 2008, une note de 01 points sera attribuée à votre %s pour ce devoir au cas où %s serait absent%s sans raison valable attestée par certificat médical ou certificat administratif, la direction du LTMA se réservant le droit de statuer sur le bien-fondé de l'absence.", $sexe, $sujet2, $accord);
 $pdf->SetY($pdf->GetY() + 5);
 $pdf->Write($h = 0, $txt . "\n", $link = '', $fill = false, $align = 'J', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
 $pdf->SetY($pdf->GetY() + 5);
 $txt = sprintf("Veuillez agréer, %s, mes salutations distinguées.", $row['CIVILITE']);
 $pdf->Write($h = 0, $txt . "\n", $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
// Signatures
 $txt = "Visa du directeur";
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 0, $x = '', $y = 190, $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $txt = "Titulaire de la branche\n" . $titulaire;
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = 105, $y = 190, $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $style = array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
 $pdf->Line(25, 220, 85, 220, $style);
 $pdf->Line(105, 220, 165, 220, $style);
 $txt = "P.S.:";
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 0, $x = '', $y = 240, $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $txt = "aucune dispense ne pourra être accordée ni pour un rendez-vous médical pris pendant les heures prévues pour le devoir de repêchage ni pour un rendez-vous pris dans le cadre de l'obtention du permis de conduire ou toute autre activité privée.";
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = 35, $y = 240, $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 if ($row['TYPE'] == 1) {
  $txt = sprintf("si l'élève termine son devoir plus tôt que prévu, %s pourra rentrer à la maison.", $sujet2);
  $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = 35, $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 }
}

$giros = $_SESSION['GIROS'];
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false, false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($giros->getUntis());
$pdf->SetTitle('Lettre composition');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(25, 25, 25);
$pdf->SetAutoPageBreak(TRUE, 25);
$pdf->setLanguageArray($l);
$pdf->setFontSubsetting(true);
foreach ($_SESSION['COMPOSITION']['DATA'] as $nocomposition) {
 pge($pdf, $nocomposition);
}
$pdf->Output('Lettre.pdf', 'I');
unset($_SESSION['COMPOSITION']);
?>
