<?php 
function processForm () {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: ".$giros->getErrorUrl());
 }
 unset($synth);
 $giros->sqlConnect();
 foreach ($_POST['chkIAM'] as $key => $value) {
  $query="SELECT IAM,NOME,PRENOME,CODE,CREDIT,TYPE,SUM(PAGES) AS TOTAL FROM COMMANDE_ELEVE ";
  $query.="LEFT JOIN COMMANDE USING (NOCOMMANDE) LEFT JOIN ELEVE USING(IAM) ";
  $query.="WHERE IAM ='%s' AND DATE BETWEEN '%s' AND '%s' ";
  $query.="GROUP BY NOME,PRENOME,CODE,TYPE";
  $query=sprintf($query,$value,$_POST['dateStart'],$_POST['dateEnd']);
  $giros->sqlQuery($query);
  unset($tmp);
  for ($i = 0; $i <= 30; $i++) {
   $tmp[$i]=0;
  }
  for ($i = 0; $i < $giros->sqlNumRows(); $i++) {
   $row=$giros->sqlData();
   $key=$row['TYPE']&30; // eliminate bit 0: giros / guichet
   $tmp[$key]+=$row['TOTAL'];
  }
  unset($ele);
  $ele=array('NOME' => $row['NOME'],'PRENOME' => $row['PRENOME'],'CODE'=>$row['CODE'],'CREDIT'=>$row['CREDIT']);
  $synth[$row['IAM']]=array_merge($ele,$tmp);
 }
 $query=sprintf("SELECT PROF.*,CLASSE.* FROM CLASSE left join PROF on REGENT=UNTIS where CODE='%s'",$row['CODE']);
 $giros->sqlQuery($query);
 $row=$giros->sqlData();
 $row=array_merge($row,array('CODE'=>$row['CODE'],'START'=>$_POST['dateStart'],'END'=>$_POST['dateEnd']));
 $synth['DATA']=$row;
 $_SESSION['DOCUMENTS']['INVOICE']=$synth;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
  <title>Facture</title>
  <script type="text/javascript" src="invoiceP2.js"></script>
</head>
<body onload="pdf(); location.href='index.php';">
<?php 
echo "Data:<pre>";
print_r($_SESSION['DOCUMENTS']['INVOICE']);
echo "</pre>";

?>
</body>
</html>
<?php
}
?>
