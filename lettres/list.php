<?php
if (filter_input(INPUT_SERVER, 'QUERY_STRING') == '') {
 include_once 'listP1.php';
 showForm();
} else {
 include_once 'listP2.php';
 processForm();
}
?>