<?php

include_once("../session.php");
if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') != 'POST') {
 include 'absP1.php';
 showForm();
} else {
 include 'absP2.php';
 processForm();
}
?>