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
 <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
 <title>Retenues - Liste par classe</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="listClass.js"></script>
</head>  
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">
<?php $menu->display(); ?>
  </div>
  <div id="cont">
   <h1>Relev&eacute; par classe:</h1>
<?php
 $giros->sqlConnect();
 $giros->sqlQuery("SELECT DISTINCT CODE FROM CLASSE ORDER BY CODE");
?>
   <form id="e1" action="listClass.php" method="post">
    <div>
     S&eacute;lectionnez votre classe:<br />
     <select name="classe" size="1" onchange="$('#e1').submit();">
      <option id="tmp">Classe:</option> 
<?php
 while ($row = $giros->sqlData()) {
  printf ("      <option value=\"%s\">%s</option>\n",$row['CODE'],$row['CODE']);
 }
?>
     </select>
    </div> 
   </form>
  </div>
 </div>
</body>
</html>
<?php
}
?>