<?php
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: ".$giros->getErrorUrl());
 } 
 $id=$_POST['id'];
 $giros->sqlConnect();
 $giros->sqlQuery("UPDATE DEVOIR SET PRESENT = 0 WHERE NODATED='".$id."'");
 if ($_POST['present'] != null) {
  foreach ($_POST['present'] as $value) {
   $giros->sqlQuery("UPDATE DEVOIR SET PRESENT = 1 WHERE NODEVOIR='".$value."'");
  }
 }
 // pdf
 $_SESSION['COMPOSITION']['ID']=$id;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
  <title>Relev&eacute; devoirs</title>
  <script type="text/javascript" src="presentP2.js"></script>
</head>
<body onload="pdf(); location.href='index.php';">
</body>
</html>
