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
 <title>Documents - Supprimer fichier</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../tablesorter/css/theme.blue.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.widgets.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="deleteFile.js"></script>
</head>   
 
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">	
<?php $menu->display(); ?>
  </div>
  <div id="cont">
  <h1>Supprimer fichier:</h1>
   <form action="deleteFile.php" method="post">  
    <table id="myTable"  class="tablesorter tablesorter-blue" > 
     <thead>
      <tr>
       <th>File</th>
      </tr>
     </thead>
     <tbody>
<?php
 $giros->sqlConnect();
 $giros->sqlQuery("SELECT TDOCUMENT.DESCRIPTION AS TDESC,DOCUMENT.* FROM TDOCUMENT RIGHT JOIN DOCUMENT USING(NOTYPE) ORDER BY TDOCUMENT.DESCRIPTION, DOCUMENT.DESCRIPTION");
 while ($row = $giros->sqlData()) {
  echo "<tr>\n";
  printf("<td><input type=\"checkbox\" name=\"file[]\" value=\"%s\"></td>",$row['NO']);
  printf("<td>%s</td>",$row['TDESC']);
  printf("<td>%s</td>",$row['DESCRIPTION']);
  echo "<tr>\n";
 }
?>
      </tbody>
    </table>
   <div><input type="submit" value="Effacer" /> </div>
  </form>
 </div>
</div>
</body>
</html>
<?php
 }
 
?>