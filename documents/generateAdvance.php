<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 include_once 'generateAdvanceP1.php';
 showForm();
} else {
 include_once 'generateAdvanceP2.php';
 processForm();
}
?>
