<?php
include_once("../session.php");
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 include 'passwdP1.php';
 showForm();
} else {
 include 'passwdP2.php';
 processForm();
}
?>