<?php
 
include_once("../session.php");
include_once('../LetterPDF.php');
$giros = $_SESSION['GIROS'];
if (isset($_SESSION['LETTRES']['GENADM'])) {
    $data = $_SESSION['LETTRES']['GENADM'];
    $letter = new LetterPDF($giros->getUntis(), "Letter");
    switch ($data['choice']) {
        case 'ai':
            $filename = 'AI_';
            break;
        case 'ad':
            $filename = 'AA_';
            break;
        case 'an':
            $filename = 'AN_';
            break;
        case 'ei':
            $filename = 'EI_';
            break;
        case 'ed':
            $filename = 'EA_';
            break;
    }

    $codeSet = false;
    foreach ($data['ele'] as $ele) {
        $giros->sqlConnect();
        $query = sprintf("SELECT * FROM ELEVE WHERE IAM='%s'", $ele);
        $giros->sqlQuery($query);
        $row = $giros->sqlData();
        $letter->addPage();
        $letter->addTick();
        $letter->addLogo();
        $letter->addAddress($row['CIVILITE'], $row['PRENOMT'] . ' ' . $row['NOMT'], $row['RUE'], $row['CP'], $row['LOCALITE']);
        $letter->addDate();
        $letter->addFooter();
        if ($row['SEXE'] == 'M') {
            $row['des'] = "fils";
        } else {
            $row['des'] = "fille";
        }
        switch ($data['choice']) {
            case 'ai':
                generateAI($letter, $data, $row);
                break;
            case 'ad':
                generateAD($letter, $data, $row);
                break;
            case 'an':
                generateAN($letter, $data, $row);
                break;
            case 'ei':
                generateEI($letter, $data, $row);
                break;
            case 'ed':
                generateED($letter, $data, $row);
                break;
        }
        if (!$codeSet) {
            $filename.=$row['CODE'];
            $codeSet = true;
        }
        $filename.='_' . $row['IAM'];
    }
    $letter->printToFile($filename . '.pdf');
}

unset($_SESSION['LETTRES']['GENADM']);

function generateAI($letter, $data, $ele) {
    $letter->addFormOfAddress($ele['CIVILITE'], "Inscription cours d'appui");
    $letter->nextLine();
    $template = "Suite à votre demande d'inscription à des cours d'appui pour votre %s %s %s, j'ai le plaisir de vous informer que %s pourra fréquenter le cours d'appui suivant:\n";
    $txt = sprintf($template, $ele['des'], $ele['PRENOME'], $ele['NOME'], $ele['PRENOME']);
    $letter->addText($txt,'J');
    switch ($data['iaBranche']) {
        case "al":
            $branche = "Allemand";
            break;
        case "an":
            $branche = "Anglais";
            break;
        case "mt":
            $branche = "Mathématiques";
            break;
        case "fr":
            $branche = "Français";
            break;
    }
    switch ($data['iaDay']) {
        case "1":
            $day = "lundi";
            break;
        case "2":
            $day = "mardi";
            break;
        case "3":
            $day = "mercredi";
            break;
        case "4":
            $day = "jeudi";
            break;
        case "5":
            $day = "vendredi";
            break;
    }
    $y = $letter->getY()+5;
    $letter->addText($branche,'L',35,$y);
    $template = "%s de %s h %s à %s h %s";
    $txt = sprintf($template, $day, $data['iaStartHour'], $data['iaStartMinute'], $data['iaEndHour'], $data['iaEndMinute']);
    $letter->addText($txt, 'L', 75, $y, 'L',false);
    $template = "Salle: %s\n";
    $txt = sprintf($template, $data['room']);
    $letter->addText($txt, 'L',140,$y);
    $letter->setY($letter->getY()+5);
    $letter->addText("Je vous rappelle également que toute absence devra être dûment motivée et excusée.\n",'J');
    $letter->nextLine();
    $template = "Veuillez agréer, %s, mes salutations les plus distinguées.\n";
    $txt = sprintf($template, $ele['CIVILITE']);
    $letter->addText($txt,'J');
    $letter->addSignatures($letter->getY()+20, "", "", "Myriam Pierre", "Directrice adjointe");
}

