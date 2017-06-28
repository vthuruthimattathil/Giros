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
 <title>Compositions - Liste de vos inscriptions</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../tablesorter/css/theme.blue.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.widgets.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="listPers.js"></script>
</head> 
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">	
<?php $menu->display(); ?>
  </div>
  <div id="cont">     
   <h1>Cliquez sur une inscription pour obtenir la convocation:</h1>
    <table id='myTable' class='tablesorter tablesorter-blue'>
     <thead>
      <tr>
       <th>Date</th>
       <th>Heure</th>
       <th>Classe</th>
       <th>Nom</th>
       <th>Pr&eacute;nom</th>
       <th>Pr&eacute;sent</th>
      </tr> 
     </thead>
     <tbody> 
<?php
  $giros->sqlConnect();
  $query="SELECT ELEVE.CODE,ELEVE.NOME,ELEVE.PRENOME,DEVOIR.NODATED,DEVOIR.NODEVOIR,DEVOIR.PRESENT,DATESD.DATED ";
  $query.="FROM DEVOIR LEFT JOIN ELEVE USING (IAM) LEFT JOIN DATESD USING(NODATED) ";
  $query.=sprintf("WHERE DEVOIR.UNTIS='%s' ORDER BY ELEVE.CODE,ELEVE.NOME",$giros->getUntis());
  $giros->sqlQuery($query);
  while ($row = $giros->sqlData()) {
   list($date,$time) = explode(" ",$row['DATED']);
   list($year,$month,$day)=explode("-",$date);
   $date=$day.".".$month.".".$year;
   $s[0]=$date; // date
   $s[1]=$time; // heure
   list($s[1],$temp) = explode(":",$s[1]);
   $s[1]=$s[1].":".$temp;
   $s[2]=$row['CODE'];
   $s[3]=htmlentities($row['NOME']);
   $s[4]=htmlentities($row['PRENOME']);
   switch ($row['PRESENT']) {
   	case -1: $s[5]='-';break;
   	case 0: $s[5]='A';break;
    case 1: $s[5]='P';break;  	
   }
   $temp="<a href=\"listPers.php?id=".urlencode($row['NODEVOIR'])."\" target=\"_blank\">";
   echo "  <tr>\n";
   for ($i=0;$i<=5;$i++) {
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