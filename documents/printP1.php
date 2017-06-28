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
  <title>Documents - Impressions</title>
  <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
  <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
  <link rel="stylesheet" href="../tablesorter/css/theme.blue.css" type="text/css" />
  <link rel="stylesheet" href="../css/layout.css" type="text/css" />
  <script type="text/javascript" src="../jquery/jquery.js"></script>
  <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
  <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.js"></script>
  <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.widgets.js"></script>
  <script type="text/javascript" src="../menu.js"></script>
  <script type="text/javascript" src="print.js"></script>
 </head> 
 <body>
   <?php include ("../logo.php"); ?>
  <div id="ww">
   <div id="sidemenu">	
   <?php $menu->display(); ?>
   </div>
   <div id="cont">   
    <h1>Relev&eacute; des impressions:</h1>
    <p>Cliquez sur une ent&ecirc;te pour modifier l'ordre du tri.</p>
    <form action="print.php" method="post" enctype="multipart/form-data" onsubmit="return checkform();">
     <table id="myTable" class="tablesorter tablesorter-blue" role="grid">
      <thead>
       <tr>
        <th>No</th>
        <th>Case -Titulaire</th>
        <th>Document</th>
        <th>Quantit&eacute;</th>
        <th>Type</th>
        <th>Payant</th>
        <th>Remis le</th>
        <th>D&eacute;lai</th>
        <th>Remarque</th>
        <th>Pages</th>
        <th>Fini</th>
       </tr>
      </thead>
      <tbody>
<?php
 $giros->sqlConnect();
 $query="SELECT NOCOMMANDE,NOM,PRENOM,NOCASE,NAME,MIMETYPE,DATE_FORMAT(DATE,'%d.%m.%Y  %H:%i') AS DATE_F,DATE_FORMAT(DELAI,'%d.%m.%Y %H:%i:%s') AS DELAI_F,";
 $query.="TYPE,COULEUR,REMARQUE,COUNT(*) AS QTE_COMM ";
 $query.="FROM COMMANDE LEFT JOIN PROF USING(UNTIS) LEFT JOIN COMMANDE_ELEVE USING(NOCOMMANDE) ";
 $query.="WHERE DONE IS NULL AND (TYPE&1)=0 GROUP BY NOCOMMANDE ORDER BY DELAI,DATE";
 $giros->sqlQuery($query);
 $index=1;
 while ($row = $giros->sqlData()) {
  $s[0]=$row['NOCASE'].' - '.$row['NOM'].' '.$row['PRENOM'];
  $s[1]=$row['NAME'];
  $s[2]=$row['QTE_COMM'];
  if (($row['TYPE'] & 2  )==0 ) {$s[3]='NB';} else {$s[3]='C';}
  if (($row['TYPE'] & 4  )==0 ) {$s[3].=' / R';} else {$s[3].=' / RV';}
  if (($row['TYPE'] & 8  )==0 ) {$s[3].=' / A4';} else {$s[3].=' / A3';}
  if (($row['TYPE'] & 32 )!=0 ) {$s[3].=' / Tri';}
  if (($row['TYPE'] & 64 )!=0 ) {$s[3].=' / P';}
  if (($row['TYPE'] & 128)!=0 ) {$s[3].=' / A';}
  if (($row['TYPE'] & 256)!=0 ) {$s[3].=' / SP';}
  if (($row['TYPE'] & 512)!=0 ) {$s[3].=' / TRANS';}
  if (($row['TYPE'] & 16 )!=0 ) {$s[4]='OUI';} else {$s[4]='NON';}
  $s[5]=$row['DATE_F'];
  $s[6]=$row['DELAI_F'];
  $tmp="Papier: ".$row['COULEUR'];
  if (strlen(trim($row['REMARQUE']))!=0) {
    $tmp.="<br />";
  }
  if(strlen($row['REMARQUE'])<35) {
    $tmp.=$row['REMARQUE'];
  } else {
    $tmp.=substr($row['REMARQUE'],1,35).'...'."<br />Cliquez ici pour le reste de la remarque."; 
  }
  $s[7]='<div onclick="alert(\''.$row['REMARQUE'].'\')">'.$tmp.'</div>';
  echo "       <tr>\n";
  printf("       <td>%s</td>",$index);
  $index++;
  for ($i=0;$i<=6;$i++) {
    printf("        <td><a target='_blank' href='ups/%s.pdf' onclick='voucher(\"%s\");'>%s</a></td>\n",$row['NOCOMMANDE'],$row['NOCOMMANDE'],$s[$i]);
   }
   echo "        <td>$s[7]</td>\n";
   echo '        <td><input type="text" id="pages_'.$row['NOCOMMANDE'].'" name="pages_'.$row['NOCOMMANDE'].'" size="3" style="border:none" onchange="checkPages(this)" /></td>'."\n";
   echo "        <td><input type='checkbox' class='check' name='check_".$row['NOCOMMANDE']."' /></td>\n";
   
   echo "  </tr>\n";
  }
?>  
      </tbody>
     </table>
     <div><input type="submit" name="submit" value="Enregistrer" /></div>
    </form>
   </div>
  </div>
 </body>
</html>
<?php
 }
