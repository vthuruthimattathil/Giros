$(document).ready(function () {
 dispMenu(".DOCUMENTS");
 $("#classTable").tablesorter({
  headerTemplate: '{content}{icon}',
  dateFormat: "ddmmyyyy"
 });
 $(document).ajaxStart(function () {
  $("wait").show();
 });
 $(document).ajaxStop(function () {
  $("wait").hide();
 });
});

function loadpers() {
 $("#tmp").remove();
 $.post("detailInvoiceGetEleves.php", {
  classe: escape($("#cl").val())
 }, function (xml) {
  $("#chkEle").empty();
  $("#jobs").empty();
  $("#chkEle").append($(xml));
 }, "html");
}
function loadDetail(IAM) {
 $.post("detailInvoiceGetJobs.php", {
  IAM: escape(IAM)
 }, function (xml) {
  $("#jobs").empty();
  $("#jobs").append($(xml));
 }, "html");
}