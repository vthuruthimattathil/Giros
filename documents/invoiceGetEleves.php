<?php
//  sleep(10);
include_once("../session.php");
$giros=$_SESSION['GIROS'];
$classe=$_POST['classe'];
$giros->sqlConnect();
$query="SELECT IAM,NOME,PRENOME FROM ELEVE WHERE CODE=\"".$classe."\" ORDER BY NOME,PRENOME";
$giros->sqlQuery($query);
echo "<table>";
echo "<tbody>";
$i=0;
while($row=$giros->sqlData()) {
 if ($i==0) {
  echo " <tr>\n";
 }
 printf( "<td><input type='checkbox' class='chkIAM' name='chkIAM[]' value='%s' checked='checked'	> %s</td>",$row['IAM'],htmlentities($row['NOME'].' '.$row['PRENOME']));
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
