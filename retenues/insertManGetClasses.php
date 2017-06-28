<?php
include_once("../session.php");
$giros=$_SESSION['GIROS'];
$untis=$_POST['untis'];
$giros->sqlConnect();
?>
<hr />
<p>
 <input type="radio" name="typeClass" value="myClass" checked="checked" onclick="swap('#myCl');">Mes classes
 <input type="radio" name="typeClass" value="allClass" onclick="swap('#allCl');">Toutes les classes
</p>
<div id="myCl">
 <select id="myClass" name="myClass" size="1" onchange="$('#tmpMyClass').remove();loadClasseEleve($('#myClass').val());">
  <option id="tmpMyClass" value="---">S&eacute;lectionnez une classe</option>
<?php
$query=sprintf("SELECT DISTINCT CODE FROM ENSEIGNER WHERE UNTIS='%s' ORDER BY CODE",$untis);
$giros->sqlQuery($query);
while ($row = $giros->sqlData()) {
 printf ("      <option value=\"%s\">%s</option>\n",$row['CODE'],$row['CODE']);
} 
?>
 </select>
</div>
<div id="allCl" style="display: none;">
 <select id="allClass" name="allClass" size="1" onchange="$('#tmpAllClass').remove();loadClasseEleve($('#allClass').val());">
  <option id="tmpAllClass" value="---">S&eacute;lectionnez une classe</option>
<?php
$query="SELECT CODE FROM CLASSE ORDER BY CODE";
$giros->sqlQuery($query);
while ($row = $giros->sqlData()) {
 printf ("      <option value=\"%s\">%s</option>\n",$row['CODE'],$row['CODE']);
} 
?>
 </select>
</div>