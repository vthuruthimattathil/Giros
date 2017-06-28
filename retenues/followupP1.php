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
 <title>Retenues - Suivi de vos retenues</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../tablesorter/css/theme.blue.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.widgets.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="followup.js"></script>
</head>  
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">	
 <?php $menu->display(); ?>
  </div>
  <div id="cont"> 
  <h1>Relev&eacute; des retenues &agrave; contr&ocirc;ler:</h1>
  <form  action="followup.php" method="post">
   <div>
<?php
  $giros->sqlConnect();
  $query="SELECT NORETENUE,NOME,PRENOME,CODE,DATE_FORMAT(DATER,'%e.%c.%Y %k:%i') AS FDATER,MOTIF,SALLE,PRESENT ";
  $query.="FROM RETENUE LEFT JOIN ELEVE USING(IAM) LEFT JOIN DATESR USING(NODATER) ";
  $query.="WHERE UNTIS='".$giros->getUntis()."' AND SUIVI =-1 AND PRESENT <> -1";
  $giros->sqlQuery($query);
  echo "  <table id=\"myTable\" class=\"tablesorter tablesorter-blue\">\n";
  echo "   <thead>\n    <tr>\n     <th>Nom</th>\n     <th>Pr&eacute;nom</th>\n     <th>Classe</th>\n     <th>Date</th>\n     <th>Motif</th>\n     <th>Salle</th>\n     <th>Suivi</th>\n    </tr>\n   </thead>\n";
  echo "   <tbody>\n";
  while ($row = $giros->sqlData()) {
   $s[1]=htmlentities($row['NOME']);
   $s[2]=htmlentities($row['PRENOME']);
   $s[3]=$row['CODE'];
   $s[4]=$row['FDATER'];
   if (strlen($row['MOTIF']>13)) {$s[5]=substr($row['MOTIF'],0,10).'...';}
   else {$s[5]=$row['MOTIF'];}
   $s[5]=htmlentities($s[5]);
   $s[6]=$row['SALLE'];
   if ($row['PRESENT']==0) {
   	$s[7]="<input type='radio' name='r".$row['NORETENUE']."' value='0'>Absence excus&eacute;e<br>\n";
   	$s[7].="         <input type='radio' name='r".$row['NORETENUE']."' value='1'>Absence non excus&eacute;e";
   } else {
   	$s[7]="<input type='radio' name='r".$row['NORETENUE']."' value='2'>Ok<br>\n";
   	$s[7].="         <input type='radio' name='r".$row['NORETENUE']."' value='3'>Travail insuffisant";  	
   }
   echo "    <tr>\n";
   for ($i=1;$i<=7;$i++) {
    printf("     <td>%s</td>\n",$s[$i]);
   }
   echo "    </tr>\n";
  }
  echo "   </tbody>\n";
  echo "  </table>\n";
?>
   <input type="submit" name="submit" value="Enregistrer" />
 </div>
  </form>
  <b>Pour information:</b><br />
  <table >
   <tr>
    <td><i>Pr&eacute;sent:</i></td>
    <td>Ok</td>
    <td>&rarr;</td>
    <td>Plus rien &agrave; faire.</td>
   </tr>
   <tr>
    <td></td>
    <td>Travail insuffisant</td>
    <td>&rarr;</td>
    <td>A vous de donner les suites n&eacute;cessaires.</td>
   </tr>
   <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
   </tr>
   <tr>
    <td><i>Absent:<br /></i></td>
    <td style="font-size:150%; font-weight:bold">Absence excus&eacute;e<br /> </td>
    <td>&rarr;</td>
    <td style="font-size:150%; font-weight:bold">Un nouveau RDV sera fix&eacute; par l'administration. Vous en serez inform&eacute;(e) par e-mail.</td>
   </tr>
   <tr>
    <td></td>
    <td>Absence non excus&eacute;e</td>
    <td>&rarr;</td>
    <td>A vous de donner les suites n&eacute;cessaires.</td>
   </tr>
  </table>
 </div>
</div>
</body>
</html>
<?php
 }
