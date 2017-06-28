<?php
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {header("Location: ".$giros->getErrorUrl());}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
 <title>Documents - Liste des documents disponibles</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <link rel="stylesheet" href="lstFiles.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="lstFiles.js"></script> 
</head>
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">
<?php
 $menu->display(); ?>
 </div>
 <div id="cont">
<?php
 echo "  <div id=\"files\">\n";
 $giros->sqlConnect();
 $giros->sqlQuery("SELECT TDOCUMENT.DESCRIPTION AS TDESC,DOCUMENT.* FROM TDOCUMENT RIGHT JOIN DOCUMENT USING(NOTYPE) ORDER BY TDOCUMENT.DESCRIPTION, DOCUMENT.DESCRIPTION");
 $head='';
 while ($row = $giros->sqlData()) {
   if ($head != $row['TDESC']) {
     if ($head!='') {echo "   </div>\n";}
     $head= $row['TDESC'];
     printf("   <h1 class=\"fileHeader\" style=\"padding-left: 25px; padding-top: 10px; padding-bottom: 10px;\">%s</h3>\n",htmlentities($head));
     echo "   <div style=\"padding: 3px;\">\n";
   }
   echo "    <a class=\"file\" href=\"lstFilesSend.php?id=".$row['NO']."\">".htmlentities($row['DESCRIPTION'])."<br></a>\n";
 }
 echo "   </div>\n";
 echo "  </div>\n";
?>
 </div>
</div>
</body>
</html>
