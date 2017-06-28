<?php
// Giros - Version 4 .2011

// Filename:       index.php
// Description:    blank page in module: desiderata
// Called by:      
// Calls:
// Includes files: session.php, menum.php
// Defines vars:
// Unsets vars:
// Modifies vars:
// Uses vars:

include_once("../session.php");
$giros=$_SESSION['GIROS'];
if ($giros->desiderata ==0) { header("Location: http://mail.ltma.lu");}
include_once("../menu.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
 <title>Desiderata - Remplir</title>
 <link rel="stylesheet" href="../layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery.min.js"></script>
 <script type="text/javascript" src="../ui.core.min.js"></script>
 <script type="text/javascript" src="../ui.accordion.min.js"></script>
 <script type="text/javascript"> $(document).ready(function(){$("ul.drawers").accordion({header: 'h2.drawer-handle',  selectedClass: 'open', event: 'click', active:'.desiderata', autoHeight: false})}); </script>
</head>
<body>
<?php include ("../logo.php");?>
 <div id="ww">
  <div id="sidemenu">
<?php menum($giros); ?>
  </div>
  <div id="cont">
  </div>
</div>
</body>
</html>