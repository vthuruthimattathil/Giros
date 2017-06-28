<?php
function processForm() {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: ".$giros->getErrorUrl());
 }

 if ((!isset($_POST['choice'])) || (!isset($_POST['ele']))) {
  header("Location:index.php");
 }


 $choice=$_POST['choice'];
 switch ($choice) {
  case "ai":
   if(!isset($_POST['room'])) {
    header("Location:index.php");
   }
   $_SESSION['LETTRES']['GENADM']=$_POST;
   break;
  case "ei":
   if(!isset($_POST['eiDay'])) {
    header("Location:index.php");
   }
   $_SESSION['LETTRES']['GENADM']=$_POST;
   break;
  case "an":
   if(!isset($_POST['anBranche'])) {
    header("Location:index.php");
   }
   if(!isset($_POST['anAET'])) {
    header("Location:index.php");
   }
   $_SESSION['LETTRES']['GENADM']=$_POST;
   break;
  case "ad":
  case "ed":
   $_SESSION['LETTRES']['GENADM']=$_POST;
   break;
  default:
   header("Location:index.php");
 }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
 <title>Lettres - Lettres administratives</title>
 <script type="text/javascript" src="genAdmP2.js"></script>
</head>
<body onload="pdf(); location.href='index.php';">
</body>
</html>
<?php 
}

?>
