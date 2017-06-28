<?php
function showForm ($ERROR='') {
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
 <title>Documents - Demande d'impression</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="mailFile.js"></script>
</head>
<body>
  <?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">	
  <?php $menu->display(); ?>
  </div>
  <div id="cont">  
   <h1>Demande d'impression:</h1>
   <span style="color: red"><?php echo $ERROR ?></span>
   <form action="mailFile.php" method="post" enctype="multipart/form-data" onsubmit="return checkform();">
    <div>
     <h2>S&eacute;lectionnez classe / groupe:<br /></h2>
     <table>
      <tr>
       <td><input type="radio" name="rgClasses" value="mycl" checked="checked" onclick="rgClick('#mycl');" /> Mes classes</td>
       <td><input type="radio" name="rgClasses" value="mycluster" onclick="rgClick('#mycluster');" /> Mes groupes</td>
      </tr>
      <tr>
       <td><input type="radio" name="rgClasses"  value="allcl" onclick="rgClick('#allcl');" /> Toutes les classes</td>
       <td></td>
      </tr>
     </table>
     <br />

<?php
// Mes classes
 $giros->sqlConnect();
 $giros->sqlQuery("SELECT CODE FROM ENSEIGNER WHERE UNTIS='".$giros->getUntis()."' ORDER BY CODE");
 if ($giros->sqlNumRows()!=0) {
  echo "     <select id=\"mycl\" name=\"mycl\" size=\"1\" onchange=\"updateList('#mycl');\">\n";
  while ($row = $giros->sqlData()) {
   printf ("      <option id=\"%s\" value=\"%s\">%s</option>\n",$row['CODE'],$row['CODE'],$row['CODE']);
  }
  echo "     </select>\n";
 } 
// Mes groupes  
 $giros->sqlQuery("SELECT NOCLUSTER, DESCRIPTION FROM CLUSTER WHERE UNTIS= '".$giros->getUntis()."' ORDER BY DESCRIPTION;");
 if ($giros->sqlNumRows()!=0) {
  echo "     <select id=\"mycluster\" name=\"mycluster\" size=\"1\" style=\"display:none\" onchange=\"updateList('#mycluster');\">\n";
  while ($row = $giros->sqlData()) {
   printf ("      <option id=\"%s\" value=\"%s\">%s</option>\n",$row['NOCLUSTER'],$row['NOCLUSTER'],htmlentities($row['DESCRIPTION']));
  }
  echo "     </select>\n";
 }
// Toutes les classes
 $giros->sqlQuery("SELECT CODE FROM CLASSE ORDER BY CODE");
 if ($giros->sqlNumRows()!=0) {
  echo "     <select id=\"allcl\" name=\"allcl\" size=\"1\" style=\"display:none\" onchange=\"updateList('#allcl');\">\n";
  while ($row = $giros->sqlData()) {
   printf ("      <option id=\"%s\" value=\"%s\">%s</option>\n",$row['CODE'],$row['CODE'],$row['CODE']);
  }
  echo "     </select>";
 }
?>       
     <br />
     <h2>El&egrave;ves inscrits: (Cliquez sur l'&eacute;l&egrave;ve pour l'ajouter ou utilisez le bouton &laquo;Ajouter tous&raquo;.)</h2>
     <p id="wait" style="display:none">Chargement en cours</p>
     <div  id="lstEle" style="height: 220px; overflow: scroll;">

     </div>
     <div>
      <button id="btnAdd">&dArr; Ajouter tous&dArr;</button>
      <button id="btnDel">&dArr; Supprimer tous &dArr;</button>
     </div>

     <div id="tot"></div>
     <div id="selEle" style="height: 200px; overflow: scroll;">
     
     </div>
     <table>
      <tr> 
       <td><input type="radio" name="rgColor" value="0" checked="checked" />Noir/blanc</td>
       <td><input type="radio" name="rgColor" value="2" />Couleur</td>
       <td></td>
      </tr>
      <tr>
       <td><input type="radio" name="rgRV" value="0" checked="checked" />Recto</td>
       <td><input type="radio" name="rgRV" value="4" />Recto/Verso</td>
       <td></td>
      </tr>
      <tr>
       <td><input type="radio" name="rgA4" value="0" checked="checked" />A4</td>
       <td><input type="radio" name="rgA4" value="8" />A3</td>
       <td></td>
      </tr>
      <tr>
       <td><input type="radio" name="rgPay" value="16" checked="checked" />Payant</td>
       <td><input type="radio" name="rgPay" value="0" />Gratuit (Devoirs en classe, test...)</td>
       <td></td>
      </tr>
      <tr>
       <td><input type="checkbox" name="chkTri" value="32" />Tri&eacute; (<b>NON</b> group&eacute;)</td>
       <td></td>
       <td></td>
      </tr>
      <tr>
       <td><input type="checkbox" name="chkPerf" value="64" />Perfor&eacute;</td>
       <td></td>
       <td></td>
      </tr>
      <tr>
       <td><input type="checkbox" name="chkAgr" value="128" />Agraf&eacute;</td>
       <td></td>
       <td></td>
      </tr>
      <tr> 
       <td><input type="checkbox" name="chkPers" value="256" />Set personnel</td>
       <td></td>
       <td></td>
      </tr>
      <tr> 
       <td><input type="checkbox" name="chkTrans" value="512" />Set transparents</td>
       <td></td>
       <td></td>
      </tr>
     </table>
     Couleur papier:
     <input type="text" name="edtCouleur" size="10" maxlength="45" value="blanc" /><br /> 
     <span style="color: red; font-size: 150%">D&eacute;lai minimum 24 heures ouvrables!<br /></span>
     Delai:<br />
     <select name="dateTime">
      <option value="TF" selected="selected">Apr&egrave;s-midi</option>
      <option value="TA">8:10</option>
      <option value="TB">9:05</option>
      <option value="TC">10:15</option>
      <option value="TD">11:10</option>
      <option value="TE">12:05</option>
     </select> 
     <input type="text" id="dateIx" value="Cliquez ici pour s&eacute;lectionner la date!" style="width:450px; border:none" readonly="readonly" name="dateIx" />
     <input type="text" id="dateI"  style="display:none" value="X" name="dateI" />
     <br />
     <span id="errFile">S&eacute;lectionnez votre fichier: (Attention: seulement les fichiers du type PDF seront trait&eacute;s!)</span><br />
     <input type="file" id="edtFile" name="edtFile" size="50" maxlength="255" /><br />
     Remarque:<br />
     <input type="text" name="edtComment" size="50" maxlength="255"/><br />
     <input type="submit" name="submit" value="Envoyer" />
     <input type="reset" /><br />
    </div> 
    <div id="iams" style="display: none;">

    </div>
   </form>
  </div>
 </div>
</body>
</html>
<?php }?>
