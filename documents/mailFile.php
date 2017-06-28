<?php

include_once 'mailFileP1.php';
include_once 'mailFileP2.php';
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 showForm();
} else {
 processForm();
}
?>
