$(document).ready(function () {
 dispMenu(".DOCUMENTS");
 $("#myTable").tablesorter({
  headerTemplate: '{content}{icon}'
 });
});

function checkPages(me) {
 if (isNaN(me.value) || ($.trim(me.value)).length == 0) {
  me.value = '???';
 } else {
  me.value = parseInt(me.value);
 }
}

function checkform() {
 check = true;
 $(".check").each(function (i) {
  if (this.checked) {
   x = $((this.name).replace("check_", "#pages_")).val();
   if (isNaN(x) || ($.trim(x)).length == 0) {
    check = false;
   }
  }
 });
 if (check) {
  return true;
 } else {
  alert('Toutes les impressions finies doivent comporter un nombres de pages!');
  return false;
 }
}
function voucher(nocommande) {
 bon = window.open("about:blank", "Bon");
 bon.location.href = "voucher.php?id=" + nocommande;
}    