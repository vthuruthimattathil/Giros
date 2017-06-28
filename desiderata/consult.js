$(document).ready(function () {
 dispMenu(".DESIDERATA");
 if ($("#untis").length > 0) {
  loaddes();
 }
});

function loaddes() {
 $("#frm").show("fast");
 $(document).ajaxStart(function () {
  $("wait").show();
 });
 $.post("getconsult.php", {
  untis: escape($("#untis").val())
 }, function (xml) {
  $("#des").empty();
  $("#des").append($(xml));
 }, "html");
}
