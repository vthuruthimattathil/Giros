<?php

include_once("../session.php");
if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') != 'POST') {
 include 'insertP1.php';
 showForm();
} else {
 include 'insertP2.php';
 processForm();
}
?>