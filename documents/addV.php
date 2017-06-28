<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 include 'addVP1.php';
 showForm();
} else {
 include 'addVP2.php';
 processForm();
}
?>