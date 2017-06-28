$(document).ready(
  function() {
   dispMenu(".DOCUMENTS");
   $("#myTable").tablesorter({
    headerTemplate: '{content}{icon}'
   });
  });
