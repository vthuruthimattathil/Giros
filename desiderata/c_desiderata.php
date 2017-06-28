<?php

include_once '../c_database.php';

class c_desiderata extends c_database {

 // property declaration
 private $nodesiderata = '';
 private $untis = '';
 private $donnespers = 'F';
 private $telephone = '';
 private $gsm = '';
 private $dispo1 = '2017-09-15';
 private $dispo2 = '2017-09-15';
 private $specialites = '';
 private $branches = '';
 private $tache = 0;
 private $recrutement = 'F';
 private $conge = '';
 private $co_duree = 0;
 private $rem_branches = '';
 private $regence1 = '';
 private $regence2 = '';
 private $rattrapage = '';
 private $surveillance = 0;
 private $fomos = 'F';
 private $etudes = 0;
 private $parascolaire = '';
 private $detachement = '';
 private $de_nombre = 0;
 private $emploi = 'A';
 private $rem_speciales = '';
 private $neige = 'F';
 private $mer = 'F';
 private $remise = '';
 private $prep_surv_cantine = 'X';
 private $prep_sites = 0;
 private $riz = 'F';
 private $huelmes = 'F';
 private $portes = 'T';
 private $angla9pr = 'F';
 private $pause ='T';
 private $choix = array();
 private $decharge = array();

 // method declaration
 function __construct($untis, $site) {
  if ($site == 'P') {
   parent::__construct('Pgestion16');
  } else {
   parent::__construct('gestion16');
  }
  $this->setUntis($untis);
  $query = 'SELECT * from DESIDERATA where UNTIS="' . $untis . '"';
  $this->sqlConnect();
  $this->sqlQuery($query);
  if ($this->sqlNumRows() == 0) {
   // no desiderata
   $this->nodesiderata = md5(uniqid(rand(), TRUE));
   $query = 'SELECT * from PROF where UNTIS="' . $untis . '"';
   $this->sqlQuery($query);
   $row = $this->sqlData();
   $this->setUntis($row['UNTIS']);
   $query = 'INSERT INTO DESIDERATA (NODESIDERATA,UNTIS,DISPO1,DISPO2) VALUES ("' . $this->nodesiderata . '", "' . $untis . '", "' . $this->dispo1 . '", "' . $this->dispo2 . '")';
   $this->sqlQuery($query);
   $this->save();
  } else {
   $query = 'SELECT * from DESIDERATA where UNTIS="' . $untis . '"';
   $this->sqlQuery($query);
   $row = $this->sqlData();
   $this->nodesiderata = $row['NODESIDERATA'];
   $this->setDonnesper($row['DONNESPERS']);
   $this->setTelephone(stripslashes($row['TELEPHONE']));
   $this->setGsm(stripslashes($row['GSM']));
   $this->setDispo1($row['DISPO1']);
   $this->setDispo2($row['DISPO2']);
   $this->setSpecialites(stripslashes($row['SPECIALITES']));
   $this->setBranches(stripslashes($row['BRANCHES']));
   $this->setTache($row['TACHE']);
   $this->setRecrutement($row['RECRUTEMENT']);
   $this->setConge(stripslashes($row['CONGE']));
   $this->setCo_duree($row['CO_DUREE']);
   $this->setRem_branches(stripslashes($row['REM_BRANCHES']));
   $this->setRegence1(stripslashes($row['REGENCE1']));
   $this->setRegence2(stripslashes($row['REGENCE2']));
   $this->setRattrapage(stripslashes($row['RATTRAPAGE']));
   $this->setSurveillance($row['SURVEILLANCE']);
   $this->setFomos($row['FOMOS']);
   $this->setEtudes($row['ETUDES']);
   $this->setParascolaire(stripslashes($row['PARASCOLAIRE']));
   $this->setDetachement($row['DETACHEMENT']);
   $this->setDe_nombre($row['DE_NOMBRE']);
   $this->setEmploi($row['EMPLOI']);
   $this->setRem_speciales(stripslashes($row['REM_SPECIALES']));
   $this->setNeige($row['NEIGE']);
   $this->setMer($row['MER']);
   $this->setRemise($row['REMISE']);
   $this->setPrep_surv_cantine($row['PREP_SURV_CANTINE']);
   $this->setPrep_sites($row['PREP_SITES']);
   $this->setRiz($row['RIZ']);
   $this->setHuelmes($row['HUELMES']);
   $this->setPortes($row['PORTES']);
   $this->setAngla9pr($row['ANGLA9PR']);
   $this->setPause($row['PAUSE']);
   $query = 'SELECT * from DECHARGE where NODESIDERATA="' . $this->getNodesiderata() . '"';
   $this->sqlQuery($query);
   for ($i = 0; $i < $this->sqlNumRows(); $i++) {
    $row = $this->sqlData();
    $this->appendDecharge($row['DESIGNATION'], $row['NOMBRE'], $row['DEPARTEMENT']);
   }

   $query = 'SELECT * from CHOIX left join CBNC using(NOCBNC) where NODESIDERATA="' . $this->getNodesiderata() . '" order by ORDRE ASC';
   $this->sqlQuery($query);
   for ($i = 0; $i < $this->sqlNumRows(); $i++) {
    $row = $this->sqlData();
    $this->appendChoix($row['NOCBNC'], $row['SALLE'], $row['NB_BLOCS'], $row['DUREE'], $row['CODE_BRANCHE'], $row['BRANCHE'], $row['NUMBER'], $row['CLASSE']);
   }
  }
 }

