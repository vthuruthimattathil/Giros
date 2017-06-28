<?php
// Giros - 2011

// Filename:       insert.php
// Description:
// Called by:
// Calls:
// Includes files:
// Defines vars:
// Unsets vars:
// Modifies vars:
// Uses vars:

if ($_SERVER['REQUEST_METHOD']!='POST') {
 if ($_SERVER['QUERY_STRING']=='') {
  include_once 'insertManP1.php';
  showForm();
 }
 else {
  include_once 'insertManP3.php';
  processForm();
 }
}
else {
 include_once 'insertManP2.php';
 showForm2();
}

?>