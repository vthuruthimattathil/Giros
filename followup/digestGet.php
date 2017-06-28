<?php
//  sleep(10);
include_once("../session.php");
$giros = $_SESSION['GIROS'];
$classe = urldecode($_POST['classe']);
$giros->sqlConnect();
$query = sprintf("SELECT ELEVE.*,SUIVI_ELEVE.* FROM ELEVE LEFT JOIN SUIVI_ELEVE USING(IAM)  WHERE CODE='%s' ORDER BY NOME,PRENOME,SCOLAIRE", $classe);
$giros->sqlQuery($query);
?>
<form  action="digest.php" method="post">
 <table id="myTable" class="tablesorter tablesorter-blue">
  <thead>
   <tr>
    <th>Ann&eacute;e</th>
    <th>Nom</th>
    <th>Ins. livre classe</th>
    <th>Retenues</th>
    <th>Conseils de classe</th>
    <th>Absences exc/non-exc.</th>
    <th>Mosaik</th>
    <th>Interventions Pitstop</th>
    <th>Stage</th>
    <th>Orientation</th>
   </tr>
  </thead>
  <tbody>

   <?php
   if (isset($data)) {
    unset($data);
   }
   while ($row = $giros->sqlData()) {
    $data[] = $row;
   }
   foreach ($data as $row) {
    if ($row['NOPORTFOLIO'] == '') {
     echo "  <tr>\n";
     echo "   <td></td>";
     printf("   <td>%s %s</td>\n", $row['NOME'], $row['PRENOME']);
     echo "   <td></td>";
     echo "   <td></td>";
     echo "   <td></td>";
     echo "   <td></td>";
     echo "   <td></td>";
     echo "   <td></td>";
     echo "   <td></td>";
     echo "   <td></td>";
     echo "  </tr>\n";
    } else {
     printf("  <tr>\n");
     $chk = sprintf("<input type=\"checkbox\" name=\"id[]\" value=\"%s\" />", $row['NOPORTFOLIO']);
     printf("   <td>%s %s %s</td>\n", $chk, $row['SCOLAIRE'], $row['SCOLAIRE'] + 1);
     printf("   <td>%s %s</td>\n", $row['NOME'], $row['PRENOME']);
     if (isset($stage)) {
      unset($stage);
     }
     $query = sprintf("SELECT * FROM SUIVI_ELEVE_STAGE WHERE NOPORTFOLIO='%s'", $row['NOPORTFOLIO']);
     $giros->sqlQuery($query);
     while ($tmp = $giros->sqlData()) {
      $stage[] = $tmp;
     }
     printf("   <td>%u</td>\n", $row['INSCRIPTIONS_NB']);
     $nb_ret = $row['RET_BAGARRE'] + $row['RET_RETARDS'] + $row['RET_ABS'] + $row['RET_CONF'];
     $nb_ret+=$row['RET_COMPORTEMENT'] + $row['RET_FRAUDE'] + $row['RET_INSOLENCE'] + $row['RET_TABAGISME'];
     $nb_ret+=$row['RET_REFUS_PUNITION'] + $row['RET_MENSONGES'] + $row['RET_INSULTES'];
     $nb_ret+=$row['RET_OUBLIS'] + $row['RET_AUTRES'];
     $title = sprintf("Retenues de %s %s:\n", $row['NOME'], $row['PRENOME']);
     $title.=sprintf("Bagarre: %u\n",$row['RET_BAGARRE']);
     $title.=sprintf("Retards: %u\n",$row['RET_RETARDS']);
     $title.=sprintf("Absences non-exc.: %u\n",$row['RET_ABS']);
     $title.=sprintf("Abus confiance: %u\n",$row['RET_CONF']);
     $title.=sprintf("Comportement: %u\n",$row['RET_COMPORTEMENT']);
     $title.=sprintf("Fraude: %u\n",$row['RET_FRAUDE']);
     $title.=sprintf("Insolence: %u\n",$row['RET_INSOLENCE']);
     $title.=sprintf("Tabagisme: %u\n",$row['RET_TABAGISME']);
     $title.=sprintf("Refus de remttre une punition: %u\n",$row['RET_REFUS_PUNITION']);
     $title.=sprintf("Mensonges: %u\n",$row['RET_MENSONGES']);
     $title.=sprintf("Insultes: %u\n",$row['RET_INSULTES']);
     $title.=sprintf("Oublis: %u\n",$row['RET_OUBLIS']);
     $title.=sprintf("Autres:%u ",$row['RET_AUTRES']);
     printf("   <td title=\"%s\">%u</td>\n", $title, $nb_ret);
     printf("   <td>%u</td>\n", $row['CONSEIL_NB']);
     printf("   <td>%u/%u</td>\n", $row['ABS_EXC'] + $row['ABS_EXC_MED'], $row['ABS_NON_EXC']);
     if ($row['MOSAIK'] != 0) {
      print("   <td>Oui</td>\n");
     } else {
      print("   <td>Non</td>\n");
     }
     $nb_pitstop = $row['PIT_INSULTES'] + $row['PIT_DISPUTES'] + $row['PIT_REFUS_TRAVAIL'];
     $nb_pitstop+=$row['PIT_JET'] + $row['PIT_COMPORTEMENT'] + $row['PIT_AUTRE'];
     printf("   <td>%u</td>\n", $nb_pitstop);
     if (isset($stage)) {
      print("   <td>");
      $br = "";
      foreach ($stage as $value) {
       echo $br . $value['ENTREPRISE'];
       $br = "<br />\n";
      }
      print("   </td>");
     } else {
      print("   <td>Non</td>\n");
     }
     printf("   <td>%s</td>\n", $row['ORIENTATION']);
    }
    echo "  </tr>\n";
   }
   ?> 
  </tbody>
 </table> 
 <input type="submit" value="Imprimer les &eacute;l&eacute;ments sélectionn&eacute;s" />
</form>
<?php
?>