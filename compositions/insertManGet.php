<?php
//  sleep(10);
  include_once("../session.php");
  $giros=$_SESSION['GIROS'];
  $classe=$_POST['classe'];
  $giros->sqlConnect();
  $query="SELECT MATRICULE,NOME,PRENOME FROM ELEVE WHERE CODE=\"".$classe."\" ORDER BY NOME,PRENOME";
  $giros->sqlQuery($query);
  echo "<select id=\"sel\" name=\"matricule[]\" multiple=\"multiple\" size=\"10\">\n";
  while($row=$giros->sqlData()) {
   echo " <option value=\"".$row['MATRICULE']."\">".htmlentities($row['NOME'])." ".htmlentities($row['PRENOME'])."</option>\n";
  }  
 echo "</select>";
?>