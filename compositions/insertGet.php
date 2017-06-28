<?php
//  sleep(10);
include_once("../session.php");
$giros = $_SESSION['GIROS'];
switch ($_POST['sw']) {
 // Classes
 case 'classe':
  $classe = urldecode($_POST['classe']);
  $giros->sqlConnect();
  $query = "SELECT IAM,NOME,PRENOME,CODE FROM ELEVE WHERE CODE=\"" . $classe . "\" ORDER BY NOME,PRENOME";
  $giros->sqlQuery($query);
  if ($giros->sqlNumRows() == 0) {
   echo "<span style=\"font-size: 125%\">Pas de classe.</span>\n";
  } else {
   echo "<span style=\"font-size: 125%\">$classe:</span>\n";
   echo "<table>\n";
   $i = 0;
   while ($row = $giros->sqlData()) {
    if ($i == 0) {
     echo " <tr>\n";
    }
    printf("  <td class = \"ele\" style=\"cursor: pointer;\" onclick=\"addEle('%s','%s','%s','%s', 0);\">", $row['IAM'], addslashes(htmlentities($row['NOME'])), addslashes(htmlentities($row['PRENOME'])), $row['CODE']);
    echo htmlentities($row['NOME'] . " " . $row['PRENOME']);
    echo "</td>\n";
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
  }
  break;

 // groupes
 case 'cluster':
  $cluster = urldecode($_POST['cluster']);
  $giros->sqlConnect();
  $query=sprintf("SELECT DESCRIPTION FROM CLUSTER WHERE NOCLUSTER='%s'",$cluster);
  $giros->sqlQuery($query);
  if ($giros->sqlNumRows() == 0) {
   echo "<span style=\"font-size: 125%\">Pas de groupe.</span>\n";
  } else {
   $row = $giros->sqlData();
   echo "<span style=\"font-size: 125%\">" . htmlentities($row['DESCRIPTION']) . ":</span>\n";
   $query = sprintf("SELECT IAM,NOME,PRENOME,CODE FROM ELEVE LEFT JOIN CLUSTER_ELEVE USING(IAM) WHERE NOCLUSTER='%s' ORDER BY NOME,PRENOME",$cluster);
   $giros->sqlQuery($query);
   if ($giros->sqlNumRows() != 0) {
    echo "<table>\n";
    $i = 0;
    while ($row = $giros->sqlData()) {
     if ($i == 0) {
      echo " <tr>\n";
     }
     printf("  <td class = \"ele\" style=\"cursor: pointer;\" onclick=\"addEle('%s','%s','%s','%s', 0);\">", $row['IAM'], addslashes(htmlentities($row['NOME'])), addslashes(htmlentities($row['PRENOME'])), $row['CODE']);
     echo htmlentities($row['NOME'] . " " . $row['PRENOME']);
     echo "</td>\n";
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
    echo "<p>Pas d'&eacute;l&egrave;ves inscrits.</p>\n";
   }
  }
  break;

 case 'dateEPS': 
 case 'date':
  if (isset($_POST['ele'])) {
   foreach ($_POST['ele'] as $ele) {
    $line = explode('@', $ele);
    $IAM[] = $line[2];
   }
   // generate dates array
   $giros->sqlConnect();
   if ($_POST['sw']=='date') {
    $query = sprintf("SELECT * FROM DATESD WHERE (DATED > NOW() + INTERVAL 3 DAY) AND (RESERVATION ='' OR RESERVATION='%s')  AND (TYPE=0 OR TYPE=1) ORDER BY DATED", $giros->getUntis());
   }
   else {
    $query = sprintf("SELECT * FROM DATESD WHERE (DATED > NOW() + INTERVAL 3 DAY) AND (RESERVATION ='' OR RESERVATION='%s')  AND (TYPE=3) ORDER BY DATED", $giros->getUntis());
   }
   $giros->sqlQuery($query);
   $i = 0;
   while ($row = $giros->sqlData()) {
    $dates[$i]['NODATED'] = $row['NODATED'];
    $dates[$i]['DATED'] = $row['DATED'];
    list($date, $time) = explode(" ", $row['DATED']);
    list($year, $month, $day) = explode("-", $date);
    list($h, $m, $s) = explode(":", $time);
    $time = $h . ":" . $m;
    switch (date('w', mktime($h, $m, $s, $month, $day, $year))) {
     case "0": $date = "Dimanche ";
      break;
     case "1": $date = "Lundi ";
      break;
     case "2": $date = "Mardi ";
      break;
     case "3": $date = "Mercredi ";
      break;
     case "4": $date = "Jeudi ";
      break;
     case "5": $date = "Vendredi ";
      break;
     case "6": $date = "Samedi ";
      break;
    }
    $date = $date . $day . "." . $month . "." . $year;
    $dates[$i]['DATE'] = $date;
    $dates[$i]['TIME'] = $time;
    $dates[$i]['SALLE'] = $row['SALLE'];
    $dates[$i]['NOMBREMAX'] = (int) $row['NOMBREMAX'];
    $dates[$i]['COMMENT'] = $row['COMMENT'];
    $dates[$i]['NOMBRE'] = 0;
    $i++;
   }
   //  complete dates array -> check if pupils are already registered
   $nb = count($IAM);
   $IAM_list = "'" . implode("','", $IAM) . "'";
   $i = 0;
   foreach ($dates as $date) {
    $giros->sqlQuery("SELECT COUNT(*) AS QTE FROM DEVOIR WHERE NODATED='" . $dates[$i]['NODATED'] . "'");
    $row = $giros->sqlData();
    $dates[$i]['NOMBRE'] = (int) $row['QTE'];
    $i++;
   }
   ?>
   <table border="1" frame="box" rules="groups" cellpadding="4px">
    <thead>
     <tr>
      <th align="center">Date</th>
      <th align="center">Commentaire</th>
      <th align="center">Heure</th>
      <th align="center">Salle</th>
      <th align="center">Maximum</th>
      <th align="center">Inscrits</th>
      <th align="center">Disponibles</th>
     </tr>
    </thead>
    <tbody>
        <?php
        $ok = 0;
        $i = 0;
        $sel = ' checked="checked"';
        foreach ($dates as $date) {
         $disp = $date['NOMBREMAX'] - $date['NOMBRE'];
         $query = "SELECT COUNT(*) AS QTE FROM RETENUE LEFT JOIN DATESR USING(NODATER) WHERE ";
         $query.="DATE_FORMAT(DATER,'%Y-%m-%d')=DATE_FORMAT('" . $dates[$i]['DATED'] . "','%Y-%m-%d') AND IAM IN (" . $IAM_list . ")";
         $giros->sqlQuery($query);
         $row = $giros->sqlData();
         $qte = (int) $row['QTE'];
         $query = "SELECT COUNT(*) AS QTE FROM DEVOIR LEFT JOIN DATESD USING(NODATED) WHERE ";
         $query.="DATE_FORMAT(DATED,'%Y-%m-%d')=DATE_FORMAT('" . $dates[$i]['DATED'] . "','%Y-%m-%d') AND IAM IN (" . $IAM_list . ")";
         $giros->sqlQuery($query);
         $row = $giros->sqlData();
         $qte = $qte + (int) $row['QTE'];
         $i++;
         if (($disp < $nb) || ($qte != 0)) {
          $dis = ' disabled="disabled"';
          $selected = '';
         } else {
          $dis = '';
          $selected = $sel;
          $ok++;
         }
         if ($date['COMMENT'] != '') {
          $alert = "onclick='alert(\"Attention: " . htmlentities($date['COMMENT']) . "\")'";
         } else {
          $alert = '';
         }
         echo "       <tr>\n";
         echo "        <td><input type='radio' class ='nodated' name='nodated' value='" . $date['NODATED'] . "' $dis $selected $alert>" . $date['DATE'] . "</td>\n";
         if ($selected == '') {
          echo "        <td align='left'> <font color='red'>" . htmlentities($date['COMMENT']) . "</font></td>\n";
         } else {
          echo "        <td align='left' id='msg'> <font color='red'>" . htmlentities($date['COMMENT']) . "</font></td>\n";
         }
         echo '        <td align="center">' . $date['TIME'] . '</td>' . "\n";
         echo '        <td align="center">' . htmlentities($date['SALLE']) . '</td>' . "\n";
         echo '        <td align="right">' . $date['NOMBREMAX'] . '</td>' . "\n";
         echo '        <td align="right">' . $date['NOMBRE'] . '</td>' . "\n";
         echo '        <td align="right">' . $disp . '</td>' . "\n";
         echo "       </tr>\n";
         if ($dis == '') {
          $sel = '';
         }
        }
        ?>
    </tbody>
   </table>
   <?php
   if ($ok == 0) {
    ?>
    <script type="text/javascript">alert("Plus de rendez-vous disponible!");</script>
    <?php
   }
  }
  break;
}
?>