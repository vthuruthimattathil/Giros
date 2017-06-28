<?php
  include_once("../session.php");
  $giros=$_SESSION['GIROS'];
  $untis=$_POST['untis'];
  $giros->sqlConnect();
  $query="SELECT NODEVOIR,DATE_FORMAT(DATED,'%e/%c/%Y') AS DATEDF,SALLE,BRANCHE,DATE_FORMAT(DATEC,'%e/%c/%Y') AS DATECF,DATE_FORMAT(DATEI,'%e/%c/%Y') AS DATEIF,NOME,PRENOME,CODE FROM DEVOIR LEFT JOIN DATESD USING (NODATED) LEFT JOIN ELEVE USING(IAM)WHERE UNTIS='$untis' ORDER BY DATED DESC";
  $giros->sqlQuery($query);
  if($giros->sqlNumRows()!=0) {
?>
   <h2>Compositions:</h2>
   <table id="myTable"  class="tablesorter tablesorter-blue" >
    <thead align="left">
     <tr>
      <th></th>
      <th>Nom</th>
      <th>Pr&eacute;nom</th>
      <th>Classe</th>     
      <th>Date du rep&ecirc;chage</th>
      <th>Branche</th>
      <th>Salle</th>
      <th>Date du devoir</th>
      <th>Date d'inscription</th>
     </tr>
    </thead>
    <tbody>
<?php
  while ($row = $giros->sqlData()) {
   $s[0]= '<input type="checkbox" name="nodevoir[]" value="'.$row['NODEVOIR'].'">';
   $s[1]=htmlentities($row['NOME']);
   $s[2]=htmlentities($row['PRENOME']);
   $s[3]=htmlentities($row['CODE']);
   $s[4]=htmlentities($row['DATEDF']);
   $s[5]=htmlentities($row['BRANCHE']);
   $s[6]=htmlentities($row['SALLE']);
   $s[7]=htmlentities($row['DATECF']);
   $s[8]=htmlentities($row['DATEIF']);
   echo "   <tr>\n";
   for ($i=0;$i<=8;$i++) {
    printf("    <td>%s</td>\n",$s[$i]);
   }
   echo "   </tr>\n";
  }
?>
    </tbody>
   </table>
<?php
  }
  else {
?>
   <p>Pas de compositions.</p>   
<?php
  }
?>