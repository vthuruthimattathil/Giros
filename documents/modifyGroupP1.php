<?php
// Giros - 2011

// Filename:       modifyGroup.php
// Description:    modifies group in database
// Called by:      side menu of module document
// Calls:
// Includes files: session.php, menum.php, menus
// Defines vars:
// Unsets vars:
// Modifies vars:
// Uses vars:

function show_form () {
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
<title>Documents - Modifier cat&eacute;gorie</title>
<link rel="stylesheet" href="../css/jquery-ui.css" type="text/css" />
<link rel="stylesheet" href="../css/layout.css" type="text/css" />
<script type="text/javascript" src="../jquery/jquery.js"></script>
<script type="text/javascript" src="../jquery/jquery-ui.js"></script>
<script type="text/javascript" src="../menu.js"></script>
<script type="text/javascript" src="modifyGroup.js"></script>
</head>
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">
<?php $menu->display(); ?>
  </div>
  <div id="cont">
  <h1>Mofifier cat&eacute;gorie</h1>
  <form action="modifygroup.php" method="post" enctype="multipart/form-data">
  <div>
<?php
 $giros->sqlConnect();
 $giros->sqlQuery("SELECT * FROM TDOCUMENT ORDER BY DESCRIPTION");
 while ($row = $giros->sqlData()) {
  printf("   <input name=\"D%s\" type=\"text\" size=\"32\" maxlength=\"32\" value=\"%s\" />\n",$row['NOTYPE'],$row['DESCRIPTION']);
  $chk='';
  if ($row['COULEUR']==hexdec('D00000')) {$chk=' checked="checked"';} else {$chk='';}
  printf("   <input type=\"Radio\" name=\"C%s\" value=\"D00000\"%s><span style=\"color: #D00000;\">RF</span>\n",$row['NOTYPE'],$chk);
  if ($row['COULEUR']==hexdec('FF0000')) {$chk=' checked="checked"';} else {$chk='';}
  printf("   <input type=\"Radio\" name=\"C%s\" value=\"FF0000\"%s><span style=\"color: #FF0000;\">R</span>\n",$row['NOTYPE'],$chk);
  if ($row['COULEUR']==hexdec('FF6060')) {$chk=' checked="checked"';} else {$chk='';}
  printf("   <input type=\"Radio\" name=\"C%s\" value=\"FF6060\"%s><span style=\"color: #FF6060\">RC</span>\n",$row['NOTYPE'],$chk);
  if ($row['COULEUR']==hexdec('0000D0')) {$chk=' checked="checked"';} else {$chk='';}
  printf("   <input type=\"Radio\" name=\"C%s\" value=\"0000D0\"%s><span style=\"color: #0000D0\">BF</span>\n",$row['NOTYPE'],$chk);
  if ($row['COULEUR']==hexdec('0000FF')) {$chk=' checked="checked"';} else {$chk='';}
  printf("   <input type=\"Radio\" name=\"C%s\" value=\"0000FF\"%s><span style=\"color: #0000FF\">B</span>\n",$row['NOTYPE'],$chk);
  if ($row['COULEUR']==hexdec('6060FF')) {$chk=' checked="checked"';} else {$chk='';}
  printf("   <input type=\"Radio\" name=\"C%s\" value=\"6060FF\"%s><span style=\"color: #6060FF\">BC</span>\n",$row['NOTYPE'],$chk);
  if ($row['COULEUR']==hexdec('00D000')) {$chk=' checked="checked"';} else {$chk='';}
  printf("   <input type=\"Radio\" name=\"C%s\" value=\"00D000\"%s><span style=\"color: #00D000\">VF</span>\n",$row['NOTYPE'],$chk);
  if ($row['COULEUR']==hexdec('00FF00')) {$chk=' checked="checked"';} else {$chk='';}
  printf("   <input type=\"Radio\" name=\"C%s\" value=\"00FF00\"%s><span style=\"color: #00FF00\">V</span>\n",$row['NOTYPE'],$chk);
  if ($row['COULEUR']==hexdec('60FF60')) {$chk=' checked="checked"';} else {$chk='';}
  printf("   <input type=\"Radio\" name=\"C%s\" value=\"60FF60\"%s><span style=\"color: #60FF60\">VC</span>\n",$row['NOTYPE'],$chk);
  echo("<br />\n");
 }
?>
   <input type="submit" name="submit" value="Modifier" />
  </div>
  </form>
  </div>
 </div>
</body>
</html>
<?php
 }
?>