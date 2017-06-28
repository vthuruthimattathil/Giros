<?php
//  sleep(10);
include_once("../session.php");
$giros=$_SESSION['GIROS'];
$id=$_POST['id'];
switch ($id) {
 case 'untis':
  $untis=$_POST['untis'];
  $giros->sqlConnect();
  $query="SELECT count(IAM) AS QTE,NOCOMMANDE,TYPE,PAGES,DATE_FORMAT(DATE,'%d.%m.%Y') AS DATE_F FROM COMMANDE ";
  $query.="LEFT JOIN COMMANDE_ELEVE USING(NOCOMMANDE)";
  $query.=sprintf("WHERE UNTIS='%s' ",$untis);
  $query.="GROUP BY NOCOMMANDE ORDER BY DATE";
  $giros->sqlQuery($query);
  $flag=0;
  while($row=$giros->sqlData()) {
   if (($row['TYPE'] & 1)!=0) {
    if ($flag==0) {
     $flag=1;
     echo "<table id=\"myTable\"  class=\"tablesorter tablesorter-blue\" >\n";
     printf(" <thead>\n  <tr>\n   <th>Nombre d'exemplaires</th>\n   <th>Type</th>\n   <th>Payant</th>\n   <th>Date</th>\n   <th>Pages</th>\n  </tr>\n </thead>\n");
     echo " <tbody>\n";
    }
    if (($row['TYPE'] & 2)==0 )   {$type='NB';}     else {$type='C';}
    if (($row['TYPE'] & 4)==0 )   {$$type.=' / R';}  else {$type.=' / RV';}
    if (($row['TYPE'] & 8)==0 )   {$$type.=' / A4';} else {$type.=' / A3';}
    if (($row['TYPE'] & 32)!=0 )  {$$type.=' / T';}
    if (($row['TYPE'] & 64)!=0 )  {$$type.=' / P';}
    if (($row['TYPE'] & 128)!=0 ) {$$type.=' / A';}
    if (($row['TYPE'] & 256)!=0 ) {$$type.=' / SP';}
    if (($row['TYPE'] & 512)!=0 ) {$type.=' / Trans';}
    if (($row['TYPE'] & 16)==0 )  {$pay='Non';}  else {$pay='Oui';}
    printf("  <tr onclick='loadJobDetail(\"%s\")';>\n",$row['NOCOMMANDE']);
    printf("   <td>%s</td>\n",$row['QTE']);
    printf("   <td>%s</td>\n",$type);
    printf("   <td>%s</td>\n",$pay);
    printf("   <td>%s</td>\n",$row['DATE_F']);
    printf("   <td>%s</td>\n",$row['PAGES']);
    echo "  </tr>\n";
   }
  }
  if ($flag==1) {
   echo " </body>\n";
   echo "</table>\n";
  }
  break;

 case 'jobs':
  $nocommande=$_POST['jobID'];
  $giros->sqlConnect();
  $query="SELECT * FROM ELEVE LEFT JOIN COMMANDE_ELEVE USING(IAM) ";
  $query.=sprintf("WHERE NOCOMMANDE='%s' ",$nocommande);
  $query.="ORDER BY CODE,NOME,PRENOME";
  $giros->sqlQuery($query);
  $flag=0;
  $qte=0;
  while($row=$giros->sqlData()) {
   $qte++;
   if ($flag==0) {
    $flag=1;
    echo "<table  class=\"tablesorter tablesorter-blue\" >\n";
    printf(" <thead>\n  <tr>\n   <th>Classe</th>\n   <th>Nom</th>\n   <th>Pr&eacute;nom</th>\n  </tr>\n </thead>\n");
    echo " <tbody>\n";
   }
   echo "  <tr>\n";
   printf("   <td>%s</td>\n",$row['CODE']);
   printf("   <td>%s</td>\n",htmlentities($row['NOME']));
   printf("   <td>%s</td>\n",htmlentities($row['PRENOME']));
   echo "  </tr>\n";
  }
  if ($flag==1) {
   echo " </body>\n";
   echo "</table>\n";
   printf("Total: %s",$qte);
  } 
  break;
}
?>
