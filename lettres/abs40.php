<?php

include_once("../session.php");
if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') != 'POST') {
 include 'abs40P1.php';
 showForm();
} else {
 include 'abs40P2.php';
 processForm();
}
?>