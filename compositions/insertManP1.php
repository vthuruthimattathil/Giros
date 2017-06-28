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
 <title>Inscription manuelle: composition</title>  <link rel="stylesheet" href="../css/jquery-ui.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
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
   <h1>Insertion manuelle d'une composition</h1>
<?php
// Liste des classes
 $giros->sqlConnect();
 $giros->sqlQuery("SELECT DISTINCT CODE FROM CLASSE ORDER BY CODE");
?>
S�lectionnez votre classe:<br />
   <form action="insertMan.php" method="post" onSubmit="return checkform();">
    <select id="cl" name="classe" size="1" onchange="loadpers()">
     <option id="tmp">Classe:</option>
<?php
 while ($row = $giros->sqlData()) {
  printf ("     <option id=\"%s\" value=\"%s\">%s</option>\n",$row['CODE'],$row['CODE'],$row['CODE']);
 } ?>
    </select>
    <br />
    <p id="wait" style="display:none">Chargement en cours</p>
    <div id="frm" style="display:none">
     <p id="el">El�ves: (pour s�lectionner plusieurs �l�ves maintenez la touche ctrl enfonc�e)<br />
      <select id="sel" name="matricule[]" size="10"></select>
     </p>
     <p>Entrez la branche:<br>
      <input type="text" size="20" maxlength="60" name="txtbranche" id="txtbranche"><br>
     </p>
     <p>Date du devoir non compos&eacute;:
      <input type="text" id="dateC" style="display:none" value="X" name="dateC">
      <input type="text" id="dateCx" value="Cliquez ici pour entrer la date du devoir non compos&eacute;!" style="width:400px; border:none" readonly="readonly">
     </p> 
     <p>Dur&eacute;e de l'&eacute;preuve:<br />   
      <input type="radio" name="duree" value="1" checked>1 le�on
      <input type="radio" name="duree" value="2">2 le�ons
      <input type="radio" name="duree" value="3">3 le�ons
     </p>
     <p>Choisissez le titulaire responsable:<br />
      <select name="prof" size="5" id="prof">
<?php
 $giros->sqlQuery("SELECT UNTIS,NOM,PRENOM FROM PROF ORDER BY NOM,PRENOM,UNTIS");
 while ($row=$giros->sqlData()) {
  echo "       <option value=\"".$row['UNTIS']."\">".$row['NOM']." ".$row['PRENOM']." (".$row['UNTIS'].")</option>"."\n";}
?>
      </select>
     </p>
     <p>Date de l'inscription: 
      <input type="text" id="dateI" style="display:none" value="X" name="dateI">
      <input type="text" id="dateIx" value="Cliquez ici pour entrer la date d'inscription du devoir non compos&eacute;!" style="width:450px; border:none" readonly="readonly">
     </p>
     <input type="submit" value="V�rifier et obtenir les dates possibles" />
    </div> 
   </form>
  </div>
 </div>
</body>
</html>
<?php
 }
 ?>