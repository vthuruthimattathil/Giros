$(document).ready(function () {
 dispMenu(".RETENUES");
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
