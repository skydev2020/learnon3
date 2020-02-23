var errors = {"duplicateEmail": false};
function checkMailStatus(){
    //document.getElementById("dup_email_prob").style.display = "block";

  var email=$("#email").val();// value in field email
  if (email.trim().length ==0 ) {
      return;
  }
  $.ajax({
      type:'post',
          url:'/api/checkEmail',// put your real file name
          data:{email: email},
          success:function(msg){
            //alert(msg); // your message will come here.
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
    //document.getElementById("dup_email_prob").style.display = "block";

    console.log(errors);
    if(errors.duplicateEmail == false){
    //   document.getElementById("dup_email_prob").style.display = "none";
      return true;
    }else{
    //   document.getElementById("dup_email_prob").style.display = "block";
      return false;
    }
}
