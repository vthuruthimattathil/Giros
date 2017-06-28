<?php

function processForm() {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros = $_SESSION['GIROS'];
 $menu = new c_menu($giros->getUntis(), $giros->getUrl());
 if (!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: " . $giros->getErrorUrl());
 }
 unset($_SESSION['FOLLOWUP']);
 if (isset($_POST['id'])) {
  $_SESSION['FOLLOWUP'] = $_POST['id'];
 }
 ?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
  <head>
   <title>Condens&eacute; suivi</title>
   <script type="text/javascript" src="digestP2.js"></script>
  </head>
  <body onload="
  <?php
  if (isset($_POST['id'])) {

   echo " pdf(); ";
  }
  ?>
    location.href = 'index.php';">
  </body>
 </html>
 <?php
}
?>