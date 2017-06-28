<?php
include_once("../session.php");
$giros = $_SESSION['GIROS'];
$untis = $_POST['untis'];
include_once("c_desiderata.php");
$des = new c_desiderata($untis, $giros->getSite());
$query = "SELECT * FROM PROF WHERE UNTIS='" . $untis . "'";
$giros->sqlConnect();
$giros->sqlQuery($query);
$row = $giros->sqlData();
?>
<h1>Donn&eacute;es personnelles:</h1>
<table>
 <tr>
  <td><?php echo htmlentities($row['PRENOM'] . ' ' . $row['NOM']); ?></td>
  <td>Case: <?php echo $row['NOCASE']; ?></td>
  <td><?php
      if ($des->getDonnespers() == 'T') {
       echo "Les donn&eacute;es sont correctes.";
      } else {
       echo "Les donn&eacute;es sont FAUSSES.";
      }
      ?></td>
 </tr>
 <tr>
  <td>Tel: <?php echo $des->getTelephone(TRUE); ?></td>
  <td>GSM: <?php echo $des->getGsm(TRUE); ?></td>
  <td>Absent du: <?php echo($des->getDispo1() . " au " . $des->getDispo2()); ?></td>
 </tr>
</table>

<hr> 
<div>
    <?php
    echo "Sp&eacute;cialit&eacute;: " . $des->getSpecialites(TRUE) . "<br />";
    echo "Autres branches: " . $des->getBranches(TRUE) . "<br />";
    echo "T&acirc;che: ";
    $tache = $des->getTache();
    switch ($tache) {
     case 1: echo "Enseignant(e) nomm&eacute;(e) 100% <br />";
      break;
     case 0.75: echo "Enseignant(e) nomm&eacute; 75%'<br />";
      break;
     case 0.5: echo "Enseignant(e) nomm&eacute; 50%'<br />";
      break;
     case 0.25: echo "Enseignant(e) nomm&eacute; 50%'<br />";
      break;
    }
    if ($tache > 30) {
     echo "Stagiaire: " . ($tache - 30) . "<br />";
    }
    if (($tache > 1) && ($tache < 29)) {
     echo 'Charg&eacute;(e): ' . ($tache - 0) . "<br />";
    }
    if ($des->getRecrutement() == 'T') {
     echo 'Inscription au concours: OUI <br />';
    } else {
     echo 'Inscription au concours: NON <br />';
    }
    switch ($des->getConge()) {
     case 'aucun': echo 'Pas de cong&eacute;';
      break;
     case 'mi': echo 'Cong&eacute; mi-temps jusqu\'&agrave; la rentr&eacute;e: 20' . $des->getCo_duree();
      break;
     case '3/4': echo 'Cong&eacute; 3/4 temps jusqu\'&agrave; la rentr&eacute;e: 20' . $des->getCo_duree();
      break;
     case 'pmi': echo 'Cong&eacute; parental mi-temps jusqu\'&agrave; la rentr&eacute;e: 20' . $des->getCo_duree();
      break;
     case 'ppt': echo 'Cong&eacute; parental temps plein jusqu\'&agrave; la rentr&eacute;e: 20' . $des->getCo_duree();
      break;
     case 'ss': echo 'Cong&eacute; sans solde jusqu\'&agrave; la rentr&eacute;e: ' . $des->getCo_duree();
      break;
    }
    ?>
</div>
<hr>
<div>
 <h1>D&eacute;charges:</h1>
 <table border="1" rules="groups">
  <thead>
   <tr>
    <th>D&eacute;charge</th>
    <th>Nb.</th>
    <th>Salle</th>
   </tr>
  </thead>
  <?php
  $dech = $des->getDecharge(-1);
  $totD = 0;
  foreach ($dech as $key => $val) {
   $totD+=$val['nombre'];
  }
  echo "<tfoot>";
  echo "<tr>";
  echo "<td> Total: </td>";
  echo "<td align='right'>" . $totD . "</td>";
  echo "<td></td>";
  echo "</tr>";
  echo "</tfoot>";
  echo "<tbody>";
  foreach ($dech as $key => $val) {
   echo "<tr>";
   echo "<td>" . htmlentities($val['designation']) . "</td>";
   echo "<td align='right'>" . $val['nombre'] . "</td>";
   echo "<td>" . htmlentities($val['departement']) . "</td>";
   echo "</tr>";
  }
  echo "</tbody>";
  ?>
 </table>
</div>
<hr> 
<div>
 <h1>Choix:</h1>
 <table border="1" rules="groups">
  <thead>
   <tr>
    <th>Nb.</th>
    <th>Branche</th>
    <th>Classe</th>
    <th>Salle</th>
    <th>Nb. blocs</th>
    <th>Dur&eacute;e bloc</th>
   </tr>
  </thead>
  <?php
  $choix = $des->getChoix(-1);
  $totC = 0;
  foreach ($choix as $key => $val) {
   $totC+=$val['number'];
  }
  echo "<tfoot>";
  echo "<tr>";
  echo "<td> Total: " . $totC . "</td>";
  echo "<td></td>";
  echo "<td></td>";
  echo "<td></td>";
  echo "<td></td>";
  echo "<td></td>";
  echo "</tr>";
  echo "</tfoot>";
  echo "<tbody>";
  foreach ($choix as $key => $val) {
   echo "<tr>";
   echo "<td align='right'>" . $val['number'] . "</td>";
   echo "<td>" . $val['branche'] . "</td>";
   echo "<td>" . htmlentities($val['classe']) . "</td>";
   if ($val['salle'] == '0') {
    echo "<td></td>";
   } else {
    echo "<td>" . htmlentities($val['salle']) . "</td>";
   }
   if ($val['nb_blocs'] == '0') {
    echo "<td></td>";
    echo "<td></td>";
   } else {
    echo "<td align='right'>" . htmlentities($val['nb_blocs']) . "</td>";
    echo "<td align='right'>" . htmlentities($val['duree']) . "</td>";
   }
   echo "</tr>";
  }
  echo "</tbody>";
  ?>
 </table>
