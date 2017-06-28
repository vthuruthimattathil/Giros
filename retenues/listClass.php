<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 include 'listClassP1.php';
 showForm();
} else {
 include 'listClassP2.php';
 processForm();
}
?>
