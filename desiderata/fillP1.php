<?php

function showForm() {
 include_once("../session.php");
 include_once("../c_menu.php");
 include_once 'c_desiderata.php';
 $giros = $_SESSION['GIROS'];
 $menu = new c_menu($giros->getUntis(), $giros->getUrl());
 if (!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: " . $giros->getErrorUrl());
 }
 $des = new c_desiderata($giros->getUntis(), $giros->getSite());
 $_SESSION['DESIDERATA'] = $des;
 $info_decharages = array('GESLA#0#PHYSI#CHIMI#BIOLO#JPHYCH', 'GESAT#0#Artistique 1#Artistique 2#Artistique 3#Bois 1 #Bois 2#Couture#Cuisine 1#Cuisine 2#Cuisine 3#Electro 1#Electro 2#M&eacute;tal 1#M&eacute;tal 2#Peinture#Polyvalente#Sanitaire#J-Bois#J-IPDM#J-M&eacute;tal#J-Polyvalente#J-Cuisine');
 $info_decharages = array_merge($info_decharages, array('ACASP#1', 'ACILO#22', 'ACT72#1', 'ACTPA#22', 'ADMIN#22', 'ALLAI#5', 'ANCIE#4', 'APOLS#22', 'APPUI#22', 'BIBLI#22', 'CANDI#5', 'CFPCO#22', 'COMIT#22', 'CORIN#2', 'COUSO#22', 'ETUDE#22', 'FACUL#22','FOPRO#12', 'FORMA#13', 'GESIN#6', 'MINCU#22', 'MINED#22', 'MINFP#22', 'MINSP#22', 'MOSAI-L#22', 'MOSAI-D#22', 'ORIEN#22', 'ORIKA#22', 'ORSTA#4', 'PROCO#22', 'PROET#22', 'PROTU#22', 'REGEN#3', 'SANTE#22', 'SCHILW#2', 'SCRIP#22', 'SECUR#22', 'SPORT#22', 'TUTEU#3'));
 sort($info_decharages);
 $info_salles = array('Abbe Pierre', 'Acropole', 'Amazone', 'Bohr', 'Bureau modele', 'Colosseum', 'DACTY 1', 'DACTY 2', 'Da Vinci', 'Darwin', 'Edison', 'Einstein', 'Fleming', 'Galileo', 'Himalaya', 'INFO 1', 'INFO 2', 'INFO 3', 'INFO 4', 'INFO 5', 'INFO 6', 'INFO 7', 'INFO 8', 'Lorenz', 'Louvre', 'Marie Curie', 'Pasteur', 'PART 1', 'PART 2', 'PART 3', 'PBOIS 1', 'PBOIS 2', 'PCOUT', 'PCUI 1', 'PCUI 2', 'PELE 1', 'PELE 2', 'PELE 2 - MEZZ','Planck', 'PMET 1', 'PMET 2', 'PMUSIC', 'PPEINT', 'PPOLY', 'PSAN', 'PSAN-MEZ', 'Rutherford', 'Sahara', 'Tesla', 'JBOIS', 'JCUI', 'JINFO', 'JIPDM', 'JMET', 'JPHYCH', 'JPOLY', 'JLAVABO1', 'JLAVABO2');
 sort($info_salles);
 $info_rattrapage = array('Allemand', 'Anglais', 'Fran&ccedil;ais', 'Math&eacute;matiques', '7MO', '7MOF', '8MO', '8MOF', '9MO', '9MOF', 'Autre (sp&eacute;cifiez dans la &laquo;remarque branches&raquo;)');
 $info_lycees = array("AL#Ath&eacute;n&eacute;e de Luxembourg", "ALR#Atert Lyc&eacute;e R&eacute;iden", "BELVAL#Lyc&eacute;e Belval", "E2C#Ecole de la 2&egrave;me Chance", "EID#Ecole Internationale Differdange", "EPF#Ecole Priv&eacute;e Fieldgen", "EPG#Ecole Priv&eacute;e Grandjean", "EPMC#Ecole Priv&eacute;e Marie Consolatrice", "EPND#Ecole Priv&eacute;e Notre Dame Sainte Sophie", "EUROSCHOOL#Ecole Europ&eacute;enne de Luxembourg", "ISLUX#International School of Luxembourg", "LAM#Lyc&eacute;e Aline Mayrisch", "LCD#Lyc&eacute;e Classique Diekirch", "LCE#Lyc&eacute;e Classique d'Echternach", "LGE#Lyc&eacute;e de Gar&ccedil;ons Esch", "LGL#Lyc&eacute;e de Gar&ccedil;ons Luxembourg", "LHCE#Lyc&eacute;e Hubert Clement", "LJBM#Lyc&eacute;e Josy Barthel Mamer", "LLJ#L&euml;nster Lyc&eacute;e", "LMRL#Lyc&eacute;e Michel Rodange", "LN#Lyc&eacute;e du Nord", "LNB#Lyc&eacute;e Nic Biever", "LRSL#Lyc&eacute;e Robert Schuman", "LTA#Lyc&eacute;e Technique agricole", "LTAM#Lyc&eacute;e Technique des Arts et M&eacute;tiers", "LTB#Lyc&eacute;e Technique de Bonnevoie", "LTC#Lyc&eacute;e Technique du Centre", "LTE#Lyc&eacute;e Technique Esch", "LTECG#Lyc&eacute;e Technique Ecole de Commerce et de Gestion", "LTETT#Lyc&eacute;e Technique Ettelbr&uuml;ck", "LTHAH#Lyc&eacute;e Technique H&ocirc;telier Alexis Heck", "LTJB#Lyc&eacute;e Technique Joseph Bech", "LTL#Lyc&eacute;e Technique de Lallange", "LTML#Lyc&eacute;e Technique Michel Lucius", "LTPEM#Lyc&eacute;e Technique Priv&eacute; Emile Metz", "LTPES#Lyc&eacute;e Technique pour Professions Educatives et Sociales", "LTPS#Lyc&eacute;e Technique pour Professions de Sant&eacute;", "LTPSA#Lyc&eacute;e Technique Priv&eacute; Sainte Anne", "LEM#Lyc&eacute;e Ermesinde", "NOSL#Nordstadlyc&eacute;e", "SPORT#Sportlyc&eacute;e", "ST-GEORGES#St. George's International School", "UELL#Uelzecht Lyc&eacute;e", "VAUBAN#Lyc&eacute;e Fran&ccedil;ais du Luxembourg", "WALDORF#Fr&auml;&iuml; &ouml;ffentlech Waldorfschoul L&euml;tzebuerg");
 ?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
   <title>Desiderata - Remplir</title>
   <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
   <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
   <link rel="stylesheet" href="../css/layout.css" type="text/css" />
   <script type="text/javascript" src="../jquery/jquery.js"></script>
   <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
   <script type="text/javascript" src="../menu.js"></script>
   <script type="text/javascript" src="fillP1.js"></script>
  </head>
  <body>
      <?php include ("../logo.php"); ?>
   <div id="ww">
    <div id="sidemenu">
        <?php $menu->display(); ?>
    </div>
    <div id="cont">
     <form action="fill.php" method="post">
      <h1>Vos donn&eacute;es personnelles:</h1>
      <table>
       <tr>
        <td>Code UNTIS:</td>
        <td><?php echo $des->getUntis(); ?></td>
       </tr>
       <tr>
        <td>Nom:</td>
        <td><?php echo $giros->getName(); ?></td>
       </tr>
       <tr>
        <td>Pr&eacute;nom:</td>
        <td><?php echo $giros->getCName(); ?></td>
       </tr>
       <tr>
        <td>Case:</td>
        <td><?php echo $giros->getNoCase(); ?></td>
       </tr>
       <tr>
        <td>Ces donn&eacute;es sont-elles correctes?</td>
        <?php
        if ($des->getDonnespers() == 'T') {
         echo('       <td><input type="radio" name="donnespers" value="T" checked="checked" /> oui<input type="radio" name="donnespers" value="F" /> non</td>');
        } else {
         echo ('       <td><input type="radio" name="donnespers" value="T" /> oui<input type="radio" name="donnespers" value="F" checked="checked" /> non</td>');
        }
        ?>
       </tr>
      </table>
      <hr />
      <p>
       T&eacute;l&eacute;phone:
       <input name="telephone" type="text" size="20" maxlength="20" value="<?php echo $des->getTelephone(TRUE); ?>" />
       GSM:
       <input name="gsm" type="text" size="20" maxlength="20" value="<?php echo $des->getGsm(TRUE); ?>" />
      </p>
      <p style="font-weight: bold">
       Absent du:
       <input type="text" id="dispo1" style="display: none" value="<?php echo $des->getDispo1() ?>" name="dispo1" />
       <input type="text" id="dispo1x" value="<?php
       $dispo = explode('-', $des->getDispo1());
       echo $dispo[2] . '/' . $dispo[1] . '/' . $dispo[0];
       ?>" style="width: 250px; border: none" readonly="readonly" name="dispo1x" />
       au:
       <input type="text" id="dispo2" style="display: none" value="<?php echo $des->getDispo2() ?>" name="dispo2" />
       <input type="text" id="dispo2x" value="<?php
       $dispo = explode('-', $des->getDispo2());
       echo $dispo[2] . '/' . $dispo[1] . '/' . $dispo[0];
       ?>" style="width: 200px; border: none" readonly="readonly" name="dispo2x" />
      </p>
      <p>
       Sp&eacute;cialit&eacute;(s): <input name="specialites" type="text" size="45" maxlength="45" value="<?php echo $des->getSpecialites(TRUE); ?>" />
      </p>
      <p>
       Autres branches susceptibles d'&ecirc;tre assum&eacute;es (Veuillez indiquer le niveau de la classe):
       <input name="branches" type="text" size="45" maxlength="45" value="<?php echo $des->getBranches(TRUE); ?>" />
      </p>
      <p>
       T&acirc;che:
       <select name="tache" size="1">
        <optgroup label="Enseignants nomm&eacute;s">
         <option value="1" <?php
         if ($des->getTache() == 1) {
          echo 'selected="selected"';
         }
         ?>>100%</option>
         <option value="0.75" <?php
         if ($des->getTache() == 0.75) {
          echo 'selected="selected"';
         }
         ?>>75%</option>
         <option value="0.5" <?php
         if ($des->getTache() == 0.5) {
          echo 'selected="selected"';
         }
         ?>>50%</option>
         <option value="0.25" <?php
         if ($des->getTache() == 0.25) {
          echo 'selected="selected"';
         }
         ?>>25%</option>
        </optgroup>
        <optgroup label="Stagiaires">
            <?php
            if ($des->getTache() == 22 + 30) {
             $c = 'selected="selected"';
            } else {
             $c = ' ';
            }
            printf("        <option value=\"%u\" %s>%u le&ccedil;ons</option>\n", 22 + 30, $c, 22);
            ?>
        </optgroup>
        <optgroup label="Charg&eacute;s">
            <?php
            for ($i = 22; $i > 11; $i--) {
             if ($des->getTache() == $i) {
              $c = 'selected="selected"';
             } else {
              $c = ' ';
             }
             printf("        <option value=\"%u\" %s>%u le&ccedil;ons</option>\n", $i, $c, $i);
            }
            if ($des->getTache() ==11.5) {
              $c = 'selected="selected"';
             } else {
              $c = ' ';
             }
             printf("        <option value=\"%s\" %s>%s le&ccedil;ons</option>\n", "11.5", $c, "11,5");


            for ($i = 11; $i > 1; $i--) {
             if ($des->getTache() == $i) {
              $c = 'selected="selected"';
             } else {
              $c = ' ';
             }
             printf("        <option value=\"%u\" %s>%u le&ccedil;ons</option>\n", $i, $c, $i);
            }

            ?>
        </optgroup>
       </select>
      </p>
      <p>
       &Ecirc;tes-vous inscrit(e) au concours de recrutement de l'enseignement post-fondamental?
       <?php
       if ($des->getRecrutement() == 'T') {
        echo '      <input type="radio" name="recrutement" value="T" checked="checked" /> oui';
        echo '      <input type="radio" name="recrutement" value="F" /> non';
       } else {
        echo '      <input type="radio" name="recrutement" value="T" /> oui';
        echo '      <input type="radio" name="recrutement" value="F" checked="checked" /> non';
       }
       ?>
      </p>
      <hr />
      <h1>D&eacute;charges:</h1>
      <p>Veuillez indiquer le nombre de le&ccedil;ons hebdomadaires.</p>
      <table>
       <tbody>
        <tr>
            <?php
            unset($det);
            foreach ($info_decharages as $i => $dech) {
             $split = explode("#", $dech);
             $key = $des->selectDecharge($split[0]);
             if ($key == -1) {
              unset($det);
             } else {
              $det = $des->getDecharge($key);
             }
             $sel = '';
             if ($split[0] == 'REGEN') {
              $class = "class='regen'";
             } else {
              $class = '';
              $enabled = '';
             }
             printf("        <td %s>%s:</td>\n", $class, $split[0]);
             printf("        <td %s>\n", $class);
             printf("         <select name=\"dech[%s]\" onchange=\"sum_lecons()\">\n", $split[0]);
             if (count($split) == 2) {
              for ($j = 0; $j <= $split[1]; $j++) {
               if (isset($det) and $j == $det['nombre']) {
                $sel = 'selected="selected"';
               } else {
                $sel = '';
               }
               if ($j == 0) {
                printf("          <option value=\"0\" coef=\"0\" %s>---</option>\n", $sel);
               } else {
                printf("          <option value=\"%d\" coef=\"%d\" %s>%d</option>\n", $j, $j, $sel, $j);
               }
              }
             } else {
              for ($j = 1; $j < count($split); $j++) {
               if (isset($det) and $split[$j] == htmlentities($det['departement'])) {
                $sel = 'selected="selected"';
               } else {
                $sel = '';
               }
               if ($j == 1) {
                print("          <option value=\"0\" coef=\"0\">---</option>\n");
               } else {
                printf("          <option value=\"%s\" coef=\"1\" %s>%s</option>\n", $split[$j], $sel, $split[$j]);
               }
              }
             }
             print("         </select>\n        </td>\n");
             if (((($i + 1) % 5) == 0) && ($i != 0)) {
              print("       </tr>\n       <tr>\n");
             }
            }
            ?>
        </tr>
       </tbody>
      </table>
      <table>
       <tr>
        <td><div class="totlecons"></div></td>
        <td><div class="totdech"></div></td>
        <td><div class="totcadre"></div></td>
       </tr>
      </table>
      <hr />
      <p>Si vous b&eacute;n&eacute;ficiez d'un cong&eacute;, veuillez en indiquer:</p>
      <table>
       <tr>
        <td>la nature:</td>
        <td>
         <select name="conge" size="1">
          <option value="aucun" <?php
           if ($des->getConge(TRUE) == "aucun") {
            echo 'selected="selected"';
           }
            ?>>aucun</option>
          <option value="mi" <?php
         if ($des->getConge(TRUE) == "mi") {
          echo 'selected="selected"';
         }
            ?>>mi-temps</option>
          <option value="pmi" <?php
         if ($des->getConge(TRUE) == "pmi") {
          echo 'selected="selected"';
         }
            ?>>parental - mi-temps</option>
          <option value="ppt" <?php
         if ($des->getConge(TRUE) == "ppt") {
          echo 'selected="selected"';
         }
            ?>>parental - temps plein</option>
          <option value="ss" <?php
         if ($des->getConge(TRUE) == "ss") {
          echo 'selected="selected"';
         }
            ?>>sans solde</option>
         </select>
        </td>
        <td>jusqu'&agrave; la rentr&eacute;e:</td>
        <td>
         <select name="co_duree" size="1">
             <?php
             if ($des->getCo_duree() == 0) {
              echo "         <option value=\"0\" selected=\"selected\" >---</option>\n";
             } else {
              echo "         <option value=\"0\" >---</option>\n";
             }
             for ($i = 17; $i <= 53; $i++) {
              if ($des->getCo_duree() == $i) {
               $c = 'selected="selected"';
              } else {
               $c = '';
              }
              printf("         <option value=\"%u\" %s>20%u </option>\n", $i, $c, $i);
             }
             ?>
         </select>
        </td>
       </tr>
      </table>
      <hr />
      <h1>Branches et classes souhait&eacute;es (par ordre de pr&eacute;f&eacute;rence)</h1>
      <p id="wait" style="display: none;">Attendez, chargement en cours!</p>
      <div id="branches">
       <div id="addDlg">
        <table>
         <tbody>
          <tr>
           <td>Classe / Module:</td>
           <td><div id="selCl"></div></td>
          </tr>
          <tr>
           <td>Branche:</td>
           <td>
            <select id="br"></select>
           </td>
          </tr>
          <tr>
           <td>Salle sp&eacute;ciale:</td>
           <td>
            <select id="salle">
             <option value=\"0\">---</option>
             <?php
             foreach ($info_salles as $sa) {
              printf("        <option value=\"%s\">%s</option>\n", $sa, $sa);
             }
             ?>
            </select>
           </td>
          </tr>
          <tr>
           <td>Nombre de blocs:</td>
           <td>
            <select id="bloc">
                <?php
                printf("       <option value=\"0\">---</option>");
                for ($j = 1; $j < 10; $j++) {
                 printf("       <option value=\"%d\" >%d</option>\n", $j, $j);
                }
                ?>
            </select>          
           </td>
          </tr>
          <tr>
           <td>Dur&eacute;e d'un bloc en le&ccedil;ons:</td>
           <td>
            <select id="duree">
                <?php
                printf("       <option value=\"0\">---</option>");
                for ($j = 2; $j < 5; $j++) {
                 printf("       <option value=\"%d\" >%d</option>\n", $j, $j);
                }
                ?>
            </select>
           </td>
          </tr>
         </tbody>
        </table>
       </div>
       <div id="tblChoice">
       </div>

       <table>
        <tr>
         <td><div class="totlecons"></div></td>
         <td><div class="totdech"></div></td>
         <td><div class="totcadre"></div></td>
        </tr>
       </table>
       <button id="addButton" class="ui-state-default ui-corner-all" type="button" onclick="updateButton()">Ajouter choix</button>
      </div>
      <table>
       <tr>
        <td><b>L&eacute;gende:</b></td>
        <td></td>
       </tr>
       <tr>
        <td><button class="ui-state-default ui-corner-all" type="button"><span class="ui-icon ui-icon-circle-close"></span></button></td>
        <td>Supprimer le choix</td>
       </tr>
       <tr>
        <td>
         <button class="ui-state-default ui-corner-all" type="button"><span class="ui-icon ui-icon-arrowthick-1-n"></span></button>
         <button class="ui-state-default ui-corner-all" type="button"><span class="ui-icon ui-icon-arrowthick-1-s"></span></button>
        </td>
        <td>Modifier l'ordre de priorit&eacute;</td>
       </tr>
      </table>
      <p>Remarque branches: <input type="text" maxlength="250" name="rem_branches" size=120 value="<?php echo $des->getRem_branches(TRUE) ?>" /></p>
      <hr />
      <p>Dans quelle(s) classe(s) aimeriez-vous assurer une r&eacute;gence?</p>
      <div>
       1<sup>ier</sup> choix: <select id ="regence1" name="regence1" size="1" onchange="sum_lecons();">
        <option value="-">---</option>
        <?php
        $query = "SELECT DISTINCT CLASSE FROM CBNC ORDER BY CLASSE";
        $giros->sqlConnect();
        $giros->sqlQuery($query);
        while ($row = $giros->sqlData()) {
         $classes[] = $row['CLASSE'];
        }

        $info_regence = array_merge(array('indiff&eacute;rent'), $classes);

        foreach ($info_regence as $i => $reg) {
         if ($des->getRegence1(TRUE) == $reg) {
          $sel = 'selected="selected"';
         } else {
          $sel = '';
         }
         printf("<option value=\"%s\" %s>%s</option>\n", $reg, $sel, $reg);
        }
        ?>
       </select> 2<sup>i&egrave;me</sup> choix: <select id="regence2" name="regence2" size="1" onchange="sum_lecons();">
        <option value="-">---</option>
        <?php
        foreach ($info_regence as $i => $reg) {
         if ($des->getRegence2(TRUE) == $reg) {
          $sel = 'selected="selected"';
         } else {
          $sel = '';
         }
         printf("<option value=\"%s\" %s>%s</option>\n", $reg, $sel, $reg);
        }
        ?>
       </select>
      </div>
      <div>
       <p>
        Dans quelle branche &ecirc;tes-vous pr&ecirc;t(e) &agrave; assurer
        un cours d'appui? <select name="rattrapage" size="1">
         <option value="0">---</option>
         <?php
         foreach ($info_rattrapage as $i => $rat) {
          if ($des->getRattrapage(TRUE) == $rat) {
           $sel = 'selected="selected"';
          } else {
           $sel = '';
          }
          printf("<option value=\"%s\" %s>%s</option>\n", $rat, $sel, $rat);
         }
         ?>
        </select>
       </p>
      </div>
      <div>
       <p>
        Combien de le&ccedil;on(s) hebdomadaires de surveillance
        &ecirc;tes-vous pr&ecirc;t(e) &agrave; assurer? <select
            name="surveillance" size="1">
                <?php
                for ($i = 0; $i <= 10; $i++) {
                 if ($i == $des->getSurveillance()) {
                  $sel = " selected=\"selected\"";
                 } else {
                  $sel = "";
                 }
                 printf("<option value=\"%s\" %s>%s</option>\n", $i, $sel, $i);
                }
                ?>
        </select>
       </p>
      </div>
      <div>
       <p>
        D&eacute;sirez-vous &ecirc;tre charg&eacute;(e) d'un cours de
        Vie et Soci&eacute;t&eacute;? <select name="fomos" size="1">
            <?php
            echo "<option value=\"F\"";
            if ($des->getFomos() == 'F') {
             echo " selected=\"selected\"";
            }
            echo ">Non</option>\n";
            echo "<option value=\"T\"";
            if ($des->getFomos() == 'T') {
             echo " selected=\"selected\"";
            }
            echo ">Oui</option>\n";
            ?>
        </select>
       </p>
      </div>
      <div>
       <p>
        Combien de le&ccedil;ons d'&Eacute;tude Surveill&eacute;e
        &ecirc;tes-vous pr&ecirc;t(e) &agrave; assurer? <select
            name="etudes" size="1">
                <?php
                for ($i = 0; $i <= 10; $i++) {
                 if ($i == $des->getEtudes()) {
                  $sel = " selected=\"selected\"";
                 } else {
                  $sel = "";
                 }
                 printf("<option value=\"%s\" %s>%s</option>\n", $i, $sel, $i);
                }
                ?>
        </select>
       </p>
      </div>
      <div>
       <p>
        Proposition d'activit&eacute; parascolaire: <input type="text"
                                                           name="parascolaire" size="80" maxlength="250"
                                                           value="<?php echo $des->getParascolaire(TRUE) ?>" />
       </p>
      </div>
      <div>
       <p>
        D&eacute;tachement &agrave; un autre &eacute;tablissement: <select
            name="detachement" size="1">
         <option value="-">---</option>
         <?php
         foreach ($info_lycees as $i => $lyc) {
          $acro = explode('#', $lyc);
          if ($des->getDetachement(TRUE) == $acro[0]) {
           $sel = 'selected="selected"';
          } else {
           $sel = '';
          }
          printf("<option value=\"%s\" %s>%s</option>\n", $acro[0], $sel, $acro[1]);
         }
         ?>
        </select> Nombre de le&ccedil;ons: <select name="de_nombre">
            <?php
            for ($i = 0; $i <= 22; $i++) {
             if ($i == $des->getDe_nombre()) {
              $sel = " selected=\"selected\"";
             } else {
              $sel = "";
             }
             printf("<option value=\"%s\" %s>%s</option>\n", $i, $sel, $i);
            }
            ?>
        </select>
       </p>
      </div>
      <div>
       <p>
        Vous pr&eacute;f&eacute;rez un emploi du temps plut&ocirc;t <select
            name="emploi" size="1">
                <?php
                echo "<option value=\"A\"";
                if ($des->getEmploi() == 'A') {
                 echo " selected=\"selected\"";
                }
                echo ">a&eacute;r&eacute; (avec quelques heures de creux) </option>\n";
                echo "<option value=\"C\"";
                if ($des->getEmploi() == 'C') {
                 echo " selected=\"selected\"";
                }
                echo ">compact</option>\n";
                ?>
        </select>
       </p>
      </div>
      <div>
       <p>
        Souhaitez-vous participer &agrave; la classe neige?
        <select name="neige" size="1">
            <?php
            echo "<option value=\"F\"";
            if ($des->getNeige() == 'F') {
             echo " selected=\"selected\"";
            }
            echo ">Non</option>\n";
            echo "<option value=\"T\"";
            if ($des->getNeige() == 'T') {
             echo " selected=\"selected\"";
            }
            echo ">Oui</option>\n";
            ?>
        </select>
       </p>
      </div>
      <div>
       <p>
        Souhaitez-vous participer &agrave; la classe mer?
        <select name="mer" size="1">
            <?php
            echo "<option value=\"F\"";
            if ($des->getMer() == 'F') {
             echo " selected=\"selected\"";
            }
            echo ">Non</option>\n";
            echo "<option value=\"T\"";
            if ($des->getMer() == 'T') {
             echo " selected=\"selected\"";
            }
            echo ">Oui</option>\n";
            ?>
        </select>
       </p>
      </div>
      <div>
       <p>
        Souhaitez-vous &ecirc;tre titulaire dans l'une des 7es qui organisent le Bol de riz?
        <select name="riz" size="1">
            <?php
            echo "<option value=\"F\"";
            if ($des->getRiz() == 'F') {
             echo " selected=\"selected\"";
            }
            echo ">Non</option>\n";
            echo "<option value=\"T\"";
            if ($des->getRiz() == 'T') {
             echo " selected=\"selected\"";
            }
            echo ">Oui</option>\n";
            ?>
        </select>
       </p>
      </div>    
      <div>
       <p>
        Souhaitez-vous accompagner une classe de 7e &agrave; Huelmes &agrave; la rentr&eacute;e?
        <select name="huelmes" size="1">
            <?php
            echo "<option value=\"F\"";
            if ($des->getHuelmes() == 'F') {
             echo " selected=\"selected\"";
            }
            echo ">Non</option>\n";
            echo "<option value=\"T\"";
            if ($des->getHuelmes() == 'T') {
             echo " selected=\"selected\"";
            }
            echo ">Oui</option>\n";
            ?>
        </select>
       </p>
       <p>
        Souhaitez-vous participer &agrave; la porte ouverte en mai 2018?
        <select name="portes" size="1">
            <?php
            echo "<option value=\"F\"";
            if ($des->getPortes() == 'F') {
             echo " selected=\"selected\"";
            }
            echo ">Non</option>\n";
            echo "<option value=\"T\"";
            if ($des->getPortes() == 'T') {
             echo " selected=\"selected\"";
            }
            echo ">Oui</option>\n";
            ?>
        </select>
       </p>  
       <p>
        Souhaitez-vous assurer un cours d'initiation en anglais (9PR)
        <select name="angla9pr" size="1">
            <?php
            echo "<option value=\"F\"";
            if ($des->getAngla9pr() == 'F') {
             echo " selected=\"selected\"";
            }
            echo ">Non</option>\n";
            echo "<option value=\"T\"";
            if ($des->getAngla9pr() == 'T') {
             echo " selected=\"selected\"";
            }
            echo ">Oui</option>\n";
            ?>
        </select>
       </p>  
       <p>
        Voulez-vous avoir une pause entre 12:00 et 14:00 si vous commencez &agrave; 11:00?
        <select name="pause" size="1">
            <?php
            echo "<option value=\"F\"";
            if ($des->getPause() == 'F') {
             echo " selected=\"selected\"";
            }
            echo ">Non</option>\n";
            echo "<option value=\"T\"";
            if ($des->getPause() == 'T') {
             echo " selected=\"selected\"";
            }
            echo ">Oui</option>\n";
            ?>
        </select>
       </p>  
      </div>
      <hr />
      <div>
       <h1>R&eacute;gime pr&eacute;paratoire:</h1> 
       <div>
        <p>
         D&eacute;sirez-vous faire la surveillance &agrave; la cantine?
         <select name="prep_surv_cantine" size="1">
          <option value="X" <?php
           if ($des->getPrep_surv_cantine() == 'X') {
            echo ' selected="selected"';
           }
            ?>>---</option>
          <option value="T" <?php
         if ($des->getPrep_surv_cantine() == 'T') {
          echo ' selected="selected"';
         }
            ?>>Oui</option>
          <option value="F" <?php
         if ($des->getPrep_surv_cantine() == 'F') {
          echo ' selected="selected"';
         }
            ?>>Non</option>
         </select>
        </p>
        <p>
         &Agrave; quel site d&eacute;sirez-vous enseigner?
         <?php
         $tmp = $des->getPrep_sites();
         if (($tmp & 1) != 0) {
          $lchecked = "checked='checked'";
         } else {
          $lchecked = "";
         }
         if (($tmp & 2) != 0) {
          $dchecked = "checked='checked'";
         } else {
          $dchecked = "";
         }
         if (($tmp & 4) != 0) {
          $xchecked = "checked='checked'";
         } else {
          $xchecked = "";
         }
         printf("        <input type=\"checkbox\" name=\"prep_site[]\" value=\"1\" %s/> Lamadelaine", $lchecked);
         printf("        <input type=\"checkbox\" name=\"prep_site[]\" value=\"2\" %s/> Differdange", $dchecked);
         printf("        <input type=\"checkbox\" name=\"prep_site[]\" value=\"4\" %s/> Indiff&eacute;rent", $xchecked);
         ?>
        </p>      
       </div>
      </div>
      <hr />
      <div>
       Remarques sp&eacute;ciales: <input type="text" name="rem_speciales"
                                          size="120" maxlength="250"
                                          value="<?php echo $des->getRem_speciales(TRUE); ?>" />
      </div>
      <hr />
      <div style="font-size: xx-large; color: red;">
       Cliquez sur ce bouton pour enregistrer &rArr;&rArr;&rArr;&rArr; <input
           type="submit" value="Enregistrer"
           style="font-size: xx-large; color: purple" />
       &lArr;&lArr;&lArr;&lArr;
      </div>
     </form>
    </div>
   </div>
  </body>
 </html>
 <?php
}
?>
