<?php
function showForm () {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: ".$giros->getErrorUrl());
 }
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
 <title>Compositions - Suppression composition</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../tablesorter/css/theme.blue.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.widgets.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="delete.js"></script>
</head>  
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">	
 <?php $menu->display(); ?>
  </div>
  <div id="cont">   
   <h1>Suppression composition:</h1>
<?php
// Liste des enseignants
 $giros->sqlConnect();
 $giros->sqlQuery("SELECT UNTIS,NOM,PRENOM FROM PROF ORDER BY NOM,PRENOM;");
?>
   <h2>S&eacute;lectionnez l'enseignant:</h2>
   <form action="delete.php" method="post">
    <div>
     <select id="untis" name="untis" size="1" onchange="loadcomp()">
<?php
 while ($row = $giros->sqlData()) {
  printf ("     <option id=\"%s\" value=\"%s\">%s %s (%s)</option>\n",$row['UNTIS'],$row['UNTIS'],$row['NOM'],$row['PRENOM'],$row['UNTIS']);
 } ?>
     </select>
     <br />
     <p id="wait" style="display:none">Chargement en cours</p>
     <div id="frm" style="display:none">
      <p id="comp"></p>
      <input type="submit" value="Effacer les compositions s&eacute;lectionn&eacute;es" />
      </div>
    </div> 
   </form>
  </div>
 </div>
</body>
</html>
<?php
 }
?>