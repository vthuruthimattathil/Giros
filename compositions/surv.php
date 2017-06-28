<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 include_once 'survP1.php';
 showForm();
} else {
 include_once 'survP2.php';
 processForm();
}
?>