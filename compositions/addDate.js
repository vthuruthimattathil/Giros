$(document).ready(function () {
 dispMenu(".COMPOSITIONS");
});

function updateTime(time) {
 $("#edtHeure").val(time);
}

function updateReservation() {
 if ($("#reservation").val() === 'X') {
  $("#edtComment").val("");
 }
 else {
  $("#edtComment").val("Réservé " + $("#reservation option:selected").text());
 }
}