$(document).ready(function () {
 dispMenu(".RETENUES");
 if ($("#myTable").length) {
  $("#myTable").tablesorter({
   headerTemplate: '{content}{icon}',
   dateFormat: "ddmmyyyy"
  });
 }
});
