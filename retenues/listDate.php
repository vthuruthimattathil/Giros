<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 include 'listDateP1.php';
 showForm();
} else {
 include 'listDateP2.php';
 processForm();
}
?>
