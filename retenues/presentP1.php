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
 <title>Retenues - Inscrire pr&eacute;sences</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../tablesorter/css/theme.blue.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.widgets.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="present.js"></script>
</head>   
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">	
<?php $menu->display(); ?>
  </div>
  <div id="cont">   
   <h1>Choisissez une date pour inscrire les pr&eacute;sences:</h1>
     <table id="myTable"  class="tablesorter tablesorter-blue" >
     <thead>
      <tr>
       <th>Date</th>
       <th>Heure</th>
       <th>Salle</th>
       <th>Inscrits</th>
       <th>Disponible</th>
       <th>Maximum</th>
       <th>Surveillant</th>
       <th>Commentaire</th>
      </tr>
     </thead>
     <tbody>
<?php 
 $giros->sqlConnect();
 $query="SELECT DATESR.*,COUNT(RETENUE.IAM) AS NUMBER, NOM, PRENOM FROM DATESR LEFT JOIN RETENUE USING(NODATER) ";
 $query.="LEFT JOIN PROF ON DATESR.SURVEILLANT=PROF.UNTIS GROUP BY NODATER ORDER BY DATER DESC,SALLE ASC";
 $giros->sqlQuery($query);
 while ($row = $giros->sqlData()) {
  list($date,$time) = explode(" ",$row['DATER']);
  list($year,$month,$day)=explode("-",$date);
  $date=$day.".".$month.".".$year;
  $s[0]=$date; // date
  $s[1]=$time; // heure
  list($s[1],$temp) = explode(":",$s[1]);
  $s[1]=$s[1].":".$temp;
  $s[2]=$row['SALLE']; // salle
  $s[3]=$row['NUMBER']; //inscrits
  $s[4]=($row['NOMBREMAX'])-$s[3]; // disponibles
  $s[5]=$row['NOMBREMAX']; //max
  $s[6]=$row['NOM'].' '.$row['PRENOM'];
  $s[7]=$row['COMMENT'];
  $temp="<a href=\"present.php?id=".urlencode($row['NODATER'])."\">";
  echo "  <tr>\n";
  for ($i=0;$i<=7;$i++) {
   printf("   <td>%s%s</a></td>\n",$temp,$s[$i]);
  }
  echo "  </tr>\n";
 }
?> 
     </tbody>
    </table>
   </div>
  </div>
 </body>
</html>
<?php
 }
?>