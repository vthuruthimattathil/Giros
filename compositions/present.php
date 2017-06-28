<?php


if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 include 'presentP1.php';
 showForm();
} else {
 include 'presentP2.php';
 processForm();
}


/*
if ($_SERVER['REQUEST_METHOD']!='POST') {
 if ($_SERVER['QUERY_STRING']=='') {
  include_once 'presentP1.php';
  showForm();
 }
 else {
  include_once 'presentP2.php';
  showForm2();
 }
}
else {
 include_once 'presentP3.php';
 insertPres();
}*/
?>