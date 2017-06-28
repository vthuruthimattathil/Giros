<?php

include_once 'c_desiderata.php';

include_once '../tcpdf/config/lang/fra.php';
include_once '../tcpdf/tcpdf.php';

function desiderataPDF($untis, $site, $cname, $name, $filename = "") {
 $des = new c_desiderata($untis, $site);
 header('Content-type: application/pdf');
 header('Content-Disposition: attachment; filename="desiderata.pdf"');

 $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false, false);
 $pdf->SetCreator(PDF_CREATOR);
 $pdf->SetAuthor($untis);
 $pdf->SetTitle('Desidérata');
 $pdf->setPrintHeader(false);
 $pdf->setPrintFooter(false);
 $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 $pdf->SetMargins(20, 20, 20);
 $pdf->SetAutoPageBreak(TRUE, 20);
 $pdf->setLanguageArray($l);
 $pdf->setFontSubsetting(true);
 $pdf->AddPage();
 $pdf->SetFont('times', '', 14, 'B', true);

// Entête lycée
 $pdf->setJPEGQuality(75);
 $pdf->Image('../logo.jpg', 12, 12, 70, 0, 'jpeg', '', 'N', true);

//Généralités
 $txt = sprintf("Desidérata de: %s %s\n", $name, $cname);
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '90', $y = '25', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->SetFont('times', '', 12, '', true);
 if ($des->getDonnespers() == 'T') {
  $txt = "Les données sont correctes\n";
 } else {
  $txt = "Les données sont fausses\n";
 }
 $txt.=sprintf("Téléphone: %s GSM: %s\n", $des->getTelephone(), $des->getGsm());
 $dispo1 = explode('-', $des->getDispo1());
 $dispo2 = explode('-', $des->getDispo2());
 $txt.=sprintf("Absent du: %s/%s/%s au %s/%s/%s\n", $dispo1[2], $dispo1[1], $dispo1[0], $dispo2[2], $dispo2[1], $dispo2[0]);
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '35', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $txt = sprintf("Spécialité: %s", $des->getSpecialites());
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $txt = sprintf("Autres branches: %s", $des->getBranches());
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);

//Tâche
 $tache = $des->getTache();
 switch ($tache) {
  case 1: $txt = "Tâche: Enseignant(e) nommé(e) 100%";
   break;
  case 0.75: $txt = "Tâche: Enseignant(e) nommé(e) 75%";
   break;
  case 0.5: $txt = "Tâche: Enseignant(e) nommé(e) 50%";
   break;
  case 0.25: $txt = "Tâche: Enseignant(e) nommé(e) 25%";
   break;
 }
 if ($tache > 30) {
  $txt = sprintf("Tâche: Stagiaire: %u", ($tache - 30));
 }
 if (($tache > 1) && ($tache < 29)) {
  $txt = sprintf("Tâche: Chargé(e): %u", ($tache - 0));
 }
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);

// Recrutement
 if ($des->getRecrutement() == 'T') {
  $txt = "Inscription au concours: OUI";
 } else {
  $txt = "Inscription au concours: NON";
 }
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);

// Congé
 switch ($des->getConge()) {
  case 'aucun': $txt = "Pas de congé";
   break;
  case 'mi': $txt = sprintf("congé mi-temps jusqu'à la rentrée: 20%u", $des->getCo_duree());
   break;
  case '3/4': $txt = sprintf("congé 3/4 temps jusqu'à la rentrée: 20%u", $des->getCo_duree());
   break;
  case 'pmi': $txt = sprintf("congé parental mi-temps jusqu'à la rentrée: 20%u", $des->getCo_duree());
   break;
  case 'ppt': $txt = sprintf("congé parental temps plein jusqu'à la rentrée: 20%u", $des->getCo_duree());
   break;
  case 'ss': $txt = sprintf("congé sans solde jusqu'à la rentrée: ", $des->getCo_duree());
   break;
 }
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);

 $pdf->Line(20, $pdf->GetY() + 2, $pdf->getPageWidth() - 20, $pdf->GetY() + 2, array('width' => 0.25, 'cap' => "round", "join" => "miter", "dash" => 0, "phase" => 0, "color" => array(0, 0, 0)));
 $pdf->SetY($pdf->GetY() + 3);

