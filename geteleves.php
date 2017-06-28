<?php
  include_once("session.php");
  $giros=$_SESSION['GIROS'];
  $classe=$_POST['classe'];
  $giros->sql_connect();
  $query="SELECT MATRICULE,NOME,PRENOME FROM ELEVE WHERE CODE=\"".$classe."\" ORDER BY NOME,PRENOME";
  $giros->sql_query($query);
  echo "<select id=\"sel\" name=\"matricule[]\" multiple=\"multiple\" size=\"10\">\n";
  while($row=$giros->sql_data()) {
   echo " <option value=\"".$row['MATRICULE']."\">".htmlentities($row['NOME'])." ".htmlentities($row['PRENOME'])."</option>\n";
  }  
 echo "</select>";
?>