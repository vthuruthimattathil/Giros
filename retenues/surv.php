<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 include 'survP1.php';
 showForm();
} else {
 include 'survP2.php';
 processForm();
}
?>
