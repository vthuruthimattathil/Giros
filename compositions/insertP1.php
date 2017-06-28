<?php
function showForm () {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: ".$giros->getErrorUrl());
 }
 $_SESSION['COMPOSITION']['GO']=TRUE;
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
 <title>Compositions - Ins&eacute;rer composition</title>
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
 <?php 
 $menu->display();
 $giros->sqlConnect();
 ?>
  </div>
  <div id="cont"> 
   <h1>Ins&eacute;rer une composition</h1>
   <form  action="insert.php" method="post" onsubmit="return checkform();">
   <div>
    S&eacute;lectionnez la classe / cours &agrave; options / modules:<br />
     <input type="radio" name="rgClasses" value="my" checked="checked" onclick="rgClick('#mycl');" /> Mes classes
     <input type="radio" name="rgClasses"  value="cluster" onclick="rgClick('#myCluster');" /> Mes groupes 
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

// Mes groupes
 $query=sprintf("SELECT NOCLUSTER, DESCRIPTION FROM CLUSTER WHERE UNTIS='%s' ORDER BY DESCRIPTION",$giros->getUntis());  
 $giros->sqlQuery($query);
 if ($giros->sqlNumRows()!=0) {
  echo "     <select id=\"myCluster\" name=\"myCluster\" size=\"1\" style=\"display:none\" onchange=\"updateList('#myCluster');\">\n";
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
     
      <p>Entrez la branche:<br />
      <input type="text" size="20" maxlength="60" name="txtbranche" id="txtbranche"><br />
     </p>
     <input type="text" id="dateC" style="display:none" value="X" name="dateC">
      <input type="text" id="dateCx" value="Cliquez ici pour entrer la date du devoir non compos&eacute;!" style="width:400px; border:none" readonly="readonly">
     <p>Dur&eacute;e de l'&eacute;preuve:<br />   
      <input type="radio" name="duree" value="1" checked>1 le&ccedil;on
       <input type="radio" name="duree" value="2">2 le&ccedil;ons
        <input type="radio" name="duree" value="3">3 le&ccedil;ons
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