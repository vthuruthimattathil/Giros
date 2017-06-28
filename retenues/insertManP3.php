<?php
function processForm() {
include_once("../session.php");
$giros=$_SESSION['GIROS'];
if (!($giros->retenues & 512) ) {
 header("Location: http://mail.ltma.lu");
}
$nodater=$_GET['nodater'];
$nodater=urldecode($nodater);
$_SESSION['RETENUE']['NODATER']=$nodater;
$giros->sql_connect();
for ($i=0;$i<$_SESSION['RETENUE']['NOMBRE'];$i++) {
 $noretenue=md5(uniqid(rand(), TRUE));
 $query="INSERT INTO RETENUE (NORETENUE, MATRICULE, UNTIS, NODATER, MOTIF, TRAVAIL, PRESENT, DATEI) VALUES ";
 $query.="('$noretenue','".$_SESSION['RETENUE']['MATRICULE'][$i]."','".$_SESSION['RETENUE']['PROF']."','".$_SESSION['RETENUE']['NODATER']."',";
 $query.="'".mysql_real_escape_string($_SESSION['RETENUE']['MOTIF'])."','".mysql_real_escape_string($_SESSION['RETENUE']['TRAVAIL'])."',0,'".$_SESSION['RETENUE']['DATEI']."')";
 $giros->sql_query($query);
 unset($_session['RETENUE']);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
  <title>Ins&eacute;rer retenue</title>
</head>
<body onload="location.href='index.php'">

</body>
</html>
<?php
  }
  ?>