<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 include 'addDateP1.php';
 showForm();
} else {
 include 'addDateP1.php';
 include 'addDateP2.php';
 processForm();
}
?>