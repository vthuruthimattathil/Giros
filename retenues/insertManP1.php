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
 <title>Retenues - Insertion manuelle</title>
 <link rel="stylesheet" href="../css/jquery-ui.css" type="text/css" />
 <link rel="stylesheet" href="../css/tablesorter.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../jquery/jquery.tablesorter.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="insertMan.js"></script>
</head>
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">	
<?php $menu->display(); ?>
  </div>
  <div id="cont">  
   <h1>Ins&eacute;rer une retenue:</h1>
   <form action="insertMan.php" method="post" enctype="multipart/form-data">
    <div>
     <p>S&eacute;lectionnez un enseignant</p>
     <select id="untis" name="untis" size="1" onchange="loadClasses();">
      <option id="tmpUntis">S&eacute;lectionnez un enseignant</option>
<?php
// Liste des enseignants
 $giros->sqlConnect();
 $giros->sqlQuery("SELECT UNTIS,NOM,PRENOM FROM PROF ORDER BY NOM,PRENOM;");
 while ($row = $giros->sqlData()) {
  printf ("      <option value=\"%s\">%s %s (%s)</option>\n",$row['UNTIS'],$row['NOM'],$row['PRENOM'],$row['UNTIS']);
 } ?>
     </select>
     <br />
     <p id="wait" style="display:none">Chargement en cours</p>
	   <div id="classes">
	   
	   </div>
	   <div id="eleves">
	   
	   </div>
	   <div id="selEle">
	   
	   </div>
	   <div id="motifs" style="display: none;">
	    Choisissez le motif ou texte libre:<br />
<?php
 $query="SELECT DESCRIPTION FROM MOTIFS ORDER BY DESCRIPTION";
 $giros->sqlQuery($query);
?>
	    <select id="motif" name="motif" size="5" onclick="$('#txtmotif').attr('value',$('#txtmotif').attr('value')+$('#motif').attr('value'));">
<?php
 while ($row=$giros->sqlData()) {
  printf("	    <option>%s</option>\n",$row['DESCRIPTION']);
 }
?>
      </select>
      <textarea id="txtmotif" name="txtmotif" rows="5" cols="60"></textarea>
      <hr />
     </div>
     <div id="travaux" style="display: none;">
      Choisissez le travail � faire ou texte libre:<br />
<?php
 $query="SELECT DESCRIPTION FROM TRAVAUX ORDER BY DESCRIPTION";
 $giros->sqlQuery($query);
?>
      <select id ="travail" name="travail" size="5" onclick="$('#txttravail').attr('value',$('#txttravail').attr('value')+$('#travail').attr('value'));">
<?php
 while ($row=$giros->sqlData()) {
  printf("       <option>%s</option>\n",$row['DESCRIPTION']);
 }
?>
      </select>
      <textarea id='txttravail' name="txttravail" rows="5" cols="60"></textarea>
      <hr />
	   </div>
	   <div id="dr" style="display: none;">
	   
	   </div>
    <input type="submit" value="Supprimer" />
   </div>
  </form>
 </div>
</div>
</body>
</html>
<?php
 }
?>