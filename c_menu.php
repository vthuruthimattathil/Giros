<?php

include_once 'c_database.php';

class c_menu extends c_database {

 // property declaration

 /* private $menu= array(array()); */
 private $menu;
 private $baseUrl;

 /* $_SERVER[SCRIPT_FILENAME] */

 function __construct($untis, $home) {
  parent::__construct($_SESSION['DATABASE']);
  $this->baseUrl = $home;
  $query = 'SELECT * from PROF where UNTIS="' . $untis . '"';
  $this->sqlConnect();
  $this->sqlQuery($query);
  $row = $this->sqlData();

  /* Documents menu */

  $items[1] = array('TITLE' => 'Liste fichiers', 'URL' => '/lstFiles.php', 'PARAM' => '', 'CODE' => 1);
  $items[2] = array('TITLE' => 'Ajouter fichier', 'URL' => '/addFile.php', 'PARAM' => '', 'CODE' => 2);
  $items[3] = array('TITLE' => 'Supprimer fichier', 'URL' => '/deleteFile.php', 'PARAM' => '', 'CODE' => 4);
  $items[4] = array('TITLE' => 'Ajouter cat&eacute;gorie', 'URL' => '/addGroup.php', 'PARAM' => '', 'CODE' => 8);
  $items[5] = array('TITLE' => 'Supprimer cat&eacute;gorie', 'URL' => '/deleteGroup.php', 'PARAM' => '', 'CODE' => 16);
 
  $items[6] = array('TITLE' => 'Envoyer document', 'URL' => '/mailFile.php', 'PARAM' => '', 'CODE' => 32); 
  $items[7] = array('TITLE' => 'Mes impressions', 'URL' => '/mydocs.php', 'PARAM' => '', 'CODE' => 64);
  $items[9] = array('TITLE' => 'Impressions', 'URL' => '/print.php', 'PARAM' => '', 'CODE' => 256);

  $items[10] = array('TITLE' => 'Ajouter bon', 'URL' => '/addV.php', 'PARAM' => '', 'CODE' => 512);
  $items[12] = array('TITLE' => 'Ajouter bon photocopieuse', 'URL' => '/addVPh.php', 'PARAM' => '', 'CODE' => 1024);
  $items[13] = array('TITLE' => 'V&eacute;rifier bons', 'URL' => '/checkV.php', 'PARAM' => '', 'CODE' => 2048);

  $items[14] = array('TITLE' => 'Factures', 'URL' => '/invoice.php', 'PARAM' => '', 'CODE' => 4096);
  $items[15] = array('TITLE' => 'D&eacute;tail facture', 'URL' => '/detailInvoice.php', 'PARAM' => '', 'CODE' => 8192);

  $items[16] = array('TITLE' => 'G&eacute;n&eacute;rer avances', 'URL' => '/generateAdvance.php', 'PARAM' => '', 'CODE' => 16384);
  $items[17] = array('TITLE' => 'Encoder avances', 'URL' => '/advance.php', 'PARAM' => '', 'CODE' => 65536);

  $this->menu['DOCUMENTS'] = array('DESCRIPTION' => 'Documents', 'URL' => '/documents', 'ITEMS' => $items, 'PERM' => $row['DOCUMENTS']);

  unset($items);

  /* Compositions menu */

  $items[1] = array('TITLE' => 'Inscrire', 'URL' => '/insert.php', 'PARAM' => '', 'CODE' => 1);

  $items[2] = array('TITLE' => 'Relev&eacute; personnel', 'URL' => '/listPers.php', 'PARAM' => '', 'CODE' => 2);
  $items[3] = array('TITLE' => 'Relev&eacute; classe', 'URL' => '/listClass.php', 'PARAM' => '', 'CODE' => 4);
  $items[4] = array('TITLE' => 'Relev&eacute; date', 'URL' => '/listDate.php', 'PARAM' => '', 'CODE' => 8);

  $items[5] = array('TITLE' => 'Pr&eacute;sences', 'URL' => '/present.php', 'PARAM' => '', 'CODE' => 16);
  $items[6] = array('TITLE' => 'Surveillance', 'URL' => '/surv.php', 'PARAM' => '', 'CODE' => 32);

  $items[7] = array('TITLE' => 'Ajouter date', 'URL' => '/addDate.php', 'PARAM' => '', 'CODE' => 64);
  $items[8] = array('TITLE' => 'Annuler date', 'URL' => '/deleteDate.php', 'PARAM' => '', 'CODE' => 128);
  $items[9] = array('TITLE' => 'Annuler composition', 'URL' => '/delete.php', 'PARAM' => '', 'CODE' => 256);
  
  $items[10] = array('TITLE' => 'Insertion manuelle', 'URL' => '/insertMan.php', 'PARAM' => '', 'CODE' => 1024);
  

  $this->menu['COMPOSITIONS'] = array('DESCRIPTION' => 'Compositions', 'URL' => '/compositions', 'ITEMS' => $items, 'PERM' => $row['COMPOSITIONS']);

  unset($items);

  /* Retenues menu */

  $items[1] = array('TITLE' => 'Inscrire', 'URL' => '/insert.php', 'PARAM' => '', 'CODE' => 1);
  $items[2] = array('TITLE' => 'Suivi', 'URL' => '/followup.php', 'PARAM' => '', 'CODE' => 2);

  $items[3] = array('TITLE' => 'Relev&eacute; personnel', 'URL' => '/listPers.php', 'PARAM' => '', 'CODE' => 4);
  $items[4] = array('TITLE' => 'Relev&eacute; classe', 'URL' => '/listClass.php', 'PARAM' => '', 'CODE' => 8);
  $items[5] = array('TITLE' => 'Relev&eacute; date', 'URL' => '/listDate.php', 'PARAM' => '', 'CODE' => 16);

  $items[6] = array('TITLE' => 'Pr&eacute;sences', 'URL' => '/present.php', 'PARAM' => '', 'CODE' => 32);
  $items[7] = array('TITLE' => 'Surveillance', 'URL' => '/surv.php', 'PARAM' => '', 'CODE' => 64);
  
  $items[8] = array('TITLE' => 'Ajouter date', 'URL' => '/addDate.php', 'PARAM' => '', 'CODE' => 128);
  $items[9] = array('TITLE' => 'Annuler date', 'URL' => '/deleteDate.php', 'PARAM' => '', 'CODE' => 256);
  $items[10] = array('TITLE' => 'Annuler retenue', 'URL' => '/delete.php', 'PARAM' => '', 'CODE' => 512);

  $items[11] = array('TITLE' => 'Insertion manuelle', 'URL' => '/insertMan.php', 'PARAM' => '', 'CODE' => 1024);
  $items[12] = array('TITLE' => 'Gestion des motifs', 'URL' => '/listM.php', 'PARAM' => '', 'CODE' => 2048);
  $items[13] = array('TITLE' => 'Gestion des travaux', 'URL' => '/listT.php', 'PARAM' => '', 'CODE' => 4096);
  
  $items[14] = array('TITLE' => 'Report', 'URL' => '/move.php', 'PARAM' => '', 'CODE' => 8192);
  $items[15] = array('TITLE' => 'Report (2)', 'URL' => '/update.php', 'PARAM' => '', 'CODE' => 16384);
  
  $items[16] = array('TITLE' => 'Best of...', 'URL' => '/hitlist.php', 'PARAM' => '', 'CODE' => 65536);

  $this->menu['RETENUES'] = array('DESCRIPTION' => 'Retenues', 'URL' => '/retenues', 'ITEMS' => $items, 'PERM' => $row['RETENUES']);

  unset($items);

  /* Lettre menu */
  
  $items[1] = array('TITLE' => 'Absences', 'URL' => '/abs.php', 'PARAM' => '', 'CODE' => 1);
  $items[2] = array('TITLE' => 'Abs. cert. m&eacute;d.', 'URL' => '/med.php', 'PARAM' => '', 'CODE' => 2);
  $items[3] = array('TITLE' => 'Abs. chambre', 'URL' => '/chambre.php', 'PARAM' => '', 'CODE' => 4);
  $items[4] = array('TITLE' => 'Abs. 40h', 'URL' => '/abs40.php', 'PARAM' => '', 'CODE' => 8);
  $items[5] = array('TITLE' => 'Mes lettres', 'URL' => '/list.php', 'PARAM' => '', 'CODE' => 16);
  $items[6] = array('TITLE' => 'Relev&eacute;', 'URL' => '/listAdm.php', 'PARAM' => '', 'CODE' => 32);
  $items[7] = array('TITLE' => 'Lettres adm', 'URL' => '/genAdm.php', 'PARAM' => '', 'CODE' => 64);
 
  $this->menu['LETTRES'] = array('DESCRIPTION' => 'Lettres', 'URL' => '/lettres', 'ITEMS' => $items, 'PERM' => $row['LETTRE']);

   unset($items);

  /* Desiderata menu */

  $items[1] = array('TITLE' => 'Remplir', 'URL' => '/fill.php', 'PARAM' => '', 'CODE' => 1);
  $items[2] = array('TITLE' => 'Imprimer', 'URL' => '/print.php', 'PARAM' => '', 'CODE' => 2);
  $items[3] = array('TITLE' => 'Consulter', 'URL' => '/consult.php', 'PARAM' => '', 'CODE' => 4);
  $items[4] = array('TITLE' => 'Synoptique', 'URL' => '/synoptique.php', 'PARAM' => '', 'CODE' => 8);
  $items[5] = array('TITLE' => 'Eval d&eacute;charges', 'URL' => '/eval_decharges.php', 'PARAM' => '', 'CODE' => 16);
 
  $this->menu['DESIDERATA'] = array('DESCRIPTION' => 'Desid&eacute;rata', 'URL' => '/desiderata', 'ITEMS' => $items, 'PERM' => $row['DESIDERATA']);

  unset($items);

  /* Divers menu */

  $items[1] = array('TITLE' => 'Charger fichier &eacute;l&egrave;ves', 'URL' => '/load.php', 'PARAM' => '', 'CODE' => 1);
  $items[2] = array('TITLE' => 'Changer mot de passe', 'URL' => '/passwd.php', 'PARAM' => '', 'CODE' => 2);
  $items[3] = array('TITLE' => 'Mes groupes', 'URL' => '/cluster.php', 'PARAM' => '', 'CODE' => 4);

  
  $this->menu['DIVERS'] = array('DESCRIPTION' => 'Divers', 'URL' => '/divers', 'ITEMS' => $items, 'PERM' => $row['DIVERS']);

  unset($items);


  /* Suivi menu */

  $items[1] = array('TITLE' => 'Inscriptions', 'URL' => '/insert.php', 'PARAM' => '', 'CODE' => 1);
  $items[2] = array('TITLE' => 'Condens&eacute;', 'URL' => '/digest.php', 'PARAM' => '', 'CODE' => 2);
  $this->menu['FOLLOWUP'] = array('DESCRIPTION' => 'Suivi', 'URL' => '/followup', 'ITEMS' => $items, 'PERM' => $row['FOLLOWUP']);

  unset($items);

  /* Quitter menu */

  $items[1] = array('TITLE' => 'Quitter', 'URL' => '/logout.php', 'PARAM' => '', 'CODE' => 1);

  $this->menu['LOGOUT'] = array('DESCRIPTION' => 'Fin', 'URL' => '', 'ITEMS' => $items, 'PERM' => 1);

 }

