<?php

include_once("../session.php");
$giros = $_SESSION['GIROS'];
switch ($_POST['sw']) {
// Classes 
 case 'classe':
  $id = urldecode($_POST['id']);
  $giros->sqlConnect();
  $query = "SELECT IAM,NOME,PRENOME,CODE FROM ELEVE WHERE CODE=\"" . $id . "\" ORDER BY NOME,PRENOME";
  $giros->sqlQuery($query);
  if ($giros->sqlNumRows() != 0) {
   echo "<span style=\"font-size: 125%\">$id:</span>\n";
   echo "<table>\n";
   $i = 0;
   while ($row = $giros->sqlData()) {
    if ($i == 0) {
     echo " <tr>\n";
    }
    printf("  <td class = \"ele\" style=\"cursor: pointer;\" onclick=\"addEle('%s','%s','%s','%s');\">", $row['IAM'], addslashes(htmlentities($row['NOME'])), addslashes(htmlentities($row['PRENOME'])), $row['CODE']);
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
   echo "<span style=\"font-size: 125%\">Pas de classe.</span>\n";
  }
  break;

// Groupes
 case 'cluster':
  $id = urldecode($_POST['id']);
  $giros->sqlConnect();
  $query = "SELECT DESCRIPTION FROM CLUSTER WHERE NOCLUSTER=\"" . $id . "\"";
  $giros->sqlQuery($query);
  if ($giros->sqlNumRows() == 0) {
   echo "<span style=\"font-size: 125%\">Pas de groupes.</span>\n";
  } else {
   $row = $giros->sqlData();
   echo "<span style=\"font-size: 125%\">" . htmlentities($row['DESCRIPTION']) . ":</span>\n";
   $query = "SELECT IAM,NOME,PRENOME,CODE FROM ELEVE LEFT JOIN CLUSTER_ELEVE USING(IAM) WHERE NOCLUSTER=\"" . $id . "\" ORDER BY NOME,PRENOME";
   $giros->sqlQuery($query);
   if ($giros->sqlNumRows() != 0) {
    echo "<table>\n";
    $i = 0;
    while ($row = $giros->sqlData()) {
     if ($i == 0) {
      echo " <tr>\n";
     }
     printf("  <td class = \"ele\" style=\"cursor: pointer;\" onclick=\"addEle('%s','%s','%s','%s');\">", $row['IAM'], addslashes(htmlentities($row['NOME'])), addslashes(htmlentities($row['PRENOME'])), $row['CODE']);
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
}
?>