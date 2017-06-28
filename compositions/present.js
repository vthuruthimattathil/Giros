$(document).ready(function () {
 dispMenu(".COMPOSITIONS");

 $(document).ajaxStart(function () {
  $("#wait").show();
  $("#data").hide();
  $("#data").empty();
 });

 $(document).ajaxStop(function () {
  $("#wait").hide();
  $("#data").show();
  if ($("#dataTable").length) {
   $("#dataTable").tablesorter({
    headerTemplate: '{content}{icon}',
    dateFormat: "ddmmyyyy"
   });
  }
 });

 if ($("#myTable").length) {
  $("#myTable").tablesorter({
   headerTemplate: '{content}{icon}',
   dateFormat: "ddmmyyyy"
  });
 }
});

function updateData(id) {
 $.post("presentGet.php", {
  id: escape(id)
 }, function (xml) {
  $("#data").append($(xml));
 }, "html");
}

