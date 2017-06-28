<?php


function processForm() {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros = $_SESSION['GIROS'];
 $menu = new c_menu($giros->getUntis(), $giros->getUrl());
 if (!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: " . $giros->getErrorUrl());
 }
 $id = md5(uniqid(rand(), TRUE));
 $name=trim($_POST['edtDescription']);
 $type = 1; // document par BON
 $type+=$_POST['rgColor'];
 $type+=$_POST['rgRV'];
 $type+=$_POST['rgA4'];
 $type+=$_POST['rgPay'];
 if (isset($_POST['chkPers'])) {
     $type+=$_POST['chkPers'];
    }
 $dateBon=$_POST['dateBon'];
 $pages=$_POST['pages'];
 $source=$_POST['photo'];
 $giros->sqlConnect();
 $query = "INSERT INTO COMMANDE (NOCOMMANDE,UNTIS,NAME,MIMETYPE,DATE,DELAI,TYPE,COULEUR,REMARQUE,PAGES,DONE,SOURCE)";
 $query.=sprintf(" VALUES('%s','%s','%s', ", $id, $giros->getUntis(), mysql_real_escape_string($name));  // NOCOMMANDE,UNTIS,NAME
 $query.=sprintf("null,'%s',null, ",$dateBon); //MIMETYPE,DATE,DELAI
 $query.=sprintf("%s,'','%s',%d,'%s','%s')", $type,mysql_real_escape_string($_POST['edtComment']),$pages,date("Y-m-d H:i:s"),$source); // TYPE,COULEUR,REMARQUE,PAGES,DONE,SOURCE
 $giros->sqlQuery($query);
 $lst = explode("*", $_POST['iams'], -1);
 foreach ($lst as $value) {
  $query = sprintf("INSERT INTO COMMANDE_ELEVE (NOCOMMANDE,IAM) VALUES ('%s','%s')", $id, $value);
  $giros->sqlQuery($query);
 }
 header("Location: " . $giros->getUrl() . "/documents/index.php");
}

?>