 public function display() {
  print("    <ul id=\"menu\">\n");
  foreach ($this->menu as $menuKey => $menuItems) {
   if ($menuItems['PERM'] != 0) {
    printf("     <li class=\"myMenu %s\">%s\n", $menuKey, $menuItems['DESCRIPTION']);
    print("      <ul>\n");
    foreach ($menuItems['ITEMS'] as $menuItemsK => $menuItem) {
     if (($menuItem['CODE'] & $menuItems['PERM']) != 0) {
      printf("       <li class=\"myMenuItem\"><a href=\"%s%s%s\" %s>%s</a></li>\n", $this->baseUrl, $menuItems['URL'], $menuItem['URL'], $menuItem['PARAM'], $menuItem['TITLE']);
     }
    }
    print("      </ul>\n");
    print("     </li>\n");
   }
  }
  print("    </ul>\n");
 }

 public function auth($scriptName) {
  $url = explode('/', $scriptName);
  $base = strtoupper($url[count($url) - 2]);
  $script = $url[count($url) - 1];
  $code = 0;
  foreach ($this->menu[$base]['ITEMS'] as $key => $value) {
   if ($value['URL'] == '/' . $script) {
    $code = $value['CODE'];
   }
  }
  return (($code & $this->menu[$base]['PERM']) != 0);
 }

}
