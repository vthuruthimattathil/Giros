<?php
  include("session.php");
  $_SESSION = array();
  if (isset($_COOKIE[session_name()])) {
   setcookie(session_name(), '', time()-42000, '/');
  }
  session_unset();
  session_destroy();
  header("Location: http://giros.ltma.lu/login.php");
?>