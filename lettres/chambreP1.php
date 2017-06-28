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
 <title>Lettres - Chambres</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="chambre.js"></script>
</head>  
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">
<?php $menu->display(); ?>
  </div>
  <div id="cont">
   <h1>Cr&eacute;ation lettre: Absences - Chambres</h1>
<?php 
 $giros->sqlConnect();
 $query=sprintf("SELECT CODE FROM CLASSE WHERE REGENT='%s' ORDER BY CODE",$giros->getUntis());
 $giros->sqlQuery($query);
 $nb=$giros->sqlNumRows();
 if ($nb==0) {
?>
   <p>Vous n'&ecirc;tes pas r&eacute;gent.</p>
   <p>Cette fonctionalit&eacute; est r&eacute;serv&eacute;e aux r&eacute;gents.</p>  
<?php   
 }
 else {
?>  
   <form action="chambre.php" method="post" enctype="multipart/form-data" > 
    <h2>S&eacute;lectionnez l'&eacute;l&egrave;ve</h2>
    <div>
     <select id="ele" name="eleve" size="1">
     
<?php
  $query=sprintf("SELECT IAM,NOME,PRENOME,CODE FROM ELEVE LEFT JOIN CLASSE USING(CODE) WHERE REGENT='%s' ORDER BY CODE,NOME,PRENOME",$giros->getUntis());
  $giros->sqlQuery($query);
  if ($nb==1) {
   while ($row=$giros->sqlData()) {
    printf ("     <option value=\"%s\">%s %s</option>\n",$row['IAM'],  htmlentities($row['NOME']),  htmlentities($row['PRENOME']));
   }
  }
  else {
   while ($row=$giros->sqlData()) {
    printf ("     <option value=\"%s\">%s - %s %s</option>\n",$row['IAM'],$row['CODE'],$row['NOME'],$row['PRENOME']);;
   }
  }
?>     
     </select>
     <table>
      <tr>
       <td>Date de l'absence:</td>
       <td>
        <input type="text" id="date1" style="display:none" value="X" name="date1" />
        <input type="text" id="date1x" style="border:none" readonly="readonly" />
       </td>
       <td></td>
       <td></td>
       <td>
        <span id="errorDate" style="display: none;">
         <span class="ui-state-error ui-corner-all" style="padding: 0 .7em; height: 100px;">
          <span class="ui-icon ui-icon-alert" style="display: inline-block;"></span>
          <span class="ui-state-error-text" style="display: inline-block;">Vous devez s&eacute;lectionner une date</span>
         </span>
        </span> 
       </td> 
      </tr>
      <tr>
       <td style="vertical-align: top;">Horaire de:</td>
       <td>
        <input type="radio" name="rgTimeStart" class="rgTimeStart" value="0" checked="checked"/> 8:10 <br /> 
        <input type="radio" name="rgTimeStart" class="rgTimeStart" value="1"/> 9:05 <br />
        <input type="radio" name="rgTimeStart" class="rgTimeStart" value="2"/> 10:10 <br />
        <input type="radio" name="rgTimeStart" class="rgTimeStart" value="3"/> 11:05 <br />
        <input type="radio" name="rgTimeStart" class="rgTimeStart" value="4"/> 12:00 <br />
        <input type="radio" name="rgTimeStart" class="rgTimeStart" value="5"/> 12:55 <br />
        <input type="radio" name="rgTimeStart" class="rgTimeStart" value="6"/> 13:50 <br />
        <input type="radio" name="rgTimeStart" class="rgTimeStart" value="7"/> 14:55 <br />
        <input type="radio" name="rgTimeStart" class="rgTimeStart" value="8"/> 15:50 <br />
       </td>
       <td style="vertical-align: top;">&agrave;</td>
       <td>
        <input type="radio" name="rgTimeEnd" class="rgTimeEnd" value="0"/> 9:00 <br /> 
        <input type="radio" name="rgTimeEnd" class="rgTimeEnd" value="1"/> 9:55 <br />
        <input type="radio" name="rgTimeEnd" class="rgTimeEnd" value="2"/> 11:00 <br />
        <input type="radio" name="rgTimeEnd" class="rgTimeEnd" value="3"/> 11:55 <br />
        <input type="radio" name="rgTimeEnd" class="rgTimeEnd" value="4"/> 12:50 <br />
        <input type="radio" name="rgTimeEnd" class="rgTimeEnd" value="5"/> 13:45 <br />
        <input type="radio" name="rgTimeEnd" class="rgTimeEnd" value="6"/> 14:40 <br />
        <input type="radio" name="rgTimeEnd" class="rgTimeEnd" value="7"/> 15:45 <br />
        <input type="radio" name="rgTimeEnd" class="rgTimeEnd" value="8" checked="checked"/> 16:40 <br />
       </td>
       <td>
        <span id="errorTime" style="display: none;">
         <span class="ui-state-error ui-corner-all" style="padding: 0 .7em; height: 100px;">
          <span class="ui-icon ui-icon-alert" style="display: inline-block;"></span>
          <span class="ui-state-error-text" style="display: inline-block;">Le d&eacute;but ne peut pas &ecirc;tre avant la fin. </span>
         </span>
        </span> 
       </td> 
      </tr>
      <tr>
       <td>Num&eacute;ro de l'absence:</td>
       <td>
        <select name="lstQte" id="lstQte" onclick="$('#lstQteTemp').remove();">
         <option value="-1" id="lstQteTemp">???</option>
<?php 
  for ($i = 1; $i < 21; $i++) {
   printf("         <option value=\"%s\" >%s</option>",$i,$i);
  } 
?>
        </select>
       </td>
       <td></td>
       <td></td>
       <td>
        <span id="errorQte" style="display: none;">
         <span class="ui-state-error ui-corner-all" style="padding: 0 .7em; height: 100px;">
          <span class="ui-icon ui-icon-alert" style="display: inline-block;"></span>
          <span class="ui-state-error-text" style="display: inline-block;">Il faut choisir un nombre.</span>
         </span>
        </span> 
       </td>
      </tr>
     </table>
     <p>Choix de la chambre:</p>
     
 <?php
  $query="SELECT * from CHAMBRE";
  $giros->sqlQuery($query);
  $checked=" checked=\"checked\"";
  while ($row=$giros->sqlData()) {
   printf("<input type=\"radio\" name=\"rgChambre\" value=\"%s\"%s/> %s %s %s %s<br />\n",$row['ID'],$checked,htmlentities($row['L1']),htmlentities($row['L2']),htmlentities($row['L3']),htmlentities($row['L4']));
   $checked="";
  }
?>         

     <input type="submit" value="Enregistrer et g&eacute;n&eacute;rer la lettre" onclick="return checkForm();"/>
    </div>
   </form>
   <div>
    <p>
     Par la pr&eacute;sente, j'ai le regret de vous informer que l'&eacute;l&egrave;ve ... de la classe ... n'a pas fr&eacute;quent&eacute; les cours du ... de ... &agrave; ... . Par ailleurs, il n'a pas fourni de certificat m&eacute;dical afin de justifier son absence.
    </p>
   </div>
<?php 
 }
?>
  </div>
 </div> 
</body>
</html>
<?php
}
?>