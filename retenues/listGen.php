<?php
// Giros - 2011

// Filename:       followup.php
// Description:
// Called by:
// Calls:
// Includes files:
// Defines vars:
// Unsets vars:
// Modifies vars:
// Uses vars:
include_once("../session.php");
include_once("../c_menu.php");
$giros=$_SESSION['GIROS'];
$menu=new c_menu($giros->getUntis(),$giros->getUrl());
if(!$menu->auth($_SERVER['SCRIPT_NAME'])) {
 header("Location: ".$giros->getErrorUrl());
}
include_once '../PDF/class.ezpdf.php';
$giros->sqlConnect();
$query="SELECT NOME,PRENOME,CODE,DATER,MOTIF,NOM,PRENOM,NOCASE,PRESENT,SUIVI,NOREPORT FROM RETENUE ";
$query.="INNER JOIN PROF USING(UNTIS) LEFT JOIN ELEVE ON RETENUE.MATRICULE=ELEVE.MATRICULE LEFT JOIN DATESR USING(NODATER) ORDER BY ELEVE.CODE, ELEVE.NOME, ELEVE.PRENOME,DATER";
$giros->sqlQuery($query);
$pdf =& new Cezpdf('a4','landscape');
$diff=array(224=>'agrave',226=>'acircumflex',232=>'egrave',233=>'eacute',234=>'ecircumflex',238=>'icircumflex',244=>'ocircumflex',249=>'ugrave',251=>'ucircumflex');
$pdf->selectFont('../PDF/fonts/Helvetica.afm',array('encodig'=>'WinAnsiEncoding','differences'=>$diff));
$pdf->ezSetCmMargins(2.54,2.54,2.54,2.54);
unset($classe);
unset($data);
while ($row = $giros->sqlData()) {
 if (!isset($classe)) {
  $classe=$row['CODE'];
 }
 if ($classe != $row['CODE']) {
  $pdf->ezSetY(525);
  $title='Classe: '.$classe;
  $pdf->ezTable($data,array('nom'=>'<b>Nom</b>','prenom'=>'<b>Prénom</b>','date'=>'<b>Date</b>','motif'=>'<b>Motif</b>','titulaire'=>'<b>Titulaire</b>','nocase'=>'<b>Case</b>','present'=>'<b>Prés.</b>'),
               $title,
               array('showLines'=>2,'shaded'=>0,'fontSize'=>12,'titleFontSize'=>16,'xPos'=>'left','xOrientation'=>'right','maxWidth'=>700,
               'cols'=>array('nocase'=>array('justification'=>'right'),
                             'present'=>array('justification'=>'center'))));
  unset($data);
  $classe=$row['CODE'];
  $pdf->newPage();
 }
 $s[0]=$row['NOM'].' '.$row['PRENOM'];
 switch ($row['PRESENT']) {
 	case -1: $s[2]='-';break;
 	case  0: $s[2]='A';break;
 	case  1: $s[2]='P'; break;
 }
 switch ($row['SUIVI']){
 	case -1: $s[2].='?';break;
 	case  0: $s[2].='E';break;
 	case  1: $s[2].='NE';break;
 	case  2: $s[2].='OK';break;
 	case  3: $s[2].='KO';break;
 }
 if ($row['PRESENT']==-1){$s[2]='-';}
 if (strlen($row['NOREPORT'])!=0) {$s[2].='R';}
 list($date,$time) = explode(" ",$row['DATER']);
 list($year,$month,$day)=explode("-",$date);
 $date=$day."/".$month;
 $line = array(array("nom"=>$row['NOME'],"prenom"=>$row['PRENOME'],"date"=>$date,"motif"=>$row['MOTIF'],"titulaire"=>$s[0],"nocase"=>$row['NOCASE'],"present"=>$s[2]));
 if (!isset($data)) {
  $data=$line;
 }
 else {
  $data = array_merge_recursive($data, $line);
 }
}
$pdf->ezSetY(525);
$title='Classe: '.$classe;
$pdf->ezTable($data,array('nom'=>'<b>Nom</b>','prenom'=>'<b>Prénom</b>','date'=>'<b>Date</b>','motif'=>'<b>Motif</b>','titulaire'=>'<b>Titulaire</b>','nocase'=>'<b>Case</b>','present'=>'<b>Prés.</b>'),
               $title,
               array('showLines'=>2,'shaded'=>0,'fontSize'=>12,'titleFontSize'=>16,'xPos'=>'left','xOrientation'=>'right','maxWidth'=>700,
               'cols'=>array('nocase'=>array('justification'=>'right'),
                             'present'=>array('justification'=>'center'))));
$pdf->ezStream();
?>
