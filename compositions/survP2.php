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
  $nodated=substr($key,1);
  if ($value=='-') {
   $giros->sqlQuery("UPDATE DATESD SET SURVEILLANT=null WHERE NODATED='$nodated'");
  } else {
   $giros->sqlQuery("UPDATE DATESD SET SURVEILLANT='$value' WHERE NODATED='$nodated'");
 }
}
header("Location: ".$giros->getUrl()."/compositions/index.php");
}