<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 include_once 'deleteP1.php';
 showForm();
} else {
 include_once 'deleteP2.php';
 processForm();
}
?>