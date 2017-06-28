<?php
include_once("../session.php");
$giros = $_SESSION['GIROS'];
$id = urldecode($_POST['id']);
$giros->sqlConnect();
$query = sprintf("SELECT IAM,NOME,PRENOME,CODE FROM ELEVE WHERE CODE=\"%s\" ORDER BY NOME,PRENOME",$id);
$giros->sqlQuery($query);
if ($giros->sqlNumRows() != 0) {
 echo "<span style=\"font-size: 125%\">$id:</span>\n";
 echo "<table>\n";
 $i = 0;
 while ($row = $giros->sqlData()) {
  if ($i == 0) {
   echo " <tr>\n";
  }
  printf("  <td><input type='checkbox' name='ele[]' value='%s' />%s %s</td>\n",$row['IAM'],$row['NOME'],$row['PRENOME']);
  if ($i == 2) {
   echo " </tr>\n";
  }
  $i++;
  $i = $i % 3;
 }
 if ($i != 2) {
  for ($j = $i; $j < 3; $j++) {
   echo "  <td></td>\n";
  }
  echo " </tr>\n";
 }
 echo "</table>";
} else {
 echo "<span style=\"font-size: 125%\">Pas d'&eacute;l&egrave;ves.</span>\n";
}
?>