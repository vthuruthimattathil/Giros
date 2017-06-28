<?php

include_once('tcpdf/tcpdf.php');
include_once ('fct.php');

class LetterPDF extends TCPDF {

    function __construct($untis, $title) {
        include_once('tcpdf//config/lang/fra.php');
        parent::__construct('P', 'mm', 'A4', true, 'UTF-8', false, false);
        parent::SetCreator(PDF_CREATOR);
        parent::SetAuthor($untis);
        parent::SetTitle($title);
        parent::setPrintHeader(false);
        parent::setPrintFooter(false);
        parent::SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        parent::SetMargins(25, 20, 20);
        parent::SetAutoPageBreak(TRUE, 20);
        parent::setLanguageArray($l);
        parent::setFontSubsetting(true);
        parent::setViewerPreferences(array("PrintScaling" => "None"));
        parent::SetAutoPageBreak(false);        
    }

    public function addTick() {
        parent::Line(5, 95, 10, 95);
    }

    public function addLogo() {
        parent::setJPEGQuality(75);
        parent::Image('/logo.jpg', 12, 12, 70, 0, 'jpeg', '', 'N', true);
    }

    public function addReference($reference = '') {
        $width = parent::GetStringWidth($reference, $fontname = 'times', $fontstyle = '', $fontsize = 12, $getarray = false);
        $x = max(41 - $width / 2, 12);
        parent::setXY($x, 34);
        parent::SetFont('times', '', 12, '', true);
        parent::Write($h = 0, $reference, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
    }

    public function addCertified() {
        $txt = "Recommandé";
        parent::setXY(105, 35);
        parent::SetFont('times', 'bu', 12, '', true);
        parent::Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
    }

    public function addAddress($civility = '', $name = '', $street = '', $postCode = '', $town = '') {
        $txt = stripslashes($civility . "\n" . $name . "\n" . $street . "\n" . $postCode . " " . $town);
        parent::SetFont('times', '', 12, '', true);
        parent::MultiCell($w = 0, $h = 1, $txt, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '105', $y = '43', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
    }

    public function addDate($date = null) {
        if (is_null($date)) {
            $date = date('Y-m-d');
        }
        $txt = sprintf("Lamadelaine, le %s", utf8_encode(fr_date_format($date)));
        parent::setXY(105, 78);
        parent::SetFont('times', '', 12, '', true);
        parent::Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
    }

    public function addFormOfAddress($form = 'Monsieur', $about = null) {
        parent::setY(100);
        if (!is_null($about)) {
            parent::SetFont('times', 'b', 12, '', true);
            parent::Write($h = 0, $about, $link = '', $fill = false, $align = 'L', $ln = false, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
            parent::setY(110);
        }
        parent::SetFont('times', '', 12, '', true);
        parent::Write($h = 0, $form . ',', $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
    }

    public function addText($txt, $align = 'J', $x = null, $y = null) {
        if (is_null($x)) {
            $x = parent::GetX();
        }
        if (is_null($y)) {
            $y = parent::GetY();
        }
        parent::MultiCell($w = 0, $h = 1, $txt, $border = '', $align, $fill = false, $ln=1, $x, $y, $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
    }

    public function addSignatures($y, $left1 = '', $left2 = '', $right1 = '', $right2 = '') {
        parent::SetFont('times', '', 12, '', true);
        parent::setXY(25, $y);
        parent::MultiCell($w = 0, $h = 1,$left1."\n". $left2, $border = '', $align = 'L', $fill = false, $ln = 1, $x = 25, parent::getY() + 2, $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
        parent::setXY(105, $y);
        parent::MultiCell($w = 0, $h = 1, $right1."\n".$right2, $border = '', $align = 'L', $fill = false, $ln = 1, $x = '105', parent::getY() + 2, $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
    }

    public function addFooter() {
        parent::Line(25, 265, 190, 265);

        parent::setY(265);
        $txt = "Adresse";
        parent::SetFont('times', 'b', 9, '', true);
        parent::Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
        $txt = "avenue de l'Europe\nL-4802 Lamadelaine\nTél.: 50 87 30 - 203 / 209\nSecrétariat du directeur";
        parent::SetFont('times', '', 9, '', true);
        parent::Write($h = 0, $txt, $link = '', $fill = false, $align = 'L', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);

        parent::setY(265);
        $txt = "Adresse postale";
        parent::SetFont('times', 'b', 9, '', true);
        parent::Write($h = 0, $txt, $link = '', $fill = false, $align = 'R', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
        $txt = "B.P. 25\nL-4701 Pétange\nTél.: 50 87 30 - 206\nSecrétariat des élèves";
        parent::SetFont('times', '', 9, '', true);
        parent::Write($h = 0, $txt, $link = '', $fill = false, $align = 'R', $ln = true, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0);
    }

    public function nextLine() {
       parent::setY(parent::getY()+5);
    }

    public function addContentRectangle() {
        parent::Rect(25, 25, 160, 247);
    }

    public function printToFile($fileName) {
        parent::Output($fileName, 'I');
    }

}

?>
