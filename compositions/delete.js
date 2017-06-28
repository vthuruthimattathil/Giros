$(document).ready(function () {
 dispMenu(".COMPOSITIONS");

 $(document).ajaxStart(function () {
  $("#wait").show();
 });
 
 $(document).ajaxStop(function () {
  $("#wait").hide();
  if ($("#myTable").length) {
   $("#myTable").tablesorter();
  }
 })
});

function loadcomp() {
 $("#frm").show("fast");
 $.post("deleteGet.php", {
  untis: escape($("#untis").val())
 }, function (xml) {
  $("#comp").empty();
  $("#comp").append($(xml));
 }, "html");
}