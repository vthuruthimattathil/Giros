<?php
 include_once('c_giros.php');
 session_start();
 if (!isset($_SESSION['GIROS'])) {
  header("Location: /giros/index.php");
  exit;
 } 
?>