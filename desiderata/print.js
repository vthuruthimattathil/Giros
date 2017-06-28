$(document).ready(function() {
 dispMenu(".DESIDERATA");
});

function pdf() {
 myWindow = window.open("pdesiderata.php", "_blank");
 if (typeof (myWindow) != "undefined") {
  myWindow.focus;
 } else {
  alert("Il faut désactiver le pop-up blocker!");
 }
}