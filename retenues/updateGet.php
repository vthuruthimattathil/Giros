<?php
 include_once("../session.php");
 $giros=$_SESSION['GIROS'];
 $noretenue=$_POST['noretenue'];
 $giros->sqlConnect();
 $query="select * from RETENUE where noretenue ='".$noretenue."'";
 $giros->sqlQuery($query);
 $row=$giros->sqlData();
 $IAM=$row['IAM']; 
 $query="SELECT NODATER,DATE_FORMAT(DATER,'%Y-%m-%d') AS DATER_MYSQL,DATE_FORMAT(DATER,'%d.%m.%Y') AS DATER_D,DATE_FORMAT(DATER,'%T') AS DATER_T,";
 $query.="SALLE,NOMBREMAX,COMMENT,COUNT(NORETENUE) AS QTE FROM DATESR LEFT JOIN RETENUE USING(NODATER) ";
 $query.="WHERE DATER > NOW() GROUP BY NODATER ORDER BY DATER";
 $giros->sqlQuery($query);
 $datesr=array();
 while ($row=$giros->sqlData()) {
  $datesr[]=$row;
 }
 $query="SELECT 'R' AS TYPE,DATE_FORMAT(DATER,'%Y-%m-%d') AS DATE_MYSQL,DATE_FORMAT(DATER,'%d.%m.%Y') AS DATE_D,DATE_FORMAT(DATER,'%T') AS DATE_T,";
 $query.=sprintf("UNTIS,MOTIF FROM RETENUE LEFT JOIN DATESR USING(NODATER) WHERE IAM='%s'",$IAM);
 $query.="UNION SELECT 'D' AS TYPE,DATE_FORMAT(DATED,'%Y-%m-%d') AS DATE_MYSQL,DATE_FORMAT(DATED,'%d.%m.%Y') AS DATE_D,DATE_FORMAT(DATED,'%T') AS DATE_T,";
 $query.=sprintf("UNTIS,BRANCHE AS MOTIF FROM DEVOIR LEFT JOIN DATESD USING(NODATED) WHERE IAM='%s' ORDER BY DATE_MYSQL",$IAM);
 $giros->sqlQuery($query);
 $ret=array();
 while ($row=$giros->sqlData()) {
  $ret[]=$row;
 }
?>
<div style="height: 200px; overflow:scroll;">
<table class="datesr tablesorter tablesorter-blue">
 <thead>
  <tr>
   <th>Date</th>
   <th>Type</th>
   <th>UNTIS</th>
   <th>Motif</th>
  </tr>
 </thead>
 <tbody>
<?php 
 foreach ($ret as $key => $value) {
  echo "<tr>\n";
  printf("<td>%s %s</td>",$value['DATE_D'],$value['DATE_T']);
  printf("<td>%s</td>",$value['TYPE']);
  printf("<td>%s</td>",$value['UNTIS']);
  printf("<td>%s</td>",$value['MOTIF']);
  echo "</tr>\n";
 } 
?> 
 </tbody>
</table> 
</div>
<hr />
<div style="height: 300px; overflow:scroll;">
<table class="datesr tablesorter tablesorter-blue">
 <thead>
  <tr>
   <th>Date</th>
   <th>Max</th>
   <th>Libre</th>
   <th>Salle</th>
   <th>Commentaire</th>
  </tr>
 </thead>
 <tbody>
<?php 
 foreach ($datesr as $key => $value) {
  $color='black';
  if (($value['NOMBREMAX']*1-$value['QTE'])<=0) {
   $color='fuchsia';
  }
  foreach ($ret as $key2 => $value2) {
   if ($value['DATER_D']==$value2['DATE_D']) {
    $color="red";
   }
  }
  printf("<tr>\n");
  printf("<td style='color:%s'><input type=\"radio\" name=\"nodater\" id=\"nodater\" value=\"%s\">%s %s</td>",$color,$value['NODATER'],$value['DATER_D'],$value['DATER_T']);
  printf("<td style='color:%s'>%s</td>",$color,$value['NOMBREMAX']);
  printf("<td style='color:%s'>%d</td>",$color,$value['NOMBREMAX']*1-$value['QTE']);
  printf("<td style='color:%s'>%s</td>",$color,$value['SALLE']);
  printf("<td style='color:%s'>%s</td>",$color,$value['COMMENT']);
  echo "</tr>\n";
 } 
?>
 </tbody>
</table> 
</div>
<hr />
