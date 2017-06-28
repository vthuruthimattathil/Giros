var choice;

$(document).ready(function () {
 dispMenu(".DESIDERATA");
 $(".regen  select").replaceWith("<span id='regen'>1</span>");
 $("#dispo1x").datepicker({
  yearRange: '2017:2017',
  dateFormat: 'dd/mm/yy',
  altField: '#dispo1',
  altFormat: 'yy-mm-dd',
  dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi',
   'Vendredi', 'Samedi'],
  dayNamesMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
  changeFirstDay: false,
  monthNames: ['Janvier', 'F&eacute;vrier', 'Mars', 'Avril', 'Mai',
   'Juin', 'Juillet', 'Ao&ucirc;t', 'Septembre', 'Octobre', 'Novembre',
   'D&eacute;cembre'],
 });
 $("#dispo2x").datepicker({
  yearRange: '2017:2017',
  dateFormat: 'dd/mm/yy',
  altField: '#dispo2',
  altFormat: 'yy-mm-dd',
  dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi',
   'Vendredi', 'Samedi'],
  dayNamesMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
  changeFirstDay: false,
  defaultDate: $.datepicker.parseDate("d m y", "15 9 17"),
  monthNames: ['Janvier', 'F&eacute;vrier', 'Mars', 'Avril', 'Mai',
   'Juin', 'Juillet', 'Ao&ucirc;t', 'Septembre', 'Octobre', 'Novembre',
   'D&eacute;cembre'],
 });

 $("#addButton").button();
 //   $("addButton").click(function() { return false; });

 $(document).ajaxStart(function () {
  $("#wait").show();
 });
 $(document).ajaxStop(function () {
  $("#wait").hide();
  sum_lecons();
 });
 $.post("fillP1get.php", {
  sw: "dispo1"
 }, function (data) {
  $("#dispo1x").datepicker("setDate", data);
 }, "json");

 $.post("fillP1get.php", {
  sw: "dispo2"
 }, function (data) {
  $("#dispo2x").datepicker("setDate", data);
 }, "json");

 $.post("fillP1get.php", {
  sw: "classes"
 }, function (data) {
  $("#selCl").append(data);
 }, "html");

 $.post("fillP1get.php", {
  sw: "choice"
 }, function (data) {
  choice = data;
  renderTable();
 }, "json");

 $("#addDlg").dialog({
  autoOpen: false,
  height: 300,
  width: 700,
  modal: true,
  buttons: {
   "Ajouter choix": function () {
    $.post("fillP1get.php", {
     sw: "complete",
     cbnc: $("#br").val()
    }, function (data) {
     cx = data;
     cx.salle = $("#salle").val();
     cx.nb_blocs = $("#bloc").val();
     cx.duree = $("#duree").val();
     choice.push(cx);
     renderTable();
    }, "json");
    $(this).dialog("close");
   },
   "Annuler": function () {
    $(this).dialog("close");
   }
  }
 });
});

function sum_lecons() {
 var lsum = 0;
 regen();
 $('#tblChoice .duree').each(function () {
  lsum = lsum + $(this).html() * 1.0;
 });
 $('.totlecons').replaceWith(
         '<div class="totlecons">Nombre total de le&ccedil;ons: ' + lsum + '</div>');
 var dsum = 0;
 $("select[name^='dech']").each(function (i) {
  if (isNaN($(this).prop('value'))) {
   dsum = dsum + 1;
  } else {
   dsum = dsum + $(this).prop('value') * 1;
  }
 });
 if ($("#regen").text() == "1") {
  dsum = dsum + 1;
 }
 $('.totdech').replaceWith(
         '<div class="totdech">Nombre total de d&eacute;charges: ' + dsum + '</div>');
 $('.totcadre').replaceWith(
         '<div class="totcadre">Grand total: ' + (lsum + dsum) + '</div>');
}

function suppressChoice(nb) {
 choice.splice(nb, 1);
 renderTable();
}

function upChoice(nb) {
 if (nb != 0) {
  choice[nb - 1] = choice.splice(nb, 1, choice[nb - 1])[0];
  renderTable();
 } else {
  alert("impossible");
 }
}

function downChoice(nb) {
 if (nb != (choice.length - 1)) {
  choice[nb + 1] = choice.splice(nb, 1, choice[nb + 1])[0];
  renderTable();
 } else {
  alert("Impossible");
 }
}

function renderTable() {
 $('#tblChoice').empty();
 $.post("fillP1get.php", {
  sw: "renderTable",
  table: choice
 }, function (data) {
  $("#tblChoice").append(data);
 }, "html");
}

function updateBranches(cl, br) {
 $(br).empty();
 $.post("fillP1get.php", {
  sw: "branches",
  classe: $(cl).val()
 }, function (data) {
  $(br).append(data);
  $(br).change();
  sum_lecons();
 }, "html");
}

function updateDuree(br, dur) {
 $(dur).empty();
 $.post("fillP1get.php", {
  sw: "duree",
  cbnc: $(br).val()
 }, function (data) {
  $(dur).append(data);
 }, "html");
}

function updateButton() {
 $.post("fillP1get.php", {
  sw: "branches",
  classe: $("#cl").val()
 }, function (data) {
  $("#br").empty();
  $("#br").append(data);
  $('#addDlg').dialog('open');
 }, "html");
}


function regen() {
 if (($("#regence1").val() != "-") || ($("#regence2").val() != "-")) {
  $(".regen").show();
  $("#regen").empty();
  $("#regen").append("1");
 } else {
  $(".regen").hide();
  $("#regen").empty();
  $("#regen").append("0");
 }
}
function test(arg) {
 $.post("fillP1get.php", {
  sw: arg
 }, function (data) {
  choice = data;
 }, "json");
}

function array_print(arr) {
 $.each(arr, function (key1, value) {
  msg = key1 + ":";
  $.each(value, function (key2, value2) {
   msg = msg + "/" + key2 + ": " + value2;
  });
  alert(msg);
 });
}
