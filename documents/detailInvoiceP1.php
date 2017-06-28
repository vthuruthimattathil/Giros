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
 <title>Documents - D&eacute;tail facture</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../tablesorter/css/theme.blue.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.widgets.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="detailInvoice.js"></script>
</head>   
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">	
<?php $menu->display(); ?>
  </div>
  <div id="cont">
   <h1>S&eacute;lectionnez la classe:</h1>
   <form action="detailInvoice.php" method="post" enctype="multipart/form-data">
    <div>
     <select id="cl" name="classe" size="1" onchange="loadpers()">
       <option id="tmp">Classe:</option>
<?php
 $giros->sqlConnect();
 $query="SELECT DISTINCT CODE FROM CLASSE ORDER BY CODE";
 $giros->sqlQuery($query);
  while ($row = $giros->sqlData()) {
   printf ("       <option id=\"%s\" value=\"%s\">%s</option>\n",$row['CODE'],$row['CODE'],$row['CODE']);
  } 
?>
      </select>
      <br />
      <hr />
     <p id="wait" style="display:none">Chargement en cours</p>
      <div id="chkEle"></div>
      <hr />
      <div id="jobs" style="height: 450px; overflow: scroll;"></div>
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