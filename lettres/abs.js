$(document).ready(function () {
 dispMenu(".LETTRES");

 $("#date1x").datepicker({
  showOn: 'button',
  buttonImageOnly: true,
  buttonImage: '../css/calendar.gif',
  yearRange: '2016:2017',
  dateFormat: 'dd/mm/yy',
  altField: '#date1',
  altFormat: 'yy-mm-dd',
  dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi',
   'Vendredi', 'Samedi'],
  dayNamesMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
  changeFirstDay: false,
  changeMonth: true,
  monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
   'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre']
 });
});

function checkForm() {
 chk = true;
 $("#errorAbs").hide();
 if ($("#date1").val() == 'X') {
  chk = false;
  $("#errorAbs").show();
 }
 return chk;
}