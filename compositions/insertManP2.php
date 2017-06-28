<?php
function showForm2() {
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
 <title>Inscription manuelle: composition</title>  <link rel="stylesheet" href="../css/jquery-ui.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="insertMan.js"></script>
</head>
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">	
 <?php $menu->display(); ?>
  </div>
  <div id="cont">     
   <h1>Insertion manuelle (composition): R�sum�</h1>
<?php
 $_SESSION['COMPOSITION']['CLASSE']=stripslashes($_POST['classe']);
 $_SESSION['COMPOSITION']['MATRICULE']=$_POST['matricule'];
 $_SESSION['COMPOSITION']['BRANCHE']=$_POST['txtbranche'];
 $_SESSION['COMPOSITION']['DATEC']=$_POST['dateC'];
 $dateC=explode("-",$_POST['dateC']);;
 $_SESSION['COMPOSITION']['DUREE']=$_POST['duree'];
 $_SESSION['COMPOSITION']['PROF']=stripslashes($_POST['prof']);
 $_SESSION['COMPOSITION']['DATEI']=$_POST['dateI'];
 $dateI=explode("-",$_POST['dateI']);
 $giros->sqlConnect();
 foreach ($_SESSION['COMPOSITION']['MATRICULE'] as $mat) {
  $giros->sqlQuery("SELECT * FROM ELEVE WHERE MATRICULE='".$mat."'");
?>
  <table>
<?php
  $row=$giros->sqlData();
  echo "   <tr>\n";
  echo "    <td>El�ve:</td>\n";
  echo "    <td>".htmlentities($row['NOME']." ".$row['PRENOME'])."</td>\n";
  echo "   </tr>\n";
  echo "   <tr>\n";
  echo "    <td>Tuteur:</td>\n";
  echo "    <td>".htmlentities($row['CIVILITE']." ".$row['NOMT']." ".$row['PRENOMT'])."</td>\n";
  echo "   </tr>\n";
  echo "   <tr>\n";
  echo "    <td>Adresse:</td>\n";
  echo "    <td>".htmlentities($row['RUE']." ".$row['CP']." ".$row['LOCALITE'])."</td>\n";
  echo "   </tr>\n";
  echo "   <tr>\n";
  echo "    <td>Date d'inscription:</td>\n";
  echo "    <td>".$dateI[2]."/".$dateI[1]."/".$dateI[0]."</td>\n";
  echo "   </tr>\n";
?>
  </table>
  <hr />
<?php
 }
  echo "Enseignant: ".htmlentities($_SESSION['COMPOSITION']['PROF'])."\n <hr>";
?>
  <table>
   <tr>
    <td>Branche:</td>
<?php
   echo "    <td>".htmlentities($_SESSION['COMPOSITION']['BRANCHE'])."</td>\n";
?>
   </tr>
   <tr>
    <td>Date du devoir non compos�:</td>
<?php
   echo "    <td>".$dateC[2]."/".$dateC[1]."/".$dateC[0]."</td>\n";
?>
   </tr>
   <tr>
    <td>Dur�e:</td>
<?php
   echo "    <td>".$_SESSION['COMPOSITION']['DUREE']."</td>\n";
?>
   </tr>
  </table>
  <h1>Dates possibles</h1>
  <form method="get" action="insertMan.php">
   <table border="1" frame="box" rules="groups" cellpadding="4px" >
    <thead>
     <tr>
      <th align="center">Date</th>
      <th align="center">Heure</th>
      <th align="center">Salle</th>
      <th align="center">Maximum</th>
      <th align="center">Inscrits</th>
      <th align="center">Disponibles</th>
      <th align="center">Commentaire</th>
     </tr>
    </thead>
    <tbody>
<?php
 $giros->sqlQuery("SELECT * FROM DATESD WHERE DATED > CURDATE() ORDER BY DATED");
 $i=0;
 while ($row=$giros->sqlData()) {
  $dates[$i]['NODATED']=$row['NODATED'];
  $dates[$i]['DATED']=$row['DATED'];
  list($date,$time) = explode(" ",$row['DATED']);
  list($year,$month,$day)=explode("-",$date);
  $date=$day.".".$month.".".$year;
  list($h,$m,$s) = explode(":",$time);
  $time=$h.":".$m;
  $dates[$i]['DATE']=$date;
  $dates[$i]['TIME']=$time;
  $dates[$i]['SALLE']=$row['SALLE'];
  $dates[$i]['NOMBREMAX']=(int)$row['NOMBREMAX'];
  $dates[$i]['COMMENT']=$row['COMMENT'];
  $dates[$i]['NOMBRE']=0;
  $i++;
 }
 $nb=count($_SESSION['COMPOSITION']['MATRICULE']);
 $_SESSION['COMPOSITION']['NOMBRE']=$nb;
 $mat_list="'".implode("','",$_SESSION['COMPOSITION']['MATRICULE'])."'";
 $i=0;
 foreach ($dates as $date) {
  $giros->sqlQuery("SELECT COUNT(*) AS QTE FROM DEVOIR WHERE DATED='".$dates[$i]['DATED']."'");
  $row=$giros->sqlData();
  $dates[$i]['NOMBRE']=(int)$row['QTE'];
  $i++;
 }
 $i=0;
 $sel=' checked="checked"';
 foreach ($dates as $date) {
  $disp= $date['NOMBREMAX']-$date['NOMBRE'];
  $giros->sqlQuery("SELECT COUNT(*) AS QTE FROM RETENUE WHERE DATE_FORMAT(DATER,'%Y-%m-%d')=DATE_FORMAT('".$dates[$i]['DATED']."','%Y-%m-%d') AND MATRICULE IN (".$mat_list.")");
  $row=$giros->sqlData();
  $qte=(int)$row['QTE'];
  $giros->sqlQuery("SELECT COUNT(*) AS QTE FROM DEVOIR WHERE DATE_FORMAT(DATED,'%Y-%m-%d')=DATE_FORMAT('".$dates[$i]['DATED']."','%Y-%m-%d') AND MATRICULE IN (".$mat_list.")");
  $row=$giros->sqlData();
  $qte=$qte+(int)$row['QTE'];
  $i++;
  $selected=$sel;
  echo "   <tr>\n";
  echo '    <td><input type="radio" name="nodated" value="'.$date['NODATED'].'"'.$selected.'>'.$date['DATE']."</td>\n";
  echo '    <td align="center">'.$date['TIME'].'</td>'."\n";
  echo '    <td align="center">'.$date['SALLE'].'</td>'."\n";
  echo '    <td align="right">'.$date['NOMBREMAX'].'</td>'."\n";
  echo '    <td align="right">'.$date['NOMBRE'].'</td>'."\n";
  echo '    <td align="right">'.$disp.'</td>'."\n";
  echo '    <td align="left" color="red">'.$date['COMMENT'].'</td>'."\n";
  echo "   </tr>\n";
  $sel='';
 }
?>
   </tbody>
  </table>
  <input type="submit" value="Enregistrer SANS g�n�rer les convocations" onclick="return checkform2();">
  </form>
 </div>
</div>
</body>
</html>

<?php
 }