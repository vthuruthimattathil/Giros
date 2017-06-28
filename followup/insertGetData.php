<?php

// sleep(10);
include_once("../session.php");
$giros = $_SESSION['GIROS'];
$fct = $_POST['FCT'];
$iam = $_POST['IAM'];
switch ($fct) {
 case 'Data':
  $giros->sqlConnect();
  $query =sprintf("SELECT IAM,NOME,PRENOME,CODE,SUIVI_ELEVE.*,SUIVI_ELEVE_STAGE.* FROM SUIVI_ELEVE LEFT JOIN ELEVE USING(IAM) LEFT JOIN SUIVI_ELEVE_STAGE USING (NOPORTFOLIO) WHERE IAM='%s' AND SCOLAIRE=%u",$iam,$giros->getYear());
  $giros->sqlQuery($query);
  if ($giros->sqlNumRows() != 0) {
   $row = $giros->sqlData();
   $output = array(
    '#dataStudent*value' => $row['PRENOME'] . ' ' . $row['NOME'] . ' - ' . $row['CODE'] . ' - ' . $row['SCOLAIRE'],
    '#lcNb*value' => $row['INSCRIPTIONS_NB'],
    '#lcRem*value' => $row['INSCRIPTIONS_REM'],
    '#retBag*value' => $row['RET_BAGARRE'],
    '#retRet*value' => $row['RET_RETARDS'],
    '#retAbsNon*value' => $row['RET_ABS'],
    '#retConf*value' => $row['RET_CONF'],
    '#retComp*value' => $row['RET_COMPORTEMENT'],
    '#retFraude*value' => $row['RET_FRAUDE'],
    '#retInsol*value' => $row['RET_INSOLENCE'],
    '#retTabac*value' => $row['RET_TABAGISME'],
    '#retRefusPun*value' => $row['RET_REFUS_PUNITION'],
    '#retMens*value' => $row['RET_MENSONGES'],
    '#retInsul*value' => $row['RET_INSULTES'],
    '#retOublis*value' => $row['RET_OUBLIS'],
    '#retAutres*value' => $row['RET_AUTRES'],
    '#retRem*value' => $row['RET_REM'],
    '#conNb*value' => $row['CONSEIL_NB'],
    '#conRem*value' => $row['CONSEIL_REM'],
    '#absExc*value' => $row['ABS_EXC'],
    '#absExcMed*value' => $row['ABS_EXC_MED'],
    '#absNonExc*value' => $row['ABS_NON_EXC'],
    '#absRem*value' => $row['ABS_REM'],
    '#mosRes*checked' => ($row['MOSAIK'] & 1) != 0,
    '#mosAbs*checked' => ($row['MOSAIK'] & 2) != 0,
    '#mosVtt*checked' => ($row['MOSAIK'] & 4) != 0,
    '#mosOublisScol*checked' => ($row['MOSAIK'] & 8) != 0,
    '#mosOublisDev*checked' => ($row['MOSAIK'] & 16) != 0,
    '#mosDe*checked' => ($row['MOSAIK'] & 32) != 0,
    '#mosAgress*checked' => ($row['MOSAIK'] & 64) != 0,
    '#mosComport*checked' => ($row['MOSAIK'] & 128) != 0,
    '#mosApathie*checked' => ($row['MOSAIK'] & 256) != 0,
    '#mosAutres*checked' => ($row['MOSAIK'] & 512) != 0,
    '#pitstopInsultes*value' => $row['PIT_INSULTES'],
    '#pitstopDisputes*value' => $row['PIT_DISPUTES'],
    '#pitstopRefusTravail*value' => $row['PIT_REFUS_TRAVAIL'],
    '#pitstopJet*value' => $row['PIT_JET'],
    '#pitstopComportement*value' => $row['PIT_COMPORTEMENT'],
    '#pitstopAutres*value' => $row['PIT_AUTRE'],
    '#pitstopRem*value' => $row['PIT_REM'],
    '#orientation*value' => $row['ORIENTATION'],
    '#rem*value' => $row['REMARQUES']
   );
  } else {
   $query = "SELECT IAM,NOME,PRENOME,CODE FROM  ELEVE WHERE IAM=\"" . $iam . "\"";
   $giros->sqlQuery($query);
   $row = $giros->sqlData();
   $output = array(
    '#dataStudent*value' => $row['PRENOME'] . ' ' . $row['NOME'] . ' - ' . $row['CODE'],
    '#lcNb*value' => '0',
    '#lcRem*value' => '',
    '#retBag*value' => '0',
    '#retRet*value' => '0',
    '#retAbsNon*value' => '0',
    '#retConf*value' => '0',
    '#retComp*value' => '0',
    '#retFraude*value' => '0',
    '#retInsol*value' => '0',
    '#retTabac*value' => '0',
    '#retRefusPun*value' => '0',
    '#retMens*value' => '0',
    '#retInsul*value' => '0',
    '#retOublis*value' => '0',
    '#retAutres*value' => '0',
    '#retRem*value' => '',
    '#conNb*value' => '0',
    '#conRem*value' => '',
    '#absExc*value' => '0',
    '#absExcMed*value' => '0',
    '#absNonExc*value' => '0',
    '#absRem*value' => '',
    '#mosRes*checked' => false,
    '#mosAbs*checked' => false,
    '#mosVtt*checked' => false,
    '#mosOublisScol*checked' => false,
    '#mosOublisDev*checked' => false,
    '#mosDe*checked' => false,
    '#mosAgress*checked' => false,
    '#mosComport*checked' => false,
    '#mosApathie*checked' => false,
    '#mosAutres*checked' => false,
    '#pitstopInsultes*value' => '0',
    '#pitstopDisputes*value' => '0',
    '#pitstopRefusTravail*value' => '0',
    '#pitstopJet*value' => '0',
    '#pitstopComportement*value' => '0',
    '#pitstopAutres*value' => '0',
    '#pitstopRem*value' => '',
    '#orientation*value' => '',
    '#rem*value' => ''
   );
  }
  echo json_encode($output);
  break;
 case 'Stage':
  $giros->sqlConnect();
  $query="SELECT SUIVI_ELEVE_STAGE.*,DATE_FORMAT(PERIODE,'%m-%Y') AS PERIODE_D,DATE_FORMAT(PERIODE,'%Y-%m-01') AS PERIODE_F  FROM SUIVI_ELEVE_STAGE LEFT JOIN SUIVI_ELEVE USING (NOPORTFOLIO) ";
  $query.= sprintf("WHERE IAM='%s' AND SCOLAIRE=%u ORDER BY PERIODE", $iam,$giros->getYear());
  $giros->sqlQuery($query);
  $output = array();
  if ($giros->sqlNumRows() != 0) {
   while ($row = $giros->sqlData()) {
    $line = array('NOSUIVIELEVESTAGE' => $row['NOSUIVIELEVESTAGE'], 'ENTREPRISE' => $row['ENTREPRISE'], 'TRAVAIL' => $row['TRAVAIL'], 'PERIODEF' => $row['PERIODE_F'], 'PERIODED' => $row['PERIODE_D']);
    $output[$row['NOSUIVIELEVESTAGE']] = $line;
   }
  }
  else {
   $output=-1;
  }
  echo json_encode($output);
  break;
 case 'UID':
  echo md5(uniqid(rand(), TRUE));
  break;
 default:
  break;
}
?>