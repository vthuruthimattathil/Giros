<?php
//  sleep(10);
include_once("../session.php");
$giros=$_SESSION['GIROS'];
$IAM=$_POST['IAM'];
$giros->sqlConnect();
$query=sprintf("SELECT * FROM  COMMANDE_ELEVE LEFT JOIN COMMANDE USING(NOCOMMANDE) LEFT JOIN PROF USING(UNTIS) WHERE COMMANDE_ELEVE.IAM='%s' ORDER BY DATE",$IAM);
$giros->sqlQuery($query);
echo "<table>\n";
echo "<tr>";
printf("<td>%s</td>\n<td>%s</td>\n<td>%s</td>\n<td>%s</td>\n<td>%s</td>\n",'Titulaire','Document','Date','Type','Pages');
echo"</tr>";
while($row=$giros->sqlData()) {
 echo "<tr>\n";
 $type=$row['TYPE'];
 switch ($type & 14) {
  case 0:
   $ttype='A4RB';
   break;
  case 2:
   $ttype='A4RC';
   break;
  case 4:
   $ttype='A4VB';
   break;
  case 6:
   $ttype='A4VC';
   break;
  case 8:
   $ttype='A3RB';
   break;
  case 10:
   $ttype='A3RC';
   break;
  case 12:
   $ttype='A3VB';
   break;
  case 14:
   $ttype='A3VC';
   break;
  default:
   $ttype='???';
  break;
 }
 if (($type & 16) == 0) {
  $ttype.='G';
 } else {
  $ttype.='P';
 }
 $date=explode(' ',$row['DATE']);
 $date_f=explode('-',$date[0]);
 if (($type & 1)==0) {
  //giros
  printf("<td>%s</td>\n<td>%s</td>\n<td>%02d-%02d-%04d</td>\n<td>%s</td>\n<td>%s</td>\n",htmlentities($row['NOM'].' '.$row['PRENOM']),htmlentities(stripslashes($row['NAME'])),$date_f[2],$date_f[1],$date_f[0],$ttype,$row['PAGES']); 
 } else {
  //bon
  printf("<td>%s</td>\n<td>%s</td>\n<td>%02d-%02d-%04d</td>\n<td>%s</td>\n<td>%s</td>\n",htmlentities($row['NOM'].' '.$row['PRENOM']),'Bon',$date_f[2],$date_f[1],$date_f[0],$ttype,$row['PAGES']); 
 }
 echo "</tr>\n";
}
echo "</table>\n";
?>
