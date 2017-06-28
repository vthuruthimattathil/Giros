<?php

function showForm() {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros = $_SESSION['GIROS'];
 $menu = new c_menu($giros->getUntis(), $giros->getUrl());
 if (!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: " . $giros->getErrorUrl());
 }
 ?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
   <title>Documents - Encoder avances</title>
   <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
   <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
   <link rel="stylesheet" href="../css/layout.css" type="text/css" />
   <script type="text/javascript" src="../jquery/jquery.js"></script>
   <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
   <script type="text/javascript" src="../menu.js"></script>
   <script type="text/javascript" src="advance.js"></script>
  </head> 



  <body>
      <?php include ("../logo.php"); ?>
   <div id="ww">
    <div id="sidemenu">	
        <?php $menu->display(); ?>
    </div>
    <div id="cont">  
     <h1>Encoder avances:</h1>
     <form action="advance.php" method="post" enctype="multipart/form-data" onsubmit="return false;">
      <div>
       Montant encaiss&eacute;:
       <input type="text" name="edtAmount" id="edtAmount"/>
       IAM:
       <input type="text" name="edtIAM" id="edtIAM" onchange="addIAM();
          renderList();"/>
      </div>
      <div id="wait" style="display: none;" >Chargement en cours...</div>
      <div id="lstEle"></div>
      <div id="tot"></div>
      <div><input type="checkbox" id="chkEncode"  /> <button id="btnEncode">Encoder</button></div>
      <div id="result"></div>
     </form>
    </div> 
   </div>
  </body>
 </html>
 <?php
}
?>