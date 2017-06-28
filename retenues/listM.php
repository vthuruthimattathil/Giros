<?php
// Giros - Version 3 - 8.2008

// Filename:       listm.php
// Description:    Liste-motifs
// Called by:      index2.php (top level)
// Calls:
// Includes files: session.php, menum.php
// Defines vars:
// Unsets vars:
// Modifies vars:
// Uses vars:

  include_once("../session.php");
  $giros=$_SESSION['GIROS'];
  if (!($giros->retenues &1024 )) { header("Location: http://mail.ltma.lu");}
  include_once("../menu.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
 <title>Retenues - Liste des motifs</title>
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
 <h1>Liste des motifs:</h1>
<?php
 $giros->sql_connect();
 $giros->sql_query("SELECT DESCRIPTION FROM MOTIFS ORDER BY DESCRIPTION");
  while ($row = $giros->sql_data()) { echo htmlentities($row['DESCRIPTION'])."<br>\n"; }
?>
 </div>
</div>
</body>
</html>