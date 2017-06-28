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
 <title>Documents - Transfer</title>
 <link rel="stylesheet" href="../css/jquery-ui.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="transfer.js"></script>
</head>
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">	
 <?php $menu->display(); ?>
  </div>
  <div id="cont">
   <h1>Transf&eacute;rer:</h1>
   <form action="transfer.php" method="post">
   <div>
<?php
 $giros->sqlConnect();
 $giros->sqlQuery("SELECT TDOCUMENT.DESCRIPTION AS TDESC, TDOCUMENT.COULEUR AS TCOL,DOCUMENT.* FROM TDOCUMENT,DOCUMENT WHERE TDOCUMENT.NOTYPE=DOCUMENT.NOTYPE ORDER BY TDOCUMENT.DESCRIPTION, DOCUMENT.DESCRIPTION");
 $head='';
 while ($row = $giros->sql_data()) {
  if ($head != $row['TDESC']) {
   $head =$row['TDESC'];
   $color=substr("000000".dechex($row['TCOL']),-6);
   echo("     <h2 style=\"color: #$color\">$head</h2>\n");
  }
  echo "     <input type=\"checkbox\" name=\"file[]\" value=\"".$row['NO']."\">".$row['DESCRIPTION']."<br>\n";
 }
?>
    <h1>S�lectionnez une nouvelle cat�gorie:</h1>
<?php
 $giros->sql_query("SELECT * FROM TDOCUMENT ORDER BY DESCRIPTION");
 $temp=' checked';
 while ($row = $giros->sql_data()) {
  $color=substr("000000".dechex($row['COULEUR']),-6);
  echo "     <input type=\"Radio\" name=\"edtCat\" value=\"".$row['NOTYPE']."\"".$temp."><font color=\"".$color."\">".$row['DESCRIPTION']."</font><br>\n";
  $temp='';
 }
?>
     <input type="submit" name="submit" value="Transf�rer" />
    </div> 
   </form>
  </div>
 </div>
</body>
</html>
<?php
 }
?>