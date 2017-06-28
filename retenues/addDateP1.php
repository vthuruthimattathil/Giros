<?php
function showForm ($ERR='',$date='',$time='',$place='',$max='',$comment='') {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: ".$giros->getErrorUrl());
 }
 $_SESSION['RETENUE']['DONE']=FALSE;
 unset($_SESSION['RETINS']);
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
 
<head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
 <title>Retenues - Ajouter date retenue</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="addDate.js"></script>
</head>   
 
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">	
 <?php $menu->display(); ?>
  </div>
  <div id="cont"> 
   <h1>Ins&eacute;rer une date (retenue):</h1>
   <form action="addDate.php" method="post" enctype="multipart/form-data">
    <div>
     Entrez la nouvelle date: (format: jj/mm/aa)<br />
<?php echo '   <input type="text" name="edtDate" maxlength="8" value="'.$date.'"><br />'; ?>
     Entrez l'heure: (format: hh:mm)
     <table style="cursor: pointer">
      <tr>
       <td>
<?php
  if ($time === "") {
   echo '   <input id ="edtHeure" type="text" name="edtHeure" maxlength="5" value="14:50"><br />';  
  }
  else {
   echo '   <input id ="edtHeure" type="text" name="edtHeure" maxlength="5" value="' . $time . '"><br />';
  }
?>
       </td>
       <td onclick="updateTime('8:10')">8:10</td>
       <td onclick="updateTime('9:05')">9:05</td>
       <td onclick="updateTime('10:15')">10:15</td>
       <td onclick="updateTime('11:10')">11:10</td>
       <td onclick="updateTime('12:05')">12:05</td>
      </tr>
      <tr>
       <td></td>
       <td onclick="updateTime('13:00')">13:00</td>
       <td onclick="updateTime('13:55')">13:55</td>
       <td onclick="updateTime('14:50')">14:50</td>
       <td onclick="updateTime('15:45')">15:45</td>
      </tr>
     </table>
     Entrez la salle:<br />
<?php echo '   <input type="text" name="edtSalle" maxlength="25" value="'.$place.'"><br />'; ?>
     Entrez le nombre maximal d'&eacute;l&egrave;ves:<br />
<?php
  if ($max != 0) {
   echo '   <input type="text" name="edtMax" maxlength="2" value="' . $max . '"><br />';
  } else {
   echo '   <input type="text" name="edtMax" maxlength="2" value="10"><br />';
  }
 ?>
     Entrez un commentaire:<br />
<?php echo '   <input type="text" id="edtComment" name="edtComment" maxlength="64" value="'.$comment.'"><br />'; ?>
     S&eacute;lectionnez une réservation:<br />
     <select name="reservation" id="reservation" onchange="updateReservation()">
      <option value='X'>---</option>
<?php
  $giros->sqlConnect();
  $query="SELECT UNTIS,NOM,PRENOM FROM PROF ORDER BY NOM,PRENOM,UNTIS ";
  $giros->sqlQuery($query);
  while ($row = $giros->sqlData()){
   printf("      <option value='%s'>%s %s (%s)</option>",$row['UNTIS'],$row['NOM'],$row['PRENOM'],$row['UNTIS']); 
  }
?>
     </select>
     <br />
     <input type="submit" name="submit" value="Enregistrer" />
     <input type="reset" /> 
    </div>
   </form>
<?php  
   echo "<br>".$ERR;
?>
  </div>
 </div>
</body>
</html>
<?php
}
?>