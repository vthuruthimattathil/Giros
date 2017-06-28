<?php
// Giros - 2011

// Filename:       insertMan.php
// Description:
// Called by:
// Calls:
// Includes files:
// Defines vars:
// Unsets vars:
// Modifies vars:
// Uses vars:
if ($_SERVER['REQUEST_METHOD']!='POST') {
 include 'insertManP1.php';
 showForm();
} else {
 include 'insertManP2.php';
 processForm();
}
?>