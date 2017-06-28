$(document).ready(function () {
 dispMenu(".DOCUMENTS");

 $("#btnAdd").button();
 $("#btnAdd").click(function (event) {
  $(".chkIAM").attr('checked', 'checked');
  event.preventDefault();
 });

 $("#btnDel").button();
 $("#btnDel").click(function (event) {
  $(".chkIAM").removeAttr('checked');
  event.preventDefault();
 });
 $("#dateStartx").datepicker(
         {
          yearRange: '2016:2017',
          dateFormat: 'dd/mm/yy',
          altField: '#dateStart',
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
 $("#dateEndx").datepicker(
         {
          yearRange: '2016:2017',
          dateFormat: 'dd/mm/yy',
          altField: '#dateEnd',
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
 $("#btnPDF").button();
 $("#btnPDF").click(function (event) {
  if ($(".chkIAM:checked").length == 0) {
   alert("Il faut sélectionner au moins un élève.");
   event.preventDefault();
  }
 });
});

function loadpers() {
 $("#tmp").remove();
 $("#btnAdd").show();
 $("#btnDel").show();
 $("#btnPDF").show();
 $("#wait").ajaxStart(function () {
  $(this).show();
 });
 $("#wait").ajaxStop(function () {
  $(this).hide();
  $("#frm").show();
 });
 $.post("invoiceGetEleves.php", {
  classe: escape($("#cl").val())
 }, function (xml) {
  $("#chkEle").empty();
  $("#chkEle").append($(xml));
 }, "html");
}
