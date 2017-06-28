<?php

include_once("../session.php");
$giros = $_SESSION['GIROS'];
switch ($_POST['sw']) {
// new cluster
 case 'newCluster':
  $giros->sqlConnect();
  $nocluster=md5(uniqid(rand(), TRUE));
  $description =mysql_real_escape_string(stripslashes(urldecode($_POST['description'])));
  $query = sprintf("INSERT INTO CLUSTER (NOCLUSTER,UNTIS,DESCRIPTION) VALUES('%s','%s','%s')",$nocluster,$giros->getUntis(),$description);
  $giros->sqlQuery($query);
  break;

// delete cluster
case 'deleteCluster':
  $id=urldecode($_POST['noCluster']);
  $giros->sqlConnect();
  $query = sprintf("DELETE FROM CLUSTER_ELEVE WHERE NOCLUSTER='%s'",$id);
  $giros->sqlQuery($query);
  $query = sprintf("DELETE FROM CLUSTER WHERE NOCLUSTER='%s'",$id);
  $giros->sqlQuery($query);
  break;

// get cluster Info
case 'getCluster':
  if (isset($_POST['noCluster'])) {
   $id=urldecode($_POST['noCluster']);
   $giros->sqlConnect();
   $query = sprintf("SELECT ELEVE.IAM,ELEVE.NOME,ELEVE.PRENOME,ELEVE.CODE FROM ELEVE LEFT JOIN CLUSTER_ELEVE USING(IAM) WHERE NOCLUSTER='%s' ORDER BY CODE,NOME,PRENOME",$id);
   $giros->sqlQuery($query);
   if ($giros->sqlNumRows()!=0) {
    while ($row = $giros->sqlData()) {
     $data[$row['IAM']]=$row;
    }  
   } else {
    $data=null;
   }
  }
  header('Content-Type: application/json');
  echo json_encode($data);

  break;

// get class info
case 'getClass':
  if (isset($_POST['code'])) {
   $code=urldecode($_POST['code']);
   $giros->sqlConnect();
   $query = sprintf("SELECT IAM,NOME,PRENOME,CODE FROM ELEVE WHERE CODE='%s' ORDER BY NOME,PRENOME",$code);
   $giros->sqlQuery($query);
   if ($giros->sqlNumRows()!=0) {
    while ($row = $giros->sqlData()) {
     $data[$row['IAM']]=$row;
    }  
   } else {
    $data=array();
   }
  }
  
  header('Content-Type: application/json');
  echo json_encode($data);
   
  break;


// Clusters
 case 'getAllCluster':
  $giros->sqlConnect();
  $query = sprintf("SELECT NOCLUSTER,DESCRIPTION,COUNT(IAM) AS QTE FROM CLUSTER LEFT JOIN CLUSTER_ELEVE USING (NOCLUSTER)  WHERE UNTIS='%s' GROUP BY NOCLUSTER ORDER BY DESCRIPTION;",$giros->getUntis());
  $giros->sqlQuery($query);
  if ($giros->sqlNumRows() == 0) {
   echo "-1";
  } else {
   $response="<table id='clusterTable' class='tablesorter tablesorter-blue'>\n";
   $response.= " <thead>  <tr>\n   <th>Description</th>\n   <th>Nombre</th>\n   <th>Action</th>\n  </tr></thead>\n";
   $response.=" <tbody>\n";
   while ($row = $giros->sqlData()) {
    $response.=        "  <tr>\n";
    $response.=sprintf("   <td>%s</td>\n",$row['DESCRIPTION']);
    $response.=sprintf("   <td>%s</td>\n",$row['QTE']);
    $response.=        "   <td>\n";
    $response.=sprintf("    <input type=\"button\" class=\"deleteClass\" value=\"Supprimer\" onclick=\"deleteCluster('%s')\" />\n",$row['NOCLUSTER']);
    $response.=sprintf("    <input type=\"button\" class=\"updateClass\" value=\"Mise &agrave; jour\" onclick=\"modifyCluster('%s')\" />",$row['NOCLUSTER']);
    $response.=        "   </td>\n";//,,$row['NOCLUSTER']);
    $response.=        "  </tr>\n"; 
   }
   $response.=" </tbody>\n";
   $response.= "</table>";
   echo $response;
   }
  break;

// update Cluster
 case 'updateCluster':
  if(isset($_POST['noCluster'])) {
   $noCluster=trim($_POST['noCluster']);
   if(strlen($noCluster) !=0) {
    $giros->sqlConnect();
    $query=sprintf("DELETE FROM CLUSTER_ELEVE WHERE NOCLUSTER='%s'",mysql_real_escape_string($noCluster));
    $giros->sqlQuery($query);
    if (isset($_POST['data'])) {
     $data=$_POST['data'];
     foreach($data as $key=>$value) {
      $query=sprintf("INSERT INTO CLUSTER_ELEVE(NOCLUSTER,IAM) VALUES('%s','%s')",$noCluster,$key);     
      $giros->sqlQuery($query);
     }
    }
   }
  }

  break;
}
?>