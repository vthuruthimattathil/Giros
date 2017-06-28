<?php

define( "0",0);       // A4 R  BW
define( "2",0);       // A4 R  C
define( "4",0);       // A4 RV BW
define( "6",0);       // A4 RV C
define( "8",0);       // A3 R  B
define("10",0);       // A3 R  C
define("12",0);       // A3 RV B
define("14",0);       // A3 RV C

define("16",0.05);    // A4 R  BW
define("18",0.1);     // A4 R  C
define("20",0.075);   // A4 RV BW
define("22",0.15);    // A4 RV C
define("24",0.1);     // A3 R  B
define("26",0.2);     // A3 R  C
define("28",0.15);    // A3 RV B
define("30",0.3);     // A3 RV C

if ($_SERVER['REQUEST_METHOD']!='POST') {
 include 'invoiceP1.php';
 showForm();
}
else {
 include 'invoiceP2.php';
 processForm(); 
}
?>

