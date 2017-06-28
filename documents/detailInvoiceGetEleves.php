<?php
//  sleep(10);
include_once("../session.php");
$giros=$_SESSION['GIROS'];
$classe=$_POST['classe'];
$giros->sqlConnect();
$query="SELECT IAM,NOME,PRENOME FROM ELEVE WHERE CODE=\"".$classe."\" ORDER BY NOME,PRENOME";
$giros->sqlQuery($query);
echo "<p>Cliquez sur un &eacute;l&eacute;ve pour obtenir le d&eacute;tail:</p>";
echo "<table style='cursor:crosshair;'>";
echo "<tbody>";
$i=0;
while($row=$giros->sqlData()) {
 if ($i==0) {
  echo " <tr>\n";
 }
 printf( "<td><div id='%s' onclick='loadDetail(\"%s\")'>%s</div></td>",$row['IAM'],$row['IAM'],htmlentities($row['NOME'].' '.$row['PRENOME']));
 if ($i==2) {
  echo " </tr>\n";
 }
 $i++;
 $i=$i%3;
}
if ($i!=2) {
 for ($j = $i; $j < 3; $j++) {
  echo "  <td></td>\n";
 }
 echo " </tr>\n";
}
echo "</tbody>";
echo "</table>";
?>