 public function getNodesiderata() {
  return $this->nodesiderata;
 }

 public function getUntis() {
  return $this->untis;
 }

 public function getDonnespers() {
  return $this->donnespers;
 }

 public function getTelephone($html = FALSE) {
  if ($html) {
   return htmlentities($this->telephone);
  } else {
   return $this->telephone;
  }
 }

 public function getGsm($html = FALSE) {
  if ($html) {
   return htmlentities($this->gsm);
  } else {
   return $this->gsm;
  }
 }

 public function getDispo1() {
  return $this->dispo1;
 }

 public function getDispo2() {
  return $this->dispo2;
 }

 public function getSpecialites($html = FALSE) {
  if ($html) {
   return htmlentities($this->specialites);
  } else {
   return $this->specialites;
  }
 }

 public function getBranches($html = FALSE) {
  if ($html) {
   return htmlentities($this->branches);
  } else {
   return $this->branches;
  }
 }

 public function getTache() {
  return $this->tache;
 }

 public function getRecrutement() {
  return $this->recrutement;
 }

 public function getConge($html = FALSE) {
  if ($html) {
   return htmlentities($this->conge);
  } else {
   return $this->conge;
  }
 }

 public function getCo_duree() {
  return $this->co_duree;
 }

 public function getRem_branches($html = FALSE) {
  if ($html) {
   return htmlentities($this->rem_branches);
  } else {
   return $this->rem_branches;
  }
 }

 public function getRegence1($html = FALSE) {
  if ($html) {
   return htmlentities($this->regence1);
  } else {
   return $this->regence1;
  }
 }

 public function getRegence2($html = FALSE) {
  if ($html) {
   return htmlentities($this->regence2);
  } else {
   return $this->regence2;
  }
 }

 public function getRattrapage($html = FALSE) {
  if ($html) {
   return htmlentities($this->rattrapage);
  } else {
   return $this->rattrapage;
  }
 }

 public function getSurveillance() {
  return $this->surveillance;
 }

 public function getFomos() {
  return $this->fomos;
 }

 public function getEtudes() {
  return $this->etudes;
 }

 public function getParascolaire($html = FALSE) {
  if ($html) {
   return htmlentities($this->parascolaire);
  } else {
   return $this->parascolaire;
  }
 }

 public function getDetachement($html = FALSE) {
  if ($html) {
   return htmlentities($this->detachement);
  } else {
   return $this->detachement;
  }
 }

 public function getDe_nombre() {
  return $this->de_nombre;
 }

 public function getEmploi() {
  return $this->emploi;
 }

 public function getRem_speciales($html = FALSE) {
  if ($html) {
   return htmlentities($this->rem_speciales);
  } else {
   return $this->rem_speciales;
  }
 }

 public function getNeige() {
  return $this->neige;
 }

 public function getMer() {
  return $this->mer;
 }

 public function getPrep_surv_cantine() {
  return $this->prep_surv_cantine;
 }

 public function getPrep_sites() {
  return $this->prep_sites;
 }

 public function getRiz() {
  return $this->riz;
 }

 public function getHuelmes() {
  return $this->huelmes;
 }


 public function getPortes() {
  return $this->portes;
 }

 public function getAngla9pr() {
  return $this->angla9pr;
 }

 public function getPause() {
  return $this->pause;
 }

 public function getRemise() {
  return $this->remise;
 }

 public function getDecharge($ordre) {
  if ($ordre == -1) {
   return $this->decharge;
  } elseif ($order < count($this->decharge)) {
   return $this->decharge[$ordre];
  } else {
   $decharge['designation'] = '';
   $decharge['nombre'] = 0;
   $decharge['departement'] = '';
   return $decharge;
  }
 }

