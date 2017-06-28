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
 <title>Retenues - Report d'un suivi</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../tablesorter/css/theme.blue.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.widgets.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="updateP1.js"></script>
</head>  

 <body>
 <?php include ("../logo.php"); ?>
  <div id="ww">
   <div id="sidemenu">	
 <?php $menu->display(); ?>
   </div>
  <div id="cont">   
   <h1>Report retenue:</h1>
   <h2>S&eacute;lectionnez la retenue:</h2>
   <form action="update.php" method="post" onsubmit="return checkForm();">
    <div>    
<?php
 $giros->sqlConnect();
 $query="SELECT NORETENUE,NOME,PRENOME,CODE,UNTIS,DATE_FORMAT(DATER,'%d.%m.%Y %T') AS DATER_F,MOTIF,SALLE FROM RETENUE LEFT JOIN ELEVE USING (IAM) LEFT JOIN DATESR USING(NODATER) WHERE SUIVI=0 ORDER BY DATER";
 $giros->sqlQuery($query);
 if ($giros->sqlNumRows()==0) {
  echo "Pas de retenues &agrave; reporter\n";
 }
 else {
?>
     <table id="dateTable"  class="tablesorter tablesorter-blue" > 
      <thead>
       <tr>
        <th>Untis</th>
        <th>Nom</th>
        <th>Classe</th>
        <th>Date Retenue</th>
        <th>Motif</th>
        <th>Salle</th>
       </tr>
      </thead>
      <tfoot></tfoot>
      <tbody> 
<?php  
  while ($row = $giros->sqlData()) {
   echo "       <tr>\n";
   printf("        <td><input type=\"radio\" name=\"noretenue\" id=\"noretenue\" value=\"%s\" onchange=\"loadret();\">%s</td>\n",$row['NORETENUE'],$row['UNTIS']);
   printf("        <td>%s %s</td>\n",$row['NOME'],$row['PRENOME']);
   printf("        <td>%s</td>\n",$row['CODE']);
   printf("        <td>%s</td>\n",$row['DATER_F']);
   printf("        <td>%s</td>\n",$row['MOTIF']);
   printf("        <td>%s</td>\n",$row['SALLE']);
  }
?>
      </tbody>
     </table>  
<?php  
 }
?>
     <hr />
     <p id="wait" style="display:none">Chargement en cours</p>
     <div id="frm" style="display:none">
      <div id ="ret" > </div>
      <p><input type="checkbox" name="memo" value="memo" />M&eacute;moriser la date initiale</p>
      <p><input type="checkbox" name="email" value="email" />Envoyer email</p>
      <input type="submit" value="Modifier les retenues s&eacute;lectionn&eacute;es" />
     </div> 
    </div>
   </form>
  </div>
 </div>
</body>
</html>
<?php
 }
?>