function generateAD($letter, $data, $ele) {    
    switch ($data['daBranche']) {
        case "al":
            $branche = "allemand";
            break;
        case "an":
            $branche = "anglais";
            break;
        case "mt":
            $branche = "mathématiques";
            break;
        case "fr":
            $branche = "français";
            break;
    }
    $letter->addFormOfAddress($ele['CIVILITE'], "Annulation de participation au cours d'appui");
    $letter->nextLine();
    $template = "Suite à votre demande de désinscrire %s %s du cours d'appui en %s, je vous confirme que votre %s n'aura plus besoin de fréquenter ce cours d'appui à partir d'aujourd'hui.\n";
    $txt = sprintf($template, $ele['PRENOME'], $ele['NOME'], $branche, $ele['des'] );
    $letter->addText($txt,'J');
    $letter->nextLine();
    $template = "Veuillez agréer, %s, mes salutations les plus distinguées.\n";
    $txt = sprintf($template, $ele['CIVILITE']);
    $letter->addText($txt,'J');
    $letter->addSignatures($letter->getY()+20, "", "", "Myriam Pierre", "Directrice adjointe");
}

function generateAN($letter, $data, $ele) { 
    $letter->addFormOfAddress($ele['CIVILITE'], "Inscription cours d'appui");
    $letter->nextLine();
    $template = "Suite à votre demande d'inscription à des cours d'appui en %s pour votre %s %s %s, je suis au regret de vous annoncer que pour l'instant aucun cours d'appui en %s n'est proposé pour les classes de %s.\n";
    $txt = sprintf($template,$data['anBranche'], $ele['des'], $ele['PRENOME'], $ele['NOME'],$data['anBranche'], $data['anAET']);
    $letter->addText($txt,'J');
    $letter->nextLine();
    $template = "Vote demande d'inscription est pour le moment gardée en suspens; nous vous contacterons dès qu'un cours d'appui en %s sera proposé pour ces classes.\n";
    $txt = sprintf($template,$data['anBranche']);
    $letter->addText($txt,'J');
    $letter->nextLine();
    $template = "Veuillez agréer, %s, mes salutations les plus distinguées.\n";
    $txt = sprintf($template, $ele['CIVILITE']);
    $letter->addText($txt,'J');
    $letter->addSignatures($letter->getY()+20, "", "", "Myriam Pierre", "Directrice adjointe");
}

function generateEI($letter, $data, $ele) {
    $day[0]='Lundi';
    $day[1]='Mardi';
    $day[2]='Mercredi';
    $day[3]='Jeudi';
    $day[4]='Vendredi';
    $letter->addFormOfAddress($ele['CIVILITE'], "Inscription aux études surveillées");
    $letter->nextLine();
    $template = "Suite à votre demande d'inscription aux études surveillées pour votre %s %s %s, j'ai le plaisir de vous informer que %s pourra fréquenter les études surveillées suivantes:\n";
    $txt = sprintf($template, $ele['des'], $ele['PRENOME'], $ele['NOME'], $ele['PRENOME']);
    $letter->addText($txt,'J');
    $y = $letter->getY()+5;
    foreach($data['eiDay'] as $key) {
      $letter->addText($day[$key],'L',35,$y);
      $letter->addText("de 15 h 00 à 16 h 30", 'L', 65, $y, 'L',false);
      $template = "Salle: %s\n";
      $txt = sprintf($template,$data['eiRoom'][$key]);
      $letter->addText($txt, 'L',110,$y);
      $y = $letter->getY();
    }
    $letter->setY($letter->getY()+5);
    $letter->addText("Je vous rappelle également que toute absence devra être dûment motivée et excusée.\n",'J');
    $letter->nextLine();
    $template = "Veuillez agréer, %s, mes salutations les plus distinguées.\n";
    $txt = sprintf($template, $ele['CIVILITE']);
    $letter->addText($txt,'J');
    $letter->addSignatures($letter->getY()+20, "", "", "Myriam Pierre", "Directrice adjointe");
}

function generateED($letter, $data, $ele) {    
    $letter->addFormOfAddress($ele['CIVILITE'], "Annulation de participation aux études surveillées");
    $letter->nextLine();
    $template = "Suite à votre demande de désinscrire votre %s  des études surveillées du %s, je vous confirme que %s %s n'aura plus besoin de fréquenter ces études à partir d'aujourd'hui.\n";
    $txt = sprintf($template,$ele['des'],$data['ed'], $ele['PRENOME'], $ele['NOME']);
    $letter->addText($txt,'J');
    $letter->nextLine();
    $template = "Veuillez agréer, %s, mes salutations les plus distinguées.\n";
    $txt = sprintf($template, $ele['CIVILITE']);
    $letter->addText($txt,'J');
    $letter->addSignatures($letter->getY()+20, "", "", "Myriam Pierre", "Directrice adjointe");
}

?>
