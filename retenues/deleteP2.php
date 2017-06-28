<?php
function processForm() {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: ".$giros->getErrorUrl());
 }
 $noretenue=$_POST['noretenue'];
 $giros->sqlConnect();
 foreach ($noretenue as $key=>$value) {
  $query=sprintf("DELETE FROM RETENUE WHERE NORETENUE='%s'",$value);
  $giros->sqlQuery($query);
 }
 header("Location: ".$giros->getUrl()."/retenues/index.php");
}