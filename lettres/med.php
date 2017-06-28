<?php

include_once("../session.php");
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 include 'medP1.php';
 showForm();
} else {
 include 'medP2.php';
 processForm();
}
?>