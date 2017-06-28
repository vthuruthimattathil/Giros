$(document).ready(function () {
 dispMenu(".DOCUMENTS");
 $(document).ajaxStart(function () {
  $("#wait").show();
 });
 $(document).ajaxStop(function () {
  $("#wait").hide();
  $("#myTable").tablesorter({
  headerTemplate: '{content}{icon}',
  dateFormat: "ddmmyyyy"
 });
 });
});

function loadUntis() {
 $("#tmp").remove();
 $.post("checkVGet.php", {
  id: "untis",
  untis: escape($("#untis").val())
 }, function (html) {
  $("#jobs").empty();
  $("#jobDetail").empty();
  $("#jobs").append(html);
 }, "html");
}
function loadJobDetail(jobID) {

 $.post("checkVGet.php", {
  id: "jobs",
  jobID: escape(jobID)
 }, function (xml) {
  $("#jobDetail").empty();
  $("#jobDetail").append(xml);
 }, "html");
}