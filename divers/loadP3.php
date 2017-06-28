<?php
function processFormP3() {
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
 <title>Maintenance Charger &eacute;l&egrave;ves</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../tablesorter/css/theme.blue.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.widgets.js"></script>
 <script type="text/javascript" src="load.js"></script>
</head>
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">	
<?php $menu->display(); ?>
  </div>
  <div id="cont">
<?php 
 $input = file_get_contents("ele.txt");
 $encoding = mb_detect_encoding($input, 'ASCII,ISO-8859-1,UTF-8');
 if ($encoding === FALSE) {
?>
   <p>L'encodage n'a pas pu &ecirc;tre d&eacute;tect&eacute;</p> 
<?php
  die();
 }
 if ($encoding !== "UTF-8") {
  $input = mb_convert_encoding($input, "UTF-8", $encoding);
 } 
 foreach (explode(PHP_EOL, $input) as $line) {
  $record = explode("\t", $line);
  $records[] = $record;
 }
 $giros->sqlConnect();
 $query='DELETE FROM ELEVE_BAK';
 $giros->sqlQuery($query);
 $i=0;
 foreach ($records as $line) {
  $i++;
  $query="INSERT INTO ELEVE_BAK (IAM, CODE, NOME, PRENOME, CREDIT, NOMT, PRENOMT, LIEN, RUE, CP, LOCALITE, CIVILITE, SEXE) VALUES (";
   // IAM, CODE
  $query.=sprintf("'%s', '%s', ",$line[0],mysql_real_escape_string(trim($line[1])));
  // NOME,PRENOME
  $query.=sprintf("'%s', '%s', ",mysql_real_escape_string(trim($line[2])),mysql_real_escape_string(trim($line[3]))); 
  // CREDIT NOMT,PRENOMT
  $query.=sprintf("0.0, '%s', '%s', ",mysql_real_escape_string(trim($line[4])),mysql_real_escape_string(trim($line[5])));
  // LIEN
  $lien=strtoupper(trim($line[12]));
  switch ($lien) {
   case strtoupper('père'): $query.="'PP', "; break;
   case strtoupper('mère'): $query.="'PM', "; break;
   case strtoupper('beau-père'): $query.="'PBP', "; break;
   case strtoupper('belle-mère'): $query.="'PBM', "; break;
   case strtoupper('tuteur'): $query.="'TM', "; break;
   case strtoupper('tutrice'): $query.="'TF', "; break;
   case strtoupper('foyer'): $query.="'F', "; break;
   case strtoupper('autre'): $query.="'A', "; break;
   default: $query.="'? $lien',"; break;
  } 
  // RUE
  $query.=sprintf("'%s, %s', ",mysql_real_escape_string(trim($line[6])),mysql_real_escape_string(trim($line[7]))); 
  // CP,LOCALITE,CIVILITE
  $query.=sprintf("'%s', '%s', '%s', ",trim($line[9]),mysql_real_escape_string(trim($line[10])),mysql_real_escape_string(trim($line[11])));
  // SEXE
  $query.=sprintf("'%s')",mysql_real_escape_string(trim($line[13])));
  $giros->sqlQuery($query);
 }
 $query='SELECT COUNT(*) as NB FROM ELEVE_BAK';
 $giros->sqlQuery($query);
 $row=$giros->sqlData(); 
 echo "$i lines processed <br />\n"; 
 echo $row['NB']." data rows in database<br />\n";
 
 $giros->sqlConnect();
 $query="SELECT * FROM ELEVE WHERE IAM NOT IN (SELECT IAM FROM ELEVE_BAK)";
 $giros->sqlQuery($query);
 if ($giros->sqlNumRows()==0) {
  echo "   <p>Aucun &eacute;l&egrave;ve n'a quitt&eacute; le lyc&eacute;e. </p>\n";
 }
 else {
?>
   <p>D&eacute;parts:</p>
   <div style="height: 200px; overflow: scroll;">
    <table id="eleTable" class="tablesorter tablesorter-blue" role="grid">
     <thead>
      <tr>
       <th>IAM</th>
       <th>Classe</th>
       <th>Nom &eacute;l&egrave;ve</th>
       <th>Pr&eacute;nom &eacute;l&egrave;ve</th>
       <th>Nom rep.</th>
       <th>Pr&eacute; rep.</th>
       <th>Adresse</th>
       <th>CP:</th>
       <th>Localit&eacute;</th>
       <th>Civilit&eacute;</th>
       <th>Lien</th>
       <th>Sexe</th>
      </tr>
     </thead>
     <tbody>
   <?php
   $i=0;
     while ($row=$giros->sqlData()) {   	
      echo "      <tr>\n";
      echo "       <td>".$row['IAM']."</td>\n";
   	  echo "       <td>".htmlentities($row['CODE'])."</td>\n";
   	  echo "       <td>".htmlentities($row['NOME'])."</td>\n";
      echo "       <td>".htmlentities($row['PRENOME'])."</td>\n";
      echo "       <td>".htmlentities($row['NOMT'])."</td>\n";
      echo "       <td>".htmlentities($row['PRENOMT'])."</td>\n";
      echo "       <td>".htmlentities($row['RUE'])."</td>\n";
   	  echo "       <td>".$row['CP']."</td>\n";
      echo "       <td>".htmlentities($row['LOCALITE'])."</td>\n";
      echo "       <td>".htmlentities($row['CIVILITE'])."</td>\n";
      echo "       <td>".htmlentities($row['LIEN'])."</td>\n";
      echo "       <td>".htmlentities($row['SEXE'])."</td>\n";
      echo "      </tr>\n";
      $i++;
     }
   	?>
     </tbody>
     <tfoot>
      <tr>
       <th>Total:</th>
   <?php 
        echo "        <th>$i</th>";
   ?>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
       </tr>
      </tfoot>
    </table>
   </div> 
<?php 
 }
 $query="SELECT * FROM ELEVE_BAK WHERE IAM NOT IN (SELECT IAM FROM ELEVE)";
 $giros->sqlQuery($query);
 if ($giros->sqlNumRows()==0) {
 	echo "Pas de nouvelle inscription<br />\n";
 }
 else {
 ?>
 	<p>Nouveaux:</p> 
    <div style="height: 200px; overflow: scroll;">
     <table id="eleTable" class="tablesorter tablesorter-blue" role="grid">
      <thead>
       <tr>
        <th>IAM</th>
        <th>Classe</th>
        <th>Nom &eacute;l&egrave;ve</th>
        <th>Pr&eacute;nom &eacute;l&egrave;ve</th>
        <th>Nom rep.</th>
        <th>Pr&eacute; rep.</th>
        <th>Adresse</th>
        <th>CP:</th>
        <th>Localit&eacute;</th>
        <th>Civilit&eacute;</th>
        <th>Lien</th>
        <th>Sexe</th>
       </tr>
      </thead>
      <tbody>
    <?php
    $i=0;
      while ($row=$giros->sqlData()) {   	
       echo "      <tr>\n";
       echo "       <td>".$row['IAM']."</td>\n";
    	  echo "       <td>".htmlentities($row['CODE'])."</td>\n";
    	  echo "       <td>".htmlentities($row['NOME'])."</td>\n";
       echo "       <td>".htmlentities($row['PRENOME'])."</td>\n";
       echo "       <td>".htmlentities($row['NOMT'])."</td>\n";
       echo "       <td>".htmlentities($row['PRENOMT'])."</td>\n";
       echo "       <td>".htmlentities($row['RUE'])."</td>\n";
    	  echo "       <td>".$row['CP']."</td>\n";
       echo "       <td>".htmlentities($row['LOCALITE'])."</td>\n";
       echo "       <td>".htmlentities($row['CIVILITE'])."</td>\n";
       echo "       <td>".htmlentities($row['LIEN'])."</td>\n";
       echo "       <td>".htmlentities($row['SEXE'])."</td>\n";
       echo "      </tr>\n";
       $i++;
      }
    	?>
      </tbody>
      <tfoot>
       <tr>
        <th>Total:</th>
    <?php 
         echo "        <th>$i</th>";
    ?>
         <th></th>
         <th></th>
         <th></th>
         <th></th>
         <th></th>
         <th></th>
         <th></th>
         <th></th>
         <th></th>
         <th></th>
        </tr>
       </tfoot>
      </table>
     </div> 
 <?php 
  } 
 $_SESSION['MAINTENANCE']=4;
?>
   <form action="load.php" method="post">
    <div><input type="submit"  value="Enregistrer" name="btnGo" /></div>
   </form>
  </div>
 </div>
</body>
</html>
<?php  
}
?>