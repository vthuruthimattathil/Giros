$(document).ready(
  function() {
   dispMenu(".RETENUES");
   $("#dateIx").datepicker(
     {
      yearRange: '2016:2017',
      dateFormat: 'dd/mm/yy',
      altField: '#dateI',
      altFormat: 'yy-mm-dd',
      dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi',
       'Jeudi', 'Vendredi', 'Samedi'],
      dayNamesMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve',
       'Sa'],
      changeFirstDay: false,
      monthNames: ['Janvier', 'Février', 'Mars', 'Avril',
       'Mai', 'Juin', 'Juillet', 'Août', 'Septembre',
       'Octobre', 'Novembre', 'Décembre']
     });
   printEle = new Array();
   render = true;
  });

function loadClasses() {
 $("#tmpUntis").remove();
 $("#wait").ajaxStart(function() {
  $('#eleves').empty();
  $(this).show();
 });
 $("#wait").ajaxStop(function() {
  $(this).hide();
  $("#ret").tablesorter();
 });
 $.post("insertManGetClasses.php", {
  untis: escape($("#untis").val())
 }, function(xml) {
  $("#classes").empty();
  $("#classes").append($(xml));
 }, "html");
}

function loadClasseEleve(code) {
 $("#wait").ajaxStart(function() {
  $(this).show();
 });
 $("#wait").ajaxStop(function() {
  $(this).hide();
  $("#ret").tablesorter();
 });
 $.post("insertManGetEleves.php", {
  code: escape(code)
 }, function(xml) {
  $("#eleves").empty();
  $("#eleves").append($(xml));
 }, "html");

}

function loadDatesr() {
 $("#wait").ajaxStart(function() {
  //	$(this).show();
 });
 $("#wait").ajaxStop(function() {
//		$(this).hide();
  // $("#datesr").tablesorter();
 });
 $.post("insertManGetDatesr.php", {
  mat: escape(printEle)
 }, function(xml) {
  //$("#dr").empty();
  $("#dr").append($(xml));
 }, "html");

}
function swap(id) {
 $("#myCl").hide();
 $("#allCl").hide();
 $(id).show();
 if ($(id + " select").val() == '---') {

  $("#eleves").empty();
 } else {
  loadClasseEleve($(id + " select").val());
 }
}

function addEle(mat, nome, prenome, code) {
 var line = code + '@' + nome + ' ' + prenome + '@' + mat;
 if ($.inArray(line, printEle) == -1) {
  printEle.push(line);
 }
 if (render == true) {
  printEle.sort();
  renderList();
 }
}

function renderList() {
 $('#selEle').empty();
 var tbl = $('<table>');
 var tr = $('<tr>');
 var td = $('<td>');
 var btn = $('<button>');
 var actuel = 0;
 var table = tbl.clone().appendTo('#selEle');
 while (actuel < printEle.length) {
  var row = tr.clone();
  table.append(row);
  for (var j = 0; j < 3; j++) {
   if (actuel < printEle.length) {
    eleve = printEle[actuel];
    elements = eleve.split("@");
    var locbtn = btn.clone().attr({
     onclick: "deleteMe('" + eleve + "');",
     id: elements[2],
     "class": 'btn'
    });
    locbtn.appendTo(td.clone().appendTo(row));
    locbtn.after(elements[0] + ' ' + elements[1]);
   } else {
    td.clone().text('').appendTo(row);
   }
   actuel++;
  }
 }
 $('#selEle').append('<hr />');
 $('.btn').button({
  icons: {
   primary: 'ui-icon-close'
  },
  text: false
 });
 if (printEle.length == 0) {
  $('#motifs').hide();
  $('#travaux').hide();
  $('#dr').hide();
 } else {
  $('#motifs').show();
  $('#travaux').show();
  loadDatesr();
  $('#dr').show();
 }

}

function deleteMe(line) {
 printEle.splice(printEle.indexOf(line), 1);
 renderList();
}