<?php
include_once("../session.php");
include_once("../c_menu.php");
include_once 'c_desiderata.php';
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
  <title>Desiderata - Consultation</title>
  <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
  <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
  <link rel="stylesheet" href="../css/layout.css" type="text/css" />
  <script type="text/javascript" src="../jquery/jquery.js"></script>
  <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
  <script type="text/javascript" src="../menu.js"></script>
  <script type="text/javascript" src="consult.js"></script>
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
       $giros->sqlQuery("SELECT UNTIS,NOM,PRENOM FROM DESIDERATA LEFT JOIN PROF USING(UNTIS) ORDER BY NOM,PRENOM;");
       if ($giros->sqlNumRows() == 0) {
        echo "pas de desid&eacute;ratas enregistr&eacute;s<br />";
       } else {
        ?>
     <h1>Choisissez l'enseignant:</h1>
     <select id="untis" name="untis" size="1" onchange="loaddes();">
         <?php
         while ($row = $giros->sqlData()) {
          printf("   <option id=\"%s\" value=\"%s\">%s %s (%s)</option>\n", $row['UNTIS'], $row['UNTIS'], $row['NOM'], $row['PRENOM'], $row['UNTIS']);
         }
         ?>
     </select>
     <br />
     <p id="wait" style="display:none">Chargement en cours</p>
     <div id="frm" style="display:none">
      <p id="des"> </p>
     </div>
    <?php } ?>
   </div>
  </div>
 </body>
</html>
