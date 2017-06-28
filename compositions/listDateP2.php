<?php
function processForm() {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: ".$giros->getErrorUrl());
 }
 unset($_SESSION['COMPOSITION']);
 $_SESSION['COMPOSITION']['ID']=$_POST['nodated'];
}
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
 <title></title>
 <script type="text/javascript" src="listDateP2.js"></script>
</head>
<body onload="pdf(); location.href='index.php';">
</body>
</html>
