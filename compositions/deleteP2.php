<?php
function processForm() {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: ".$giros->getErrorUrl());
 } 
 $giros->sqlConnect();
 if ($_POST['nodevoir'] != null) {
  foreach ($_POST['nodevoir'] as $value) {
   $query=sprintf("DELETE FROM DEVOIR WHERE NODEVOIR='%s'",$value);
   $giros->sqlQuery($query);
  }
 }
 header("Location: ".$giros->getUrl()."/compositions/index.php"); 
}