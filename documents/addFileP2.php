<?php

function processForm() {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros = $_SESSION['GIROS'];
 $menu = new c_menu($giros->getUntis(), $giros->getUrl());
 $error = false;
 if (!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: " . $giros->getErrorUrl());
 }
 $msg='';
 if (strlen(trim($_POST['edtDescription'])) == 0) {
  $error = true;
  $msg = "Il faut une description <br />";
 }
 if (($_FILES['edtFile']['error'] != UPLOAD_ERR_OK)) {
  $error = true;
  $msg .= "Une erreure est survenue, veuillez recommencer. [Err1]<br />";
 } else {
  if (!is_uploaded_file($_FILES['edtFile']['tmp_name'])) {
   $error = true;
   $msg .= "Le fichier n'a pas été téléchargé, veuillez recommencer. [Err2] <br />";
  } else {
   if (!move_uploaded_file($_FILES['edtFile']['tmp_name'], 'docs/temp')) {
    $error = true;
    $msg .= "Le fichier n'a pas été téléchargé,  veuillez recommencer. [Err3] <br />";
   }
  }
 }
 if (!$error) {
  $id = md5(uniqid(rand(), TRUE));
  $FName = mysql_real_escape_string($_FILES['edtFile']['name']);
  $rgCat = $_POST['rgCat'];
  $edtDescription = mysql_real_escape_string($_POST['edtDescription']);
  $giros->sqlConnect();
  $giros->sqlQuery("INSERT INTO DOCUMENT (NO,NOTYPE,DESCRIPTION,NOM) VALUES ('$id','$rgCat','$edtDescription','$FName')");
  rename('docs/temp', 'docs/' . $id);
 } else {
  showForm($msg);
 }
 header("Location: " . $giros->getUrl() . "/documents/index.php");
}

?>