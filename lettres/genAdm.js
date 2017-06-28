$(document).ready(
  function() {
    if (!window.Globalize) window.Globalize = {
      format: function(number, format) {
        number = String(this.parseFloat(number, 10) * 1);
        format = (m = String(format).match(/^[nd](\d+)$/)) ? m[1] : 2;
        for (i = 0; i < format - number.length; i++)
          number = '0' + number;
        return number;
      },
      parseFloat: function(number, radix) {
        return parseFloat(number, radix || 10);
      }
    };
    dispMenu();
    $("#iaStartHour").spinner({
      max: 18,
      min: 8,
      numberFormat: "n2"
    }).val(15);
    $("#iaStartMinute").spinner({
      step: 5,
      max: 55,
      min: 0,
      numberFormat: "n2"
    }).val(50);
    $("#iaEndHour").spinner({
      max: 18,
      min: 8,
      numberFormat: "n2"
    }).val(16);
    $("#iaEndMinute").spinner({
      step: 5,
      max: 55,
      min: 0,
      numberFormat: "n2"
    }).val(40);

  });

function rgClick(active) {
  $("#ai").hide();
  $("#ad").hide();
  $("#an").hide();
  $("#ei").hide();
  $("#ed").hide();
  $(active).show();
}

function updateList() {
  id = $("#selCode").val();
  $("#lstEle").empty();
  $.post("genAdmGet.php", {
    id: escape(id)
  }, function(xml) {
    $("#lstEle").append($(xml));
  }, "html");
}