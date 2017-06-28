<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 include 'digestP1.php';
 showForm();
}
else {
 include_once 'digestP2.php';
 processForm();
}
?>