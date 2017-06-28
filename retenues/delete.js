$(document).ready(function () {
 dispMenu(".RETENUES");
});

function loadret() {
 $("#tmp").remove();
 $(document).ajaxStart(function () {
  $("#wait").show();
 });
 $(document).ajaxStop(function () {
  $("#wait").hide();
  $("#myTable").tablesorter({
   headerTemplate: '{content}{icon}',
   dateFormat: "ddmmyyyy"
  }
  );
 });
 $.post("deleteGet.php", {
  untis: escape($("#untis").val())
 }, function (xml) {
  $("#ret").empty();
  $("#ret").append($(xml));
 }, "html");
}
