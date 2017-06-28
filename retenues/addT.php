<?php
// Giros - Version 3 - 8.2008

// Filename:       addt.php
// Description:    adds a "travail" in retenue module
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
  if (!($giros->retenues & 16384 )) { header("Location: http://mail.ltma.lu");}
  include_once("../menu.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
 <title>Retenues - Ajouter travail</title>
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
  <h1>Ajouter travail</h1>
  <form action="addt.php" method="post" enctype="multipart/form-data">
Entrez un nouveau travail<br>
  <input type="text" name="edtTravail"><br>
  <input type="submit" name="submit" value="Enregistrer">
  <input type="reset">
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
  $notravail=md5(uniqid(rand(), TRUE));;
  $giros->sql_connect();
  $giros->sql_query("INSERT INTO TRAVAUX(NOTRAVAIL,DESCRIPTION) VALUES('".$notravail."','".mysql_real_escape_string(stripslashes($_POST['edtTravail']))."')");
  header("Location: listt.php");
 }
?>