<?php
include_once("../session.php");
$switch = $_POST['sw'];
$giros = $_SESSION['GIROS'];
$untis = $giros->getuntis();

include_once("c_desiderata.php");
$des = new c_desiderata($untis, $giros->getSite());
switch ($switch) {
 // -----------------------------------------------------------------------
 case "dispo1":
  $dispo1 = explode("-", $des->getDispo1());
  $dispo = $dispo1[2] . "/" . $dispo1[1] . "/" . $dispo1[0];
  echo json_encode($dispo);
  break;
 // -----------------------------------------------------------------------
 case "dispo2":
  $dispo2 = explode("-", $des->getDispo2());
  $dispo = $dispo2[2] . "/" . $dispo2[1] . "/" . $dispo2[0];
  echo json_encode($dispo);
  break;
 // -----------------------------------------------------------------------
 case "classes":
  $query = "SELECT DISTINCT CLASSE FROM CBNC ORDER BY CLASSE";
  $giros->sqlConnect();
  $giros->sqlQuery($query);
  ?>
  <select id="cl" onchange="updateBranches('#cl', '#br')">
      <?php
      while ($row = $giros->sqlData()) {
       printf("        <option value=\"%s\">%s</option>\n", $row['CLASSE'], $row['CLASSE']);
      }
      ?>
  </select>
  <?php
  break;
 // -----------------------------------------------------------------------
 case "branches":
  $classe = $_POST['classe'];
  $query = sprintf("SELECT * FROM CBNC WHERE CLASSE='%s' ORDER BY BRANCHE", $classe);
  $giros->sqlConnect();
  $giros->sqlQuery($query);
  $msg = '';
  while ($row = $giros->sqlData()) {
   $msg.=sprintf("        <option value=\"%s\">%s</option>\n", $row['NOCBNC'], htmlentities($row['BRANCHE']));
  }
  echo $msg;
  break;
 // -----------------------------------------------------------------------
 case "duree":
  $cbnc = $_POST['cbnc'];
  $query = sprintf("SELECT * FROM CBNC WHERE NOCBNC=%s ORDER BY BRANCHE", $cbnc);
  $giros->sqlConnect();
  $giros->sqlQuery($query);
  if ($row = $giros->sqlData()) {
   echo $row['NUMBER'];
  } else {
   echo "0";
  }
  break;
 // -----------------------------------------------------------------------
 case "complete":
  $cbnc = $_POST['cbnc'];
  $query = sprintf("SELECT * FROM CBNC WHERE NOCBNC=%s ORDER BY BRANCHE", $cbnc);
  $giros->sqlConnect();
  $giros->sqlQuery($query);
  $row = $giros->sqlData();
  $data['cbnc'] = $row['NOCBNC'];
  $data['code_branche'] = $row['CODE_BRANCHE'];
  $data['branche'] = $row['BRANCHE'];
  $data['number'] = $row['NUMBER'];
  $data['classe'] = $row['CLASSE'];
  echo json_encode($data);
  break;
 // -----------------------------------------------------------------------
 case "choice":
  $choice = $des->getChoix(-1);
  echo json_encode($choice);
  break;
 // -----------------------------------------------------------------------
 case "renderTable":
  $table = $_POST['table'];
  $info_salles = array('Abbe Pierre', 'Acropole', 'Amazone', 'Bohr', 'Bureau modele', 'Colosseum', 'DACTY 1', 'DACTY 2', 'Da Vinci', 'Darwin', 'Edison', 'Einstein', 'Fleming', 'Galileo', 'Himalaya', 'INFO 1', 'INFO 2', 'INFO 3', 'INFO 4', 'INFO 5', 'INFO 6', 'INFO 7', 'INFO 8', 'Lorenz', 'Louvre', 'Marie Curie', 'Pasteur', 'PART 1', 'PART 2', 'PART 3', 'PBOIS 1', 'PBOIS 2', 'PCOUT', 'PCUI 1', 'PCUI 2', 'PELE 1', 'PELE 2', 'PELE 2 - MEZZ', 'Planck', 'PMET 1', 'PMET 2', 'PMUSIC', 'PPEINT', 'PPOLY', 'PSAN', 'PSAN-MEZ', 'Rutherford', 'Sahara', 'Tesla', 'JBOIS', 'JCUI', 'JINFO', 'JIPDM', 'JMET', 'JPHYCH', 'JPOLY');
  sort($info_salles);
  if (count($table) != 0) {
   ?> 
   <table border="1" rules="cols">
    <thead>
     <tr>
      <th> </th>
      <th>Classe / Module</th>
      <th>Branche</th>
      <th>Nombre de le&ccedil;ons</th>
      <th>Salle sp&eacute;ciale</th>
      <th>Nombre de blocs</th>
      <th>Dur&eacute;e d'un bloc en le&ccedil;ons</th>
     </tr>
    </thead>
    <tbody>
        <?php
        foreach ($table as $index => $line) {
         ?>
      <tr <?php printf("id=\"tblChoiceTR%s\"", $index); ?>>
       <td>
        <button class="ui-state-default ui-corner-all" type="button" onclick="suppressChoice(<?php echo $index; ?>)">
         <span class="ui-icon ui-icon-circle-close"></span>
        </button>
        <button class="ui-state-default ui-corner-all" type="button" onclick="upChoice(<?php echo $index; ?>);">
         <span class="ui-icon ui-icon-arrowthick-1-n"></span>
        </button>
        <button class="ui-state-default ui-corner-all" type="button" onclick="downChoice(<?php echo $index; ?>);">
         <span class="ui-icon ui-icon-arrowthick-1-s"></span>
        </button>
       </td>
       <td>
           <?php
           $query = "SELECT DISTINCT CLASSE FROM CBNC ORDER BY CLASSE";
           $giros->sqlConnect();
           $giros->sqlQuery($query);
           while ($row = $giros->sqlData()) {
            $classes[] = $row['CLASSE'];
           }
           $query = sprintf("SELECT * FROM CBNC WHERE NOCBNC=%u", $line['cbnc']);
           $giros->sqlQuery($query);
           if (!$row = $giros->sqlData()) {
            $row['NOCBNC'] = '?';
            $row['CODE_BRANCHE'] = '?';
            $row['BRANCHE'] = '?';
            $row['NUMBER'] = '0';
            $row['CLASSE'] = '?';
           }
           printf("        <select id=\"classe[%d]\" name=\"classe[%d]\" onchange=\"updateBranches('#classe\\\\[%d\\\\]','#branche\\\\[%d\\\\]');\">\n", $index, $index, $index, $index);
           foreach ($classes as $cl) {
            if ($cl == $line['classe']) {
             $checked = 'selected="selected"';
            } else {
             $checked = "";
            }
            printf("        <option value=\"%s\" %s>%s</option>\n", $cl, $checked, $cl);
           }
           echo "      </select>";
           ?>
       </td>
       <td>
           <?php
           $query = sprintf("SELECT * FROM CBNC WHERE CLASSE=\"%s\" ORDER BY BRANCHE", $line['classe']);
           $giros->sqlQuery($query);
           while ($row = $giros->sqlData()) {
            $cbnc[] = $row;
           }
           printf("        <select id=\"branche[%d]\" name=\"branche[%d]\" onchange=\"updateDuree('#branche\\\\[%d\\\\]','#duree\\\\[%d\\\\]')\">\n", $index, $index, $index, $index);
           foreach ($cbnc as $br) {
            if ($br['NOCBNC'] == $line['cbnc']) {
             $checked = 'selected="selected"';
            } else {
             $checked = "";
            }
            printf("        <option value=\"%s\" %s>%s</option>\n", $br['NOCBNC'], $checked, htmlentities($br['BRANCHE']));
           }
           echo "      </select>";
           ?>
       </td>
       <?php
       printf("  <td id=\"duree[%s]\" class=\"duree\">", $index);
       echo $line['number'];
       echo "  </td>";
       ?>
       <td>
           <?php
           printf("        <select name=\"salle[%d]\">\n", $index);
           printf("    <option value=\"0\">---</option>\n");
           foreach ($info_salles as $sa) {
            if ($sa == $line['salle']) {
             $checked = 'selected="selected"';
            } else {
             $checked = "";
            }
            printf("        <option value=\"%s\" %s>%s</option>\n", $sa, $checked, $sa);
           }
           echo "      </select>";
           ?>
       </td>
       <td>
           <?php
           printf("      <select name=\"nb_blocs[%d]\" onchange=\"activateDuree(%d);\">\n", $index, $index);
           printf("       <option value=\"0\">---</option>");
           for ($j = 1; $j < 10; $j++) {
            if ($j == $line['nb_blocs']) {
             $checked = 'selected="selected"';
            } else {
             $checked = "";
            }
            printf("       <option value=\"%d\" %s>%d</option>\n", $j, $checked, $j);
           }
           echo "      </select>";
           ?>
       </td>
       <td>
           <?php
           printf("      <select name=\"duree[%d]\">\n", $index);
           printf("       <option value=\"0\">---</option>");
           for ($j = 2; $j < 5; $j++) {
            if ($j == $line['duree']) {
             $checked = 'selected="selected"';
            } else {
             $checked = "";
            }
            printf("        <option value=\"%d\" %s>%d</option>\n", $j, $checked, $j);
           }
           echo "      </select>";
           ?>
       </td>
      </tr> 
      <?php
     }
     ?> 
    </tbody>
   </table> 
   <?php
  }
  break;
}
?>