<?php

function insertPres() {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros = $_SESSION['GIROS'];
 $menu = new c_menu($giros->getUntis(), $giros->getUrl());
 if (!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: " . $giros->getErrorUrl());
 }
 $id = $_POST['id'];
 $giros->sqlConnect();
 $giros->sqlQuery("UPDATE RETENUE SET PRESENT = 0, SUIVI=-1 WHERE NODATER='" . $id . "' AND SUIVI =-1");
 if ($_POST['present'] != null) {
  foreach ($_POST['present'] as $value) {
   $giros->sqlQuery("UPDATE RETENUE SET PRESENT = 1, SUIVI=-1 WHERE NORETENUE='" . $value . "'");
  }
 }
 if ($_POST['CO'] != null) {
  foreach ($_POST['CO'] as $key => $value) {
   $query = sprintf("UPDATE RETENUE SET CO='%s' WHERE NORETENUE='%s'", $value, $key);
   $giros->sqlQuery($query);
  }
 }
 // pdf
 unset($_SESSION['RETENUE']);
 $_SESSION['RETENUE']['ID'] = $id;
 $_SESSION['RETENUE']['COMPACT'] = "1";
 ?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
  <head>
   <title>Relev&eacute; retenues</title>
   <script type="text/javascript" src="presentP3.js"></script>
  </head>
  <body onload="pdf();
     location.href = 'index.php';">
  </body>
 </html>
 <?php
}
?>
