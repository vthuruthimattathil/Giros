<?php
include_once("../session.php");
$giros=$_SESSION['GIROS'];
$code=$_POST['code'];
$giros->sqlConnect();
?>
<hr />
<?php 
  $query=sprintf("SELECT MATRICULE,NOME,PRENOME,CODE FROM ELEVE WHERE CODE=\"%s\" ORDER BY NOME,PRENOME",$code);
  $giros->sqlQuery($query);
  echo "<span style=\"font-size: 125%\">$code:</span>\n";
?>
<table>
<?php  
  $i=0;
  while($row=$giros->sqlData()) {
   if ($i==0) { echo " <tr>\n";}
    printf("  <td class = \"ele\" style=\"cursor: pointer;\" onclick=\"addEle('%s','%s','%s','%s');\">",$row['MATRICULE'],addslashes(htmlentities($row['NOME'])),addslashes(htmlentities($row['PRENOME'])),$row['CODE']);
    echo htmlentities($row['NOME']." ".$row['PRENOME']);
    echo "</td>\n";
   if ($i==2) {echo " </tr>\n";}
   $i++;
   $i=$i%3; 
  }
  if ($i!=2) {
   for ($j = $i; $j < 3; $j++) {echo "  <td></td>\n";}
   echo " </tr>\n";
  }

  ?>
</table>
<hr />