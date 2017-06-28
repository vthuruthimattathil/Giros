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
 <title>Lettres - Certificat m&eacute;dical</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="med.js"></script>
</head>  
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">
<?php $menu->display(); ?>
  </div>
  <div id="cont">
   <h1>Cr&eacute;ation lettre: Absences - certificat m&eacute;dical</h1>
<?php 
 $giros->sqlConnect();
 $query=sprintf("SELECT CODE FROM CLASSE WHERE REGENT='%s' ORDER BY CODE",$giros->getUntis());
 $giros->sqlQuery($query);
 $nb=$giros->sqlNumRows();
 if ($nb==0) {
?>
   <p>Vous n'&ecirc;tes pas r&eacute;gent.</p>
   <p>Cette fonctionalit&eacute; est r&eacute;serv&eacute;e aux r&eacute;gents.</p>  
<?php   
 }
 else {
?>  
   <form action="med.php" method="post" enctype="multipart/form-data" > 
    <h2>S&eacute;lectionnez l'&eacute;l&egrave;ve</h2>
    <div>
     <select id="ele" name="eleve" size="1">   
<?php
  $query=sprintf("SELECT IAM,NOME,PRENOME,CODE FROM ELEVE LEFT JOIN CLASSE USING(CODE) WHERE REGENT='%s' ORDER BY CODE,NOME,PRENOME",$giros->getUntis());
  $giros->sqlQuery($query);
  if ($nb==1) {
   while ($row=$giros->sqlData()) {
    printf ("     <option value=\"%s\">%s %s</option>\n",$row['IAM'],  htmlentities($row['NOME']),  htmlentities($row['PRENOME']));
   }
  }
  else {
   while ($row=$giros->sqlData()) {
    printf ("     <option value=\"%s\">%s - %s %s</option>\n",$row['IAM'],$row['CODE'],$row['NOME'],$row['PRENOME']);;
   }
  }
?>     
     </select>  
     <input type="submit" value="Enregistrer et g&eacute;n&eacute;rer la lettre" />
    </div>
   </form>
<?php 
 }
?>
   <div>
    <p>Suite aux nombreuses absences de l'&eacute;l&egrave;ve ... de la classe ..., nous nous voyons forc&eacute;s d'exiger,
     d'apr&egrave;s l'article 12 du r&egrave;glement grand-ducal du 23 d&eacute;cembre 2004 concernant l'ordre int&eacute;rieur et de la discipline dans les lyc&eacute;es et lyc&eacute;es techniques,
     un certificat m&eacute;dical justifiant chaque absence de ... &agrave; l'avenir, et ce jusqu'&agrave; la fin de l'ann&eacute;e scolaire 2016-2017.</p>
   </div>
  </div>
 </div> 
</body>
</html>
<?php
}
?>