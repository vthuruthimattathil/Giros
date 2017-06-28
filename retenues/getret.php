<?php
  include_once("../session.php");
  $giros=$_SESSION['GIROS'];
  $untis=$_POST['untis'];
  $giros->sql_connect();
  $query="SELECT NORETENUE,DATE_FORMAT(DATER,'%e/%c/%Y') AS DATERF,SALLE,MOTIF,DATE_FORMAT(DATEI,'%e/%c/%Y') AS DATEIF,NOME,PRENOME,CODE FROM RETENUE LEFT JOIN DATESR USING (NODATER) LEFT JOIN ELEVE USING(MATRICULE)WHERE UNTIS='$untis' ORDER BY DATER DESC";
  $giros->sql_query($query);
?>
   <h2>Compositions:</h2>
   <table border="1" rules="groups" width="100%">
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
  while ($row = $giros->sql_data()) {
   $s[0]= '<input type="checkbox" name="noretenue[]" value="'.$row['NORETENUE'].'">';
   $s[1]=htmlentities($row['NOME']);
   $s[2]=htmlentities($row['PRENOME']);
   $s[3]=htmlentities($row['CODE']);
   $s[4]=htmlentities($row['DATERF']);
   $s[5]=htmlentities($row['SALLE']);
   $s[6]=htmlentities($row['DATEIF']);
   $s[7]=htmlentities($row['MOTIF']);
   echo "   <tr>\n";
   for ($i=0;$i<=7;$i++) {
    printf("    <td>%s</td>\n",$s[$i]);
   }
   echo "   </tr>\n";
  }
?>
    </tbody>
   </table>