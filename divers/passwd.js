$(document).ready(function () {
 dispMenu();
 $("#newPasswd1OK").hide();
 $("#newPasswd2OK").hide();
 $("#changeButton").hide();

});

function checkRule(passwd) {
 var rule = /^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$/;  
 if(passwd.match(rule)) {   
  return true;  
 }  
 else {   
  return false;  
 }
}  

function checkPwd() {
 old=$("#oldPasswd").val().trim();
 passwd1=$("#newPasswd1").val();
 passwd2=$("#newPasswd2").val();
 if (checkRule(passwd1)) {
  $("#newPasswd1OK").show()
  $("#newPasswd1Cancel").hide();
 } else {
  $("#newPasswd1OK").hide();
  $("#newPasswd1Cancel").show();
 }
 if (checkRule(passwd2)&&(passwd1.valueOf()==passwd2.valueOf())) {
  $("#newPasswd2OK").show()
  $("#newPasswd2Cancel").hide();
 } else {
  $("#newPasswd2OK").hide();
  $("#newPasswd2Cancel").show();
 }
 if (checkRule(passwd2)&&(passwd1.valueOf()==passwd2.valueOf())&&(old.length!=0)) {
  $("#changeButton").show();
 } else {
  $("#changeButton").hide();
 }
}
