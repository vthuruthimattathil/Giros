<?php
function processForm() {
 
 include_once("../session.php");
 include_once("../c_menu.php");
 include_once 'c_desiderata.php';
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
   <title>Desiderata - Remplir</title>
   <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
   <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
   <link rel="stylesheet" href="../css/layout.css" type="text/css" />
   <script type="text/javascript" src="../jquery/jquery.js"></script>
   <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
   <script type="text/javascript" src="../menu.js"></script>
   <script type="text/javascript" src="fillP2.js"></script>
  </head>
<body>
<?php include ("../logo.php"); ?>
 <div id="ww">
  <div id="sidemenu">	
<?php $menu->display(); ?>
  </div>
  <div id="cont">
  Votre d&eacute;sid&eacute;rata a &eacute;t&eacute; enregistr&eacute;.<br />
  Des modifications restent encore possibles.<br />
  Pour consulter votre d&eacute;sid&eacute;rata utilisez le menu &laquo;Remplir&raquo;
<?php 
  $des=new c_desiderata($giros->getUntis(),$giros->getSite());
  $des->setDonnesper($_POST['donnespers']);
  $des->setTelephone($_POST['telephone']);
  $des->setGsm($_POST['gsm']); 
  $des->setDispo1($_POST['dispo1']);
  $des->setDispo2($_POST['dispo2']);
  $des->setSpecialites($_POST['specialites']);
  $des->setBranches($_POST['branches']);
  $des->setTache($_POST['tache']);
  $des->setRecrutement($_POST['recrutement']);
  $des->setConge($_POST['conge']);
  $des->setCo_duree($_POST['co_duree']);
  $des->setRem_branches($_POST['rem_branches']);
  $des->setRegence1($_POST['regence1']);
  $des->setRegence2($_POST['regence2']);
  $des->setRattrapage($_POST['rattrapage']);
  $des->setSurveillance($_POST['surveillance']);
  $des->setFomos($_POST['fomos']);
  $des->setEtudes($_POST['etudes']);
  $des->setParascolaire($_POST['parascolaire']);
  $des->setDetachement($_POST['detachement']);
  $des->setDe_nombre($_POST['de_nombre']);
  $des->setEmploi($_POST['emploi']);
  $des->setNeige($_POST['neige']);
  $des->setMer($_POST['mer']);
  $des->setRiz($_POST['riz']);
  $des->setHuelmes($_POST['huelmes']);
  $des->setPortes($_POST['portes']);
  $des->setAngla9pr($_POST['angla9pr']);
  $des->setPause($_POST['pause']);
  $des->setPrep_surv_cantine($_POST['prep_surv_cantine']);
  $tmp=0;
  if (isset($_POST['prep_site'])) {
   foreach ($_POST['prep_site'] as $value) {
    $tmp+=$value;
   }
  }
  $des->setPrep_sites($tmp);
  $des->setRem_speciales($_POST['rem_speciales']);
  $des->purgeDecharge();
  if (isset($_POST['dech'])){
   foreach ($_POST['dech'] as $key => $value) {
    if (is_numeric($value) && ($value!=0))  {
     $des->appendDecharge($key,$value,'');
    }
    if (!is_numeric($value)) {
     $des->appendDecharge($key,1,$value);
    }
   }
  }

  $des->purgeChoix();
  if (isset($_POST['branche'])) {
   foreach ($_POST['branche'] as $key => $value) {
    $des->appendChoix($value,$_POST['salle'][$key],$_POST['nb_blocs'][$key],$_POST['duree'][$key],'','','','');
   }
  }
  $des->save();
?>
  </div>
 </div>
</body>
</html>
  
<?php
}
?>
