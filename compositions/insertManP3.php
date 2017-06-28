<?php
function processForm() {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: ".$giros->getErrorUrl());
 }
 $id=$_GET['nodated'];
 $id=urldecode($id);
 $_SESSION['COMPOSITION']['ID']=$id;
 $today=getdate();
// insert into db
 $giros->sqlConnect();
 for ($i=0;$i<$_SESSION['COMPOSITION']['NOMBRE'];$i++) {
  $nodevoir=md5(uniqid(rand(), TRUE));
  $query="INSERT INTO DEVOIR (NODEVOIR,MATRICULE,NODATED,UNTIS,BRANCHE,DATEC,DUREE,DATEI,PRESENT) ";
  $query.=sprintf("VALUES('%s','%s','%s',",$nodevoir,$_SESSION['COMPOSITION']['MATRICULE'][$i],$id);
  $query.=sprintf("'%s','%s',",$_SESSION['COMPOSITION']['PROF'],mysql_real_escape_string($_SESSION['COMPOSITION']['BRANCHE']));
  $query.=sprintf("'%s',%d,'%s',-1)",$_SESSION['COMPOSITION']['DATEC'],$_SESSION['COMPOSITION']['DUREE'],$_SESSION['COMPOSITION']['DATEI']);
  echo $query;
  $giros->sqlQuery($query);
 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
 <title>Ins&eacute;rer composition</title>
</head>
<body onload="location.href='index.php'">
<head>
</head>
</body>
</html>
<?php
}
 