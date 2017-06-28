<?php
function show_form ($ERROR='') {
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
 <title>Documents - Supprimer groupe</title>
 <link rel="stylesheet" href="../css/jquery-ui.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="deleteGroup.js"></script>
</head>
<body>
	<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">	
	<?php $menu->display(); ?>
  </div>
  <div id="cont">
   <h1>Supprimer cat�gorie:</h1>
   <form action="deleteGroup.php" method="post">
   <div>
    <h2>Seul les cat�gories vides peuvent �tre supprim�es!</h2>

<?php
 $giros->sqlConnect();
 $giros->sqlQuery("SELECT TDOCUMENT.NOTYPE, TDOCUMENT.DESCRIPTION AS TDESC, COUNT(DOCUMENT.NO) AS QTE FROM TDOCUMENT  LEFT JOIN DOCUMENT ON TDOCUMENT.NOTYPE=DOCUMENT.NOTYPE GROUP BY NOTYPE");
 while ($row = $giros->sqlData()) {
  if ($row['QTE'] == 0) $temp='';
  else $temp=' disabled';
  echo '    <input type="checkbox" name="group[]" value="'.$row['NOTYPE'].'"'.$temp.' />'.$row['TDESC']."<br />\n";
 }
?>
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