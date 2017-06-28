<?php

include_once 'addVPhP1.php';
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 showForm();
} else {
 include_once 'addVPhP2.php';
 processForm();
}
?>
