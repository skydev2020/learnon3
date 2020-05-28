var errors = {
    "duplicateEmail": false
};
function checkMailStatus(){
    //document.getElementById("dup_email_prob").style.display = "block";

  var email=$("#email").val().trim();// value in field email
  if (email.length ==0 ) {
      return;
  }
  $.ajax({
      type:'post',
          url:'/api/checkEmail',
          data:{email: email},
          success:function(msg){

            var obj = eval(msg);
            if (obj.exist =="no"){
                errors.duplicateEmail = false;
                document.getElementById("dup_email_prob").style.display = "none";
            }else{
                errors.duplicateEmail = true;
                document.getElementById("dup_email_prob").style.display = "block";
            }

            console.log(msg);
        }
   });
}


function submitOnValid(){
    if (errors.duplicateEmail == false) {
      return true;
    }
    return false;
}
function checkPwd() {
    if (document.tutor_frm.password.value != document.tutor_frm.password_confirmation.value) {
        document.tutor_frm.password_confirmation.setCustomValidity('Password should be matched');            
    }
    else {
        document.tutor_frm.password_confirmation.setCustomValidity('');
    }
}