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
 <title>Documents - Ajouter bon</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="addV.js"></script>
</head>  

<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">	
<?php $menu->display(); ?>
  </div>
  <div id="cont">  
   <h1>Ajout bon:</h1>
   <span style="color: red"><?php echo $ERROR ?></span>
   <form action="addV.php" method="post" enctype="multipart/form-data" onsubmit="return checkform();">
    <div>S&eacute;lectionnez le titulaire:
     <select id="untis" name="untis" size="1" onchange="lstclasse(this)" >
<?php
 $giros->sqlConnect();
 $giros->sqlQuery("SELECT UNTIS,NOM,PRENOM,NOCASE FROM PROF ORDER BY NOM,PRENOM,UNTIS");
 while ($row = $giros->sqlData()) {
  printf ("     <option value=\"%s\">%s %s (%s)</option>\n",$row['UNTIS'],$row['NOM'],$row['PRENOM'],$row['UNTIS']);
 } 
?> 
     </select> 
    </div>
    <div>
S&eacute;lectionnez la classe:
     <p id="wait" style="display:none">Chargement en cours</p>
     <input id="myrgclasses" type="radio" name="rgclasses" value="my" checked="checked" onclick="rgclick('#mycl','#allcl');" />Classes du titulaire
     <input type="radio" name="rgclasses" value="all" onclick="rgclick('#allcl','#mycl');" />Toutes les classes
    </div>
    <div id="divmycl"></div>
    <div id="divallcl">
     <select id="allcl" name="allcl" size="1" style="display:none" onclick="updateClasse('#allcl');">
<?php
 $giros->sqlConnect();
 $giros->sqlQuery("SELECT CODE, COUNT(*) AS QTE FROM CLASSE LEFT JOIN ELEVE USING (CODE) GROUP BY CODE");
 while ($row = $giros->sqlData()) {
  printf ("      <option id=\"%s\" value=\"%s\">%s</option>\n",$row['CODE'],$row['QTE'],$row['CODE']);
 }
?>
     </select>  
    </div>
    <table>
     <tr>
	    <td>Nombre d'exemplaires:</td>
 	    <td><input type="text" id="qte" name ="qte" size="3" style="border: none" readonly="readonly" /></td>
 	    <td></td> 
     </tr>
     <tr>
      <td>Nombre de pages:</td> 
      <td><input type="text" id="pages" name ="pages" size="3" onchange="(isNaN($('#pages').val()))?$('#pages').val('???'):$('#pages').val(parseInt($('#pages').val()));" /></td>
      <td><span style="color:red; display: none" id="errPages" >Attention nombre positif!</span></td> 
     </tr>
     <tr>
      <td><input type="radio" name="rgRV" value="0" checked="checked" />Recto</td>
      <td><input type="radio" name="rgRV" value="4" />Recto/Verso</td>
      <td></td>
     </tr>
     <tr>
      <td><input type="checkbox" name="chkTri" value="32" />Tri&eacute;</td>
      <td><input type="checkbox" name="chkAgr" value="128" />Agraf&eacute;</td>
      <td></td>
     </tr>
    <tr>
      <td><input type="checkbox" name="chkPerf" value="64" />Perfor&eacute;</td>
      <td>Papier couleur:<input type="text" name="edtCouleur" size="10" maxlength="45" value="blanc" /></td>
      <td></td>
     </tr>         
     <tr>
      <td><input type="radio" name="rgA4" value="0" checked="checked" />A4</td>
      <td><input type="radio" name="rgA4" value="8" />A3</td>
      <td></td>
     </tr> 
     <tr>
      <td><input type="checkbox" name="chkTrans" value="512" />Set transparents</td>
      <td></td>
      <td></td>
     </tr>  
     <tr>
      <td><input type="checkbox" name="chkPers" value="256" />Set personnel</td>
      <td></td>
      <td></td>
     </tr>     
     <tr> 
      <td><input type="radio" name="rgColor" value="0" checked="checked" />Noir/blanc</td>
      <td><input type="radio" name="rgColor" value="2" />Couleur</td>
      <td></td>
     </tr>      
     <tr>
      <td><input type="radio" name="rgPay" value="16" checked="checked" />Payant</td>
      <td><input type="radio" name="rgPay" value="0" />Gratuit</td>
      <td></td>
     </tr>
    </table> 
    <div>
 Date du bon: 
     <input type="text" id="dateIx" value="Cliquez ici pour s&eacute;lectionner la date!" style="width:450px; border:none" readonly="readonly" name="dateIx" />
     <input type="text" id="dateI" value="X" name="dateI" style="display:none" />
     <input type="text" id="classe" name="classe" style="display:none"/>
     <br />
 Remarque:<br />
     <input type="text" name="edtComment" size="50" maxlength="255" /><br />
     <input type="submit" name="submit" value="Envoyer" />
     <input type="reset" /><br />
    </div>
   </form>
  </div>
 </div>
</body>
</html>
<?php
 }