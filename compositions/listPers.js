$(document).ready(function () {
 dispMenu(".COMPOSITIONS");
 if ($("#myTable").length) {
  $("#myTable").tablesorter({
   headerTemplate: '{content}{icon}',
   dateFormat: "ddmmyyyy"
  });
 }
});