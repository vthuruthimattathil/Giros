$(document).ready(function () {
 dispMenu();

 $(document).ajaxStart(function () {
  $("#displayCluster").hide(); 
  $("#wait").show();
 });

 $(document).ajaxStop(function () {
  $("#wait").hide();
  $("#displayCluster").show();
 });

 $(".btn").button();
 $("#exitBtn").button();
 $("#addClusterBtn").on("click",function () {addBtnClicked()});
 updateView();

});

var clusterEleve;
var classList;


// --------------------------------------------------------------

function addBtnClicked() {
 description=$("#addClusterDescription").val().trim();
 if (description) {
  $("#addClusterDescription").val("");
  $.post("clusterGet.php",
   { sw: 'newCluster',
     description: encodeURIComponent(description),
   });
 } else {
  alert("La description ne doit pas être vide!");
 }
 updateView();
}

// --------------------------------------------------------------

function deleteCluster(id) {
  $.post("clusterGet.php",
   { sw: 'deleteCluster',
     noCluster: encodeURIComponent(id)
   }
  );
 updateView();
}

// --------------------------------------------------------------

function deleteMe(id) {
 delete clusterEleves[id];
 renderCluster();
}

// --------------------------------------------------------------

function addMe(id) {
 var tmp={};
 tmp[id]=classList[id];
 $().extend(clusterEleves, tmp);
 renderCluster();
}

// --------------------------------------------------------------

function updateCluster(id) {
 $(document).ajaxStop(function() {
  updateView();
  $(document).unbind('ajaxStop');
  $(document).ajaxStop(function () {
   $("#wait").hide();
   $("#displayCluster").show();
  });
 });
 $.post("clusterGet.php",
       { sw: 'updateCluster',
         noCluster: id,
         data: clusterEleves
       },  
       function(data) {
        alert(data);
       },
       "json"
      );
}

// --------------------------------------------------------------

function renderCluster(noCluster) {
 const COLUMNS=4;
 var tr = $('<tr>');
 var td = $('<td>');
 var btn = $('<button>');
 $('#clusterEleves').empty();
 var table = $('<table>').attr({id: noCluster});
 table.appendTo('#clusterEleves');
 var index=0;
 var row;
 $.each(clusterEleves,function(IAM,value) {
  if(index==0) {
   row=tr.clone();
   row.appendTo(table); 	
  }
  var cell=td.clone();  
  var button = btn.clone().attr({
   onclick: 'deleteMe("' + value.IAM + '");',
   "class": 'btn'
  });
  button.appendTo(cell);
  button.after(value.CODE+' '+value.NOME+' '+value.PRENOME);
  cell.appendTo(row);
  index=(index+1)%COLUMNS;
 });
 for(var i=index;i<COLUMNS;i++) {
  td.clone().text('').appendTo(row);
 }
 if(clusterEleves != null) {
  $('.btn').button({
   icons: {
    primary: 'ui-icon-close'
   },
   text: false
  });
 }
}

// --------------------------------------------------------------

function renderClass() {
 const COLUMNS=4;
 var tr = $('<tr>');
 var td = $('<td>');
 var btn = $('<button>');
 $('#classList').empty();
 var table = $('<table>').appendTo('#classList');
 var index=0;
 var row;
 $.each(classList,function(IAM,value) {
  if(index==0) {
   row=tr.clone();
   row.appendTo(table); 	
  }
  var cell=td.clone();  
  var button = btn.clone().attr({
   onclick: 'addMe("' + value.IAM + '");',
   "class": 'addBtn'
  });
  button.appendTo(cell);
  button.after(value.NOME+' '+value.PRENOME);
  cell.appendTo(row);
  index=(index+1)%COLUMNS;
 });
 for(var i=index;i<COLUMNS;i++) {
  td.clone().text('').appendTo(row);
 }
 $('.addBtn').button({
  icons: {
   primary: 'ui-icon-plus'
  },
  text: false
 });
}

// --------------------------------------------------------------

function modifyCluster(noCluster) {

 function updateData(noCluster) {
  renderCluster(noCluster);
  renderClass();
  $(document).unbind('ajaxStop');
  $(document).ajaxStop(function () {
   $("#wait").hide();
   $("#displayCluster").show();
  });
 }

 $(document).ajaxStop(function() {
   updateData(noCluster);
   $( "#clusterForm" ).dialog({
   resizable: true,
   height: "auto",
   width: "auto",
   modal: true,
   buttons: {
    "Confirmer": function() {
      updateCluster(noCluster);
      $(this).dialog( "close" );
     },
     "Annuler": function() {
      $(this).dialog( "close" );
     }
   }
  });
 });

 $.post("clusterGet.php",
  { sw: 'getCluster',
    noCluster: encodeURIComponent(noCluster)
  },  
  function(data) {
   if(data==null) {
    clusterEleves={};
   } else {
    clusterEleves=data;
   }
  },
  "json"
  );

 $.post("clusterGet.php",
  { sw: 'getClass',
    code: encodeURIComponent($("#classes").val())
  },  
  function(data) {
   classList=data;
  },
  "json"
  );

}

// --------------------------------------------------------------

function loadClass() {

 function updateData() {
  renderClass();
  $(document).unbind('ajaxStop');
  $(document).ajaxStop(function () {
   $("#wait").hide();
   $("#displayCluster").show();
  });
 }

 $(document).ajaxStop(function() {updateData();});

 $.post("clusterGet.php",
  { sw: 'getClass',
    code: encodeURIComponent($("#classes").val())
  },  
  function(data) {
   classList=data;
  },
  "json"
  ); 
}

// --------------------------------------------------------------

function updateView() {
  $.post("clusterGet.php",
   { sw: 'getAllCluster'},
   function(data) {
    if (data==-1) {
     $("#tableClusters").empty();
     $("#tableClusters").append("<h3>Pas de groupes</h3>");

    } else {
     $("#tableClusters").empty();
     $("#tableClusters").append(data); 
     $("#clusterTable").tablesorter(
      { headerTemplate: '{content}{icon}',
        headers: {2:{sorter:false}}
      });
     $(".deleteClass").button();
     $(".updateClass").button();
    }
   },
   "html"
  );
}