 public function selectDecharge($needle) {
  if (empty($needle) || empty($this->decharge)) {
   return -1;
  }
  foreach ($this->decharge as $key => $value) {
   if ($value['designation'] == $needle) {
    return $key;
   }
  }
  return -1;
 }

 public function getChoix($ordre) {
  if ($ordre == -1) {
   return $this->choix;
  } elseif ($ordre < count($this->choix)) {
   return $this->choix[$ordre];
  } else {
   return null;
  }
 }

 //	public function setNodesiderata($nodesiderata) {$this->nodesiderata=$nodesiderata;}
 public function setUntis($untis) {
  $this->untis = $untis;
 }

 public function setDonnesper($donnespers) {
  $this->donnespers = $donnespers;
 }

 public function setTelephone($telephone) {
  $this->telephone = $telephone;
 }

 public function setGsm($gsm) {
  $this->gsm = $gsm;
 }

 public function setDispo1($dispo1) {
  $this->dispo1 = $dispo1;
 }

 public function setDispo2($dispo2) {
  $this->dispo2 = $dispo2;
 }

 public function setSpecialites($specialites) {
  $this->specialites = $specialites;
 }

 public function setBranches($branches) {
  $this->branches = $branches;
 }

 public function setTache($tache) {
  $this->tache = $tache;
 }

 public function setRecrutement($recrutement) {
  $this->recrutement = $recrutement;
 }

 public function setConge($conge) {
  $this->conge = $conge;
 }

 public function setCo_duree($co_duree) {
  $this->co_duree = $co_duree;
 }

 public function setRem_branches($rem_branches) {
  $this->rem_branches = $rem_branches;
 }

 public function setRegence1($regence1) {
  $this->regence1 = $regence1;
 }

 public function setRegence2($regence2) {
  $this->regence2 = $regence2;
 }

 public function setRattrapage($rattrapage) {
  $this->rattrapage = $rattrapage;
 }

 public function setSurveillance($surveillance) {
  $this->surveillance = $surveillance;
 }

 public function setFomos($fomos) {
  $this->fomos = $fomos;
 }

 public function setEtudes($etudes) {
  $this->etudes = $etudes;
 }

 public function setParascolaire($parascolaire) {
  $this->parascolaire = $parascolaire;
 }

 public function setDetachement($detachement) {
  $this->detachement = $detachement;
 }

 public function setDe_nombre($de_nombre) {
  $this->de_nombre = $de_nombre;
 }

 public function setEmploi($emploi) {
  $this->emploi = $emploi;
 }

 public function setRem_speciales($rem_speciales) {
  $this->rem_speciales = $rem_speciales;
 }

 public function setNeige($neige) {
  $this->neige = $neige;
 }

 public function setMer($mer) {
  $this->mer = $mer;
 }

 public function setPrep_surv_cantine($prep_surv_cantine) {
  $this->prep_surv_cantine = $prep_surv_cantine;
 }

 public function setPrep_sites($prep_sites) {
  $this->prep_sites = $prep_sites;
 }

 public function setRiz($riz) {
  $this->riz = $riz;
 }

 public function setHuelmes($huelmes) {
  $this->huelmes = $huelmes;
 }


 public function setPortes($portes) {
  $this->portes = $portes;
 }

 public function setAngla9pr($angla) {
  $this->angla9pr = $angla;
 }

 public function setPause($pause) {
  $this->pause = $pause;
 }

 public function setRemise($remise) {
  $this->remise = $remise;
 }

 public function appendDecharge($designation, $nombre, $departement) {
  $decharge['designation'] = $designation;
  $decharge['nombre'] = $nombre;
  $decharge['departement'] = $departement;
  if (count($this->decharge) == 0) {
   $this->decharge[0] = $decharge;
  } else {
   sort($this->decharge);
   $this->decharge[count($this->decharge)] = $decharge;
  }
 }

 public function purgeDecharge() {
  unset($this->decharge);
 }

 public function appendChoix($cbnc, $salle, $nb_blocs, $duree, $codeBranche, $branche, $number, $classe) {
  $cx['cbnc'] = $cbnc;
  $cx['salle'] = $salle;
  $cx['nb_blocs'] = $nb_blocs;
  $cx['duree'] = $duree;
  $cx['code_branche'] = $codeBranche;
  $cx['branche'] = $branche;
  $cx['number'] = $number;
  $cx['classe'] = $classe;
  if (count($this->choix) == 0) {
   $this->choix[0] = $cx;
  } else {
   $i = 0;
   foreach ($this->choix as $key => $value) {
    $tmp[$i] = $value;
    $i++;
   }
   $this->choix = $tmp;
   // sort($this->choix);

   $this->choix[count($this->choix)] = $cx;
  }
 }

