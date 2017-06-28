<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 include 'moveP1.php';
 showForm();
} else {
 include 'moveP2.php';
 processForm();
}
?>
