<?php
function processForm(){
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: ".$giros->getErrorUrl());
 }
 $giros->sqlConnect();
 foreach ($_POST as $key=>$value) {
  if ($key !='submit') {
   $noret=substr($key,1);
   $query="UPDATE RETENUE SET SUIVI=$value WHERE NORETENUE='$noret'";
   $giros->sqlQuery($query);
  }
 }
 header("Location: ".$giros->getUrl()."/retenues/index.php");
}
?>