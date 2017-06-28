<?php
  include_once("../session.php");
  $giros=$_SESSION['GIROS'];
  $untis=urldecode($_POST['UNTIS']); 
  $giros->sqlConnect();
  $query="SELECT CODE,COUNT(*) AS QTE FROM ENSEIGNER LEFT JOIN ELEVE USING(CODE) WHERE UNTIS='$untis' GROUP BY CODE";
  $giros->sqlQuery($query);
?>
 <select id="mycl" name="mycl" size="1"  onclick="updateClasse('#mycl');">
<?php
 while ($row = $giros->sqlData()) {
  printf ("   <option id=\"%s\" value=\"%s\">%s</option>\n",$row['CODE'],$row['QTE'],$row['CODE']);
 }
?>
  </select> 
