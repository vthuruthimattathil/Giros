<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 include 'followupP1.php';
 showForm();
} else {
 include 'followupP2.php';
 processForm();
}
?>
