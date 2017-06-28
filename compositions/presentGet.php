<?php
include_once("../session.php");
$giros = $_SESSION['GIROS'];
$id=$_POST['id'];
$giros->sqlConnect();
$query=sprintf("SELECT * FROM DEVOIR LEFT JOIN PROF USING(UNTIS) LEFT JOIN ELEVE ON DEVOIR.IAM=ELEVE.IAM WHERE NODATED='%s' ORDER BY PRESENT,NOME",$id);
$giros->sqlQuery($query);
if ($giros->sqlNumRows()==0) {
 echo "<p>Pas d'inscriptions!</p>";
}
else {
?>
<form action="present.php"  method="post">
 <table  id="dataTable" class="tablesorter tablesorter-blue">
  <thead align="left">
   <tr>
    <th>Nom</th>
    <th>Prénom</th>
    <th>Classe</th>
    <th>Titulaire</th>
    <th>Case</th>
    <th>Présent</th>
   </tr>
  </thead>
  <tbody>
<?php
 
 while ($row = $giros->sqlData()) {
  $s[0]=htmlentities($row['NOME']);
  $s[1]=htmlentities($row['PRENOME']);
  $s[2]=htmlentities($row['CODE']);
  $s[3]=htmlentities($row['NOM'].' '.$row['PRENOM']);
  $s[4]=$row['NOCASE'];
  if ($row['PRESENT']!=1) {
   $s[5]='';
  }
  else {
   $s[5]=' checked="checked"';
  }
  $s[5]= '<input type="checkbox" name="present[]" value="'.$row['NODEVOIR'].'"'.$s[5].'>';
  echo "   <tr>\n";
  for ($i=0;$i<=5;$i++) {
   printf("    <td>%s</td>\n",$s[$i]);
  }
  echo "   </tr>\n";
 }
?>
  </tbody>
 </table>
 <div>
<?php
 printf("   <input type=\"hidden\" name=\"id\" value=\"%s\">",$id); 
?>
  <input type="submit" name="submit" value="Enregistrer et générer relevé" />
 </div>
</form> 
<?php
}
?>