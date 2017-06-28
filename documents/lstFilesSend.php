<?php
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 if(!$menu->auth('documents/lstFiles.php')) {
  header("Location: ".$giros->getErrorUrl());
 }
 $id=$_GET['id'];
 $giros->sqlConnect();
 $giros->sqlQuery("SELECT NOM FROM DOCUMENT WHERE NO = '".$id."'");
 $row = $giros->sqlData();
 $fname=$row['NOM'];
 $path = "./docs/".$id;
 header('Content-Disposition: attachment; filename= "'.$fname.'"');
 header("Content-Length: " . filesize($path));
 header("Content-Type: file");
 readfile("$path");
 exit;
?>

