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
 <title>Lettres - Administration</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="genAdm.js"></script>
</head>  
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">
<?php $menu->display(); ?>
  </div>
  <div id="cont">
   <h1>Cr&eacute;ation lettre: Gestion des &eacute;tudes surveill&eacute;es et appuis</h1>
   <form action="genAdm.php" method="post" enctype="multipart/form-data" >
    <div>
     <h2>Choix de l'&eacute;l&egrave;ve:</h2>
<?php
$giros->sqlConnect();
$query = "SELECT DISTINCT CODE,NOM,PRENOM FROM CLASSE LEFT JOIN PROF ON (REGENT=UNTIS) ORDER BY CODE,REGENT";
$giros->sqlQuery($query);
?>
     <select name="selCode" id="selCode" onchange="updateList();">
<?php 
while ($row = $giros->sqlData()) {
 printf("      <option value='%s'>%s - (%s %s)</option>\n",$row['CODE'],$row['CODE'],$row['NOM'],$row['PRENOM']);
}
?>
     </select>
     <div id="lstEle">
 
     </div>
     <h2>Votre choix:</h2>
     <input type="radio" name="choice" value="ai" onclick="rgClick('#ai');" /> Inscription appui<br />
     <input type="radio" name="choice" value="ad" onclick="rgClick('#ad');" /> D&eacute;sinscription appui<br />
     <input type="radio" name="choice" value="an" onclick="rgClick('#an');" /> Appui non disponible<br />
     <input type="radio" name="choice" value="ei" onclick="rgClick('#ei');" /> Inscription &eacute;tudes<br />
     <input type="radio" name="choice" value="ed" onclick="rgClick('#ed');" /> D&eacute;sinscription &eacute;tudes
    </div>
    <div>
     
     <div id="ai" style="display:none">
      <h2>Inscription appui</h2>
      <table>
       <tr>
        <td>Branche:</td>
        <td>
         <select name="iaBranche">
          <option value="al">Allemand</option>
          <option value="an">Anglais</option>
          <option value="mt">Math&eacute;matiques</option>
          <option value="fr">Fran&ccedil;ais</option>
         </select>
        </td>
        <td></td>
        <td></td>
       </tr>
       <tr> 
        <td>Jour:</td>
        <td>
         <select name="iaDay"> 
          <option value="1">Lundi</option>
          <option value="2">Mardi</option>
          <option value="3">Mercredi</option>
          <option value="4">Jeudi</option>
          <option value="5">Vendredi</option>
         </select>
        </td>
        <td></td>
        <td></td>
       </tr>
       <tr>
        <td>De:</td>
        <td>
         <input name="iaStartHour" id="iaStartHour" style="width:30px" />:<input name="iaStartMinute" id="iaStartMinute" style="width:30px" />
        </td>
        <td>A:</td>
        <td>
         <input name="iaEndHour" id="iaEndHour" style="width:30px" />:<input name="iaEndMinute" id="iaEndMinute" style="width:30px" />
        </td>
       </tr>
       <tr> 
        <td>Salle:</td>
        <td><input type="text" name="room" id="room" /></td>
        <td></td>
        <td></td>
       </tr>
      </table>
     </div>

     <div id="ad" style="display:none">
      <h2>Annulation appui</h2>
      <p> Branche:
       <select name="daBranche">
        <option value="al">Allemand</option>
        <option value="an">Anglais</option>
        <option value="mt">Math&eacute;matiques</option>
        <option value="fr">Fran&ccedil;ais</option>
       </select>
      </p>
     </div>

     <div id="an" style="display:none">
      <h2>Appui non disponible</h2>
      <table>
       <tr>      
        <td>Branche:</td>
        <td><input type="text" name="anBranche" id="anBranche" /></td>
       </tr>
       <tr>       
        <td>AET:</td>
        <td><input type="text" name="anAET" id="anAET" /></td>
       </tr>
      </table>
     </div>

     <div id="ei" style="display:none">
      <h2>Inscription &eacute;tudes</h2>
      <table>
       <thead>
        <tr>
         <th>Jour:</th>
         <th>Horaire:</th>
         <th>Salle</th>
        </tr>
       </thead>
       <tbody>
        <tr>
         <td><input type="checkbox" name="eiDay[]" value="0" />Lundi</td>
         <td>15 h 00 &agrave; 16 h 30</td> 
         <td><input type="text" name="eiRoom[0]" value="P127" /></td>
        </tr>
        <tr>
         <td><input type="checkbox" name="eiDay[]" value="1" />Mardi</td>
         <td>15 h 00 &agrave; 16 h 30</td> 
         <td><input type="text" name="eiRoom[1]" value="P127" /></td>
        </tr>
        <tr>
         <td><input type="checkbox" name="eiDay[]" value="2" />Mercredi</td>
         <td>15 h 00 &agrave; 16 h 30</td> 
         <td><input type="text" name="eiRoom[2]" value="P127" /></td>
        </tr>
        <tr>
         <td><input type="checkbox" name="eiDay[]" value="3" />Jeudi</td>
         <td>15 h 00 &agrave; 16 h 30</td> 
         <td><input type="text" name="eiRoom[3]" value="P127" /></td>
        </tr>
        <tr>
         <td><input type="checkbox" name="eiDay[]" value="4" />Vendredi</td>
         <td>15 h 00 &agrave; 16 h 30</td> 
         <td><input type="text" name="eiRoom[4]" value="P127" /></td>
        </tr>

       </tbody>
      </table> 
     </div>

     <div id="ed" style="display:none">
      <h2>Annulation &eacute;tudes</h2>
      <p>Jour:
       <select name="ed">
        <option value="lundi">Lundi</option>
        <option value="mardi">Mardi</option>
        <option value="mercredi">Mercredi</option>
        <option value="jeudi">Jeudi</option>
        <option value="vendredi">Vendredi</option>
       </select>
      </p>
     </div>
     <input type="submit" value="G&eacute;n&eacute;rer lettre" />
    </div>
   </form>
  </div>
 </div> 
</body>
</html>
<?php
}
?>