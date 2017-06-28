<?php
function processForm() {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: ".$giros->getErrorUrl());
 }
 $today=getdate();
 $untis=$giros->getUntis();
 $iam=$_POST['eleve'];
 $datei=sprintf("%s-%s-%s",$today['year'],$today['mon'],$today['mday']);
 $data=sprintf("%s#%s#%s#%s#%s",$_POST['date1'],$_POST['rgTimeStart'],$_POST['rgTimeEnd'],$_POST['lstQte'],$_POST['rgChambre']);
 $giros->sqlConnect();
 $query="INSERT INTO LETTRE (UNTIS,IAM,DATEI,DATA,NOTYPE) VALUES ";
 $query.=sprintf("('%s','%s','%s','%s',2)",$untis,$iam,$datei,$data);
 $giros->sqlQuery($query);
 $id=$giros->sqlInsertId();
 $_SESSION['LETTRES']['ID']=$id;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
 <title>Lettres - Absences chambre</title>
 <script type="text/javascript" src="chambreP2.js"></script>
</head>
<body onload="pdf(); location.href='index.php';">
</body>
</html>
<?php 
}
?>
