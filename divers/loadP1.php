<?php
function showForm ($ERROR='') {
 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
 unset($_SESSION['MAINTENANCE']);
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {header("Location: ".$giros->getErrorUrl());}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
 <title>Maintenance - Charger &eacute;l&egrave;ves</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="load.js"></script>
</head>
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">
<?php $menu->display(); ?>
  </div>
  <div id="cont">
   <form action="load.php" method="post" enctype="multipart/form-data">
    <div>
     <h1>Charger &eacute;l&egrave;ves:</h1>
     Choisir fichier:
     <input type="file" name="edtFile" size="50" maxlength="255" /> <br />
     <input type="submit" name="submit" value="Envoyer" />
     <input type="reset" /> <br />
     <span style="color: red"><?php echo $ERROR;?></span>
    </div>
   </form>
  </div>
 </div> 
</body>
</html>
<?php
 }
?>