$(document).ready(function () {
 dispMenu(".RETENUES");
 $(document).ajaxStart(function () {
  $("#wait").show();
 });
 $(document).ajaxStop(function () {
  $("#wait").hide();
 });
 if ($("#myTable").length) {
  $("#myTable").tablesorter({
   headerTemplate: '{content}{icon}',
   dateFormat: "ddmmyyyy"
  });
 }

});

function loadret() {
 $("#frm").show("fast");
 $.post("moveGet.php", {
  switch : 'loadret',
  untis: escape($("#untis").val())
 }, function (xml) {
  $("#ret").empty();
  $("#ret").append($(xml));
  $("#rets").tablesorter({
   headerTemplate: '{content}{icon}',
   dateFormat: "ddmmyyyy"
  });

 }, "html");
}
function checkdates() {
 $("#frm").show("fast");
 $.post("moveGet.php", {
  switch : 'loaddate',
  noretenue: $(".noret:input:checked").serialize()
 }, function (xml) {
  $("#datesret").empty();
  $("#datesret").append($(xml));
  $("#datesr").tablesorter({
   headerTemplate: '{content}{icon}',
   dateFormat: "ddmmyyyy"
  });
 }, "html");
}