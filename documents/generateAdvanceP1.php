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
 <title>Documents - G&eacute;n&eacute;rer avances</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="generateAdvance.js"></script>
</head>  
<body>
  <?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">	
  <?php $menu->display(); ?>
  </div>
  <div id="cont">  
   <h1>Demande d'impression:</h1>
   <form action="generateAdvance.php" method="post" enctype="multipart/form-data">
    <div>
     Montant demand&eacute;:
     <input type="text" name="amount" />
    </div>
    <div>
     S&eacute;lectionnez les classes:
     <div>
      <button id="btnAll">S&eacute;lectionnez toutes</button>
      <button id="btnNone">S&eacute;lectionnez aucune</button>
     </div>
     <table>
      <tr>
<?php
 $giros->sqlConnect();
 $giros->sqlQuery("SELECT CODE FROM CLASSE ORDER BY CODE");
 $col=0;
 while ($row=$giros->sqlData()) {
  if ($col==6) {
   $col=0;
   echo "</tr>\n<tr>\n";
  }
  printf("<td><input type=\"checkbox\" name=\"class[]\" class=\"chkClass\" value=\"%s\"/>%s</td>\n",$row['CODE'],$row['CODE']);
  $col++;
 }
 for ($i=$col;$i<6;$i++) {
  echo "<td></td>\n";
 }
?>
      </tr>
     </table>
    </div>
    <div>
     <button id="btnGo">G&eacute;n&eacute;rer</button>
    </div>
   </form>
  </div>
 </div>
</body>
</html>
<?php
}
?>