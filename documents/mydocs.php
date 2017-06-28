<?php

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
 <title>Documents - Mes impressions</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../tablesorter/css/theme.blue.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.widgets.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="mydocs.js"></script>
</head>  
 
<body>
  <?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">	
  <?php $menu->display(); ?>
  </div>
  <div id="cont">  
   <h1>Relev&eacute; de vos impressions:</h1>
   <p>Cliquez sur une ent&ecirc;te pour modifier l'ordre du tri.</p>
<?php
  $giros->sqlConnect();
  $query="SELECT NOCOMMANDE,NAME,DATE_FORMAT(DATE,'%d.%m.%Y  %h:%i') AS DATE_F,DATE_FORMAT(DONE,'%d.%m.%Y  %h:%i') AS DONE_F,";
  $query.="TYPE,PAGES,COUNT(*) AS QTE_COMM,SOURCE FROM COMMANDE LEFT JOIN COMMANDE_ELEVE USING(NOCOMMANDE) ";
  $query.="WHERE UNTIS='".$giros->getUntis()."' GROUP BY NOCOMMANDE ORDER BY DATE";
  $giros->sqlQuery($query);
  echo "  <table id=\"myTable\"  class=\"tablesorter tablesorter-blue\" role=\"grid\">\n";
  printf("   <thead>\n    <tr>\n     <th>Document</th>\n     <th>Nombre d'exemplaires</th>\n     <th>Type</th>\n     <th>Payant</th>\n     <th>Remis le / o&ugrave;</th>\n     <th>Pages</th>\n     <th>Disponible depuis</th>\n    <tr>\n   </thead>\n");
  echo "   <tbody>\n";
  while ($row = $giros->sqlData()) {
   if (($row['TYPE'] & 1)==0) {
    $s[0]=$row['NAME'];
   } else {
    if ($row['NAME']=='') {
     $s[0]='-';
    } else {
     $s[0]=$row['NAME'];
    }
   }
   $s[1]=$row['QTE_COMM'];
   if (($row['TYPE'] & 2)==0 )   {$s[2]='NB';}     else {$s[2]='C';}
   if (($row['TYPE'] & 4)==0 )   {$s[2].=' / R';}  else {$s[2].=' / RV';}
   if (($row['TYPE'] & 8)==0 )   {$s[2].=' / A4';} else {$s[2].=' / A3';}
   if (($row['TYPE'] & 32)!=0 )  {$s[2].=' / T';}
   if (($row['TYPE'] & 64)!=0 )  {$s[2].=' / P';}
   if (($row['TYPE'] & 128)!=0 ) {$s[2].=' / A';}
   if (($row['TYPE'] & 256)!=0 ) {$s[2].=' / SP';}
   if (($row['TYPE'] & 512)!=0 ) {$s[2].=' / Trans';}
   if (($row['TYPE'] & 16)==0 )  {$s['3']='Non';}  else {$s['3']='Oui';}
   $s[4]=$row['DATE_F'];
   if (($row['TYPE'] & 1)==0) {
    $s[4].=' - Giros';
   }
   else {
    $tmp=explode(" ",$s[4]);
    $s[4]=$tmp[0].' - '.$row['SOURCE'];
   }
   if ($row['PAGES']==null) {$s[5]='';} else {$s[5]=$row['PAGES'];}
   if ($row['DONE_F']==null) {$s[6]='/';} else {$s[6]=$row['DONE_F'];}
   if (($row['TYPE'] & 1)!=0) {$s[6]='-';}
   echo "    <tr>\n";
   for ($i=0;$i<7;$i++) {
    printf("     <td>%s</td>\n",$s[$i]);
   }
   echo "    </tr>\n";
  }
  echo "   </tbody>\n";
  echo "  </table>\n";
?>
  <table>
   <tr>
    <td>Codes pour le type:</td>
    <td>NB:</td>
    <td>Noir et blanc</td>
   </tr>
   <tr>
    <td></td>
    <td>C:</td>
    <td>Couleur</td>
   </tr>
   <tr>
    <td></td>
    <td>R:</td>
    <td>Recto</td>
   </tr>
   <tr>
    <td></td>
    <td>RV:</td>
    <td>Recto/Verso</td>
   </tr>
   <tr>
    <td></td>
    <td>T:</td>
    <td>Tri&eacute;</td>
   </tr>
   <tr>
    <td></td>
    <td>P:</td>
    <td>Perfor&eacute;</td>
   </tr>      
   <tr>
    <td></td>
    <td>A:</td>
    <td>Agraf&eacute;</td>
   </tr>      
   <tr>
    <td></td>
    <td>SP:</td>
    <td>Set personnel</td>
   </tr>         
   <tr>
    <td></td>
    <td>Trans:</td>
    <td>Set de transparents</td>
   </tr> 
  </table>
 </div>
</div>
</body>
</html>
