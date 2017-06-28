var stages = {};

$(document).ready(function () {
 dispMenu(".FOLLOWUP");
 $(".retQ").change(function () {
  updateView();
 });
 $(".pitstopQ").change(function () {
  updateView();
 });
 $("#addStageButton").button();
 $("#addDlg").dialog({
  autoOpen: false,
  height: 400,
  width: 700,
  modal: true,
  open: function (event, ui) {
   $("#stageTravail").val("");
   $("#stageEntreprise").val("");
   $("#stageDate").prop('selectedIndex', 0);
  },
  buttons: {
   "Ajouter stage": function () {
    result = true;
    if ($("#stageTravail").val().length > 200) {
     alert("Desription du travail trop longue.");
     result = false;
    }
    if ($("#stageTravail").val().length < 5) {
     alert("Description du travail trop brève");
     result = false;
    }
    if ($("#stageEntreprise").val().length < 1) {
     alert("Entreprise manque");
     result = false;
    }
    if (result) {
     $.post('insertGetData.php', {
      FCT: 'UID'
     }, function (result) {
      var line = new Object();
      line['ENTREPRISE'] = $("#stageEntreprise").val();
      line['NOSUIVIELEVESTAGE'] = result;
      line['PERIODED'] = $("#stageDate option:selected").text();
      line['PERIODEF'] = $("#stageDate").val();
      line['TRAVAIL'] = $("#stageTravail").val();
      stages[result] = line;
      renderStages();
     });
     $(this).dialog("close");
    }
   },
   "Annuler": function () {
    $(this).dialog("close");
   }
  }
 });
 $(document).ajaxStart(function () {
  $("#wait").show();
  $("#frm").hide();
 });
 $(document).ajaxStop(function () {
  $("#wait").hide();
  $("#frm").show();
 });
});

function updateButton() {
 $('#addDlg').dialog('open');
}

$(document).ajaxError(function () {
 $("#frm").hide();
 $("#wait").hide();
 alert("Une Erreur s'est produite. Veuillez essayer une nouvelle fois");
});


function updateView() {
 tot = 0;
 $(".retQ").each(function () {
  tot += $(this).val() * 1;
 });
 $("#retTotal").text(tot);
 tot = 0;
 $(".pitstopQ").each(function () {
  tot += $(this).val() * 1;
 });
 $("#pitstopTotal").text(tot);
 tot = 0;
 num = true;
 $(".absQ").each(function () {
  num = num && checkNumInput($(this).val(), 0, 1200);
  tot += $(this).val() * 1;
 });
 if (num) {
  $("#absTotal").text(tot);
  $(".absError").hide();
 }
 else {
  $("#absTotal").text("Erreur");
 }
}

function loadData(ele) {
 $.post('insertGetData.php', {
  FCT: 'Data',
  IAM: escape(ele)
 }, function (result) {
  obj = $.parseJSON(result);
  $.each(obj, function (index, value) {
   ids = index.split("*");
   $(ids[0]).prop(ids[1], value);
  });
  updateView();
  $("#IAM").val(ele);
 });
 $.post('insertGetData.php', {
  FCT: 'Stage',
  IAM: escape(ele)
 }, function (result) {
  tmp = $.parseJSON(result);
  if (tmp === -1) {
   stages = {};
  }
  else {
   stages = $.parseJSON(result);
  }

  renderStages();
 });
}

function renderStages() {
 $('#stages').empty();
 if (!$.isEmptyObject(stages)) {
  html = "<table>";
  html += "<tr><th></th><th>Entreprise</th><th>Travail</th><th>Date</th></tr>";
  $.each(stages, function (index, value) {
   html + "<tr>";
   html += "<td><button class=\"ui-state-default ui-corner-all stageButton\" type=\"button\" onclick=\"suppressChoice('" + index + "') \"><span class=\"ui-icon ui-icon-circle-close\"></span></button></td>";
   html += "<td><input type=\"text\" name=\"stage[" + value.NOSUIVIELEVESTAGE + "][ENTREPRISE]\" value=\"" + value.ENTREPRISE + "\" readonly=\"readonly\" /></td>";
   html += "<td><input type=\"text\" name=\"stage[" + value.NOSUIVIELEVESTAGE + "][TRAVAIL]\" value=\"" + value.TRAVAIL + "\" readonly=\"readonly\" /></td>";
   html += "<td><input type=\"text\" name=\"stage[" + value.NOSUIVIELEVESTAGE + "][PERIODED]\" value=\"" + value.PERIODED + "\" readonly=\"readonly\" /></td>";
   html += "<td><input type=\"text\" name=\"stage[" + value.NOSUIVIELEVESTAGE + "][PERIODEF]\" value=\"" + value.PERIODEF + "\" readonly=\"readonly\" style=\"display: none\"/></td>";
   html += "</tr>";
  });
  html += "</table>";
  $('#stages').append(html);
  $('.stageButton').button();
 }
 /*    console.log(index);
  console.log(value.ENTREPRISE);
  console.log(value.TRAVAIL);*/
}

function suppressChoice(index) {
 delete stages[index];
 renderStages();
}

function checkForm() {
 pass = true;
 $(".error").hide();
 tot = 0;
 $(".absQ").each(function (index) {
  val = $(this).val();
  if (checkNumInput(val, 0, 1200)) {
   tot += $(this).val() * 1;
  } else {
   $(this).parent().next().show();
   pass = false;
  }
 });
 $("#absTotal").text(tot);
 if ($("#lcRem").val().length > 255) {
  $("#lcRemError").show();
  pass = false;
 }
 if ($("#retRem").val().length > 255) {
  $("#retRemError").show();
  pass = false;
 }
 if ($("#conRem").val().length > 255) {
  $("#conRemError").show();
  pass = false;
 }
 if ($("#absRem").val().length > 255) {
  $("#absRemError").show();
  pass = false;
 }
 if ($("#pitstopRem").val().length > 255) {
  $("#pitstopRemError").show();
  pass = false;
 }
 if ($("#rem").val().length > 255) {
  $("#remError").show();
  pass = false;
 }
 if (!pass) {
  alert("Erreur(s) de saisie!");
 }
 return pass;
}

function checkRange(x, min, max) {
 if (x >= min && x <= max) {
  return true;
 }
 else {
  return false;
 }
}

function checkNumInput(n, min, max) {
 if (!isNaN(parseFloat(n)) && isFinite(n) && checkRange(n, min, max)) {
  return true;
 } else {
  return false;
 }

}
