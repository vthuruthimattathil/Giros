<?php
// Giros - 2011

// Filename:       modifyGroup.php
// Description:    modifies group in database
// Called by:      side menu of module document
// Calls:
// Includes files: session.php, menum.php, menus
// Defines vars:
// Unsets vars:
// Modifies vars:
// Uses vars:

include 'modfifyGroupP1.php';
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
 foreach ($_POST as $key => $value) {
  if (substr($key,0,1)=='D') {
   $notype=substr($key,1);
   $description=$value;
  }
  else
  {
   $couleur=hexdec($value);
   $giros->sqlConnect();
   $giros->sqlQuery("UPDATE TDOCUMENT SET DESCRIPTION='$description', COULEUR=$couleur WHERE NOTYPE='$notype'");
  }
 }
 header("Location: ".$giros->getUrl()."/documents/index.php");
}
?>