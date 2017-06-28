<?php
function showForm2 () {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: ".$giros->getErrorUrl());
 }
 $id=$_GET['id'];
 $id=urldecode($id);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
 
<head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
 <title>Retenues - Inscrire pr&eacute;sences</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../tablesorter/css/theme.blue.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.widgets.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="present.js"></script>
</head>  
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">
<?php $menu->display(); ?>
  </div>
  <div id="cont">
   <form action="present.php"  method="post">
   <div>
   <table id="myTable"  class="tablesorter tablesorter-blue" >
    <thead align="left">
     <tr>
      <th>Nom</th>
      <th>Pr&eacute;nom</th>
      <th>Classe</th>
      <th>Titulaire</th>
      <th>Case</th>
      <th>Pr&eacute;sent</th>
      <th>Convocation</th>
     </tr>
    </thead>
    <tbody>
<?php
  $giros->sqlConnect();
  $query="SELECT NOME,PRENOME,CODE,NOM,PRENOM,NOCASE,PRESENT,CO,NORETENUE FROM RETENUE INNER JOIN PROF USING(UNTIS) ";
  $query.="LEFT JOIN ELEVE ON RETENUE.IAM=ELEVE.IAM LEFT JOIN DATESR USING(NODATER) ";
  $query.="WHERE NODATER='".$id."' AND SUIVI =-1 ORDER BY PRESENT,NOME";
  $giros->sqlQuery($query);
  while ($row = $giros->sqlData()) {
   $s[0]=htmlentities($row['NOME']);
   $s[1]=htmlentities($row['PRENOME']);
   $s[2]=$row['CODE'];
   $s[3]=htmlentities($row['NOM'].' '.$row['PRENOM']);
   $s[4]=$row['NOCASE'];
   if ($row['PRESENT']==1) {
    $s[5]=' checked';
   }
   else {
    $s[5]='';
   }
   $s[5]= '<input type="checkbox" name="present[]" value="'.$row['NORETENUE'].'"'.$s[5].'>';
   $s[6]=sprintf("<input type='radio' name='CO[%s]' value='S' checked='checked'>Sign&eacute;\n",$row['NORETENUE']);
   if ($row['CO']=='NS') {$checked=" checked='checked'";} else {$checked='';}
   $s[6].=sprintf("<input type='radio' name='CO[%s]' value='NS' %s>Non-sign&eacute;\n",$row['NORETENUE'],$checked);
   if ($row['CO']=='M') {$checked=" checked='checked'";} else {$checked='';}
   $s[6].=sprintf("<input type='radio' name='CO[%s]' value='M' %s>Manque\n",$row['NORETENUE'],$checked);

   echo "   <tr>\n";
   for ($i=0;$i<=6;$i++) {
    printf("    <td>%s</td>\n",$s[$i]);
   }
   echo "   </tr>\n";
  }
?>
    </tbody>
   </table>
   <br />
<?php echo '   <input type="hidden" name="id" value="'.$id.'">'; ?>
   <input type="submit" name="submit" value="Enregistrer et g&eacute;n&eacute;rer relev&eacute;" />
   </div>
  </form>
 </div>
</div>
</body>
</html>
<?php
}
?>
