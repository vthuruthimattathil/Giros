$(document).ready(function () {
 dispMenu(".LETTRES");
 if ($("#myTable").length) {
  $("#myTable").tablesorter({
   headerTemplate: '{content}{icon}',
   dateFormat: "ddmmyyyy"
  });
 }
});