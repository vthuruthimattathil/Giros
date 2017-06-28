<?php

class c_database {

 // property declaration
 private $sqlHost = "localhost";
// private $sqlHost = "127.0.0.1";
 private $sqlUser = "giros";
 private $sqlPasswd = "???";
 private $sqlBase;
 private $sqlLink;
 private $sqlResultID = null;

 function __construct($site) {
  $this->sqlBase = $site;
 }

 public function sqlError() {
  return mysql_error();
 }

 public function sqlQuery($query) {
  if (!$this->sqlLink) {
   return false;
  }
  if ($this->sqlResultID) {
   mysql_free_result($this->sqlResultID);
  }
  $this->sqlResultID = mysql_query($query, $this->sqlLink);
  if (!$this->sqlResultID) {
   return false;
  }
  return true;
 }

 public function sqlData() {
  if (!$this->sqlLink) {
   return false;
  }
  if (!$this->sqlResultID) {
   return false;
  }
  $result = mysql_fetch_array($this->sqlResultID, MYSQL_ASSOC);
  return $result;
 }

 public function sqlNumRows() {
  if (!$this->sqlLink) {
   return false;
  }
  if (!$this->sqlResultID) {
   return false;
  }
  $result = mysql_num_rows($this->sqlResultID);
  return $result;
 }

 public function sqlConnect() {
  $temp = mysql_connect($this->sqlHost, $this->sqlUser, $this->sqlPasswd);
  //       printf("Connection:%s %s %s<br>",$this->sqlHost,$this->sqlUser, $this->sqlPasswd);
  //       printf("Connection:%s<br>",$this->sqlError());
  if (!$temp) {
   return false;
  }
  $this->sqlLink = $temp;
  $temp = mysql_select_db($this->sqlBase, $temp);
//        printf("Base:%s<br>",$this->sqlError());
//        die();
  mysql_set_charset('utf8');
  if (!$temp) {
   return false;
  }
  return true;
 }

 public function sqlInsertId() {
  return mysql_insert_id();
 }

}
