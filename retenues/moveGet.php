<?php
include_once("../session.php");
switch ($_POST['switch']) {
 case 'loadret':
  loadRet($_POST['untis']);
  break;
 case 'loaddate':
  loadDate($_POST['noretenue']);
  break;
 default:
  break;
}

function loadRet($untis) {
 $giros = $_SESSION['GIROS'];
 $giros->sqlConnect();
 $query = "SELECT NODATER,COUNT(NORETENUE) AS QTE FROM DATESR LEFT JOIN RETENUE USING(NODATER) WHERE DATER > CURDATE() GROUP BY NODATER";
 $giros->sqlQuery($query);
 while ($row = $giros->sqlData()) {
  $QTE[$row['NODATER']] = $row['QTE'];
 }
 $query = "SELECT NORETENUE,DATE_FORMAT(DATER,'%d/%m/%Y %H:%i') AS DATERF,SALLE,MOTIF,DATE_FORMAT(DATEI,'%e/%c/%Y') AS DATEIF,";
 $query.="NOME,PRENOME,CODE FROM RETENUE LEFT JOIN DATESR USING (NODATER) LEFT JOIN ELEVE USING(IAM) ";
 $query.=sprintf("WHERE UNTIS='%s' ORDER BY DATER DESC", $untis);
 $giros->sqlQuery($query);
 ?>
 <h2>Retenues:</h2>
 <table  id="rets" class="tablesorter tablesorter-blue" >
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
      while ($row = $giros->sqlData()) {
       $s[0] = '<input type="radio" class ="noret" name="noretenue[]" value="' . $row['NORETENUE'] . '" onclick="checkdates();">';
       $s[1] = htmlentities($row['NOME']);
       $s[2] = htmlentities($row['PRENOME']);
       $s[3] = htmlentities($row['CODE']);
       $s[4] = htmlentities($row['DATERF']);
       $s[5] = htmlentities($row['SALLE']);
       $s[6] = htmlentities($row['DATEIF']);
       $s[7] = htmlentities($row['MOTIF']);
       echo "   <tr>\n";
       for ($i = 0; $i <= 7; $i++) {
        printf("    <td>%s</td>\n", $s[$i]);
       }
       echo "   </tr>\n";
      }
      ?>
  </tbody>
 </table>
 <?php
}

function loadDate($noretenue) {
 $giros = $_SESSION['GIROS'];
 $giros->sqlConnect();
 ?> 
 <h2>Dates disponibles:</h2>
 <table id="datesr" class="tablesorter tablesorter-blue">
  <thead align="left">
   <tr> 
    <th>Date</th>
    <th>Commentaire</th>
    <th>Heure</th>
    <th>Salle</th>
    <th>Maximum</th>
    <th>Inscrits</th>
    <th>Disponibles</th>
   </tr>
  </thead>
  <tbody style="border-collapse:collapse; ">

   <?php
   // $query="SELECT NODATER,DATE_FORMAT(DATER,'%e/%c/%Y') AS DATERF,DATE_FORMAT(DATER,'%k %i') AS HEURE,SALLE,COMMENT,NOMBREMAX FROM DATESR WHERE DATER > CURDATE() ORDER BY DATER DESC";
   $query = "SELECT NODATER,DATE_FORMAT(DATER,'%e/%c/%Y') AS DATERF,DATE_FORMAT(DATER,'%k %i') AS HEURE,SALLE,COMMENT,NOMBREMAX,COUNT(NORETENUE) AS QTE FROM DATESR LEFT JOIN RETENUE USING(NODATER) GROUP BY NODATER ORDER BY DATER DESC";
   $giros->sqlQuery($query);
   while ($row = $giros->sqlData()) {
    $s[0] = '<input type="radio" name="newdate" value="' . $row['NODATER'] . '" id="' . $row['NODATER'] . '">' . htmlentities($row['DATERF']);
    $s[1] = htmlentities($row['COMMENT']);
    $s[2] = htmlentities($row['HEURE']);
    $s[3] = htmlentities($row['SALLE']);
    $s[4] = htmlentities($row['NOMBREMAX']);
    $s[5] = htmlentities($row['QTE']);
    $s[6] = htmlentities($row['NOMBREMAX']*1 - $row['QTE']*1);
    echo "   <tr>\n";
    for ($i = 0; $i <= 6; $i++) {
     printf("    <td>%s</td>\n", $s[$i]);
    }
    echo "   </tr>\n";
   }
   ?>
  </tbody>
 </table>
 <?php
}
?>