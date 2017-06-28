<?php

function processForm() {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros = $_SESSION['GIROS'];
 $menu = new c_menu($giros->getUntis(), $giros->getUrl());
 if (!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: " . $giros->getErrorUrl());
 }
 unset($_SESSION['RETENUE']);
 $_SESSION['RETENUE']['DATA'][0] = $_GET['id'];
 include('convocation.php');
}

?>