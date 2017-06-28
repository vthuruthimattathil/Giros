<?php
function showForm ($ERROR='') {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {header("Location: ".$giros->getErrorUrl());}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
 <title>Documents - Ajouter fichier</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="addFile.js"></script> 
</head> 
 
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">	
<?php $menu->display(); ?>
  </div>
  <div id="cont">
   <h1>Ajouter fichier:</h1>
   <form action="addFile.php" method="post" enctype="multipart/form-data">
    <h2>Entrez la description du nouveau fichier:</h2>
    <div>
     <input type="text" name="edtDescription" size="92" maxlength="255" /><br />
     <h2>S&eacute;lectionnez le fichier:</h2>
     <input type="file" name="edtFile" size="50" maxlength="255" /><br />
     <h2>S&eacute;lectionnez la cat&eacute;gorie associ&eacute;e:</h2>
<?php
 $giros->sqlConnect();
 $giros->sqlQuery("SELECT * FROM TDOCUMENT ORDER BY DESCRIPTION");
 $temp=' checked="checked"';
 while ($row = $giros->sqlData()) {
  printf("     <input type=\"Radio\" name=\"rgCat\" value=\"%s\" size=\"0\"%s>%s<br>\n",$row['NOTYPE'],$temp,$row['DESCRIPTION']);
  $temp='';
 }
?>
     <input type="submit" name="submit" value="Enregistrer"/>
     <input type="reset"/><br/>
    </div>
   </form>
<?php echo $ERROR ?>
  </div>
 </div>
</body>
</html>
<?php
 }
?>