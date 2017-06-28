<?php

if (filter_input(INPUT_SERVER, 'QUERY_STRING') == '') {
 include_once 'listAdmP1.php';
 showForm();
} else {
 include_once 'listAdmP2.php';
 processForm();
}
?>