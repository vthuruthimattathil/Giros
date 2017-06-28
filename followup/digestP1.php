<?php

function showForm() {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros = $_SESSION['GIROS'];
 $menu = new c_menu($giros->getUntis(), $giros->getUrl());
 if (!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: " . $giros->getErrorUrl());
 }
 ?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">

  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
   <title>Suivi - Condens&eacute;</title>
   <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
   <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
   <link rel="stylesheet" href="../tablesorter/css/theme.blue.css" type="text/css" />
   <link rel="stylesheet" href="../css/layout.css" type="text/css" />
   <script type="text/javascript" src="../jquery/jquery.js"></script>
   <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
   <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.js"></script>
   <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.widgets.js"></script>
   <script type="text/javascript" src="../menu.js"></script>
   <script type="text/javascript" src="digest.js"></script>
  </head>
  <body>
      <?php include ("../logo.php"); ?>
   <div id="ww">
    <div id="sidemenu">	
        <?php $menu->display(); ?>
    </div>
    <div id="cont"> 
     <h1>Condens&eacute;</h1>
     <?php
     $giros->sqlConnect();
     $query = sprintf("(SELECT CODE FROM ENSEIGNER WHERE UNTIS='%s') UNION (SELECT CODE FROM CLASSE WHERE REGENT='%s') ORDER BY CODE", $giros->getUntis(), $giros->getUntis());
     $giros->sqlQuery($query);
     $nb = $giros->sqlNumRows();
     switch ($nb) {
      case 0:
       ?>
       <p>Vous n'avez pas de classe concern&eacute;</p>
       <?php
       break;
      case 1:
       $row = $giros->sqlData();
       printf("<input type='radio' name='rgClasse' id='rgClasse' value='%s' checked='checked' style='display:none' />", $row['CODE']);
       break;
      default:
       ?>
       <h2>Votre choix:</h2>
       <table>
        <tbody>
         <tr>
             <?php
             $col = 0;
             $sel = " checked='checked'";
             while ($row = $giros->sqlData()) {
              printf("<td><input type='radio' name='rgClasse' id='rgClasse' value='%s' %s onclick='updateData(\"%s\");'>%s</td>", $row['CODE'], $sel, $row['CODE'], $row['CODE']);
              $sel = '';
              $col = ($col + 1) % 4;
              if ($col == 0) {
               echo "</tr><tr>";
              }
             }
             for ($i = $col; $i < 4; $i++) {
              echo "<td></td>";
             }
             ?>
         </tr>
        </tbody>
       </table>
       <?php
       break;
     }
     ?> 
     <div id="data">

     </div> 
    </div>
   </div>
  </body>
 </html>
 <?php
}
?> 