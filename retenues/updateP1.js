$(document).ready(function () {
 dispMenu(".RETENUES");
 $(document).ajaxStart(function () {
  $("#wait").show();
 });
 $(document).ajaxStop(function () {
  $("#wait").hide();
 });
 if ($("#dateTable").length) {
  $("#dateTable").tablesorter();
 }
});

function loadret() {
 $("#frm").show("fast");
 $.post("updateGet.php", {
  noretenue: escape($("#noretenue:checked").val())
 }, function (xml) {
  $("#ret").empty();
  $("#ret").append($(xml));
  $(".datesr").tablesorter({
   headerTemplate: '{content}{icon}',
   dateFormat: "ddmmyyyy"
  });
 }, "html");
}

function checkForm() {
 if (typeof $("#nodater:checked").val() === 'undefined') {
  alert('Il faut sélectionner une nouvelle date');
  return false;
 } else {
  return true;
 }
}