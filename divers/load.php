<?php

include_once("../session.php");

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 include 'loadP1.php';
 showForm();
} else {
 if (!array_key_exists('MAINTENANCE', $_SESSION)) {
  include 'loadP1.php';
  include 'loadP2.php';
  processFormP2();
 } else {
  switch ($_SESSION['MAINTENANCE']) {
   case 3: {
     include 'loadP3.php';
     processFormP3();
    } break;
   case 4: {
     include 'loadP4.php';
     processFormP4();
    } break;
  }
 }
}
?>