var errors = {
    "duplicateEmail": false,
    "nameMatch": false
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

function checkName() {
    if(document.getElementById("terms_val").checked == false) return;

    var n1 = document.getElementById("name1").value;
    var n2 = document.getElementById("name2").value;
    var n3 = document.getElementById("name3").value;

    var fname = document.getElementById("fname").value;
    var lname = document.getElementById("lname").value;

    var full_name = fname + ' '+ lname;
    if(full_name!=n1  || full_name!=n2 || full_name!=n3){

        document.getElementById("register").disabled = true;
        document.getElementById("terms_val").checked = false;
        document.getElementById("name_match").style.display = "block";
    }
    else {
        document.getElementById("register").disabled = false;
        errors.nameMatch = true;
        document.getElementById("name_match").style.display = "none";
    }
}

function submitOnValid(){
    if (errors.duplicateEmail == false && errors.nameMatch == true) {
      return true;
    }
    return false;
}
