<?php

function processForm() {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros = $_SESSION['GIROS'];
 $menu = new c_menu($giros->getUntis(), $giros->getUrl());
 if (!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: " . $giros->getErrorUrl());
 }
 $nodated = $_POST['nodated'];
 $branche = $_POST['txtbranche'];
 $dateC = $_POST['dateC'];
 $duree = $_POST['duree'];
 $today = getdate();
 $dateI = $today['year'] . '-' . $today['mon'] . '-' . $today['mday'] . ' ' . $today['hours'] . ':' . $today['minutes'];
 if ($_SESSION['COMPOSITION']['GO']) {
  $_SESSION['COMPOSITION']['GO'] = FALSE;
  $giros->sqlConnect();
  foreach ($_POST['ele'] as $value) {
   $info = explode('@', $value);
   $nocomposition = md5(uniqid(rand(), TRUE));
   $query = "INSERT INTO DEVOIR (NODEVOIR, IAM, NODATED,UNTIS, BRANCHE, DATEC,DUREE, DATEI,PRESENT) VALUES ";
   $query.=sprintf("('%s','%s','%s','%s',", $nocomposition, $info[2], $nodated, $giros->getUntis());
   $query.=sprintf("'%s','%s', %s, '%s',-1)", mysql_real_escape_string($branche), $dateC, $duree, $dateI);
   $_SESSION['COMPOSITION']['DATA'][] = $nocomposition;
   $giros->sqlQuery($query);
  }
  ?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
   <head>
    <title>Ins&eacute;rer composition</title>
    <script type="text/javascript" src="insertP2.js"></script>
   </head>
   <body onload="pdf();
     location.href = 'index.php';">
   </body>
  </html>
  <?php
 }
}
?>
