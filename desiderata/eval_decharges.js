$(document).ready(function () {
 dispMenu(".DESIDERATA");
 $("#myTable").tablesorter({
  headerTemplate: '{content}{icon}',
  dateFormat: "ddmmyyyy"
 });
});
