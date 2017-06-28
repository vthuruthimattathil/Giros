<?php

session_start();
session_unset();

function show_form($UN = "", $REPLAY = 0) {
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
        <head>
            <title>Gestion du LTMA</title>
            <link rel="stylesheet" href="css/layout.css" type="text/css" />
            <link rel="stylesheet" href="css/jquery-ui.css" type="text/css" />
            <script type="text/javascript" src="jquery/jquery.js"></script>
            <script type="text/javascript" src="jquery/jquery-ui.js"></script>
            <script type="text/javascript" src="login.js"></script>
        </head>
        <body>
            <h1 style="text-align: center">Login - 2016/2017</h1>
            <form action="login.php" method="post">
                <table border="" style="margin-left:auto; margin-right:auto;" cellpadding="3" rules="none">
                    <tr>
                        <td style="text-align: right;">Code UNTIS<br /> (en minuscules):</td>
                        <td style="vertical-align: bottom;"><input type="text" name="edtUNTIS" value="<?php echo htmlspecialchars($UN) ?>" /></td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">Password:</td>
                        <td style="vertical-align: top;"><input type="password" name="edtPasswd" /></td>
                    </tr>
                    <tr >
                        <td style="text-align: right;">Site:</td>
                        <td style="vertical-align: top;"><input type="radio" name="site" value="L" checked="checked" />Lamadelaine</td>
                    </tr>
                    <tr >
                        <td></td>
                        <td><input type="radio" name="site" value="P"  />Differdange</td>
                    </tr>
                    <?php
                    if ($REPLAY == 1) {
                        echo "   <tr>\n    <td></td>\n    <td>Donn&eacute;es incompl&egrave;tes</td>\n   </tr>\n";
                    }
                    if ($REPLAY == 2) {
                        echo "   <tr>\n    <td></td>\n    <td>Mauvais nom d'utilisateur / mot de passe</td>\n    </tr>\n";
                    }
                    ?>
                    <tr>
                        <td align="right"></td>
                        <td><input type="submit" name="submit" value="Log In" /></td>
                    </tr>
                </table>
<p align="center">En cas de probl&egrave;me avec le login, veuillez faire un mail &agrave; wagal</p>
            </form>
            <p id="browser" style="text-align:center; font-size:200%; color:red; display:none;">
                Utilisez de pr&eacute;f&eacute;rence FIREFOX (PC) ou Safari (Mac) <br />
            </p>
        </body>
    </html>
    <?php
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    show_form();
} else {
    if (empty($_POST['edtUNTIS']) || empty($_POST['edtPasswd']) || strlen(trim($_POST['edtUNTIS'])) == 0) {
        show_form($_POST['edtUNTIS'], 1);
    } else {
        $edtUntis = strtolower(trim($_POST['edtUNTIS']));
        $edtPasswd = trim($_POST['edtPasswd']);
        $mbox = @imap_open("{mail.ltma.lu:143/imap/tls/novalidate-cert}", $edtUntis, $edtPasswd, OP_HALFOPEN);
        if ($mbox != FALSE) {
            $edtUntis = strtoupper($edtUntis);
            include_once('c_giros.php');
            $giros = new c_giros($edtUntis, $_POST['site']);
            echo "Object created<br>";
            $_SESSION['GIROS'] = $giros;
            echo "Session set up<br>";
            header("Location: index2.php");
        } else {
            show_form($_POST['edtUNTIS'], 2);
        }
    }
}
?>
