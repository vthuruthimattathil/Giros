<?php
// Giros - 2011

// Filename:       transfer.php
// Description:    transfers a file into a new group
// Called by:      side menu of module document
// Calls:
// Includes files: session.php, menum.php, menus
// Defines vars:
// Unsets vars:
// Modifies vars:
// Uses vars:


if ($_SERVER['REQUEST_METHOD']!='POST') show_form();
else {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: ".$giros->getErrorUrl());
 }
 if (!is_null($_POST['file'])) {
  $cat=$_POST['edtCat'];
  $giros->sqlConnect();
  foreach ($_POST['file'] as $value) {
   $giros->sqlQuery("UPDATE DOCUMENT SET NOTYPE='$cat' WHERE NO='$value'");
  }
 }
 header ("Location: ".$giros->getUrl()."/documents/index.php");
}
?>