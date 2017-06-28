<?php

include_once '../session.php';
include_once '../c_menu.php';
include_once 'desiderataPDF.php';

$giros = $_SESSION['GIROS'];
$menu = new c_menu($giros->getUntis(), $giros->getUrl());
if (!$menu->auth($giros->getUrl() . '/desiderata/print.php')) {
 header("Location: " . $giros->getErrorUrl());
}
desiderataPDF($giros->getUntis(), $giros->getSite(), $giros->getName(), $giros->getCName());
?>
