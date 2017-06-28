<?php
include_once("../session.php");
$giros=$_SESSION['GIROS'];
switch ($_POST['sw']) {
 case 'info':
  $IAM=urldecode($_POST['IAM']);
  $giros->sqlConnect();
  $query=sprintf("SELECT IAM,NOME,PRENOME,CODE,CREDIT FROM ELEVE WHERE IAM=\"%s\" ",$IAM);
  $giros->sqlQuery($query);
  if ($row=$giros->sqlData()) {
   $result=array('IAM'=>$row['IAM'],'nome'=>htmlentities($row['NOME']),'prenome'=>htmlentities($row['PRENOME']),'code'=>$row['CODE'],'credit'=>$row['CREDIT']);
  }
  else {
   $result=array('IAM'=>$IAM,'nome'=>'???','prenome'=>'???','code'=>'???','credit'=>'???');
  }
  echo json_encode($result);
  break;

 case 'encode':
  $giros->sqlConnect();
  $data= $_POST['IAM'];
  $IAMs='"';
  foreach ($data as $value) {
   $line=explode("@",$value);
   //[0] => classe [1] => nom prénom [2] => IAM [3] => ancien crédit [4] => ajout
   $query=sprintf("UPDATE ELEVE SET CREDIT=CREDIT+%F WHERE IAM=\"%s\"",$line[4],$line[2]);
   $giros->sqlQuery($query);
   $IAMs.=$line[2].'","';
  }
  $IAMs=substr($IAMs,0,-2);
  $query=sprintf("SELECT NOME,PRENOME,CODE,CREDIT FROM ELEVE WHERE IAM IN (%s) ORDER BY CODE,NOME,PRENOME",$IAMs);
  $giros->sqlQuery($query);
  ?>
<table>
 <thead>
  <tr>
   <th>Classe</th>
   <th>Nom</th>
   <th>Pr&eacute;nom</th>
   <th>Nouveau cr&eacute;dit</th>
  </tr>
 </thead>
 <tbody>
<?php 
while ($row=$giros->sqlData()) {
 echo "  <tr>\n";
 printf("   <td>%s</td>\n",htmlentities($row['CODE']));
 printf("   <td>%s</td>\n",htmlentities($row['NOME']));
 printf("   <td>%s</td>\n",htmlentities($row['PRENOME']));
 printf("   <td>%s</td>\n",htmlentities($row['CREDIT']));
 echo "  </tr>\n";
}
?>
	</tbody>
</table>
<?php 
 break;
}
?>
