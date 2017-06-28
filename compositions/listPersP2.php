<?php
function processForm() {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
/* if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: ".$giros->getErrorUrl());
 }*/
 $id=$_GET['id'];
 $id=urldecode($id);
 $giros->sqlConnect();
 $query = "SELECT TYPE FROM DATESD LEFT JOIN DEVOIR USING(NODATED)";
 $query.=sprintf(" WHERE NODEVOIR ='%s'", $id);
 $giros->sqlQuery($query);
 $row = $giros->sqlData();
 if ($row['TYPE']=='3') {
  unset($_SESSION['EPS']);
  $_SESSION['EPS']['DATA']=array($id);
 include('EPSconvocation.php');
 }
 else {
  unset($_SESSION['COMPOSITION']);
  $_SESSION['COMPOSITION']['DATA']=array($id);
 include('convocation.php');
 }
 
}