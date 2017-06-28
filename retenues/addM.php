<?php
// Giros - Version 3 - 8.2008

// Filename:       addm.php
// Description:    adds a "motif" in retenue module
// Called by:      index.php (retenue level)
// Calls:
// Includes files: session.php, menum.php
// Defines vars:
// Unsets vars:
// Modifies vars:
// Uses vars:

 function show_form ($ERR='') {
   include_once("../session.php");
  $giros=$_SESSION['GIROS'];
  if (!($giros->retenues &2048 )) { header("Location: http://mail.ltma.lu");}
  include_once("../menu.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
 <title>Retenues - Ajouter motif</title>
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
  <h1>Ajouter motif:</h1>
  <form action="addm.php" method="post" enctype="multipart/form-data">
Entrez un nouveau motif<br>
  <input type="text" name="edtMotif"><br>
  <input type="submit" name="submit" value="Enregistrer">
  <input type="reset">
  </form>
<?php echo "<br>".$ERR; ?>
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
  if (!($giros->retenues &2048 )) { header("Location: http://mail.ltma.lu");}
  $nomotif=md5(uniqid(rand(), TRUE));
  $giros->sql_connect();
  $giros->sql_query("INSERT INTO MOTIFS(NOMOTIF,DESCRIPTION) VALUES('".$nomotif."','".mysql_real_escape_string(stripslashes($_POST['edtMotif']))."')");
  header("Location: listm.php");
 }
?>