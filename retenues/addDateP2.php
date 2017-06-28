<?php

function processForm() {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros = $_SESSION['GIROS'];
 $menu = new c_menu($giros->getUntis(), $giros->getUrl());
 if (!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: " . $giros->getErrorUrl());
 }
 $giros->sqlConnect();
 $err = '';
 $edtDate = $_POST['edtDate'];
 $edtHeure = $_POST['edtHeure'];
 $edtSalle = mysql_real_escape_string(stripslashes($_POST['edtSalle']));
 $edtMax = (int) $_POST['edtMax'];
 $edtComment = mysql_real_escape_string(stripslashes($_POST['edtComment']));
// Check the date
 if (sscanf($edtDate, "%d/%d/%d", $day, $month, $year) != 3) {
  if (sscanf($edtDate, "%d.%d.%d", $day, $month, $year) != 3) {
   $err = $err . "<br>Le format de la date est erron&eacute;e";
  }
 }
 if ($year < 10) {
  $year = substr("200" . $year, -4);
 } else {
  $year = substr("20" . $year, -4);
 }
 if (!(is_numeric($day) && is_numeric($month) && is_numeric($year) && checkdate($month, $day, $year))) {
  $err = $err . "<br>La date est erronn&eacute;e";
 }
// check the time
 if ((sscanf($_POST['edtHeure'], "%d:%d", $hour, $min) != 2) or ( $hour < 7 or $hour > 20 or $min < 0 or $min > 59)) {
  $err = $err . "<br>Indication de l'heure incorrecte ou incompl&egrave;te";
 }
// check the place
 if (strlen(trim($edtSalle)) == 0) {
  $err = $err . "<br>Il faut indiquer une salle";
 }
// number must be positif
 if ($edtMax < 1) {
  $err = $err . "<br>Le nombre d'&eacute;l&egraveves doit &ecirc;tre un nombre positif";
 }
 if ($err != '') {
  showForm($err, $edtDate, $edtHeure, $edtSalle, $edtMax, $edtComment);
 } else {
  // everything is allright, let's go
  $code = $year . "-" . $month . "-" . $day . " " . $edtHeure . ":00";
  $reservation = $_POST['reservation'];
  if ($reservation == 'X') {
   $reservation = '';
  }
  $nodater = md5(uniqid(rand(), TRUE));
  $query = sprintf("INSERT INTO DATESR (NODATER,SURVEILLANT,DATER,SALLE,NOMBREMAX,COMMENT,RESERVATION,SITE) VALUES('%s',null,'%s','%s',%d,'%s','%s','%s')", $nodater, $code, $edtSalle, $edtMax, $edtComment, $reservation, $giros->getSite());
  $giros->sqlQuery($query);
  header("Location: index.php");
 }
}
