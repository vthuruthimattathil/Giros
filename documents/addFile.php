<?php

include 'addFileP1.php';
include 'addFileP2.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 showForm();
} else {
 processForm();
}
?>