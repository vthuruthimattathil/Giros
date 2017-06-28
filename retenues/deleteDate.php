<?php
// Giros - Version 3 - 8.2008

// Filename:       deletedate.php
// Description:    deletes a date
// Called by:      index.php (retenue level)
// Calls:
// Includes files: session.php, menum.php
// Defines vars:
// Unsets vars:
// Modifies vars:
// Uses vars:

function show_form () {
  include_once("../session.php");
  $giros=$_SESSION['GIROS'];
  if (!($giros->retenues & 128 )) { header("Location: http://mail.ltma.lu");}
  include_once("../menu.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
 <title>Retenues - Suppression date</title>
 <link rel="stylesheet" href="../layout.css" type="text/css">
 <script type="text/javascript" src="../jquery.min.js"></script>
 <script type="text/javascript" src="../ui.core.min.js"></script>
 <script type="text/javascript" src="../ui.accordion.min.js"></script>
 <script type="text/javascript"> $(document).ready(function(){$("ul.drawers").accordion({header: 'h2.drawer-handle',  selectedClass: 'open', event: 'click', active:'.retenues', autoHeight: false})}); </script>
</head>
<body>
<?php include ("../logo.php");?>
 <div id="ww">
  <div id="sidemenu">
<?php menum($giros); ?>
  </div>
  <div id="cont">
   <h1>Suppression date:</h1>
   <p>S&eacute;lectionnez la date &agrave; supprimer. Seul les rdv vides peuvent &ecirc;tre supprim&eacute;s.</p>
  <form name="d1" action="deletedate.php"  method="post" enctype="multipart/form-data">
   <table border="1" rules="groups" width="100%">
    <thead align="left">
     <tr>
      <th></th>
      <th>Date</th>
      <th>Nombre</th>
      <th>Inscrits</th>
      <th>Salle</th>
      <th>Commentaire</th>
     </tr>
    </thead>
    <tbody>
<?php
  $giros->sql_connect();
  $giros->sql_query("SELECT DATESR.NODATER,DATE_FORMAT(DATER,'%e/%c/%Y') AS DATERF,NOMBREMAX,SALLE,COMMENT,COUNT(MATRICULE) AS NB FROM DATESR LEFT JOIN RETENUE USING(NODATER) GROUP BY DATESR.NODATER,DATER,NOMBREMAX,SALLE,COMMENT ORDER BY DATER ASC");
  while ($row = $giros->sql_data()) {
   if ($row['NB']==0) {
   $s[0]= '<input type="checkbox" name="del[]" value="'.$row['NODATER'].'">';
   }
   else {
   $s[0]='';
   }  
   
   $s[1]=$row['DATERF'];
   $s[2]=$row['NOMBREMAX'];
   $s[3]=$row['NB'];
   $s[4]=$row['SALLE'];
   $s[5]=$row['COMMENT'];
   echo "   <tr>\n";
   for ($i=0;$i<=5;$i++) {
    printf("    <td>%s</td>\n",$s[$i]);
   }
   echo "   </tr>\n";
  }
?>
    </tbody>
   </table>
   <br>
   <input type="submit" name="submit" value="Effacer les dates s&eacute;lectionn&eacute;es" >
  </form>
 </div>
</div>
</body>
</html>
<?php
 }
 if ($_SERVER['REQUEST_METHOD']!='POST') {
  show_form();
 }
 else {
  include_once("../session.php");
  $giros=$_SESSION['GIROS'];
  if (!($giros->retenues & 128) ) { header("Location: http://mail.ltma.lu");}
  $giros->sql_connect();
  if ($_POST['del'] != null) {
   foreach ($_POST['del'] as $value) { $giros->sql_query("DELETE FROM DATESR WHERE NODATER='".$value."'"); }
   }
  header("Location: index.php");
 }
?>