<?php

function processForm() {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros = $_SESSION['GIROS'];
 $menu = new c_menu($giros->getUntis(), $giros->getUrl());
 if (!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: " . $giros->getErrorUrl());
 }
 ?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
   <title>Suivi - Inscription</title>
   <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
   <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
   <link rel="stylesheet" href="../css/layout.css" type="text/css" />
   <script type="text/javascript" src="../jquery/jquery.js"></script>
   <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
   <script type="text/javascript" src="../menu.js"></script>
   <script type="text/javascript" src="insertP2.js"></script>
  </head>   
  <body>
 <?php include ("../logo.php"); ?>
   <div id="ww">
    <div id="sidemenu">
 <?php $menu->display(); ?>
    </div>
    <div id="cont">
     <?php
     $giros->sqlConnect();
     $query = sprintf("SELECT NOPORTFOLIO FROM SUIVI_ELEVE WHERE IAM='%s' AND SCOLAIRE=%d", $_POST['IAM'], $giros->getYear());
     $giros->sqlQuery($query);
     if ($giros->sqlNumRows() == 0) {
      $noPortfolio = md5(uniqid(rand(), TRUE));
      $newPortfolio = true;
      $query = sprintf("INSERT INTO SUIVI_ELEVE (NOPORTFOLIO,IAM,SCOLAIRE) VALUES ('%s','%s','%s')", $noPortfolio, $_POST['IAM'], $giros->getYear());
      $giros->sqlQuery($query);
     } else {
      $row = $giros->sqlData();
      $noPortfolio = $row['NOPORTFOLIO'];
      $newPortfolio = false;
     }
     $mosaik = $_POST['mosRes'] + $_POST['mosAbs'] + $_POST['mosVtt'] + $_POST['mosOublisScol'] + $_POST['mosOublisDev'] + $_POST['mosDe'] + $_POST['mosAgress'] + $_POST['mosComport'] + $_POST['mosApathie'] + $_POST['mosAutres'];
     $query = "UPDATE SUIVI_ELEVE SET ";
     $query.=sprintf("INSCRIPTIONS_NB=%d, ", $_POST['lcNb']);
     $query.=sprintf("INSCRIPTIONS_REM='%s', ", mysql_real_escape_string($_POST['lcRem']));
     $query.=sprintf("RET_BAGARRE=%d, ", $_POST['retBag']);
     $query.=sprintf("RET_RETARDS=%d, ", $_POST['retRet']);
     $query.=sprintf("RET_ABS=%d, ", $_POST['retAbsNon']);
     $query.=sprintf("RET_CONF=%d, ", $_POST['retConf']);
     $query.=sprintf("RET_COMPORTEMENT=%d, ", $_POST['retComp']);
     $query.=sprintf("RET_FRAUDE=%d, ", $_POST['retFraude']);
     $query.=sprintf("RET_INSOLENCE=%d, ", $_POST['retInsol']);
     $query.=sprintf("RET_TABAGISME=%d, ", $_POST['retTabac']);
     $query.=sprintf("RET_REFUS_PUNITION=%d, ", $_POST['retRefusPun']);
     $query.=sprintf("RET_MENSONGES=%d, ", $_POST['retMens']);
     $query.=sprintf("RET_INSULTES=%d, ", $_POST['retInsul']);
     $query.=sprintf("RET_OUBLIS=%d, ", $_POST['retOublis']);
     $query.=sprintf("RET_AUTRES=%d, ", $_POST['retAutres']);
     $query.=sprintf("RET_REM='%s', ", mysql_real_escape_string($_POST['retRem']));
     $query.=sprintf("CONSEIL_NB=%d, ", $_POST['conNb']);
     $query.=sprintf("CONSEIL_REM='%s', ", mysql_real_escape_string($_POST['conRem']));
     $query.=sprintf("ABS_EXC=%d, ", $_POST['absExc']);
     $query.=sprintf("ABS_EXC_MED=%d, ", $_POST['absExcMed']);
     $query.=sprintf("ABS_NON_EXC=%d, ", $_POST['absNonExc']);
     $query.=sprintf("ABS_REM='%s', ", mysql_real_escape_string($_POST['absRem']));
     $query.=sprintf("CONSEIL_NB=%d, ", $_POST['conNb']);
     $query.=sprintf("CONSEIL_REM='%s', ", mysql_real_escape_string($_POST['conRem']));
     $query.=sprintf("MOSAIK=%d, ", $mosaik);
     $query.=sprintf("PIT_INSULTES=%d, ", $_POST['pitstopInsultes']);
     $query.=sprintf("PIT_DISPUTES=%d, ", $_POST['pitstopDisputes']);
     $query.=sprintf("PIT_REFUS_TRAVAIL=%d, ", $_POST['pitstopRefusTravail']);
     $query.=sprintf("PIT_JET=%d, ", $_POST['pitstopJet']);
     $query.=sprintf("PIT_COMPORTEMENT=%d, ", $_POST['pitstopComportement']);
     $query.=sprintf("PIT_AUTRE=%d, ", $_POST['pitstopAutres']);
     $query.=sprintf("PIT_REM='%s', ", mysql_real_escape_string($_POST['pitstopRem']));
     $query.=sprintf("ORIENTATION='%s', ", mysql_real_escape_string($_POST['orientation']));
     $query.=sprintf("REMARQUES='%s' ", mysql_real_escape_string($_POST['rem']));
     $query.=sprintf("WHERE NOPORTFOLIO='%s'", $noPortfolio);
     $giros->sqlQuery($query);
     // Stage
     $query = sprintf("DELETE FROM SUIVI_ELEVE_STAGE WHERE NOPORTFOLIO='%s'", $noPortfolio);
     $giros->sqlQuery($query);
     $stages = $_POST['stage'];
     foreach ($stages as $stage) {
      $noSuiviEleveStage = md5(uniqid(rand(), TRUE));
      $stageEntreprise = $stage['ENTREPRISE'];
      $stageTravail = $stage['TRAVAIL'];
      $stagePeriode = $stage['PERIODEF'];
      $query = sprintf("INSERT INTO SUIVI_ELEVE_STAGE (NOSUIVIELEVESTAGE,NOPORTFOLIO,ENTREPRISE,TRAVAIL,PERIODE) VALUES ('%s','%s','%s','%s','%s')", $noSuiviEleveStage, $noPortfolio, mysql_real_escape_string($stageEntreprise), mysql_real_escape_string($stageTravail), $stagePeriode);
      $giros->sqlQuery($query);
     }
     ?>
     <h1>Les donn&eacute;es ont &eacute;t&eacute; inscrites</h1>
    </div>
   </div> 
  </body>
 </html>
 <?php
}
?>

