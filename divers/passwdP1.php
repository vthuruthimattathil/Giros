<?php
function showForm () {
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
   <form action="passwd.php" method="post" enctype="multipart/form-data" onInput="checkPwd();">
    <div>
     <table>
      <tr>
       <td>Ancien mot de passe:</td>
       <td><input type="password" id="oldPasswd" name="oldPasswd" /></td>
       <td><input type="submit" value="Modifier" id="changeButton" style="display: none;" /></td>
      </tr>
      <tr>
       <td>Nouveau mot de passe:</td>
       <td><input type="password" id="newPasswd1" name="newPasswd1" onInput="checkPwd();"/></td>
       <td><span class="ui-icon ui-icon-cancel" id="newPasswd1Cancel"></span><span class="ui-icon ui-icon-check" id="newPasswd1OK"></span></td>
      </tr>
      <tr>
       <td>Veuillez r&eacute;p&eacute;ter votre nouveau mot de passe:</td>
       <td><input type="password" id="newPasswd2" name="newPasswd2" onInput="checkPwd();"/></td>
       <td><span class="ui-icon ui-icon-cancel" id="newPasswd2Cancel"></span><span class="ui-icon ui-icon-check" id="newPasswd2OK"></span></td>
      </tr>
     </table>
    </div>
   </form>
   <div>
   <p> Information:</p>
   <p> Le mot de passe doit avoir une longueur d'au moins <b>6 lettres</b> (au moins une majuscule et au moins une minuscule) et contenir <b>au moins</b> un chiffre.</p> 
   </div>
  </div>
 </div> 
</body>
</html>
<?php
 }
?>