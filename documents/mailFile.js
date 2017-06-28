$(document).ready(function () {
 dispMenu(".DOCUMENTS");
 $(document).ajaxStart(function () {
  $("#wait").show();
  $("#lstEle").hide();
 });
 $(document).ajaxStop(function () {
  $("#wait").hide();
  $("#lstEle").show();
 });
 day = new Date();
 updateList("#mycl");
 $("#dateIx").datepicker({
  yearRange: '2016:2017',
  dateFormat: 'dd/mm/yy',
  altField: '#dateI',
  altFormat: 'yy-mm-dd',
  dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi',
   'Vendredi', 'Samedi'],
  dayNamesMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
  changeFirstDay: false,
  monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
   'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
  defaultDate: new Date(day.getTime() + 187200000),
  minDate: new Date(day.getTime() + 100800000)
 });
 $("#btnAdd").button();
 $("#btnAdd").click(function (event) {
  addAll();
  event.preventDefault();
 });
 $("#btnDel").button();
 $("#btnDel").click(function (event) {
  delAll();
  event.preventDefault();
 });
 printEle = new Array();
 render = true;
});

function rgClick(active) {
 $("#mycl").hide();
 $("#mycluster").hide();
 $("#allcl").hide();
 $(active).show();
 updateList(active);
}

function updateList(div) {
 $("#lstEle").empty();
 switch (div) {
  case "#mycl":
  case "#allcl":
   $.post("mailFileGet.php", {
    sw: 'classe',
    id: escape($(div).val())
   }, function (xml) {
    $("#lstEle").append($(xml));
   }, "html");
   break;
  case "#mycluster":
   $.post("mailFileGet.php", {
    sw: 'cluster',
    id: escape($(div).val())
   }, function (xml) {
    $("#lstEle").append($(xml));
   }, "html");
   break;
 }
}

function addEle(iam, nome, prenome, code) {
 var line = code + '@' + nome + ' ' + prenome + '@' + iam;
 if ($.inArray(line, printEle) == -1) {
  printEle.push(line);
 }
 if (render == true) {
  printEle.sort();
  renderList();
 }
}

function addAll() {
 render = false;
 $.each($(".ele"), function (index, value) {
  $(this).click();
 });
 printEle.sort();
 renderList();
 render = true;
}

function delAll() {
 delete printEle;
 printEle = new Array();
 renderList();
}

function renderList() {
 $('#selEle').empty();
 // var table = $('#selEle').append('<table>');
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
     onclick: 'deleteMe("' + eleve + '");',
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
 tr = null;
 td = null;
 $('.btn').button({
  icons: {
   primary: 'ui-icon-close'
  },
  text: false
 });
 $('#tot').replaceWith(
         "<div id=\"tot\"> El&egrave;ves s&eacute;lectionn&eacute;s:"
         + printEle.length + "</div>");
}

function deleteMe(line) {
 printEle.splice(printEle.indexOf(line), 1);
 renderList();
}

function checkform() {
 var OK = true;
 var msg = '';
 if ($('#dateI').val() == 'X') {
  $('#dateIx').attr('style', 'color:red;width:450px; border:none');
  OK = false;
  msg += "Il faut indiquer une date.\n";
 }
 if ($("#edtFile").val() == '') {
  $("#errFile").attr('style', 'color:red;');
  OK = false;
  msg += "Il faut choisir un fichier.\n";
 }
 if (printEle.length == 0) {
  OK = false;
  msg += "Il faut s�lectionner au moins un �l�ve.\n";
 }
 if (OK) {
  var lst = '';
  $('#iams').empty();
  for (var i = 0; i < printEle.length; i++) {
   eleve = printEle[i];
   elements = eleve.split("@");
   lst += elements[2] + '*';
  }
  $('#iams').append('<input name="iams" type="text" value="' + lst + '" />');
  return true;
 } else {
  alert(msg);
  return false;
 }
}
