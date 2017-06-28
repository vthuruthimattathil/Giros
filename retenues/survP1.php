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
 <title>Retenues - Ajouter surveillant</title>
 <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
 <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
 <link rel="stylesheet" href="../tablesorter/css/theme.blue.css" type="text/css" />
 <link rel="stylesheet" href="../css/layout.css" type="text/css" />
 <script type="text/javascript" src="../jquery/jquery.js"></script>
 <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.js"></script>
 <script type="text/javascript" src="../tablesorter/js/jquery.tablesorter.widgets.js"></script>
 <script type="text/javascript" src="../menu.js"></script>
 <script type="text/javascript" src="surv.js"></script>
</head>   

<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">	
<?php $menu->display(); ?>
  </div>
  <div id="cont">  
   <h1>Ajouter une / des surveillance(s):</h1>
   <form action="surv.php" method="post" enctype="multipart/form-data">
    <div>
     <input type="submit" value="Enregistrer" />
     <table id="myTable"  class="tablesorter tablesorter-blue" >
      <thead>
       <tr>
        <th>Date</th>
        <th>Salle</th>
        <th>Commentaire</th>
        <th>Surveillant</th>
       </tr>
      </thead>
      <tbody>
<?php 
  $giros->sqlConnect();
  $giros->sqlQuery("SELECT NOM,PRENOM,UNTIS FROM PROF ORDER BY UNTIS");
  while ($row=$giros->sqlData()) {
  	$surv[$row['UNTIS']]=htmlentities($row['UNTIS'].' '.$row['PRENOM'].' '.$row['NOM']);
  }
  $query="SELECT NODATER, SURVEILLANT, DATE_FORMAT(DATER,'%d.%m.%Y %k:%i') AS FDATER, SALLE, COMMENT, NOM,PRENOM ";
  $query.="FROM DATESR LEFT JOIN PROF ON PROF.UNTIS=DATESR.SURVEILLANT ORDER BY DATER DESC, SALLE ASC";
  $giros->sqlQuery($query);
  while ($row = $giros->sqlData()) {
   $s[1]=$row['FDATER'];
   $s[2]=$row['SALLE'];
   $s[3]=$row['COMMENT'];
   $s[4]="\n      <select name='S$row[NODATER]' size='1'>\n       <option value='-'>----</option>\n";
   foreach ($surv as $key=>$val) {   
   	if ($row['SURVEILLANT']==$key) {
   	 $s[4].="       <option value='$key' selected='selected'>$val</option>\n";
    } else {
   	 $s[4].="       <option value='$key'>$val</option>\n";;
    }
   }
   $s[4].="      </select>";
   echo "    <tr>\n";
   for ($i=1;$i<=4;$i++) {
    printf("     <td>%s</td>\n",$s[$i]);
   }
   echo "    </tr>\n";
  }
  ?>  
      </tbody>
     </table>
    </div>
   </form>
  </div>
  </div>
 </body>
</html>
<?php
 }
 ?>
