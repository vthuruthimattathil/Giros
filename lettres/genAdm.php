<?php

include_once("../session.php");
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 include 'genAdmP1.php';
 showForm();
} else {
 include 'genAdmP2.php';
 processForm();
}
?>