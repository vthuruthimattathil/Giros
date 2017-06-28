<?php

include_once("../session.php");
include_once('../tcpdf/config/lang/fra.php');
include_once('../tcpdf/tcpdf.php');

function pge(&$pdf, $giros, $no) {
 unset($data);
 $query = "SELECT NOME,PRENOME,CODE,SUIVI_ELEVE.* ";
 $query.="FROM ELEVE LEFT JOIN SUIVI_ELEVE USING(IAM) ";
 $query.=sprintf("WHERE SUIVI_ELEVE.NOPORTFOLIO='%s'", $no);
 $giros->sqlQuery($query);
 if (!$row = $giros->sqlData()) {
  $pdf->AddPage();
  $margins = $pdf->getMargins();
  $pdf->SetFont('times', 'B', 14, '', true);
  $txt = "Pas de portfolio avec cet identifiant: " . $no;
  $pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
 } else {
  $pdf->AddPage();
  $margins = $pdf->getMargins();
  $pdf->SetFont('times', 'B', 16, '', true);
  $txt = sprintf("Suivi de %s %s (%s/%s)", $row['PRENOME'], $row['NOME'], $row['SCOLAIRE'], $row['SCOLAIRE'] + 1);
  $pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
  $pdf->SetFont('times', 'B', 12, '', true);
// Inscriptions dans le llivre de classe
  $pdf->Write(0, "Inscriptions dans le livre de classe: ", '', 0, 'L', false, 0, false, false, 0);
  $pdf->SetFont('times', '', 12, '', true);
  $pdf->Write(0, $row['INSCRIPTIONS_NB'], '', 0, 'L', true, 0, false, false, 0);
  if (strlen(trim($row['INSCRIPTIONS_REM'])) != 0) {
   $pdf->Write(0, $row['INSCRIPTIONS_REM'] . "\n", '', 0, 'J', true, 0, false, false, 0);
  }

// Retenues
  $tot = 0;
  $tot+=$row['RET_BAGARRE'];
  $tot+=$row['RET_RETARDS'];
  $tot+=$row['RET_ABS'];
  $tot+=$row['RET_CONF'];
  $tot+=$row['RET_COMPORTEMENT'];
  $tot+=$row['RET_FRAUDE'];
  $tot+=$row['RET_INSOLENCE'];
  $tot+=$row['RET_TABAGISME'];
  $tot+=$row['RET_REFUS_PUNITION'];
  $tot+=$row['RET_MENSONGES'];
  $tot+=$row['RET_INSULTES'];
  $tot+=$row['RET_OUBLIS'];
  $tot+=$row['RET_AUTRES'];
  $pdf->setY($pdf->getY() + 5, true);
  if ($tot == 0) {
   $pdf->SetFont('times', 'B', 12, '', true);
   $txt = "Pas de retenue.\n";
   $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'J', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->SetFont('times', '', 12, '', true);
  } else {
   $pdf->SetFont('times', 'B', 12, '', true);
   $pdf->Write(0, "Nombre total de retenues: ", '', 0, 'L', false, 0, false, false, 0);
   $pdf->SetFont('times', '', 12, '', true);
   $pdf->Write(0, $tot, '', 0, 'L', true, 0, false, false, 0);
  }
  $maxcols = 2;
  $ln = 0;
  $col = 0;
  $border = "";
  $tbl = false;
  if ($row['RET_BAGARRE'] != 0) {
   $pdf->MultiCell(70, $h = 0, "Bagarre:", $border, $align = 'L', $fill = false, 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell(10, $h = 0, $row['RET_BAGARRE'], $border, $align = 'R', $fill = false, 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell(10, $h = 0, "", $border, $align = 'L', $fill = false, $ln, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $ln = ($ln + 1) % 2;
   $tbl = true;
  }
  if ($row['RET_RETARDS'] != 0) {
   $pdf->MultiCell(70, $h = 0, "Retards fréquents:", $border, $align = 'L', $fill = false, 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell(10, $h = 0, $row['RET_RETARDS'], $border, $align = 'R', $fill = false, 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell(10, $h = 0, "", $border, $align = 'L', $fill = false, $ln, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $ln = ($ln + 1) % 2;
   $tbl = true;
  }
  if ($row['RET_ABS'] != 0) {
   $pdf->MultiCell(70, $h = 0, "Absences non excusées:", $border, $align = 'L', $fill = false, 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell(10, $h = 0, $row['RET_ABS'], $border, $align = 'R', $fill = false, 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell(10, $h = 0, "", $border, $align = 'L', $fill = false, $ln, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $ln = ($ln + 1) % 2;
   $tbl = true;
  }
  if ($row['RET_CONF'] != 0) {
   $pdf->MultiCell(70, $h = 0, "Abus de confiance:", $border, $align = 'L', $fill = false, 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell(10, $h = 0, $row['RET_CONF'], $border, $align = 'R', $fill = false, 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell(10, $h = 0, "", $border, $align = 'L', $fill = false, $ln, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $ln = ($ln + 1) % 2;
   $tbl = true;
  }
  if ($row['RET_COMPORTEMENT'] != 0) {
   $pdf->MultiCell(70, $h = 0, "Comportement inadmissible:", $border, $align = 'L', $fill = false, 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell(10, $h = 0, $row['RET_COMPORTEMENT'], $border, $align = 'R', $fill = false, 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell(10, $h = 0, "", $border, $align = 'L', $fill = false, $ln, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $ln = ($ln + 1) % 2;
   $tbl = true;
  }
  if ($row['RET_FRAUDE'] != 0) {
   $pdf->MultiCell(70, $h = 0, "Fraude:", $border, $align = 'L', $fill = false, 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell(10, $h = 0, $row['RET_FRAUDE'], $border, $align = 'R', $fill = false, 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell(10, $h = 0, "", $border, $align = 'L', $fill = false, $ln, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $ln = ($ln + 1) % 2;
   $tbl = true;
  }
  if ($row['RET_INSOLENCE'] != 0) {
   $pdf->MultiCell(70, $h = 0, "Insolence:", $border, $align = 'L', $fill = false, 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell(10, $h = 0, $row['RET_INSOLENCE'], $border, $align = 'R', $fill = false, 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell(10, $h = 0, "", $border, $align = 'L', $fill = false, $ln, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $ln = ($ln + 1) % 2;
   $tbl = true;
  }
  if ($row['RET_TABAGISME'] != 0) {
   $pdf->MultiCell(70, $h = 0, "Tabagisme:", $border, $align = 'L', $fill = false, 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell(10, $h = 0, $row['RET_TABAGISME'], $border, $align = 'R', $fill = false, 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell(10, $h = 0, "", $border, $align = 'L', $fill = false, $ln, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $ln = ($ln + 1) % 2;
   $tbl = true;
  }
  if ($row['RET_REFUS_PUNITION'] != 0) {
   $pdf->MultiCell(70, $h = 0, "Refus d'écrire sa punition:", $border, $align = 'L', $fill = false, 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell(10, $h = 0, $row['RET_REFUS_PUNITION'], $border, $align = 'R', $fill = false, 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell(10, $h = 0, "", $border, $align = 'L', $fill = false, $ln, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $ln = ($ln + 1) % 2;
   $tbl = true;
  }
  if ($row['RET_MENSONGES'] != 0) {
   $pdf->MultiCell(70, $h = 0, "Mensonges:", $border, $align = 'L', $fill = false, 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell(10, $h = 0, $row['RET_MENSONGES'], $border, $align = 'R', $fill = false, 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell(10, $h = 0, "", $border, $align = 'L', $fill = false, $ln, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $ln = ($ln + 1) % 2;
   $tbl = true;
  }
  if ($row['RET_INSULTES'] != 0) {
   $pdf->MultiCell(70, $h = 0, "Insultes:", $border, $align = 'L', $fill = false, 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell(10, $h = 0, $row['RET_INSULTES'], $border, $align = 'R', $fill = false, 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell(10, $h = 0, "", $border, $align = 'L', $fill = false, $ln, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $ln = ($ln + 1) % 2;
   $tbl = true;
  }
  if ($row['RET_OUBLIS'] != 0) {
   $pdf->MultiCell(70, $h = 0, "Oublis:", $border, $align = 'L', $fill = false, 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell(10, $h = 0, $row['RET_OUBLIS'], $border, $align = 'R', $fill = false, 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell(10, $h = 0, "", $border, $align = 'L', $fill = false, $ln, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $ln = ($ln + 1) % 2;
   $tbl = true;
  }
  if ($row['RET_AUTRES'] != 0) {
   $pdf->MultiCell(70, $h = 0, "Autres motifs:", $border, $align = 'L', $fill = false, 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell(10, $h = 0, $row['RET_AUTRES'], $border, $align = 'R', $fill = false, 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell(10, $h = 0, "", $border, $align = 'L', $fill = false, $ln, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $ln = ($ln + 1) % 2;
   $tbl = true;
  }
  if ($tbl) {
   $pdf->setY($pdf->getY() + 8, true);
  }

// Conseils de classe
  $pdf->setY($pdf->getY() + 5, true);
  if ($row['CONSEIL_NB'] == 0) {
   $pdf->SetFont('times', 'B', 12, '', true);
   $pdf->MultiCell($w = 0, $h = 0, "Pas de conseil.\n", $border = '', $align = 'J', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->SetFont('times', '', 12, '', true);
  } else {
   $pdf->SetFont('times', 'B', 12, '', true);
   $pdf->Write(0, "Nombre de conseils en classe: ", '', 0, 'L', false, 0, false, false, 0);
   $pdf->SetFont('times', '', 12, '', true);
   $pdf->Write(0, $row['CONSEIL_NB'], '', 0, 'L', true, 0, false, false, 0);
   $conseil_rem = trim($row['CONSEIL_REM']);
   if (!empty($conseil_rem)) {
    $pdf->MultiCell($w = 0, $h = 0, $conseil_rem . "\n", $border = '', $align = 'J', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   }
  }

  // Absences
  $pdf->setY($pdf->getY() + 5, true);
  $absExc = $row['ABS_EXC'] * 1;
  $absExcMed = $row['ABS_EXC_MED'] * 1;
  $absNExc = $row['ABS_NON_EXC'] * 1;
  $absRem = trim($row['ABS_REM']);
  if (($absExc + $absExcMed + $absNExc) == 0) {
   $pdf->SetFont('times', 'B', 12, '', true);
   $pdf->MultiCell($w = 0, $h = 0, "Pas d'absences.\n", $border = '', $align = 'J', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->SetFont('times', '', 12, '', true);
  } else {
   $pdf->SetFont('times', 'B', 12, '', true);
   $pdf->Write(0, "Nombre total d'absences: ", '', 0, 'L', false, 0, false, false, 0);
   $pdf->SetFont('times', '', 12, '', true);
   $pdf->Write(0, $absExc + $absExcMed + $absNExc, '', 0, 'L', true, 0, false, false, 0);
   $txt = sprintf("Excusées: %d", $absExc);
   $pdf->MultiCell($w = 50, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $txt = sprintf("Certificat médical: %d", $absExcMed);
   $pdf->MultiCell($w = 50, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $txt = sprintf("Non-excusées:%d", $absNExc);
   $pdf->MultiCell($w = 50, $h = 0, $txt, $border = '', $align = 'L', $fill = false, 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
  }
  if (strlen($absRem) != 0) {
   $pdf->MultiCell($w = 0, $h = 0, $absRem . "\n", $border = '', $align = 'J', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
  }

  /* mosaik
   * 1: résultats insuffisants
   * 2: absences nombreuses
   * 4: retards fréquents
   * 8: oublis affaires scolaires
   * 16: oublis devoirs à domicile
   * 32: démotivation
   * 64: agressivité
   * 128: comportement problématique
   * 256: apathie
   * 512: autres
   */

  $pdf->setY($pdf->getY() + 5, true);
  if ($row['MOSAIK'] == 0) {
   $pdf->SetFont('times', 'B', 12, '', true);
   $pdf->MultiCell($w = 0, $h = 0, "Pas de classe Mosaik.\n", $border = '', $align = 'J', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->SetFont('times', 'B', 12, '', true);
  } else {
   $code = $row['MOSAIK'];
   $pdf->SetFont('times', 'B', 12, '', true);
   $pdf->Write(0, "Classe Mosaik:", '', 0, 'L', true, 0, false, false, 0);
   $pdf->SetFont('times', '', 12, '', true);
   $motifs = array('résultats insuffisants', 'absences nombreuses', 'retards fréquents', 'oublis affaires scolaires', 'oublis devoirs à domicile', 'démotivation', 'agressivité', 'comportement problématique', 'apathie', 'autres');
   $index = 9;
   $txt = "#";
   while ($index >= 0) {
    if ($code >= pow(2, $index)) {
     $code-=pow(2, $index);
     $txt = " " . $motifs[$index] . "," . $txt;
    }
    $index--;
   }
   $txt = trim(str_replace(",#", ".", $txt));
   $pdf->MultiCell($w = 0, $h = 0, $txt . "\n", $border = '', $align = 'J', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
  }

  // Pitstop
  $pdf->setY($pdf->getY() + 5, true);
  $pitInsultes = $row['PIT_INSULTES'] * 1;
  $pitDisputes = $row['PIT_DISPUTES'] * 1;
  $pitRefusTravail = $row['PIT_REFUS_TRAVAIL'] * 1;
  $pitJet = $row['PIT_JET'] * 1;
  $pitComportement = $row['PIT_COMPORTEMENT'] * 1;
  $pitAutre = $row['PIT_AUTRE'] * 1;
  $pitRem = trim($row['PIT_REM']);
  if (($pitInsultes + $pitDisputes + $pitRefusTravail + $pitJet + $pitComportement + $pitAutre) == 0) {
   $pdf->SetFont('times', 'B', 12, '', true);
   $pdf->MultiCell($w = 0, $h = 0, "Pas d'intervention Pitstop.\n", $border = '', $align = 'J', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->SetFont('times', '', 12, '', true);
  } else {
   $pdf->SetFont('times', 'B', 12, '', true);
   $pdf->Write(0, "Nombre d'interventions Pitstop: ", '', 0, 'L', false, 0, false, false, 0);
   $pdf->SetFont('times', '', 12, '', true);
   $pdf->Write(0, $pitInsultes + $pitDisputes + $pitRefusTravail + $pitJet + $pitComportement + $pitAutre, '', 0, 'L', true, 0, false, false, 0);
   $txt = sprintf("Insultes: %d", $pitInsultes);
   $pdf->MultiCell($w = 50, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $txt = sprintf("Disputes: %d", $pitDisputes);
   $pdf->MultiCell($w = 50, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $txt = sprintf("Refus de travail: %d", $pitRefusTravail);
   $pdf->MultiCell($w = 50, $h = 0, $txt, $border = '', $align = 'L', $fill = false, 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $txt = sprintf("Jet: %d", $pitJet);
   $pdf->MultiCell($w = 50, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $txt = sprintf("Comportement: %d", $pitComportement);
   $pdf->MultiCell($w = 50, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $txt = sprintf("Autre: %d", $pitAutre);
   $pdf->MultiCell($w = 50, $h = 0, $txt . "\n", $border = '', $align = 'L', $fill = false, 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
  }
  if (strlen($pitRem) != 0) {
   $pdf->MultiCell($w = 0, $h = 0, $pitRem . "\n", $border = '', $align = 'J', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
  }

  // orientation
  $pdf->setY($pdf->getY() + 5, true);
  $orient = trim($row['ORIENTATION']);
  if (strlen($orient) != 0) {
   $pdf->SetFont('times', 'B', 12, '', true);
   $pdf->Write(0, "Orientation: ", '', 0, 'L', false, 0, false, false, 0);
   $pdf->SetFont('times', '', 12, '', true);
   $pdf->Write(0, $orient, '', 0, 'L', true, 0, false, false, 0);
  }
  // stages
  $pdf->setY($pdf->getY() + 5, true);
  $query = "SELECT *, DATE_FORMAT(PERIODE,\"%m-%Y\") AS PERIODE_F FROM SUIVI_ELEVE_STAGE";
  $query.=sprintf(" WHERE NOPORTFOLIO='%s' ORDER BY PERIODE", $no);
  $giros->sqlQuery($query);
  if ($giros->sqlNumRows() != 0) {
   $pdf->SetFont('times', 'B', 12, '', true);
   $pdf->Write(0, "Stages: ", '', 0, 'L', true, 0, false, false, 0);
   $pdf->SetFont('times', '', 12, '', true);
   while ($stage = $giros->sqlData()) {
    $txt = sprintf("%s en: %s", $stage['ENTREPRISE'], $stage['PERIODE_F']);
    $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
    $pdf->MultiCell($w = 0, $h = 0, $stage['TRAVAIL'], $border = '', $align = 'L', $fill = false, $ln = 1, $x = 12 + 10, $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   }
  }
//remarques
  $pdf->setY($pdf->getY() + 5, true);
  $rem = trim($row['REMARQUES']);
  if (strlen($rem) != 0) {
   $pdf->SetFont('times', 'B', 12, '', true);
   $pdf->Write(0, "Remarques: ", '', 0, 'L', true, 0, false, false, 0);
   $pdf->SetFont('times', '', 12, '', true);
   $pdf->MultiCell($w = 0, $h = 0, $rem."\n", $border = '', $align = 'J', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
  }
 }
}

$giros = $_SESSION['GIROS'];
$giros->sqlConnect();
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false, false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($giros->getUntis());
$pdf->SetTitle('Portfolo');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(20, 20, 20);
$pdf->SetAutoPageBreak(TRUE, 12);
$pdf->setLanguageArray($l);
$pdf->setFontSubsetting(true);
foreach ($_SESSION['FOLLOWUP'] as $id) {
 pge($pdf, $giros, $id);
}
$pdf->Output('Portfolio.pdf', 'I');
?>
