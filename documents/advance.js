$(document).ready(function () {
 dispMenu(".DOCUMENTS");
 IAMEle = new Array();
 $("#btnEncode").button();
 $("#btnEncode").click(function (event) {
  if ($("#chkEncode").prop("checked")) {
   $.post("advanceGet.php", {
    sw: 'encode',
    IAM: IAMEle
   }, function (data) {
    $("#result").empty();
    $("#result").append(data);
   }, "html");
  }
  event.preventDefault();
 });
 $(document).ajaxStart(function () {
  $("#wait").show();
 });
 $(document).ajaxStop(function () {
  $("#wait").hide();
  if ($("#chkEncode").prop("checked")) {
   IAMEle = new Array();
  }
  $("#chkEncode").prop("checked", false);
  renderList();
 });
});

function addIAM() {
 if ($("#edtIAM").val().length > 7) {
  IAM = $("#edtIAM").val();
  $("#edtIAM").val('');
  $.post("advanceGet.php", {
   sw: 'info',
   IAM: IAM
  }, function (data) {
   addEle(data.IAM, data.nome, data.prenome, data.code, data.credit,
           $("#edtAmount").val());
  }, "json");
 }
}

function addEle(IAM, nome, prenome, code, credit, amount) {
 var line = code + '@' + nome + ' ' + prenome + '@' + IAM + '@' + credit + '@'
         + amount;
 if ($.inArray(line, IAMEle) == -1) {
  IAMEle.push(line);
 }
 IAMEle.sort();
}

function renderList() {
 $('#lstEle').empty();
 var tbl = $('<table>');
 var tr = $('<tr>');
 var td = $('<td>');
 var btn = $('<button>');
 var actuel = 0;
 var total = 0;

 var table = tbl.clone().appendTo('#lstEle');
 while (actuel < IAMEle.length) {
  var row = tr.clone();
  table.append(row);
  for (var j = 0; j < 3; j++) {
   if (actuel < IAMEle.length) {
    eleve = IAMEle[actuel];
    elements = eleve.split("@");
    var locbtn = btn.clone().attr({
     onclick: "deleteMe('" + eleve + "');",
     id: elements[2],
     "class": 'btn'
    });
    locbtn.appendTo(td.clone().appendTo(row));
    locbtn.after(elements[0] + ' ' + elements[1] + ' ' + elements[3] + '+'
            + elements[4]);
    total = total + elements[4] * 1;
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
         "<div id=\"tot\"> El&egrave;ves s&eacute;lectionn&eacute;s: " + IAMEle.length
         + " Montant encaiss&eacute;: " + total + "</div>");
}

function deleteMe(line) {
 IAMEle.splice(IAMEle.indexOf(line), 1);
 renderList();
}
