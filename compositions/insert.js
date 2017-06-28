$(document).ready(function() {
 dispMenu();
 devEle = new Array();
 updateList("#mycl");
 $("#dateCx").datepicker({
  yearRange: '2016:2017',
  dateFormat: 'dd/mm/yy',
  altField: '#dateC',
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

});

function rgClick(active) {
 $("#mycl").hide();
 $("#myCluster").hide();
 $("#allcl").hide();
 $(active).show();
 updateList(active);
}

function updateList(div) {
 $("#lstEle").empty();
 $(document).unbind("ajaxStart ajaxStop");
 $(document).ajaxStart(function() {
  $("#wait").show();
  $("#lstEle").hide();
 });
 $(document).ajaxStop(function() {
  $("#wait").hide();
  $("#lstEle").show();
 });
 switch (div) {
  case "#mycl":
  case "#allcl":
   $.post("insertGet.php", {
    sw: 'classe',
    classe: escape($(div).val())
   }, function(xml) {
    $("#lstEle").append($(xml));
   }, "html");
   break;

  case "#myCluster":
    $.post("insertGet.php", {
    sw: 'cluster',
    cluster: escape($(div).val())
   }, function(xml) {
    $("#lstEle").append($(xml));
   }, "html");
   break;

 }
}

function addEle(iam, nome, prenome, code, type) {
 var line = code + '@' + nome + ' ' + prenome + '@' + iam;
 if (($.inArray(line + '@0', devEle) == -1)
         && ($.inArray(line + '@1', devEle) == -1)) {
  line = line + '@' + type;
  devEle.push(line);
  devEle.sort();
  renderList();
  updateDates();
 }
}

function updateDates() {
 $("#lstDates").empty();
 $(document).unbind("ajaxStart ajaxStop");
 $(document).ajaxStart(function() {
  $("#wait").show();
  $("#lstDates").hide();
 });
 $(document).ajaxStop(function() {
  $("#wait").hide();
  $("#lstDates").show();
  if ($(".nodated").not(':disabled').size() > 0) {
   $("#btnSubmit").show();
   $(".nodated:checked").click();
  }
  else {
   $("#btnSubmit").hide();
  }
 });
 $.post("insertGet.php", {
  sw: 'date',
  ele: devEle
 }, function(data) {
  $("#lstDates").append($(data));
 }, "html");
}

function renderList() {
 $('#selEle').empty();
 var tbl = $('<table>');
 var tr = $('<tr>');
 var td = $('<td>');
 var btn = $('<button>');
 var inp = $('<input type="text" style="display: none;" readonly="readonly" name="ele[]"/>');
 var actuel = 0;

 var table = tbl.clone().appendTo('#selEle');
 while (actuel < devEle.length) {
  var row = tr.clone();
  table.append(row);
  for (var j = 0; j < 3; j++) {
   if (actuel < devEle.length) {
    eleve = devEle[actuel];
    elements = eleve.split("@");
    var locbtn = btn.clone().attr({
     onclick: "deleteMe('" + eleve + "');",
     id: elements[2],
     "class": 'btn'
    });
    locbtn.appendTo(td.clone().appendTo(row));
    var txt = elements[0] + ' ' + elements[1];
    if (elements[3] == 1) {
     txt = txt + ' ' + '(r&eacute;gence)';
    }
    locbtn.after(txt);
    var locinput = inp.clone().attr({
     value: eleve
    });
    locbtn.after(locinput);
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
         "<div id=\"tot\"> El&egrave;ves s&eacute;lectionn&eacute;s: " + devEle.length
         + "</div>");
}

function deleteMe(line) {
 devEle.splice(devEle.indexOf(line), 1);
 renderList();
 updateDates();
}

function checkform() {
 var ok = 0;
 if (devEle.length == 0) {
  ok++;
 }
 if ($("#txtbranche").val() == '') {
  ok++;
 }
 if ($("#txtbranche").val().length > 60) {
  alert("La descrition de la branche est trop grande.");
  return false;
 }
 if ($("#dateC").val() == 'X') {
  alert("Il faut indiquer une date.");
  return false;
 }
 if (ok != 0) {
  alert("Données incomplètes!");
  return false;
 } else {
  return true;
 }

}

