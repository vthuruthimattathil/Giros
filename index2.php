<?php
 include_once("session.php");
 include_once("c_menu.php");
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
 <title>Bienvenue</title>
 <link rel="stylesheet" href="css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="tablesorter/css/theme.blue.css" type="text/css" />
 <link rel="stylesheet" href="css/layout.css" type="text/css" />
 <script type="text/javascript" src="jquery/jquery.js"></script>
 <script type="text/javascript" src="jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="tablesorter/js/jquery.tablesorter.js"></script>
 <script type="text/javascript" src="tablesorter/js/jquery.tablesorter.widgets.js"></script>
 <script type="text/javascript" src="menu.js"></script>
 <script type="text/javascript" src="index2.js"></script>
</head>  

<body>
<?php
 include ("logo.php");
?>
 <div id="ww">
  <div id="sidemenu">
<?php 
 $menu->display()
?>
  </div>
  <div id="cont">
   <h1>Bonjour, veuillez v&eacute;rifier vos donn&eacute;es:</h1>
<?php
 echo "Nom d'utilisateur: ".$giros->getUntis()."<br/>\n";
 echo "Nom: ".htmlentities($giros->getName())."<br>\n";
 echo "Pr&eacute;nom: ".htmlentities($giros->getCName())."<br/>\n";
 echo "Case: ".$giros->getNocase()."<br/>\n";
 echo $giros->getDbDate()."<br/>\n";  
?>
 En cas d'erreur, veuillez contacter M. Wagner
<?php 
 $giros->sqlConnect();
 $query="select NOME,PRENOME,CODE,DATE_FORMAT(DATESR.DATER,'%e.%c.%Y %k:%i') as F_DATER from RETENUE left join ELEVE  using (IAM) left join DATESR using(NODATER) where SUIVI = -1 and PRESENT <> -1 and DATER < curdate() ";
 $query.="and UNTIS='".$giros->getUntis()."' order by DATER ";
 $giros->sqlQuery($query);
 if ($giros->sqlNumRows() !=0){
?>

 <h1>Veuillez effectuer le suivi des retenues suivantes:</h1>
  <p>Menu: Retenues-&raquo;Suivi</p>
<?php 
  echo "  <table id =\"myFollowup\" class=\"tablesorter tablesorter-blue\">\n";
  printf("  <thead>\n  <tr>\n   <th>Nome</th>\n   <th>Pr&eacute;nom</th>\n   <th>Classe</th>\n   <th>Date</th>\n </thead>\n");
  echo " </tbody>\n";
  while ($row = $giros->sqlData()) {
   echo "  </tr>\n";	 
   $s[0]=htmlentities($row['NOME']); 
   $s[1]=htmlentities($row['PRENOME']); 
   $s[2]=$row['CODE'];
   $s[3]=$row['F_DATER'];
   for ($i=0;$i<=3;$i++) {
    printf("   <td>%s</td>\n",$s[$i]);
   }
   echo "  </tr>\n";
  } 
  echo " </tbody>\n";
  echo "</table>\n";
 }
?>
  </div>
 </div>
</body>
</html>
