<?php
 include_once("../session.php");
 $giros=$_SESSION['GIROS'];
 $untis=$_POST['untis'];
 $giros->sqlConnect();
?>
<h2>Retenues:</h2>
<table id="myTable" class="tablesorter tablesorter-blue">
 <thead align="left">
  <tr>
   <th></th>
   <th>Nom</th>
   <th>Pr&eacute;nom</th>
   <th>Classe</th>     
   <th>Date retenue</th>
   <th>Salle</th>
   <th>Date d'inscription</th>
   <th>Motif</th>
  </tr>
 </thead>
 <tbody>
<?php
  $query="SELECT NORETENUE,DATE_FORMAT(DATER,'%d.%m.%Y %H:%i') AS DATERF,SALLE,MOTIF,DATE_FORMAT(DATEI,'%d.%m.%Y %H:%i') AS DATEIF,";
  $query.="NOME,PRENOME,CODE FROM RETENUE LEFT JOIN DATESR USING (NODATER) LEFT JOIN ELEVE USING(IAM) ";
  $query.=sprintf("WHERE UNTIS='%s' ORDER BY DATER DESC",$untis);
  $giros->sqlQuery($query);
  while ($row = $giros->sqlData()) {
   $s[0]= '<input type="checkbox" name="noretenue[]" value="'.$row['NORETENUE'].'">';
   $s[1]=htmlentities($row['NOME']);
   $s[2]=htmlentities($row['PRENOME']);
   $s[3]=htmlentities($row['CODE']);
   $s[4]=htmlentities($row['DATERF']);
   $s[5]=htmlentities($row['SALLE']);
   $s[6]=htmlentities($row['DATEIF']);
   $s[7]=htmlentities($row['MOTIF']);
   echo "  <tr>\n";
   for ($i=0;$i<=7;$i++) {
    printf("   <td>%s</td>\n",$s[$i]);
   }
   echo "  </tr>\n";
  }
?>
 </tbody>
</table>