 public function deleteChoix($order) {
  if ($order < count($this->choix)) {
   unset($this->choix[$order]);
   sort($this->choix);
  };
 }

 public function purgeChoix() {
  unset($this->choix);
 }

 public function save() {
  $this->sqlConnect();
  $query = "UPDATE DESIDERATA SET ";
  $query.='DONNESPERS="' . $this->donnespers . '", ';
  $query.='TELEPHONE="' . mysql_real_escape_string($this->telephone) . '", ';
  $query.='GSM="' . mysql_real_escape_string($this->gsm) . '", ';
  $query.='DISPO1="' . $this->dispo1 . '", ';
  $query.='DISPO2="' . $this->dispo2 . '", ';
  $query.='SPECIALITES="' . mysql_real_escape_string($this->specialites) . '", ';
  $query.='BRANCHES="' . mysql_real_escape_string($this->branches) . '", ';
  $query.='TACHE="' . $this->tache . '", ';
  $query.='RECRUTEMENT="' . $this->recrutement . '", ';
  $query.='CONGE="' . mysql_real_escape_string($this->conge) . '", ';
  $query.='CO_DUREE=' . $this->co_duree . ', ';
  $query.='REM_BRANCHES="' . mysql_real_escape_string($this->rem_branches) . '", ';
  $query.='REGENCE1="' . mysql_real_escape_string($this->regence1) . '", ';
  $query.='REGENCE2="' . mysql_real_escape_string($this->regence2) . '", ';
  $query.='RATTRAPAGE="' . mysql_real_escape_string($this->rattrapage) . '", ';
  $query.='SURVEILLANCE=' . $this->surveillance . ', ';
  $query.='FOMOS="' . $this->fomos . '", ';
  $query.='ETUDES=' . $this->etudes . ', ';
  $query.='PARASCOLAIRE="' . mysql_real_escape_string($this->parascolaire) . '", ';
  $query.='DETACHEMENT="' . $this->detachement . '", ';
  $query.='DE_NOMBRE=' . $this->de_nombre . ', ';
  $query.='EMPLOI="' . $this->emploi . '", ';
  $query.='REM_SPECIALES="' . mysql_real_escape_string($this->rem_speciales) . '", ';
  $query.='NEIGE="' . $this->neige . '", ';
  $query.='MER="' . $this->mer . '", ';
  $query.='PREP_SURV_CANTINE="' . $this->prep_surv_cantine . '", ';
  $query.='PREP_SITES=' . $this->prep_sites . ', ';
  $query.='RIZ="' . $this->riz . '", ';
  $query.='HUELMES="' . $this->huelmes . '", ';
  $query.='PORTES="' . $this->portes . '", ';
  $query.='ANGLA9PR="' . $this->angla9pr . '", ';
  $query.='PAUSE="' . $this->pause . '", ';
  $query.='REMISE="' . date('Y-m-d') . '" ';
  $query.='WHERE NODESIDERATA="' . $this->nodesiderata . '"';
  $this->sqlQuery($query);

  $query = 'DELETE FROM DECHARGE WHERE NODESIDERATA="' . $this->nodesiderata . '"';
  $this->sqlQuery($query);
  if (isset($this->decharge)) {
   foreach ($this->decharge as $key => $value) {
    $id = md5(uniqid(rand(), TRUE));
    $query = "INSERT INTO DECHARGE (NODECHARGE, NODESIDERATA, DESIGNATION, NOMBRE, DEPARTEMENT) VALUES";
    $query.=sprintf("(\"%s\",\"%s\",\"%s\",%u,\"%s\")", $id, $this->nodesiderata, mysql_real_escape_string($value['designation']), $value['nombre'], mysql_real_escape_string($value['departement']));
    $this->sqlQuery($query);
   }
  }
  $query = 'DELETE FROM CHOIX WHERE NODESIDERATA="' . $this->nodesiderata . '"';
  $this->sqlQuery($query);
  $cx = $this->getChoix(-1);
  if (isset($cx)) {
   foreach ($cx as $key => $value) {
    $id = md5(uniqid(rand(), TRUE));
    $query = "INSERT INTO CHOIX (NOCHOIX, NODESIDERATA, NOCBNC, ORDRE, SALLE, NB_BLOCS, DUREE) VALUES";
    $query.=sprintf("(\"%s\",\"%s\",%u,", $id, $this->nodesiderata, $value['cbnc']);
    $query.=sprintf("%u,\"%s\",%u,%u)", $key, mysql_real_escape_string($value['salle']), $value['nb_blocs'], $value['duree']);
    $this->sqlQuery($query);
   }
  }
 }

}

?>