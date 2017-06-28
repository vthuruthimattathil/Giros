<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 include 'updateP1.php';
 showForm();
} else {
 include 'updateP2.php';
 processForm();
}
?>
