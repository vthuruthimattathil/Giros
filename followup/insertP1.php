<?php

function showForm() {
 include_once("../session.php");
 include_once("../c_menu.php");
 $giros = $_SESSION['GIROS'];
 $menu = new c_menu($giros->getUntis(), $giros->getUrl());
 if (!$menu->auth($_SERVER['SCRIPT_NAME'])) {
  header("Location: " . $giros->getErrorUrl());
 }
 ?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">

  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
   <title>Suivi - Inscription</title>
   <link rel="stylesheet" href="../css/jquery-ui.structure.css" type="text/css" />
   <link rel="stylesheet" href="../css/jquery-ui.theme.css" type="text/css" />
   <link rel="stylesheet" href="../css/layout.css" type="text/css" />
   <script type="text/javascript" src="../jquery/jquery.js"></script>
   <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
   <script type="text/javascript" src="../menu.js"></script>
   <script type="text/javascript" src="insertP1.js"></script>
  </head>
  <body>
      <?php include ("../logo.php"); ?>
   <div id="ww">
    <div id="sidemenu">
        <?php $menu->display(); ?>
    </div>
    <div id="cont">
     <h1>Inscription</h1>
     <?php
     $giros->sqlConnect();
     $query = sprintf("SELECT CODE FROM CLASSE WHERE REGENT='%s' ORDER BY CODE", $giros->getUntis());
     $giros->sqlQuery($query);
     $nb = $giros->sqlNumRows();
     if ($nb == 0) {
      ?>
      <p>Vous n'&ecirc;tes pas r&eacute;gent.</p>
      <p>Cette fonctionalit&eacute; est r&eacute;serv&eacute;e aux r&eacute;gents.</p>
      <?php
     } else {
      ?>
      <h2>S&eacute;lectionnez l'&eacute;l&egrave;ve</h2>
      <div>
       <select id="ele" name="eleve" size="1" onchange="$('#selTmp').remove();
           loadData($('#ele').val());">
        <option id="selTmp" value="-" >Choix:</option>
        <?php
        $query = sprintf("SELECT IAM,NOME,PRENOME,CODE FROM ELEVE LEFT JOIN CLASSE USING(CODE) WHERE REGENT='%s' ORDER BY CODE,NOME,PRENOME", $giros->getUntis());
        $giros->sqlQuery($query);
        if ($nb == 1) {
         while ($row = $giros->sqlData()) {
          printf("    <option value=\"%s\">%s %s</option>\n", $row['IAM'], htmlentities($row['NOME']), htmlentities($row['PRENOME']));
         }
        } else {
         while ($row = $giros->sqlData()) {
          printf("    <option value=\"%s\">%s - %s %s</option>\n", $row['IAM'], $row['CODE'], htmlentities($row['NOME']), htmlentities($row['PRENOME']));
         }
        }
        ?>
       </select>
       <br />
      </div>
      <div id="wait" style="display: none;">
       <p style="color: red;">Chargement en cours, veuillez patienter...</p>
      </div>
      <form  id="frm" style="display: none;" action="insert.php" method="post" enctype="multipart/form-data" onsubmit="return checkForm();" >

       <div id="student">
        <h1>El&egrave;ve: <input type="text" id="dataStudent" readonly="readonly" value="?" size="50"></input></h1>
        <input  name="IAM" type="text" readonly="readonly" style="display: none;" id="IAM" value="?"></input>
        <!-- Inscriptions livre de classe -->
        <h2>Inscriptions dans le livre de classe:</h2>
        <p>Nombre:
         <select name="lcNb" id="lcNb">
             <?php generateOption(0, 40); ?>
         </select>
        </p>
        <p>
         Remarques &eacute;ventuelles:<br />
         <textarea name="lcRem" id="lcRem" cols="50" rows="5"></textarea>
        </p>
        <p class="error" id="lcRemError" style="color: red; display: none; " >Remarque trop longue!</p>
        <!-- Retenues -->
        <h2>Retenues:</h2>
        <table>
         <thead>
          <tr><th>Motif:</th><th>Nombre:</th><th>Motif:</th><th>Nombre:</th></tr>
         </thead>
         <tfoot>
          <tr><td>Total:</td><td id="retTotal">0</td><td></td><td></td></tr>
         </tfoot>
         <tbody>
          <tr>
           <td>Bagarre:</td>
           <td>
            <select name="retBag" id="retBag" class="retQ">
                <?php generateOption(0, 40); ?>
            </select>
           </td>
           <td>Retards fr&eacute;quents:</td>
           <td>
            <select name="retRet" id="retRet" class="retQ">
                <?php generateOption(0, 40); ?>
            </select>
           </td>
          </tr>
          <tr>
           <td>Absences non excus&eacute;es:</td>
           <td>
            <select name="retAbsNon" id="retAbsNon" class="retQ">
                <?php generateOption(0, 40); ?>
            </select>
           </td>
           <td>Abus de confiance:</td>
           <td>
            <select name="retConf" id="retConf" class="retQ">
                <?php generateOption(0, 40); ?>
            </select>
           </td>
          </tr>
          <tr>
           <td>Comportement non admissible:</td>
           <td>
            <select name="retComp" id="retComp" class="retQ">
                <?php generateOption(0, 40); ?>
            </select>
           </td>
           <td>Fraude:</td>
           <td>
            <select name="retFraude" id="retFraude" class="retQ">
                <?php generateOption(0, 40); ?>
            </select>
           </td>
          </tr>
          <tr>
           <td>Insolence:</td>
           <td>
            <select name="retInsol" id="retInsol" class="retQ">
                <?php generateOption(0, 40); ?>
            </select>
           </td>
           <td>Tabagisme:</td>
           <td>
            <select name="retTabac" id="retTabac" class="retQ">
                <?php generateOption(0, 40); ?>
            </select>
           </td>
          </tr>
          <tr>
           <td>Refus d'&eacute;crire sa punition:</td>
           <td>
            <select name="retRefusPun" id="retRefusPun" class="retQ">
                <?php generateOption(0, 40); ?>
            </select>
           </td>
           <td>Mensonges:</td>
           <td>
            <select name="retMens" id="retMens" class="retQ">
                <?php generateOption(0, 40); ?>
            </select>
           </td>
          </tr>
          <tr>
           <td>Insultes:</td>
           <td>
            <select name="retInsul" id="retInsul" class="retQ">
                <?php generateOption(0, 40); ?>
            </select>
           </td>
           <td>Oublis:</td>
           <td>
            <select name="retOublis" id="retOublis" class="retQ">
                <?php generateOption(0, 40); ?>
            </select>
           </td>
          </tr>
          <tr>
           <td>Autres:</td>
           <td>
            <select name="retAutres" id="retAutres" class="retQ">
                <?php generateOption(0, 40); ?>
            </select>
           </td>
           <td></td>
           <td></td>
          </tr>
         </tbody>
        </table>
        <p> Remarques &eacute;ventuelles: <br />
         <textarea name="retRem" id="retRem" cols="50" rows="5"></textarea>
        </p>
        <p class="error" id="retRemError" style="color: red; display: none; " >Remarque trop longue!</p>
        <!-- Conseil de classe -->
        <h2>Conseil(s) de classe:</h2>
        <p>Nombre:
         <select name="conNb"  id="conNb">
             <?php generateOption(0, 5); ?>
         </select><br />
         <p>Remarques &eacute;ventuelles:</p>
         <textarea name="conRem" id="conRem" cols="50" rows="5"></textarea><br />
    <!--     Fichier &agrave; ajouter:<input name="conRapport" type="file"></input> -->
        </p>
        <p class="error" id="conRemError" style="color: red; display: none; " >Remarque trop longue!</p>
        <!-- Absences -->
        <h2>Absences:</h2>
        <table>
         <tfoot>
          <tr>
           <td>Total:</td>
           <td id="absTotal">0</td>
           <td></td>
          </tr>
         </tfoot>
         <tbody>
          <tr>
           <td>Excus&eacute;es:</td>
           <td><input type="text" name="absExc" id="absExc" class="absQ" value="0" size="3" onchange="updateView();"></input></td>
           <td class="error absError" id="absExcError" style="color: red; display:none;" >Erreur de saisie</td>
          </tr>
          <tr>
           <td>Excus&eacute;es m&eacute;dicales:</td>
           <td><input type="text" name="absExcMed" id="absExcMed" class="absQ" value="0" size="3" onchange="updateView();"></input></td>
           <td class="error absError" id="absExcMedError" style="color: red; display:none;" >Erreur de saisie</td>
          </tr>
          <tr>
           <td>Non-excus&eacute;es:</td>
           <td><input type="text" name="absNonExc" id="absNonExc" class="absQ" value="0" size="3" onchange="updateView();"></input> </td>
           <td class="error abserror" id="absNonExcError" style="color: red; display:none;" >Erreur de saisie</td>
          </tr>
         </tbody>
        </table>
        <p>
         Remarques &eacute;ventuelles:<br />
         <textarea name="absRem" id="absRem" cols="50" rows="5"></textarea><br />
        </p>
        <p class="error" id="absRemError" style="color: red; display: none; " >Remarque trop longue!</p>
        <!-- Mosaik -->
        <h2>Classe Mosa&iuml;k:</h2>
        <table>
         <thead>
          <tr>
           <th></th>
           <th>Raison:</th>
           <th></th>
           <th>Raison:</th>
          </tr>
         </thead>
         <tbody>
          <tr>
           <td><input name="mosRes" type="checkbox" id="mosRes" value="1"></input></td>
           <td>R&eacute;sultats scolaires insuffisants</td>
           <td><input name="mosAbs" type="checkbox" id="mosAbs" value="2"></input></td>
           <td>Absences nombreuses</td>
          </tr>
          <tr>
           <td><input name="mosVtt" type="checkbox" id="mosVtt" value="4"></input></td>
           <td>Retards fr&eacute;quents</td>
           <td><input name="mosOublisScol" type="checkbox" id="mosOublisScol" value="8"></input></td>
           <td>Oublis des affaires scolaires</td>
          </tr>
          <tr>
           <td><input name="mosOublisDev" type="checkbox" id="mosOublisDev" value="16"></input></td>
           <td>Oublis des devoirs &agrave; domicile</td>
           <td><input name="mosDe" type="checkbox" id="mosDe" value="32"></input></td>
           <td>D&eacute;motivation</td>
          </tr>
          <tr>
           <td><input name="mosAgress" type="checkbox" id="mosAgress" value="64"></input></td>
           <td>Agressivit&eacute;</td>
           <td><input name="mosComport" type="checkbox" id="mosComport" value="128"></input></td>
           <td>Comportement probl&eacute;matique</td>
          </tr>
          <tr>
           <td><input name="mosApathie" type="checkbox" id="mosApathie" value="256"></input></td>
           <td>Apathie</td>
           <td><input name="mosAutres" type="checkbox" id="mosAutres" value="512"></input></td>
           <td>Autres</td>
          </tr>
         </tbody>
        </table>
        <!-- PitStop -->
        <h2>Pitstop:</h2>
        <table>
         <thead>
          <tr>
           <th>Raison:</th>
           <th>Nombre</th>
           <th>Raison:</th>
           <th>Nombre:</th>
          </tr>
         </thead>
         <tfoot>
          <tr>
           <td>Total:</td>
           <td id='pitstopTotal'>0</td>
           <td></td>
           <td></td>
          </tr>
         </tfoot>
         <tbody>
          <tr>
           <td>Insultes</td>
           <td>
            <select name="pitstopInsultes"  id="pitstopInsultes" class="pitstopQ" >
                <?php generateOption(0, 15); ?>
            </select>
           </td>
           <td>Disputes avec autrui</td>
           <td>
            <select name="pitstopDisputes"  id="pitstopDisputes" class="pitstopQ">
                <?php generateOption(0, 15); ?>
            </select>
           </td>
          </tr>
          <tr>
           <td>Refus de travail</td>
           <td>
            <select name="pitstopRefusTravail"  id="pitstopRefusTravail" class="pitstopQ">
                <?php generateOption(0, 15); ?>
            </select>
           </td>
           <td>Jet d'objets</td>
           <td>
            <select name="pitstopJet"  id="pitstopJet" class="pitstopQ">
                <?php generateOption(0, 15); ?>
            </select>
           </td>
          </tr>
          <tr>
           <td>Comportement irrespectueux</td>
           <td>
            <select name="pitstopComportement"  id="pitstopComportement" class="pitstopQ">
                <?php generateOption(0, 15); ?>
            </select>
           </td>
           <td>Autres</td>
           <td>
            <select name="pitstopAutres"  id="pitstopAutres" class="pitstopQ">
                <?php generateOption(0, 15); ?>
            </select>
           </td>
          </tr>
         </tbody>
        </table>
        <p>
         Remarques &eacute;ventuelles:<br />
         <textarea name="pitstopRem" id="pitstopRem" cols="50" rows="5"></textarea><br />
        </p>
        <p class="error" id="pitstopRemError" style="color: red; display: none; " >Remarque trop longue!</p>
        <!-- Stage -->
        <h2>Stage(s)</h2>
        <button id="addStageButton" class="ui-state-default ui-corner-all" type="button" onclick="updateButton()">Ajouter stage</button>
        <div id="addDlg">
         <table>
          <tbody>
           <tr>
            <td>Entreprise:</td>
            <td>
             <input type="text" name="stageEntreprise" id="stageEntreprise" maxlength="255" style="width: 50em;"> </input>
            </td>
           </tr>
           <tr>
            <td>Travail effectu&eacute;:</td>
            <td>
             <textarea name="stageTravail" id="stageTravail" cols="45" rows="5"></textarea>
            </td>
           </tr>
           <tr>
            <td>Date</td>
            <td>
             <select id="stageDate">
                 <?php
                 if (date("n") < 9) {
                  $year = date("Y") - 1;
                 } else {
                  $year = date("Y");
                 }
                 for ($i = 9; $i < 13; $i++) {
                  printf("<option value=\"%s-%02d-01\" >%02d-%s</option>", $year, $i, $i, $year);
                 }
                 $year++;
                 for ($i = 1; $i < 8; $i++) {
                  printf("<option value=\"%s-%02d-01\" >%02d-%s</option>", $year, $i, $i, $year);
                 }
                 ?>

             </select>
            </td>
           </tr>
          </tbody>
         </table>
        </div>
        <div id="stages">

        </div>
        <!-- Orientation -->
        <h2>Orientation</h2>
        <p>
         <input type="text" name="orientation" id="orientation" maxlength="255" style="width: 50em;"> </input>
        </p>
        <!-- Remarques -->

        <h2>Remarques &eacute;ventuelles</h2>
        <p>
         <textarea name="rem" id="rem" cols="50" rows="5"></textarea>
        </p>
        <p class="error" id="remError" style="color: red; display: none; " >Remarque trop longue!</p>
        <input type="submit" value="Enregistrer"/>
       </div>
      </form>

      <?php
     }
     ?>
    </div>
   </div>
  </body>
 </html>
 <?php
}

function generateOption($min, $max) {
 for ($i = $min; $i <= $max; $i++) {
  printf("       <option value='%d'>%d</option>", $i, $i);
 }
}
?>