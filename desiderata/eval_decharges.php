<?php
include_once("../session.php");
include_once("../c_menu.php");
include_once 'c_desiderata.php';
include_once("../PDF/class.ezpdf.php");
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
  <title>Desiderata - Evaluation d&eacute;charges</title>
  <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
  <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
  <link rel="stylesheet" href="../tablesorter/css/theme.blue.css" type="text/css" />
  <link rel="stylesheet" href="../css/layout.css" type="text/css" />
  <script type="text/javascript" src="../jquery/jquery.js"></script>
  <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
  <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.js"></script>
  <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.widgets.js"></script>
  <script type="text/javascript" src="../menu.js"></script>
  <script type="text/javascript" src="eval_decharges.js"></script>
 </head>   
 <body>
     <?php include ("../logo.php"); ?>
  <div id="ww">
   <div id="sidemenu">
       <?php $menu->display(); ?>
   </div>
   <div id="cont">

    <?php
    $lDech = array();
    $lUntis = array();
    $query = 'SELECT DISTINCT DESIGNATION FROM DECHARGE ORDER BY DESIGNATION';
    $giros->sqlConnect();
    $giros->sqlQuery($query);
    while ($row = $giros->sqlData()) {
     $lDech[] = $row['DESIGNATION'];
    }
    $query = 'SELECT DISTINCT UNTIS FROM DECHARGE LEFT JOIN DESIDERATA USING(NODESIDERATA) WHERE UNTIS IS NOT NULL ORDER BY UNTIS';
    $giros->sqlQuery($query);
    while ($row = $giros->sqlData()) {
     $lUntis[] = $row['UNTIS'];
    }
    foreach ($lUntis as $kUntis => $vUntis) {
     foreach ($lDech as $kDech => $vDech) {
      $query = "SELECT NOMBRE FROM DECHARGE LEFT JOIN DESIDERATA USING(NODESIDERATA) WHERE UNTIS='" . $vUntis . "' AND DESIGNATION='" . $vDech . "'";
      $giros->sqlQuery($query);
      $row = $giros->sqlData();
      $matrix[$vUntis][$vDech] = $row['NOMBRE'];
     }
    }
    $head = TRUE;
    foreach ($matrix as $untis => $val) {
     if ($head) {
      $head = FALSE;
      ?>
      <table id="myTable"  class="tablesorter tablesorter-blue" >
       <thead>
        <tr> 
         <th>Untis</th>
         <?php
         foreach ($val as $kdech => $vdech) {
          printf("<th>%s</th>", $kdech);
         }
         ?>
        </tr>
       </thead>
       <tbody> 
        <tr>
            <?php
           }
           printf("<td>%s</td>", $untis);
           foreach ($val as $kdech => $vdech) {
            printf("<td>%s</td>", $vdech);
           }
           ?>
       </tr>
       <?php
      }
      ?>

     </tbody>
    </table>
   </div>
  </div>
 </body>
</html>

