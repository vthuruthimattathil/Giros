<?php
function processForm() {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: ".$giros->getErrorUrl());
 }
 $giros->sqlConnect();
 foreach ($_POST as $key=>$value ) {
  $temp=explode('_',$key);
  if ($temp[0]=='check') {
   $nb=$_POST['pages_'.$temp[1]];
   $query=sprintf("UPDATE COMMANDE SET PAGES=\"%s\", DONE=\"%s\" WHERE NOCOMMANDE=\"%s\"",$nb,date('Y-m-d h:i:s'),$temp[1]);
   $giros->sqlQuery($query);
  }
 }
 header ("Location: ".$giros->getUrl()."/documents/index.php");
}
?>