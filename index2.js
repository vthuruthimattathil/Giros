$(document).ready(function () {
 dispMenu();
 if ($("#myFollowup").length) {
  $("#myFollowup").tablesorter({
   headerTemplate: '{content}{icon}',
   dateFormat: "ddmmyyyy"
  });
 }
});