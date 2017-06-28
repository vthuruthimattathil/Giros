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
 foreach ($_POST as $key=>$value) {
  $nodater=substr($key,1);
  if ($value=='-') {
   $giros->sqlQuery("UPDATE DATESR SET SURVEILLANT=null WHERE NODATER='$nodater'");
  } else {
   $giros->sqlQuery("UPDATE DATESR SET SURVEILLANT='$value' WHERE NODATER='$nodater'");
  }
 }
 header("Location: ".$giros->getUrl()."/retenues/index.php");
}