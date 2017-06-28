<?php
// Giros - 2011

// Filename:       addfile.php
// Description:    adds file in database
// Called by:      side menu of module document
// Calls:
// Includes files: session.php, menum.php, menus
// Defines vars:
// Unsets vars:
// Modifies vars:
// Uses vars:

include_once("../session.php");
include_once("../c_menu.php");
$giros=$_SESSION['GIROS'];
$menu=new c_menu($giros->getUntis(),$giros->getUrl());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
 <title>Retenues - And the winner are...</title>
 <link rel="stylesheet" href="../css/jquery-ui.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="menu.js"></script>
</head>
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">	
<?php $menu->display(); ?>
  </div>
  <div id="cont">
   <h1>Liste des &eacute;l&egrave;ves m&eacute;ritants:</h1>
<?php
 $giros->sqlConnect();
 $query="SELECT CODE,NOME,PRENOME,COUNT(*) AS QTE FROM ELEVE RIGHT JOIN RETENUE USING(MATRICULE) GROUP BY MATRICULE HAVING COUNT(*) >0 ORDER BY QTE DESC,CODE ASC, NOME ASC, PRENOME ASC";
 $giros->sqlQuery($query);
 echo "<table border=\"1\" rules=\"groups\">\n";
 printf(" <thead>\n  <tr>\n   <th>Classe</th>\n   <th>Nom</th>\n   <th>Pr&eacute;nom</th>\n   <th>Nombre</th>\n </thead>\n");
 echo " <tbody>\n";
 while ($row = $giros->sqlData()) {
  echo "  <tr>\n";
  printf("   <td>%s</td>\n   <td>%s</td>\n   <td>%s</td>\n   <td>%s</td>\n",$row['CODE'],htmlentities($row['NOME']),htmlentities($row['PRENOME']),$row['QTE']);
  echo "  </tr>\n";
 }
 echo " </tbody>\n";
 echo "</table>\n";
?>
 </div>
</div>
</body>
</html>
