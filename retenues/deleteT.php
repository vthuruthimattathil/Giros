<?php
// Giros - Version 3 - 8.2008

// Filename:       deletem.php
// Description:    deletes a "travail" in retenue module
// Called by:      index.php (retenue level)
// Calls:
// Includes files: session.php, menum.php
// Defines vars:
// Unsets vars:
// Modifies vars:
// Uses vars:

 function show_form () {
  include_once("../session.php");
  $giros=$_SESSION['GIROS'];
  if (!($giros->retenues & 2048 )) { header("Location: http://mail.ltma.lu");}
  include_once("../menu.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
 <title>Retenues - Supprimer travail</title>
 <link rel="stylesheet" href="../layout.css" type="text/css">
 <script type="text/javascript" src="../jquery.min.js"></script>
 <script type="text/javascript" src="../ui.core.min.js"></script>
 <script type="text/javascript" src="../ui.accordion.min.js"></script>
 <script type="text/javascript"> $(document).ready(function(){$("ul.drawers").accordion({header: 'h2.drawer-handle',  selectedClass: 'open', event: 'click', active:'.retenues', autoHeight: false})}); </script>                                        
</head>
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">
<?php menum($giros); ?>
 </div>
 <div id="cont">
  <h1>Sélectionnez le travail ou les travaux à supprimer:</h1>
  <form action="deletet.php" method="post">
<?php
 $giros->sql_connect();
 $giros->sql_query("SELECT * FROM TRAVAUX ORDER BY DESCRIPTION");
 while ($row = $giros->sql_data()) {printf("   <input type=\"checkbox\" name=\"travail[]\" value=\"%s\">%s<br>\n",$row['NOTRAVAIL'],htmlentities($row['DESCRIPTION']));}
 ?>
   <input type="submit" name="submit" value="Supprimer">
  </form>
 </div>
</div>
</body>
</html>
<?php
 }
 if ($_SERVER['REQUEST_METHOD']!='POST') {show_form();}
 else {
  include_once("../session.php");
  $giros=$_SESSION['GIROS'];
  if (!($giros->retenues & 16384) ) { header("Location: http://mail.ltma.lu");}
  $giros->sql_connect();
  foreach ($_POST['travail'] as $value) {
   $query="DELETE FROM TRAVAUX WHERE NOTRAVAIL=".$value;
   $giros->sql_query($query);
  }
  header("Location: listt.php");
 }
?>