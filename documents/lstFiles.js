$(document).ready(function() {
 dispMenu(".DOCUMENTS");
 $("#files").accordion({
  header: 'h1',
  collapsible: true,
  event: 'click',
  heightStyle: 'content',
  icons: true,
  animated: false,
  active: false
 });

});