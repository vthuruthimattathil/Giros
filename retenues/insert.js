$(document).ready(function() {
 dispMenu();
 retEle = new Array();
 updateList("#mycl");
});

function rgClick(active) {
 $("#mycl").hide();
 $("#myreg").hide();
 $("#mycluster").hide();
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

  case "#mycluster":
   $.post("insertGet.php", {
    sw: 'cluster',
    nocluster: escape($(div).val())
   }, function(xml) {
    $("#lstEle").append($(xml));
   }, "html");
   break;

  case "#myreg":
   $.post("insertGet.php", {
    sw: 'reg'
   }, function(xml) {
    $("#lstEle").append($(xml));
   }, "html");
   break;
 }
}

function addEle(iam, nome, prenome, code, type) {
 var line = code + '@' + nome + ' ' + prenome + '@' + iam;
 if (($.inArray(line + '@0', retEle) == -1)
         && ($.inArray(line + '@1', retEle) == -1)) {
  line = line + '@' + type;
  retEle.push(line);
  retEle.sort();
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
  if ($(".nodater").not(':disabled').size() > 0) {
   $("#btnSubmit").show();
   $(".nodater:checked").click();
  }
  else {
   $("#btnSubmit").hide();
  }
 });
 $.post("insertGet.php", {
  sw: 'date',
  ele: retEle
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
 while (actuel < retEle.length) {
  var row = tr.clone();
  table.append(row);
  for (var j = 0; j < 3; j++) {
   if (actuel < retEle.length) {
    eleve = retEle[actuel];
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
         "<div id=\"tot\"> El&egrave;ves s&eacute;lectionn&eacute;s: " + retEle.length
         + "</div>");
}

function deleteMe(line) {
 retEle.splice(retEle.indexOf(line), 1);
 renderList();
 updateDates();
}

function checkform() {
 var ok = 0;
 if (retEle.length == 0) {
  ok++;
 }
 if ($("#txtmotif").val() == '') {
  ok++;
 }
 if ($("#txttravail").val() == '') {
  ok++;
 }
 if ($("#txtmotif").val().length > 255) {
  alert("La descrition du motif est trop grande.");
  return false;
 }
 if ($("#txttravail").val().length > 255) {
  alert("La descrition du travail est trop grande.");
  return false;
 }
 if (ok != 0) {
  alert("Données incomplètes!");
  return false;
 } else {
  return true;
 }

}

