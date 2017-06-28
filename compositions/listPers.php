<?php

if ($_SERVER['QUERY_STRING'] == '') {
 include_once 'listPersP1.php';
 showForm();
} else {
 include_once 'listPersP2.php';
 processForm();
}
?>
