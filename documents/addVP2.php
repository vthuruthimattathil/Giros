<?php
function processForm() {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: ".$giros->getErrorUrl());
 }
 $id=md5(uniqid(rand(), TRUE));
 $untis=$_POST['untis'];
 $type=1; // document via office
 $type+=$_POST['rgColor'];
 $type+=$_POST['rgRV'];
 $type+=$_POST['rgA4'];
 $type+=$_POST['rgPay'];
 if (isset($_POST['chkTri']))   {
  $type+=$_POST['chkTri'];
 }
 if (isset($_POST['chkPerf']))  {
  $type+=$_POST['chkPerf'];
 }
 if (isset($_POST['chkAgr']))   {
  $type+=$_POST['chkAgr'];
 }
 if (isset($_POST['chkPers']))  {
  $type+=$_POST['chkPers'];
 }
 if (isset($_POST['chkTrans'])) {
  $type+=$_POST['chkTrans'];
 }
 if (strlen(trim($_POST['edtCouleur']))==0) {
  $col='blanc';
 }
 else {$col=trim($_POST['edtCouleur']);
 }

 $giros->sqlConnect();
 $query="INSERT INTO COMMANDE (NOCOMMANDE,UNTIS,NAME,MIMETYPE,DATE,DELAI,TYPE,COULEUR,REMARQUE,PAGES,DONE,SOURCE)";
 $query.=sprintf(" VALUES('%s','%s',null,null, ",$id,$_POST['untis']);
 $query.=sprintf("'%s',null, ",$_POST['dateI']);
 $query.=sprintf("%s,'%s','%s',%s,null,'BON')",$type,mysql_real_escape_string($col),mysql_real_escape_string($_POST['edtComment']),$_POST['pages']);
 $giros->sqlQuery($query);
 $query=sprintf('SELECT IAM FROM ELEVE WHERE CODE="%s"',$_POST['classe']);
 $giros->sqlQuery($query);
 while ($row=$giros->sqlData()) {
  $mats[]=$row['IAM'];
  }
 foreach ($mats as $key => $mat) {
  $query=sprintf("INSERT INTO COMMANDE_ELEVE (NOCOMMANDE,IAM) VALUES ('%s','%s')",$id,$mat);
  $giros->sqlQuery($query);
 }
 header ("Location: ".$giros->getUrl()."/documents/index.php");
}