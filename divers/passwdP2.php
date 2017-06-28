<?php
function processForm ($ERROR='') {

 function extractCode($msg) {
  $chunks=explode(" ",$msg);
  return $chunks[0];
 }

 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {header("Location: ".$giros->getErrorUrl());}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
 <title>Maintenance - Changer mot de passé</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="passwd.js"></script>
</head>
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">
<?php $menu->display(); ?>
  </div>
  <div id="cont">
<?php 
 $user=strtolower(trim($giros->getUntis()));
 $old=trim($_POST['oldPasswd']);
 $new1=trim($_POST['newPasswd1']);
 $new2=trim($_POST['newPasswd2']);
 try {
  $socket=fsockopen('mail.ltma.lu',106,$errno,$errstr,30);
  if ($errno !=0) {
   throw new Exception("La communication avec le serveur des mots de passe a &eacute;chou&eacute;");
  } 
  $prompt=fgets($socket,4096);
  if (extractCode($prompt) !=200) {
    throw new Exception("La communication avec le service mots de passe a &eacute;chou&eacute;");
  }
  $out=sprintf("USER %s\n",$user);
  fputs($socket,$out);
  $prompt=fgets($socket,4096);
  if (extractCode($prompt) !=200) {
     throw new Exception("Erreur avec le nom d'utilisateur");
  }
  $out=sprintf("PASS %s\n",$old);
  fputs($socket,$out);
  $prompt=fgets($socket,4096);
  if (extractCode($prompt) !=200) {
      throw new Exception("L'ancien mot de passe est erron&eacute;");
  }
  if ($new1!=$new2) {
   throw new Exception("Les deux nouveaux mots de passe ne sont pas identiques.");
  }
  $out=sprintf("NEWPASS %s\n",$new1);
  fputs($socket,$out);
  $prompt=fgets($socket,4096);
  if (extractCode($prompt) !=200) {
      throw new Exception("Le nouveau mot de passe n'a pas &eacute;t&eacute; accept&eacute; par le serveur.");
  }
  fputs($socket,"QUIT\n");
  $prompt=fgets($socket,4096);
  echo "Le mot de passe a &eacute;t&eacute; mis &agrave; jour.";      
 }
 catch(Exception $e) {
  echo $e->getMessage();      
 } 
 ?>
  </div>
 </div> 
</body>
</html>
<?php
 }
?>