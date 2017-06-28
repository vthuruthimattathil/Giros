$(document).ready(
  function() {
   dispMenu(".COMPOSITIONS");
   $("#dateCx").datepicker(
     {
      yearRange: '2016:2017',
      dateFormat: 'dd/mm/yy',
      altField: '#dateC',
      altFormat: 'yy-mm-dd',
      dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi',
       'Jeudi', 'Vendredi', 'Samedi'],
      dayNamesMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve',
       'Sa'],
      changeFirstDay: false,
      monthNames: ['Janvier', 'Février', 'Mars', 'Avril',
       'Mai', 'Juin', 'Juillet', 'Août', 'Septembre',
       'Octobre', 'Novembre', 'Décembre']
     });
   $("#dateIx").datepicker(
     {
      yearRange: '2016:2017',
      dateFormat: 'dd/mm/yy',
      altField: '#dateI',
      altFormat: 'yy-mm-dd',
      dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi',
       'Jeudi', 'Vendredi', 'Samedi'],
      dayNamesMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve',
       'Sa'],
      changeFirstDay: false,
      monthNames: ['Janvier', 'Février', 'Mars', 'Avril',
       'Mai', 'Juin', 'Juillet', 'Août', 'Septembre',
       'Octobre', 'Novembre', 'Décembre']
     });
  });

function loadpers() {
 $("#tmp").remove();
 $("#frm").show("fast");
 $("#wait").ajaxStart(function() {
  $("wait").show()
 });
 $.post("insertManGet.php", {
  classe: escape($("#cl").val())
 }, function(xml) {
  $("#el #sel").remove();
  $("#el").append($(xml));
 }, "html");
}

function checkform() {
 var ok = 0;
 if (!$('#sel').val()) {
  ok++
 }
 if ($("#txtbranche").val() == '') {
  ok++
 }
 if ($("#dateC").val() == 'X') {
  ok++
 }
 ;
 if ($("#dateI").val() == 'X') {
  ok++
 }
 ;
 if (!$('#prof').val()) {
  ok++
 }
 ;
 if (ok != 0) {
  alert("Données incomplètes!");
  return false;
 } else {
  return true;
 }
}