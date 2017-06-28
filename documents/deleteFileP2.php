<?php
function processForm() {
include_once("../session.php");
include_once("../c_menu.php");
$giros=$_SESSION['GIROS'];
$menu=new c_menu($giros->getUntis(),$giros->getUrl());
if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {
 header("Location: ".$giros->getErrorUrl());
}
if (!is_null($_POST['file'])) {
  $giros->sqlConnect();
  foreach ($_POST['file'] as $value) {
    $giros->sqlQuery("DELETE FROM DOCUMENT WHERE NO='".$value."'");
    unlink('./docs/'.$value);
  }
}
 header ("Location: ".$giros->getUrl()."/documents/index.php");
}
?>