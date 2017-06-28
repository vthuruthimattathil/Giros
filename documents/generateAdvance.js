$(document).ready(function() {
 dispMenu(".DOCUMENTS");
 $("#btnAll").button();
 $("#btnAll").click(function(event) {
  $(".chkClass").prop("checked", true);
  event.preventDefault();
 });
 $("#btnNone").button();
 $("#btnNone").click(function(event) {
  $(".chkClass").prop("checked", false);
  event.preventDefault();
 });
 $("#btnGo").button();
});
