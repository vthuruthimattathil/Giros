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
 <title> - </title>
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
   <h1>Relev&eacute; par date:</h1>
   <h2>Type du relev&eacute;:</h2>
   <div>
    <input type="radio" checked="checked" value="1" name="rgcompact"/>Compact (pour surveillance) 
    <input type="radio" name="rgcompact" value="0"/>D&eacute;taill&eacute;
   </div>
   <h2>Choisissez une date pour obtenir le relev&eacute;:</h2>
   <table id="myTable"  class="tablesorter tablesorter-blue" >
    <thead>
     <tr>   
      <th></th>
      <th>Date</th>
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
 $query="SELECT NODATER, DATE_FORMAT(DATER,'%d.%m.%Y %k:%i') AS FDATER, SURVEILLANT, SALLE, NOMBREMAX, COMMENT,COUNT(RETENUE.IAM) AS NUMBER ";
 $query.="FROM DATESR LEFT JOIN RETENUE USING(NODATER) GROUP BY NODATER ORDER BY DATER,SALLE";
 $giros->sqlQuery($query);
 while ($row = $giros->sqlData()) {
 $s[0]=sprintf("<input type=\"radio\" name=\"nodater\" value=\"%s\"/ >",$row['NODATER']);
 $s[1]=$row['FDATER'];
 $s[2]=$row['SALLE']; // salle
 $s[3]=$row['NUMBER']; //inscrits
 $s[4]=($row['NOMBREMAX'])-$s[3]; // disponibles
 $s[5]=$row['NOMBREMAX']; //max
 $s[6]=$row['SURVEILLANT'];
 $s[7]=$row['COMMENT'];
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
?>