// Décharges
 $pdf->SetFont('times', '', 14, '', true);
 $yd = $pdf->GetY();
 $pdf->MultiCell($w = 0, $h = 0, "Décharges:", $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $xd = $pdf->GetX() + $pdf->GetStringWidth("Décharges:") + 5;
 $pdf->SetFont('times', '', 12, '', true);
 $dech = $des->getDecharge(-1);
 $totDech = 0;
 if (count($dech) == 0) {
  $pdf->MultiCell($w = 0, $h = 0, "Pas de décharges:", $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 } else {
  foreach ($dech as $key => $value) {
   if ($value['departement'] == '') {
    $txt = sprintf("%s: %u", $value['designation'], $value['nombre']);
    $totDech+=$value['nombre'];
   } else {
    $txt = sprintf("%s: %u %s", $value['designation'], $value['nombre'], $value['departement']);
    ++$totDech;
   }
   $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
  }
 }
 if (($des->getRegence1() != '-') || ($des->getRegence2() != '-')) {
  $totDech++;
  $txt = "REGEN: 1";
  $pdf->MultiCell($w = 22, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 }
 $xn = $pdf->GetX();
 $yn = $pdf->GetY();
 $txt = sprintf("Total: %u", $totDech);
 $pdf->SetXY($xd, $yd);
 $pdf->SetFont('times', '', 14, '', true);
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->SetFont('times', '', 12, '', true);
 $pdf->SetXY($xn, $yn);

 $pdf->Line(20, $pdf->GetY() + 2, $pdf->getPageWidth() - 20, $pdf->GetY() + 2, array('width' => 0.25, 'cap' => "round", "join" => "miter", "dash" => 0, "phase" => 0, "color" => array(0, 0, 0)));
 $pdf->SetY($yn + 3);

// Branches
 $pdf->SetFont('times', '', 14, '', true);
 $yd = $pdf->GetY();
 $pdf->MultiCell($w = 0, $h = 0, "Branches:", $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $xd = $pdf->GetX() + $pdf->GetStringWidth("Branches:") + 5;
 $pdf->SetFont('times', '', 12, '', true);
 $choix = $des->getChoix(-1);
 $totChoix = 0.0;
 if (count($choix) == 0) {
  $pdf->MultiCell($w = 0, $h = 0, "Pas de décharges:", $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 } else {
  $pdf->MultiCell($w = 22, $h = 0, "Nb. leçons", $border = 'TBRL', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
  $pdf->MultiCell($w = 36, $h = 0, "Branche", $border = 'TBRL', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
  $pdf->MultiCell($w = 30, $h = 0, "Classe", $border = 'TBRL', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
  $pdf->MultiCell($w = 40, $h = 0, "Salle", $border = 'TBRL', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
  $pdf->MultiCell($w = 20, $h = 0, "Nb. blocs", $border = 'TBRL', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
  $pdf->MultiCell($w = 22, $h = 0, "Durée bloc", $border = 'TBRL', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
  foreach ($choix as $key => $value) {
   $pdf->MultiCell($w = 22, $h = 0, $value['number'], $border = 'TBRL', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell($w = 36, $h = 0, $value['code_branche'], $border = 'TBRL', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $pdf->MultiCell($w = 30, $h = 0, $value['classe'], $border = 'TBRL', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   if ($value['salle'] != '0') {
    $txt = $value['salle'];
   } else {
    $txt = "";
   }
   $pdf->MultiCell($w = 40, $h = 0, $txt, $border = 'TBRL', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   if ($value['nb_blocs'] != 0) {
    $txt = $value['nb_blocs'];
   } else {

    $txt = "";
   }
   $pdf->MultiCell($w = 20, $h = 0, $txt, $border = 'TBRL', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   if ($value['duree'] != 0) {
    $txt = $value['duree'];
   } else {

    $txt = "";
   }
   $pdf->MultiCell($w = 22, $h = 0, $txt, $border = 'TBRL', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
   $totChoix+=$value['number'];
  }
  $xn = $pdf->GetX();
  $yn = $pdf->GetY();
  $txt = sprintf("Total: %.1f", $totChoix);
  $pdf->SetXY($xd, $yd);
  $pdf->SetFont('times', '', 14, '', true);
  $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
  $pdf->SetFont('times', '', 12, '', true);
  $pdf->SetXY($xn, $yn);
 }
 if (strlen(trim($des->getRem_branches())) != 0) {
  $txt = sprintf("Remarques: %s", $des->getRem_branches());
  $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 }
 $txt = sprintf("Total des décharges: %.1f Nombre total des leçons: %.1f Grand total:%.1f", $totDech, $totChoix, $totDech + $totChoix);
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 $pdf->Line(20, $pdf->GetY() + 2, $pdf->getPageWidth() - 20, $pdf->GetY() + 2, array('width' => 0.25, 'cap' => "round", "join" => "miter", "dash" => 0, "phase" => 0, "color" => array(0, 0, 0)));
 $pdf->SetY($pdf->GetY() + 3);
 if (($des->getRegence1() == '-') && ($des->getRegence2() == '-')) {
  $txt = 'Pas de régence demandée.';
 } else {
  $txt = sprintf("Régence: choix1: %s choix2: %s", $des->getRegence1(), $des->getRegence2());
 }
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);

// Divers
//Rattrapage
 if ($des->getRattrapage() != '0') {
  $txt = sprintf("Rattrapage en: %s", $des->getRattrapage());
 } else {
  $txt = "Pas de rattrapage demandé.";
 }
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);

// Surveillance 
 if ($des->getSurveillance() == '0') {
  $txt = 'Pas de surveillance.';
 } else {
  $txt = sprintf("Nombre de leçon(s) hebdomadaires de surveillance: %u", $des->getSurveillance());
 }
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);

// Vie et societe
 if ($des->getFomos() == 'T') {
  $txt = 'Vie et Société: OUI';
 } else {
  $txt = 'Vie et Société: NON';
 }
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);

// Etudes
 if ($des->getEtudes() == '0') {
  $txt = 'Pas d\'Etudes surveillées.';
 } else {
  $txt = sprintf("Nombre de leçon(s) hebdomadaires d'Etudes surveillées: %u", $des->getEtudes());
 }
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);

// parascolaire
 if (strlen(trim($des->getParascolaire())) == 0) {
  $txt = "Pas d'activité parascolaire proposée.";
 } else {
  $txt = sprintf("Activité parascolaire: %s", $des->getParascolaire());
 }
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);

//Detachement
 if ($des->getDetachement() == '-') {
  $txt = 'Pas de détachement à un autre lycée.';
 } else {
  $txt = sprintf("Détaché(e) au %s pour %u leçons.", $des->getDetachement(), $des->getDe_nombre());
 }
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);

// Emploi
 if ($des->getEmploi() == 'A') {
  $txt = 'Je préfère un emploi du temps plutôt aéré.';
 } else {
  $txt = 'Je préfère un emploi du temps plutôt compact.';
 }
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);

// Pause midi
 $txt = "Pause à midi si cours à partir de 11h: ";
 if ($des->getPause() == 'T') {
  $txt.='OUI';
 } else {
  $txt.='NON';
 }
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);

// Classe neige  
 $txt = "Classe neige: ";
 if ($des->getNeige() == 'T') {
  $txt.='OUI';
 } else {
  $txt.='NON';
 }
 $pdf->MultiCell($w = 50, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);

// Classe mer  
 $txt = "Classe mer: ";
 if ($des->getMer() == 'T') {
  $txt.='OUI';
 } else {
  $txt.='NON';
 }
 $pdf->MultiCell($w = 50, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);


// Bol de riz  
 $txt = "Bol de riz: ";
 if ($des->getRiz() == 'T') {
  $txt.='OUI';
 } else {
  $txt.='NON';
 }
 $pdf->MultiCell($w = 50, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);

// Huelmes  
 $txt = "Huelmes: ";
 if ($des->getHuelmes() == 'T') {
  $txt.='OUI';
 } else {
  $txt.='NON';
 }
 $pdf->MultiCell($w = 50, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);

// Portes ouvertes
 $txt = "Portes ouvertes 2017: ";
 if ($des->getPortes() == 'T') {
  $txt.='OUI';
 } else {
  $txt.='NON';
 }
 $pdf->MultiCell($w = 50, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 0, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);

// Anglais 9pr
 $txt = "Anglais 9PR: ";
 if ($des->getAngla9pr() == 'T') {
  $txt.='OUI';
 } else {
  $txt.='NON';
 }
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);

 $pdf->Line(20, $pdf->GetY() + 2, $pdf->getPageWidth() - 20, $pdf->GetY() + 2, array('width' => 0.25, 'cap' => "round", "join" => "miter", "dash" => 0, "phase" => 0, "color" => array(0, 0, 0)));
 $pdf->SetY($pdf->GetY() + 3);

// RP
 $txt = "R. p.: ";
 switch ($des->getPrep_surv_cantine()) {
  case "X":
   $txt.="";
   break;
  case "T":
   $txt.="Surveillance cantine: OUI ";
   break;
  case "F":
   $txt.="Surveillance cantine: NON ";
   break;
  default:
   $txt.="Surveillance cantine: ??? ";
   break;
 }
 $site = $des->getPrep_sites();
 if ($site != 0) {
  $txt.="Sites:";
  if (($site & 1) != 0) {
   $txt.=" Lamadelaine ";
  }
  if (($site & 2) != 0) {
   $txt.=" Differdange ";
  }
  if (($site & 4) != 0) {
   $txt.=" Indifférent ";
  }
 }
 if ($txt != "R. p.: ") {
  $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
  $pdf->Line(20, $pdf->GetY() + 2, $pdf->getPageWidth() - 20, $pdf->GetY() + 2, array('width' => 0.25, 'cap' => "round", "join" => "miter", "dash" => 0, "phase" => 0, "color" => array(0, 0, 0)));
  $pdf->SetY($pdf->GetY() + 3);
 }

// Rem spéciales & Footer
 $txt = sprintf("Remarques spéciales:\n%s", $des->getRem_speciales());
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);

 $remise = explode('-', $des->getRemise());
 $txt = sprintf("Enregistré le: %u/%u/%u", $remise[2], $remise[1], $remise[0]);
 $pdf->MultiCell($w = 0, $h = 0, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
 if ($filename == "") {
  $pdf->Output('Lettre.pdf', 'I');
 } else {
  $pdf->Output($filename, 'F');
 }
}
