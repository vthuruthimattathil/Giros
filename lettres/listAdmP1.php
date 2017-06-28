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
 <title>Lettres - Relev&eacute; g&eacute;n&eacute;ral</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../tablesorter/css/theme.blue.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.widgets.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="listAdm.js"></script>
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
 $query="SELECT NOLETTRE,NOME,PRENOME,CODE,DATE_FORMAT(DATEI,'%e.%c.%Y') AS DATEINS,NOTYPE,PROF.NOM AS PNOM,PROF.PRENOM AS PPRENOM ";
 $query.="FROM LETTRE LEFT JOIN ELEVE USING(IAM) LEFT JOIN PROF USING(UNTIS) ORDER BY NOLETTRE";
 $giros->sqlQuery($query);
 if($giros->sqlNumRows()==0) {
?>
   <p>Pas de lettre.</p>
<?php    
  }
 else {
?>
   <h1>Les lettres:</h1>
   <p>Cliquez sur une lettre pour obtenir le fichier PDF</p>  
   <table id='myTable' class='tablesorter tablesorter-blue'>
    <thead>
     <tr>
      <th>R&eacute;f&eacute;rence</th>
      <th>Date</th>
      <th>Titulaire</th>
      <th>El&egrave;ve</th>
      <th>Classe</th>
      <th>Type</th>
     </tr> 
    </thead>
    <tbody> 
<?php
  while ($row = $giros->sqlData()) {
   $temp="<a href=\"listAdm.php?id=".urlencode($row['NOLETTRE'])."\" target=\"_blank\">";
   $s[0]=$row['NOLETTRE'];
   $s[1]=$row['DATEINS'];
   $s[2]=  htmlentities($row['PNOM']." ".$row['PPRENOM']);
   $s[3]=  htmlentities($row['NOME']." ".$row['PRENOME']);
   $s[4]=$row['CODE'];
   switch ($row['NOTYPE']) {
    case 0: 
     $s[5]='Absences';
    break;
    case 1:
     $s[5]='Absences cert. m&eacute;d.';
    break;    
    case 2:
     $s[5]='Absences chambre';
    break;
   case 3:
     $s[5]='Absences 40h';
    break;
   }
   echo "     <tr>\n";
   for ($i=0;$i<=5;$i++) {
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