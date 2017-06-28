<?php

include 'addGroupP1.php';
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 showForm();
} else {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros = $_SESSION['GIROS'];
 $menu = new c_menu($giros->getUntis(), $giros->getUrl());
 if (!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: " . $giros->getErrorUrl());
 }
 $id = md5(uniqid(rand(), TRUE));
 $giros->sqlConnect();
 $edtName =  mysql_real_escape_string(trim($_POST['edtName']));
 $giros->sqlQuery("INSERT INTO TDOCUMENT (NOTYPE,DESCRIPTION) VALUES('$id','$edtName')");
 header("Location: " . $giros->getUrl() . "/documents/index.php");
}
?>