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
 foreach ($_POST[noretenue] as $noretenue) {
  if (isset($_POST['memo'])) {
   $query=sprintf("UPDATE RETENUE SET NOREPORT=TRIM(CONCAT_WS(' ',NOREPORT,NODATER)) WHERE NORETENUE='%s'",$noretenue);
   $giros->sqlQuery($query);
  }
  $query=sprintf("UPDATE RETENUE SET NODATER='%s',SUIVI=-1,PRESENT=-1 WHERE NORETENUE='%s'",$_POST['newdate'],$noretenue);
  $giros->sqlQuery($query);
 }
 header("Location: index.php");
 
}