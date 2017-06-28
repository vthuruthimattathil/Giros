$(document).ready(function () {
 dispMenu(".DOCUMENTS");
 $("#dateIx").datepicker({
  yearRange: '2016:2017',
  dateFormat: 'dd/mm/yy',
  altField: '#dateI',
  altFormat: 'yy-mm-dd',
  dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi',
   'Jeudi', 'Vendredi', 'Samedi'],
  dayNamesMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve',
   'Sa'],
 // changeFirstDay: false,
  monthNames: ['Janvier', 'Février', 'Mars', 'Avril',
   'Mai', 'Juin', 'Juillet', 'Août', 'Septembre',
   'Octobre', 'Novembre', 'Décembre']
 });
 $(document).ajaxStart(function () {
  $("#wait").show();
 });
 $(document).ajaxStop(function () {
  $("#wait").hide();
  $('#qte').val($('#mycl').val());
  $('#classe').val($("#mycl option:selected").attr("id"));
 });
 $.post("addVGet.php", {
  UNTIS: escape($("#untis").val())
 }, function (html) {
  $("#divmycl").empty();
  $("#divmycl").append(html);
 }, "html");
});

function rgclick(a, b) {
 $(a).show();
 $(b).hide();
 $('#qte').val($(a).val());
 $('#classe').val($(a + " option:selected").attr('id'));
}

function lstclasse(unt) {
 $(document).unbind("ajaxStop");
 $(document).ajaxStop(function () {
  $("#wait").hide();
  rgclick('#mycl', '#allcl');
  $('#myrgclasses').prop("checked", true);
 });
 $.post("addVGet.php", {
  UNTIS: escape($("#untis").val())
 }, function (html) {
  $("#divmycl").empty();
  $("#divmycl").append(html);
 }, "html");
}
function updateClasse(lst) {
 $('#qte').val($(lst).val());
 $('#classe').val($(lst + " option:selected").attr('id'));
}

function checkform() {
 ok = true;
 $("#errQte").hide();
 $("#errPages").hide();
 $("#errDate").hide();
 $('#dateIx').attr('style', 'color:black;width:450px; border:none');
 qte = parseInt($("#qte").val());
 if (isNaN(qte) || qte <= 0) {
  $("#errQte").show();
  ok = false;
 }
 pge = parseInt($("#pages").val());
 if (isNaN(pge) || pge <= 0) {
  $("#errPages").show();
  ok = false;
 }
 if ($('#dateI').val() == 'X') {
  $("#errDate").show();
  $('#dateIx').attr('style', 'color:red;width:450px; border:none');
  ok = false;
 }
 return ok;
}

