<?php
function showForm () {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: ".$giros->getErrorUrl());
 }
 unset($_SESSION['RETENUE']);
 $_SESSION['RETENUE']['DONE']=FALSE;
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
 <title>Retenues - Ins&eacute;rer retenues</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="insert.js"></script>
</head>  
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">	
 <?php $menu->display(); ?>
  </div>
  <div id="cont"> 
   <h1>Ins&eacute;rer une retenue</h1>
   <form  action="insert.php" method="post" onsubmit="return checkform();">
   <div>
    S&eacute;lectionnez la classe / groupe:<br />
     <input type="radio" name="rgClasses" value="my" checked="checked" onclick="rgClick('#mycl');" /> Mes classes
<?php 
 $giros->sqlConnect();
 $query=sprintf("SELECT CODE FROM CLASSE WHERE REGENT='%s' ORDER BY CODE",$giros->getUntis());
 $giros->sqlQuery($query);
 if ($giros->sqlNumRows()) {     
  echo "     <input type=\"radio\" name=\"rgClasses\"  value=\"mod\" onclick=\"rgClick('#myreg');\" />Ma r&eacute;gence";
 }
?>
     <input type="radio" name="rgClasses"  value="opt" onclick="rgClick('#mycluster');" /> Mes groupes
     <input type="radio" name="rgClasses"  value="allcl" onclick="rgClick('#allcl');" /> Toutes les classes
     <hr />

<?php
// Mes classes
 $giros->sqlQuery("SELECT CODE FROM ENSEIGNER WHERE UNTIS='".$giros->getUntis()."' ORDER BY CODE");
 if ($giros->sqlNumRows()!=0) {
  echo "     <select id=\"mycl\" name=\"mycl\" size=\"1\" onchange=\"updateList('#mycl');\">\n";
  while ($row = $giros->sqlData()) {
   printf ("      <option id=\"%s\" value=\"%s\">%s</option>\n",$row['CODE'],$row['CODE'],$row['CODE']);
  }
  echo "     </select>\n";
 } 
// Ma régence 

// Mes groupes
 $query=sprintf("SELECT NOCLUSTER, DESCRIPTION FROM CLUSTER WHERE UNTIS= '%s' ORDER BY DESCRIPTION",$giros->getUntis());   
 $giros->sqlQuery($query);
 if ($giros->sqlNumRows()!=0) {
  echo "     <select id=\"mycluster\" name=\"mycluster\" size=\"1\" style=\"display:none\" onchange=\"updateList('#mycluster');\">\n";
  while ($row = $giros->sqlData()) {
   printf ("      <option id=\"%s\" value=\"%s\">%s</option>\n",$row['NOCLUSTER'],$row['NOCLUSTER'],htmlentities($row['DESCRIPTION']));
  }
  echo "     </select>\n";
 }
// Toutes les classes
 $giros->sqlQuery("SELECT CODE FROM CLASSE ORDER BY CODE");
 if ($giros->sqlNumRows()!=0) {
  echo "     <select id=\"allcl\" name=\"allcl\" size=\"1\" style=\"display:none\" onchange=\"updateList('#allcl');\">\n";
  while ($row = $giros->sqlData()) {
   printf ("      <option id=\"%s\" value=\"%s\">%s</option>\n",$row['CODE'],$row['CODE'],$row['CODE']);
  }
  echo "     </select>";
 }
?>
     
     <p>El&egrave;ves inscrits: (Cliquez sur l'&eacute;l&egrave;ve pour l'ajouter)</p>
     <p id="wait" style="display:none">Chargement en cours</p>
     <div id="lstEle" style="height: 220px; overflow: scroll;"></div>  
     <div id="tot"></div>
     <div id="selEle" style="height: 100px; overflow: scroll;"></div>
     <div id="lstDates" style="height: 300px; overflow: scroll;"></div>
   <hr />
     <p >Choisissez le motif ou texte libre:<br />
<?php
 $query="SELECT DESCRIPTION FROM MOTIFS ORDER BY DESCRIPTION";
 $giros->sqlQuery($query);
?>
      <select id="motif"  size="5" onclick="$('#txtmotif').val($('#txtmotif').val()+$('#motif').val());">
<?php while ($row=$giros->sqlData()) { echo "      <option>".htmlentities($row['DESCRIPTION'])."</option>"."\n";} ?>
      </select>
      <textarea id="txtmotif" name="txtmotif" rows="5" cols="60" style="resize:none"></textarea>
     </p>
   <p>Choisissez le travail &agrave; faire ou texte libre:<br />
<?php
 $query="SELECT DESCRIPTION FROM TRAVAUX ORDER BY DESCRIPTION";
 $giros->sqlQuery($query);
?>
      <select id ="travail" size="5" onclick="$('#txttravail').val($('#txttravail').val()+$('#travail').val());">
<?php
 while ($row=$giros->sqlData()) { echo "       <option>".htmlentities($row['DESCRIPTION'])."</option>"."\n";}
?>
      </select>
      <textarea id='txttravail' name="txttravail" rows="5" cols="60" style="resize:none"></textarea>
     </p>
     
     
     <div id="btnSubmit" style="display: none;"><input type="submit" value="Inscrire" /></div>
    </div> 
   
   </form>
  </div>
 </div>
</body>
</html>
<?php
 }
 ?>
