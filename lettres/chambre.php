<?php

include_once("../session.php");
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 include 'chambreP1.php';
 showForm();
} else {
 include 'chambreP2.php';
 processForm();
}
?>