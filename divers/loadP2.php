<?php

function processFormP2() {
 include_once("../c_menu.php");
 $giros = $_SESSION['GIROS'];
 $menu = new c_menu($giros->getUntis(), $giros->getUrl());
 if (!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: " . $giros->getErrorUrl());
 }
 if ($_FILES['edtFile']['error'] != UPLOAD_ERR_OK) {
  showForm("Une erreure est survenue, veuillez r&eacute;ressayer. [Err1]");
  die();
 }
 if (!is_uploaded_file($_FILES['edtFile']['tmp_name'])) {
  showForm("Le fichier n'a pas &eacute;t&eacute; t&eacute;l&eacute;charg&eacute;, veuillez recommencer. [Err2]");
  die();
 }
 if (move_uploaded_file($_FILES['edtFile']['tmp_name'], 'ele.txt')) {
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
  <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.js"></script>
  <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.widgets.js"></script>
  <script type="text/javascript" src="../menu.js"></script>
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
  } else {
   if ($encoding !== "UTF-8") {
    echo "Encodage: " . $encoding . " conversion vers UTF-8";
    $input = mb_convert_encoding($input, "UTF-8", $encoding);
   } else {
    echo "<p>File encoded in:$encoding</p>";
   }
   foreach (explode(PHP_EOL, $input) as $line) {
    $record = explode("\t", $line);
    $records[] = $record;
   }
?> 
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
        <th>CP</th>
        <th>Localit&eacute;</th>
        <th>Civilit&eacute;</th>
        <th>Lien</th>
        <th>Sexe</th>
       </tr>
      </thead>
      <tbody>
<?php
   $i = 0;
   foreach ($records as $line) {
    echo "      <tr>\n";
    echo "       <td>$line[0]</td>\n"; // IAM
    echo "       <td>" . mb_convert_encoding(trim($line[1]), 'HTML-ENTITIES', 'UTF-8') . "</td>\n"; // Classe
    echo "       <td>" . mb_convert_encoding(trim($line[2]), 'HTML-ENTITIES', 'UTF-8') . "</td>\n"; // Nom
    echo "       <td>" . mb_convert_encoding(trim($line[3]), 'HTML-ENTITIES', 'UTF-8') . "</td>\n"; // Prenom
    echo "       <td>" . mb_convert_encoding(trim($line[4]), 'HTML-ENTITIES', 'UTF-8') . "</td>\n"; //Nom rep.
    echo "       <td>" . mb_convert_encoding(trim($line[5]), 'HTML-ENTITIES', 'UTF-8') . "</td>\n"; // Prenom rep
    printf("       <td>%s, %s</td>\n", mb_convert_encoding(trim($line[6]), 'HTML-ENTITIES', 'UTF-8'), mb_convert_encoding(trim($line[7]), 'HTML-ENTITIES', 'UTF-8')); // Adr
    echo "       <td>$line[9]</td>\n"; //CP
    echo "       <td>" . mb_convert_encoding(trim($line[10]), 'HTML-ENTITIES', 'UTF-8') . "</td>\n"; // Localite
    echo "       <td>" . mb_convert_encoding(trim($line[11]), 'HTML-ENTITIES', 'UTF-8') . "</td>\n"; // Civilite
    echo "       <td>" . mb_convert_encoding(trim($line[12]), 'HTML-ENTITIES', 'UTF-8') . "</td>\n"; // Lien
    echo "       <td>" . mb_convert_encoding(trim($line[13]), 'HTML-ENTITIES', 'UTF-8') . "</td>\n"; // Sexe
    echo "      </tr>\n";
    $i++;
   }
 ?>
      </tbody>
      <tfoot>
       <tr>
        <th>Total:</th>
 <?php
   echo "       <th>$i</th>";
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
    <form action="load.php" method="post">
     <div><input type="submit"  value="Analyser" name="btnGo" /></div>
    </form>
   </div>
  </div>
 </body>
</html>
<?php
  }
  $_SESSION['MAINTENANCE'] = 3;
 } else {
  showForm("Le fichier n'a pas &eacute;t&eacute; d&eacute;plac&eacute;, veuillez recommencer. [Err3]");
 }
}
?>