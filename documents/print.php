<?php

include_once 'printP1.php';
include_once 'printP2.php';
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 showForm();
} else {
 processForm();
}
?>