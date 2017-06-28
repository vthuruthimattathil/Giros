<?php
function fr_day($no) {
 switch ($no) {
  case 0:
   return "Dimanche";
   break;
  case 1:
   return "Lundi";
   break;
  case 2:
   return "Mardi";
   break;
  case 3:
   return "Mercredi";
   break;
  case 4:
   return "Jeudi";
   break;
  case 5:
   return "Vendredi";
   break;
  case 6:
   return "Samedi";
   break;
  case 7:
   return "Dimanche";
   break;
  default:
   return "???";
   break;
 }
}

function fr_month($no) {
 switch ($no) {
  case 1:
   return "Janvier";
   break;
  case 2:
   return "Février";
   break;
  case 3:
   return "Mars";
   break;
  case 4:
   return "Avril";
   break;
  case 5:
   return "Mai";
   break;
  case 6:
   return "Juin";
   break;
  case 7:
   return "Juillet";
   break;
  case 8:
   return "Août";
   break;
  case 9:
   return "Septembre";
   break;
  case 10:
   return "Octobre";
   break;
  case 11:
   return "Novembre";
   break;
  case 12:
   return "Décembre";
   break;
  default:
   return "???";
   break;
 }
}

function fr_date_format($date,$day=false) {
 $myDate=date_create($date);
 if(!$myDate) {
  $e = date_get_last_errors();
  $msg='Date error:';
  foreach ($e['errors'] as $error) {
   $msg.=$error."\n";
  }
 }
 else {
  $msg=sprintf("%s %s %s",date_format($myDate,"j"),strtolower(fr_month(date_format($myDate,"n"))),date_format($myDate,"Y"));
  if ($day) {
   $msg=sprintf("%s ",strtolower(fr_day(date_format($myDate,"N")))).$msg;
  }
 }
 return $msg;
}

?>