<?php
function processFormP4() {
 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {header("Location: ".$giros->getErrorUrl());}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
 <title>Maintenance Charger &eacute;l&egrave;ves</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="load.js"></script>
</head>
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">	
<?php $menu->display(); ?>
  </div>
  <div id="cont">
<?php 
 $giros->sqlConnect();
 $query="UPDATE ELEVE_BAK,ELEVE SET ELEVE_BAK.CREDIT=ELEVE.CREDIT WHERE ELEVE_BAK.IAM=ELEVE.IAM;";
 $giros->sqlQuery($query);
 $query="DELETE FROM ELEVE WHERE IAM IN (SELECT IAM FROM ELEVE_BAK)";
 $giros->sqlQuery($query);
 $query="UPDATE ELEVE SET CODE='depart'";
 $giros->sqlQuery($query); 
 $query="INSERT INTO ELEVE  SELECT * FROM ELEVE_BAK";
 $giros->sqlQuery($query);
 $time=localtime(time(), true);
 $m=$time[tm_mon]+1;
 $y=$time[tm_year]+1900;
 $value=$time[tm_mday].".".$m.".".$y;
 $query="UPDATE REGISTRY SET REGVALUE='".$value."' WHERE UNTIS='GIROS' AND REGKEY='updateDate'";
 $giros->sqlQuery($query);
 unset( $_SESSION['MAINTENANCE']);
?>
   <h1>Termin&eacute;</h1>
  </div>
 </div>
</body>
</html>
<?php 
 }
?>