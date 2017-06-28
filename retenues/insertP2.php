<?php
function processForm() {
 include_once("../session.php");
 include_once("../c_menu.php");
 require_once 'Mail.php';
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {
 	header("Location: ".$giros->getErrorUrl());
 }
 $nodater=$_POST['nodater'];
 $travail=$_POST['txttravail'];
 $motif=$_POST['txtmotif'];
 $today=getdate();
 $datei=$today['year'].'-'.$today['mon'].'-'.$today['mday'].' '.$today['hours'].':'.$today['minutes'];
 if (!$_SESSION['RETENUE']['DONE']) {
  $_SESSION['RETENUE']['DONE']=TRUE;
  $giros->sqlConnect();
  foreach ($_POST['ele'] as $value) {
   $info=explode('@', $value);
   $noretenue=md5(uniqid(rand(), TRUE));
   $query="INSERT INTO RETENUE (NORETENUE, IAM, UNTIS, NODATER, MOTIF, TRAVAIL,REGENT, PRESENT, DATEI,SUIVI) VALUES ";
   $query.=sprintf("('%s','%s','%s','%s',",$noretenue,$info[2],$giros->getUntis(),$nodater);
   $query.=sprintf("'%s','%s', %s, -1,'%s',-1)",mysql_real_escape_string($motif),mysql_real_escape_string($travail),$info[3],$datei);
   $_SESSION['RETENUE']['DATA'][]=$noretenue;
   $giros->sqlQuery($query);
 
   $query=sprintf("SELECT * FROM RETENUE LEFT JOIN DATESR USING(NODATER) LEFT JOIN ELEVE USING(IAM) WHERE NORETENUE='%s'",mysql_real_escape_string($noretenue));
   $giros->sqlQuery($query);
   $row = $giros->sqlData();

   $to = "eicjc@ltma.lu";
   $subject = "Inscription retenue";
   $body=sprintf("La retenue suivante a été inscrite:\nElève:\t\t%s %s %s\n",$row['NOME'],$row['PRENOME'],$row['IAM']);
   $body.=sprintf("Classe:\t\t%s\n",$row['CODE']);
   $body.=sprintf("Titulaire:\t%s\n",$row['UNTIS']);
   $body.=sprintf("Date:\t\t%s\n",$row['DATER']);
   $body.=sprintf("Salle:\t\t%s\n",$row['SALLE']);
   $body.=sprintf("Motif:\t\t%s\n",$motif);
   $headers =array('From'=>'Giros <giros@ltma.lu>','To'=>$to,'Reply-To'=>'giros@ltma.lu','Subject'=>$subject,'Content-Type' => 'text/plain; charset=UTF-8');
   $host='mail.ltma.lu';
   $username='giros';
   $password='ltmagiros';
   $smtp=Mail::factory('smtp',array('host'=>$host,'auth'=>true,'username'=>$username,'password'=>$password));
   $mail=$smtp->send($to.', giros@ltma.lu',$headers,$body);
  }
 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
  <title>Ins&eacute;rer retenue</title>
  <script type="text/javascript" src="insertP2.js"></script>
</head>
<body onload="pdf(); location.href='index.php';">
</body>
</html>
<?php
}
?>
