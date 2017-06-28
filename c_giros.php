<?php

include_once 'c_database.php';
include_once 'cfg.php';
date_default_timezone_set("Europe/Luxembourg");

class c_giros extends c_database {

 private $errorUrl = "http://www.ltma.lu";
 private $url = "https://giros.ltma.lu";
 private $untis;
 private $name;
 private $cname;
 private $sexe;
 private $nocase;
 private $dbdate;
 private $site;
 private $year = 2016;

 function __construct($untis, $site) {
  if ($site == 'P') {
   parent::__construct(_Pdatabase);
   $_SESSION['DATABASE'] = _Pdatabase;
   $this->site = 'P';
   $this->sqlConnect();
   $query="SELECT REGVALUE FROM REGISTRY WHERE UNTIS='GIROS' AND REGKEY='updateDate'";
   $this->sqlQuery($query);
   $result = $this->sqlData();
   $this->dbdate = 'Mise &agrave; jour: '.$result["REGVALUE"].'<br />';
  } else {
   parent::__construct(_database);
   $_SESSION['DATABASE'] = _database;
   $this->site = 'L';
   $this->sqlConnect();
   $query="SELECT REGVALUE FROM REGISTRY WHERE UNTIS='GIROS' AND REGKEY='updateDate'";
   $this->sqlQuery($query);
   $result = $this->sqlData();
   $this->dbdate = 'Mise &agrave; jour: '.$result["REGVALUE"].'<br />';
  }
  
  $this->sqlQuery("SELECT * FROM PROF WHERE UNTIS='" . $untis . "'");
  $result = $this->sqlData();
  $this->setUntis($result["UNTIS"]);
  $this->setName($result["NOM"]);
  $this->setCName($result["PRENOM"]);
  $this->setSexe($result["SEXE"]);
  $this->setNoCase($result["NOCASE"]);
 }

 public function getUrl() {
  return $this->url;
 }

 public function getErrorUrl() {
  return $this->errorUrl;
 }

 public function setUntis($value) {
  $this->untis = $value;
 }

 public function getUntis() {
  return $this->untis;
 }

 public function setName($value) {
  $this->name = $value;
 }

 public function getName() {
  return $this->name;
 }

 public function setCName($value) {
  $this->cname = $value;
 }

 public function getCName() {
  return $this->cname;
 }
 public function getSexe() {
  return $this->sexe;
 }

 public function setSexe($sexe) {
  $this->sexe = $sexe;
 }

  public function setNoCase($value) {
  $this->nocase = $value;
 }

 public function getNoCase() {
  return $this->nocase;
 }

 public function getDbDate() {
  return $this->dbdate;
 }

 public function getSite() {
  return $this->site;
 }

 public function getYear() {
  return $this->year;
 }

}

?>
