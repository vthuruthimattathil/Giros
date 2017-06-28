<?php

include "deleteFileP1.php";
include "deleteFileP2.php";
if ($_SERVER['REQUEST_METHOD']!='POST') {
 showForm();
}
else { processForm();
}
?>