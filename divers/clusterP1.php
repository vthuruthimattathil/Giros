<?php 
function showForm ($ERROR='') {
 include_once("../session.php");
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
 <title>Documents - Gestion des grouppes</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../tablesorter/css/theme.blue.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.widgets.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="cluster.js"></script>
</head>   
 
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">	
<?php $menu->display(); ?>
  </div>
  <div id="cont">
  <h1>Gestion des groupes:</h1>
  <div>
   <h2>Ajouter un nouveau groupe</h2>
   <input id="addClusterDescription" type="text" name="addClusterDesctiption" size="45" />  
   <input id="addClusterBtn" class="btn" type="button" name="addClusterBtn" value="Ajouter groupe"/>
  </div>
  <div id="displayClusters">
   <h2>Mofidier ou supprimer un groupe existant</h2>
   <div id="wait" style="display:none">Chargement en cours...</div>
   <div id="tableClusters">
   </div> 
   <div id="clusterForm" style="display:none">
    <h3>El&egrave;ves dans le groupe</h3>
    <div id="clusterEleves">

    </div>
    <h3>Veuillez choisir une classe:
     <select name='classes' id='classes' onchange='loadClass();'>
<?php
 $query="SELECT CODE FROM CLASSE ORDER BY CODE";
 $giros->sqlConnect();
 $giros->sqlQuery($query);
 while ($row = $giros->sqlData()) {
 printf("     <option value='%s'>%s</option>",$row['CODE'],$row['CODE']);
 }

?>   </select>  
    </h3>
    <div id="classList">
    </div>
   </div> 
  </div> 
  <div id="ok">
   <a id='exitBtn' href="<?php echo $giros->getURL(); ?>/divers/index.php">Termin&eacute; </a>
  </div> 
 </div>
</div>
</body>
</html>
<?php
 }
 
?>