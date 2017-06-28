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
 <title>Compositions - Inscrire pr&eacute;sences</title>
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
   <h1>Inscriptions pr&eacute;sences</h1>
    Choisissez une date pour inscrire les pr&eacute;sences:<br />
   <div style="height: 200px; overflow: scroll;">
    <table id="myTable"  class="tablesorter tablesorter-blue" >
     <thead>
      <tr>
       <th>Date</th>
       <th>Heure</th>
       <th>Salle</th>
       <th>Inscrits</th>
       <th>Maximum</th>
       <th>Surveillant</th>
       <th>Commentaire</th>
      </tr>
     </thead>
     <tbody>
<?php
 $url="present.php";
 $giros->sqlConnect();
 $query="SELECT DATESD.*,COUNT(DEVOIR.IAM) AS NUMBER FROM DATESD LEFT JOIN DEVOIR USING(NODATED) GROUP BY DATESD.NODATED ORDER BY DATESD.DATED";
 $giros->sqlQuery($query);
 while ($row = $giros->sqlData()) {
  list($date,$time) = explode(" ",$row['DATED']);
  list($year,$month,$day)=explode("-",$date);
  $date=$day.".".$month.".".$year;
  $s[0]=$date; // date
  $s[1]=$time; // heure
  list($s[1],$temp) = explode(":",$s[1]);
  $s[1]=$s[1].":".$temp;
  $s[2]=htmlentities($row['SALLE']); // salle
  $s[3]=$row['NUMBER']; //inscrits
  $s[4]=$row['NOMBREMAX']; //max
  $s[5]=htmlentities($row['SURVEILLANT']);
  $s[6]=htmlentities($row['COMMENT']);
  $temp=sprintf("onclick=\"updateData('%s');\"",$row['NODATED']);
  echo "   <tr>\n";
  for ($i=0;$i<=6;$i++) {
   printf("    <td %s>%s</td>\n",$temp,$s[$i]);
  }
  echo "   </tr>\n";
 }
?> 
     </tbody>
    </table>
   </div> 
   <div id="wait" style="display: none;">Chargment en cours</div>
   <div id="data"></div>
  </div>
 </div>
</body>
</html>
<?php
}