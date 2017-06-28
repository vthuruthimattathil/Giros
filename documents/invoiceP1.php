<?php
function showForm () {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: ".$giros->getErrorUrl());
 }
 ?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
 <head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
 <title>Documents - G&eacute;n&eacute;rer factures</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="invoiceP1.js"></script>
</head>  
 <body>
 <?php include ("../logo.php"); ?>
  <div id="ww">
   <div id="sidemenu">	
 <?php $menu->display(); ?>
   </div>
   <div id="cont">
    <h1>S&eacute;lectionnez la ou les classe(s):</h1>
    <form action="invoice.php" method="post" enctype="multipart/form-data">
     <div>
Date d&eacute;but:
      <input type="text" id="dateStartx" value="Cliquez ici." style="width:450px; border:none" readonly="readonly" name="dateStartx" />
<?php  //  <input type="text" id="dateStart" value="X" name="dateStart" style="display:none" /> ?>
      <input type="text" id="dateStart" value="2016-09-15" name="dateStart" style="display:none" />
Date fin:
      <input type="text" id="dateEndx" value="Cliquez ici pour s&eacute;lectionner la date!" style="width:450px; border:none" readonly="readonly" name="dateEndx" />
 <?php //      <input type="text" id="dateEnd" value="X" name="dateEnd" style="display:none" /> ?>
      <input type="text" id="dateEnd" value="2017-07-16" name="dateEnd" style="display:none" />
     </div>
     <div>
      S&eacute;lectionnez votre classe:<br />
      <select id="cl" name="classe" size="1" onchange="loadpers()">
       <option id="tmp">Classe:</option>
<?php
 $giros->sqlConnect();
 $query="SELECT DISTINCT CODE FROM CLASSE ORDER BY CODE";
 $giros->sqlQuery($query);
  while ($row = $giros->sqlData()) {
   printf ("       <option id=\"%s\" value=\"%s\">%s</option>\n",$row['CODE'],$row['CODE'],$row['CODE']);
  } 
?>
      </select>
      <br />
      <p id="wait" style="display:none">Chargement en cours</p>
      <div id="chkEle"></div>
      <div>
       <button id="btnAdd" style="display: none;">S&eacute;lectionner tous</button>
       <button id="btnDel" style="display: none;">S&eacute;lectionner aucun</button>
       <button id="btnPDF" style="display: none;">G&eacute;n&eacute;rer PDF</button>
      </div>	
     </div>      
    </form>
   </div>
  </div>
 </body>
</html>
<?php 
}
?>