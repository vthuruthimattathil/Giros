<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 include 'insertP1.php';
 showForm();
} else {
 include 'insertP2.php';
 processForm();
}
?>