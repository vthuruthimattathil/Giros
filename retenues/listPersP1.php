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
 <title>Retenues - Liste de vos retenues</title>
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
   <h1>Relev&eacute; des retenues:</h1>
   <p>Cliquez sur une inscription pour obtenir la convocation:</p>
   <p>Cliquez sur une ent&ecirc;te pour modifier l'ordre du tri.</p>
<?php
  $giros->sqlConnect();
  $query="SELECT ELEVE.*,DATESR.DATER,RETENUE.NORETENUE,RETENUE.PRESENT,RETENUE.NOREPORT,RETENUE.CO,RETENUE.REGENT, RETENUE.TRAVAIL FROM RETENUE LEFT JOIN ELEVE USING(IAM) ";
  $query.=sprintf("LEFT JOIN DATESR USING(NODATER) WHERE RETENUE.UNTIS='%s' ORDER BY ELEVE.CODE,ELEVE.NOME,DATESR.DATER",$giros->getUntis());
  $giros->sqlQuery($query);
?>  
   <table id="myTable" class="tablesorter tablesorter-blue" role="grid">
    <thead>
     <tr>
      <th>Date</th>
      <th>Heure</th>
      <th>Classe</th>
      <th>Nom</th>
      <th>Pr&eacutenom</th>
      <th>Travail &agrave; faire</th>
      <th>R&eacute;gent</th>
      <th>Pr&eacute;sent</th>
      <th>Convocation</th>
     </tr> 
    </thead>
    <tbody>
<?php     
  while ($row = $giros->sqlData()) {
   list($date,$time) = explode(" ",$row['DATER']);
   list($year,$month,$day)=explode("-",$date);
   $date=$day.".".$month.".".$year;
   $s[0]=$date; // date
   $s[1]=$time; // heure
   list($s[1],$temp) = explode(":",$s[1]);
   $s[1]=$s[1].":".$temp;
   $s[2]=$row['CODE'];
   $s[3]=$row['NOME'];
   $s[4]=$row['PRENOME'];
   $s[5]=$row['TRAVAIL'];
   if ($row['REGENT']==0) {
    $s[6]='-';}
   else {
    $s[6]='X';
   }
   switch ($row['PRESENT']) {
   	case -1: $s[7]='-';break;
   	case  0: $s[7]='A';break;
   	case  1: $s[7]='P'; break;
   }
   if (strlen($row['NOREPORT'])!=0) {
    $s[7].='R';
   }
   switch ($row['CO']) {
    case 'X': $s[8]='-';break;
    default: $s[8]=$row['CO'];
   }
   $temp="<a href=\"listPers.php?id=".urlencode($row['NORETENUE'])."\" target=\"_blank\">";
   echo "  <tr>\n";
   for ($i=0;$i<=8;$i++) {
   	if ($i<6) { printf("   <td>%s%s</a></td>\n",$temp,$s[$i]);} 
   	else {printf("   <td>%s</td>\n",$s[$i]);}
   }
   echo "  </tr>\n";
  }
  echo " </tbody>\n";
  echo "</table>\n";
?>
  <table>
   <tr>
    <td>Codes pour la rubrique pr&eacute;sent:</td>
    <td>A: absent</td>
    <td>Codes pour la rubrique convocation:</td>
    <td>M: manque</td>
   </tr>
   <tr>
    <td></td>
    <td>P: pr&eacute;sent</td>
    <td></td>
    <td>S: sign&eacute;e</td>
   </tr>
   <tr>
    <td></td>
    <td>-: inconnu</td>
    <td></td>
    <td>NS: non-sign&eacute;e</td>
   </tr>
   <tr>
    <td></td>
    <td>R: Retenue report&eacute;e ant&eacute;rieurement</td>
    <td></td>
    <td>-: inconnu</td>
   </tr>
  </table>
 </div>
</div>
</body>
</html>
<?php
 }