<?php
// Giros - 2011

// Filename:       deleteGroup.php
// Description:    deletes group in database
// Called by:      side menu of module document
// Calls:
// Includes files: session.php, menum.php, menus
// Defines vars:
// Unsets vars:
// Modifies vars:
// Uses vars:

include 'addGroupP1.php';
if ($_SERVER['REQUEST_METHOD']!='POST') {
	showForm();
}
else {
	include_once("../session.php");
	include_once("../c_menu.php");
	$giros=$_SESSION['GIROS'];
	$menu=new c_menu($giros->getUntis(),$giros->getUrl());
	if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {
		header("Location: ".$giros->getErrorUrl());
	}
  $giros->sqlConnect();
  if (!is_null($_POST['group'])) {
   foreach ($_POST['group'] as $value) {
    $giros->sqlQuery("DELETE FROM TDOCUMENT WHERE NOTYPE='$value'");
   }
  }
  header ("Location: ".$giros->getUrl()."/documents/index.php");
 }
?>