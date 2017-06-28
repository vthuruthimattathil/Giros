<?php

function showForm() {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
 <title>Lettres - Relev&eacute; personnel</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../tablesorter/css/theme.blue.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.widgets.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="list.js"></script>
</head>  
<body>
<?php
 include ("../logo.php");
?>
 <div id="ww">
  <div id="sidemenu">
<?php 
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 $menu->display()
?>
  </div>
  <div id="cont">
<?php 
 $giros->sqlConnect();
 $query="SELECT NOLETTRE,NOME,PRENOME,CODE,DATE_FORMAT(DATEI,'%e.%c.%Y') AS DATEINS,NOTYPE FROM LETTRE LEFT JOIN ELEVE USING(IAM) ";
 $query.=sprintf("WHERE UNTIS='%s' ORDER BY DATEI,NOME",$giros->getUntis());
 $giros->sqlQuery($query);
 if($giros->sqlNumRows()==0) {
?>
   <p>Vous n'avez pas de lettre.</p>
<?php    
  }
 else {
?>
   <h1>Vos lettres:</h1>
   <p>Cliquez sur une lettre pour obtenir le fichier PDF</p>  
   <table id='myTable' class='tablesorter tablesorter-blue'>
    <thead>
     <tr>
      <th>Date</th>
      <th>Nom</th>
      <th>Pr&eacute;nom</th>
      <th>Classe</th>
      <th>Type</th>
     </tr> 
    </thead>
    <tbody> 
<?php
  while ($row = $giros->sqlData()) {
   $temp="<a href=\"list.php?id=".urlencode($row['NOLETTRE'])."\" target=\"_blank\">";
   $s[0]=$row['DATEINS'];
   $s[1]=htmlentities($row['NOME']);
   $s[2]=htmlentities($row['PRENOME']);
   $s[3]=$row['CODE'];
   switch ($row['NOTYPE']) {
    case 0: 
     $s[4]='Absences';
    break;
    case 1:
     $s[4]='Absences cert. m&eacute;d.';
    break;    
    case 2:
     $s[4]='Absences chambre';
    break;
   case 3:
     $s[4]='Absences 40h';
    break;
   }
   echo "     <tr>\n";
   for ($i=0;$i<=4;$i++) {
    printf("      <td>%s%s</a></td>\n",$temp,$s[$i]);
   }
   echo "  </tr>\n";
  }
?>
    </tbody>
   </table>
<?php 
 }

?>   
  </div>
 </div>
</body>
</html>
<?php 
}
?>