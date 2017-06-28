<?php

function fileUploadErrorMessage($error_code) {
 switch ($error_code) {
  case UPLOAD_ERR_INI_SIZE:
   return 'Le fichier d&eacute;passe la limite maxiamle autoris&eacute;e';
  case UPLOAD_ERR_FORM_SIZE:
   return 'Le fichier d&eacute;passe la limite maxiamle autoris&eacute;e';
  case UPLOAD_ERR_PARTIAL:
   return 'Le fichier a &eacute;t&eacute; paritellement t&eacute;l&eacuate;charg&eacute;e.';
  case UPLOAD_ERR_NO_FILE:
   return 'Absence de fichier';
  case UPLOAD_ERR_NO_TMP_DIR:
   return 'Erreur interne (tmp dir)';
  case UPLOAD_ERR_CANT_WRITE:
   return 'Erreur interne (write failed)';
  case UPLOAD_ERR_EXTENSION:
   return 'File upload stopped by extension';
  default:
   return 'Unknown upload error';
 }
}

function processForm() {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros = $_SESSION['GIROS'];
 $menu = new c_menu($giros->getUntis(), $giros->getUrl());
 if (!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: " . $giros->getErrorUrl());
 }
 if ($_FILES['edtFile']['error'] != UPLOAD_ERR_OK) {
  showForm("Une erreur est survenue, veuillez recommencer. " . fileUploadErrorMessage($_FILES['edtFile']['error']));
 } else {
  if (!is_uploaded_file($_FILES['edtFile']['tmp_name'])) {
   show_form("Le fichier n'a pas été téléchargé, veuillez recommencer. [Err2]");
  } else {
   $id = md5(uniqid(rand(), TRUE));
   $FName = $_FILES['edtFile']['name'];
   if (move_uploaded_file($_FILES['edtFile']['tmp_name'], 'ups/' . $id . '.pdf')) {
    $type = 0; // document via giros
    $type+=$_POST['rgColor'];
    $type+=$_POST['rgRV'];
    $type+=$_POST['rgA4'];
    $type+=$_POST['rgPay'];
    if (isset($_POST['chkTri'])) {
     $type+=$_POST['chkTri'];
    }
    if (isset($_POST['chkPerf'])) {
     $type+=$_POST['chkPerf'];
    }
    if (isset($_POST['chkAgr'])) {
     $type+=$_POST['chkAgr'];
    }
    if (isset($_POST['chkPers'])) {
     $type+=$_POST['chkPers'];
    }
    if (isset($_POST['chkTrans'])) {
     $type+=$_POST['chkTrans'];
    }
    if (strlen(trim($_POST['edtCouleur'])) == 0) {
     $col = 'Blanc';
    } else {
     $col = trim($_POST['edtCouleur']);
    }
    switch ($_POST['dateTime']) {
     case 'TA':
      $delai=$_POST['dateI']." 8:00:00";
      break;
     case 'TB':
      $delai=$_POST['dateI']." 9:00:00";
      break;
     case 'TC':
      $delai=$_POST['dateI']." 10:00:00";
      break;
     case 'TD':
      $delai=$_POST['dateI']." 11:00:00";
      break;
     case 'TE':
      $delai=$_POST['dateI']." 12:00:00";
      break;
     default:
       $delai=$_POST['dateI']." 13:00:00";
       break;
    }
    $giros->sqlConnect();
    $query = "INSERT INTO COMMANDE (NOCOMMANDE,UNTIS,NAME,MIMETYPE,DATE,DELAI,TYPE,COULEUR,REMARQUE,PAGES,DONE,SOURCE)";
    $query.=sprintf(" VALUES('%s','%s','%s', ", $id, $giros->getUntis(), mysql_real_escape_string($FName));
    $query.=sprintf("'%s','%s','%s', ", mysql_real_escape_string($_FILES['edtFile']['type']), date("Y-m-d H:i:s"),$delai );
    $query.=sprintf("%s,'%s','%s',null,null,0)", $type, mysql_real_escape_string($col), mysql_real_escape_string($_POST['edtComment']));
    $giros->sqlQuery($query);
    $lst = explode("*", $_POST['iams'], -1);
    foreach ($lst as $value) {
     $query = sprintf("INSERT INTO COMMANDE_ELEVE (NOCOMMANDE,IAM) VALUES ('%s','%s')", $id, $value);
     $giros->sqlQuery($query);
    }
    header("Location: " . $giros->getUrl() . "/documents/index.php");
   }
  }
 }
}

?>