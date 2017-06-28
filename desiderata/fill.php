<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 include 'fillP1.php';
 showForm();
} else {
 include 'fillP2.php';
 processForm();
}
?>
