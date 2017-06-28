<?php
include_once("../session.php");
include_once("../c_menu.php");
include_once 'c_desiderata.php';
include_once("desiderataPDF.php");
$giros = $_SESSION['GIROS'];
$menu = new c_menu($giros->getUntis(), $giros->getUrl());
if (!$menu->auth($_SERVER['SCRIPT_NAME'])) {
 header("Location: " . $giros->getErrorUrl());
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
 <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
  <title>Desiderata - Synoptique</title>
  <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
  <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
  <link rel="stylesheet" href="../css/layout.css" type="text/css" />
  <script type="text/javascript" src="../jquery/jquery.js"></script>
  <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
  <script type="text/javascript" src="../menu.js"></script>
  <script type="text/javascript" src="synoptique.js"></script>
 </head>   
 <body>
     <?php include ("../logo.php"); ?>
  <div id="ww">
   <div id="sidemenu">
       <?php $menu->display(); ?>
   </div>
   <div id="cont">
    <?php
    $query = 'select UNTIS,NOM,PRENOM from DESIDERATA LEFT JOIN PROF USING(UNTIS) ORDER BY UNTIS';
    $giros->sqlConnect();
    $giros->sqlQuery($query);
    while ($row = $giros->sqlData()) {
     $untislist[] = $row;
    }
    foreach ($untislist as $pdfunits) {
     printf("%s %s %s<br>\n", $pdfunits['UNTIS'], $pdfunits['NOM'], $pdfunits['PRENOM']);
     desiderataPDF($pdfunits['UNTIS'], 'L', $pdfunits['PRENOM'], $pdfunits['NOM'], "out/" . $pdfunits['UNTIS'].".pdf");
    }
    ?>	
   </div>
  </div>
 </body>
</html>