</div>
<hr />
<div>
 <table>
  <tr>
   <td>Total d&eacute;charges:</td>
   <td align='right'><?php echo $totD; ?></td>
  </tr>
  <tr>
   <td>Total le&ccedil;ons:</td>
   <td align='right'><?php echo $totC; ?></td>
  </tr>
  <tr>
   <td>Grand total:</td>
   <td align='right'><?php echo $totD + $totC; ?></td>
  </tr>   
 </table>
</div>
<hr> 
<div>
 <p>Remarque:</p>
<?php echo "<p>" . $des->getRem_branches(TRUE) . "</p>"; ?>
</div> 
<hr />
<div>
 <h1>R&eacute;gence</h1>
 <?php
 if ($des->getRegence1() == '-' && $des->getRegence2() == '-') {
  echo 'Pas de r&eacute;gence demand&eacute;e';
 } else {
  if ($des->getRegence1() != '-') {
   echo "Choix 1: " . $des->getRegence1(TRUE) . "<br />";
  }
  if ($des->getRegence2() != '-') {
   echo "Choix 2: " . $des->getRegence2(TRUE) . "<br />";
  }
 }
 ?>
 <hr />
 <h1>Divers</h1>
 <?php
 if ($des->getRattrapage() == '0') {
  echo "Pas de cours de rattrapage demand&eacute;<br />";
 } else {
  echo "Rattrapage: " . $des->getRattrapage(TRUE) . "<br />";
 }
 if ($des->getSurveillance() == '0') {
  echo "Pas de surveillance demand&eacute;<br />";
 } else {
  echo "Surveillance: " . $des->getSurveillance() . "<br />";
 }
 if ($des->getFomos() == 'T') {
  echo "Vie et Soci&eacute;t&eacute;: OUI<br />";
 } else {
  echo "Vie et Soci&eacute;t&eacute;: NON<br />";
 }
 if ($des->getEtudes() == '0') {
  echo "Pas d'&eacute;tudes surveill&eacute;es<br />";
 } else {
  echo "Etudes surveill&eacute;es: " . $des->getEtudes() . "<br />";
 }
 if ($des->getParascolaire() == '') {
  echo "Pas d'activit&eacute; parascolaire<br />";
 } else {
  echo "Activit&eacute parascolaire: " . $des->getParascolaire(TRUE) . "<br />";
 }
 if ($des->getDetachement() == '-') {
  echo "Pas de d&eacute;tachement<br />";
 } else {
  echo "D&eacute;tachement: " . $des->getDetachement(TRUE) . "<br />";
 }
 if ($des->getEmploi() == 'A') {
  echo "Emploi du temps a&eacute;r&eacute;<br />";
 } else {
  echo "Emploi du temps compact<br />";
 }
 if ($des->getNeige() == 'T') {
  echo "Classe neige: OUI<br />";
 } else {
  echo "Classe neige: NON<br />";
 }
 if ($des->getMer() == 'T') {
  echo "Classe mer: OUI<br />";
 } else {
  echo "Classe mer: NON<br />";
 }
 if ($des->getRiz() == 'T') {
  echo "Bol de riz: OUI<br />";
 } else {
  echo "Bol de riz: NON<br />";
 }
 if ($des->getHuelmes() == 'T') {
  echo "Huelmes: OUI<br />";
 } else {
  echo "Huelmes: NON<br />";
 }
 if ($des->getAngla9pr() == 'T') {
  echo "Anglais 9pr: OUI<br />";
 } else {
  echo "Anglais 9pr: NON<br />";
 }
 if ($des->getPause() == 'T') {
  echo "Pause &agrave; midi: OUI<br />";
 } else {
  echo "Pause &agrave; midi: NON<br />";
 }
 if ($des->getPortes() == 'T') {
  echo "Portes ouvertes: OUI<br />";
 } else {
  echo "Portes ouvertes: NON<br />";
 }
 $rp = "R. p.: ";
 switch ($des->getPrep_surv_cantine()) {
  case "X":
   $rp.="";
   break;
  case "T":
   $rp.="Surveillance cantine: OUI ";
   break;
  case "F":
   $rp.="Surveillance cantine: NON ";
   break;
  default:
   $rp.="Surveillance cantine: ??? ";
   break;
 }
 $site = $des->getPrep_sites();
 if ($site != 0) {
  $rp.="Sites:";
  if (($site & 1) != 0) {
   $rp.=" Lamadelaine ";
  }
  if (($site & 2) != 0) {
   $rp.=" Differdange ";
  }
  if (($site & 4) != 0) {
   $rp.=" Indiff&eacute;rent ";
  }
 }
 if ($rp != "R. p.: ") {
  ?>
  <hr />
  <h1>R&eacute;gime pr&eacute;paratoire:</h1>
  <?php
  echo $rp;
 }
 ?>  
</div>
<hr />
<div>
 <h1>Remarques sp&eacute;ciales:</h1>
<?php echo "<p>" . $des->getRem_speciales(TRUE) . "</p>"; ?> 
</div>
<hr />
<div>
 <p>Enregistr&eacute; le: <?php echo $des->getRemise(); ?></p>
</div>