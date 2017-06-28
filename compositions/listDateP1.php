<?php
function showForm() {
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
 <title>Compositions - Liste par date</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../tablesorter/css/theme.blue.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.widgets.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="listDate.js"></script>
</head>
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">	
<?php $menu->display(); ?>
  </div>
  <div id="cont"> 
   <form action="listDate.php" method="post" id="frm">     
    <h1>Relev&eacute; par date</h1>
    <h2>S&eacute;lectionnez une date pour obtenir le relev&eacute;:</h2>
    <table id="myTable"  class="tablesorter tablesorter-blue" >
     <thead>
      <tr>
       <th></th>
       <th>Date</th>
       <th>Salle</th>
       <th>Inscrits</th>
       <th>Maximum</th>
       <th>R&eacute;servation</th>
       <th>Commentaire</th>
       <th>Surveillant</th>
      </tr>
     </thead>
     <tbody>        
<?php
 $giros->sqlConnect();
 $query="SELECT NODATED,DATE_FORMAT(DATED,'%d.%m.%Y %H:%i') AS FDATED,SALLE,NOMBREMAX,COMMENT,RESERVATION,SURVEILLANT,COUNT(DEVOIR.IAM) AS NUMBER ";
 $query.="FROM DATESD LEFT JOIN DEVOIR USING(NODATED) GROUP BY DATESD.NODATED ORDER BY DATESD.DATED,SALLE";
 $giros->sqlQuery($query);
 while ($row = $giros->sqlData()) {
  $s[0]=sprintf("<input type=\"radio\" name=\"nodated\" value=\"%s\"/ >",$row['NODATED']);
  $s[1]=$row['FDATED']; // date
  $s[2]=htmlentities($row['SALLE']); // salle
  $s[3]=$row['NUMBER']; //inscrits
  $s[4]=$row['NOMBREMAX']; //max
  $s[5]=$row['RESERVATION']; // réservation
  $s[6]=htmlentities($row['COMMENT']);
  $s[7]=htmlentities($row['SURVEILLANT']);
  echo "  <tr>\n";
  for ($i=0;$i<=7;$i++) {
   printf("   <td onclick=\"$('#frm').submit()\">%s</a></td>\n",$s[$i]);
  }
  echo "  </tr>\n";
 }
 ?>
     </tbody>
    </table>
   </form>
  </div>
 </div>
</body>
</html>
<?php
 }