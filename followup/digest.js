$(document).ready(function () {
 dispMenu(".FOLLOWUP");
 $(document).ajaxStart(function () {
  $("#wait").show();
  $("#data").hide();
 });
 $(document).ajaxStop(function () {
  $("#wait").hide();
  $("#data").show();
 });
 if ($("#rgClasse").length) {
  updateData($("#rgClasse:checked").val());
 };
});

function updateData(classe) {
 $("#data").empty();
 $.post("digestGet.php", {
  classe: classe
 }, function (data) {
  $("#data").append(data);
   if ($("#myTable").length) {
  $("#myTable").tablesorter({
   headerTemplate: '{content}{icon}',
   dateFormat: "ddmmyyyy"
  });
 }
 }, "html");
}