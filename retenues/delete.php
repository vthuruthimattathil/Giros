<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 include 'deleteP1.php';
 showForm();
} else {
 include 'deleteP2.php';
 processForm();
}
?>
