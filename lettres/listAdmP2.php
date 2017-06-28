<?php

function processForm() {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros = $_SESSION['GIROS'];
 $menu = new c_menu($giros->getUntis(), $giros->getUrl());
 if (!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: " . $giros->getErrorUrl());
 }
 unset($_SESSION['LETTRES']);
 $id=$_GET['id'];
 $_SESSION['LETTRES']['ID'] = $id;
 $giros->sqlConnect();
 $query="SELECT NOTYPE FROM LETTRE ";
 $query.=sprintf("WHERE NOLETTRE='%s'",$id);
 $giros->sqlQuery($query);
  if($giros->sqlNumRows()!=0) {
  $row = $giros->sqlData();
  switch ($row['NOTYPE']) {
   case 0:
    include('absPDF.php');
    break;
   case 1:
    include('medPDF.php');
    break;
   case 2:
    include 'chambrePDF.php';
    break;
   case 3:
    include 'abs40PDF.php';
    break;
   default:
    break;
  }
 }
 
}
?>