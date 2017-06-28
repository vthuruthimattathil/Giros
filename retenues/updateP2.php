<?php
function processForm() {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros=$_SESSION['GIROS'];
 $menu=new c_menu($giros->getUntis(),$giros->getUrl());
 if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: ".$giros->getErrorUrl());
 }
 require_once 'Mail.php';
 $noretenue=$_POST['noretenue'];
 $nodater=$_POST['nodater'];
 $giros->sqlConnect();
 $query="SELECT *,DATE_FORMAT(DATER,'%d.%m.%Y %T') AS DATER_F FROM RETENUE LEFT JOIN ELEVE USING(IAM) ";
 $query.=sprintf("LEFT JOIN DATESR USING (NODATER) WHERE NORETENUE='%s'",$noretenue);
 $giros->sqlQuery($query);
 $row_old=$giros->sqlData();
 if (isset($_POST['memo'])) {
  $query=sprintf("UPDATE RETENUE SET NOREPORT=TRIM(CONCAT_WS(' ',NOREPORT,'%s')) WHERE NORETENUE='%s'",$row_old['NODATER'],$noretenue);
  $giros->sqlQuery($query);
 }
 $query=sprintf("UPDATE RETENUE SET NODATER='%s',SUIVI=-1,PRESENT=-1 WHERE NORETENUE='%s'",$nodater,$noretenue);
 $giros->sqlQuery($query);
 if (isset($_POST['email'])) {
  $query="SELECT *,DATE_FORMAT(DATER,'%d.%m.%Y %T') AS DATER_F FROM RETENUE LEFT JOIN ELEVE USING(IAM) ";
  $query.=sprintf("LEFT JOIN DATESR USING (NODATER) WHERE NORETENUE='%s'",$noretenue);
  $giros->sqlQuery($query);
  $row=$giros->sqlData();
  $date=$row['DATER'];
  $to = sprintf("%s@ltma.lu",$row['UNTIS']);
  $subject = "Report retenue";
  $body="La retenue suivante:\n";
  $body.= sprintf("%s %s (%s) du %s a été reportée au: %s (%s).\n",$row['PRENOME'],$row['NOME'],$row['CODE'],$row_old['DATER_F'],$row['DATER_F'],$row['SALLE']);
  $body.= "Veuillez imprimer la convocation (Menu: Retenues->Relevé personnel) et la remettre dans les meilleurs délais au secretariat.\n";
  $body.="A. Wagner\nAttaché à la direction\n";
  $headers =array('From'=>'Giros <giros@ltma.lu>','To'=>$to,'Reply-To'=>'giros@ltma.lu','Subject'=>$subject,'Content-Type' => 'text/plain; charset=UTF-8');
  $host='mail.ltma.lu';
  $username='giros';
  $password='ltmagiros';
  $smtp=Mail::factory('smtp',array('host'=>$host,'auth'=>true,'username'=>$username,'password'=>$password));
  $mail=$smtp->send($to.', giros@ltma.lu, eicjc@ltma.lu',$headers,$body);
 }
 header("Location: index.php");
}
?>
