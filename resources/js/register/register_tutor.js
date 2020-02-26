var errors = {"duplicateEmail": false};
function checkName() {
    if(document.getElementById("terms_val").checked == false) return;

    var n1 = document.getElementById("name1").value;
    var n2 = document.getElementById("name2").value;
    var n3 = document.getElementById("name3").value;

    var fname = document.getElementById("fname").value;
    var lname = document.getElementById("lname").value;

    var full_name = fname + ' '+ lname;
    if(full_name!=n1  || full_name!=n2 || full_name!=n3){
    alert('Names do not match !!');
    document.getElementById("register").disabled = true;
    document.getElementById("terms_val").checked = false;
    }else{
        document.getElementById("register").disabled = false;
    }
}


function submitOnValid(){
    //document.getElementById("dup_email_prob").style.display = "block";

    if(errors.duplicateEmail == false){
    //   document.getElementById("dup_email_prob").style.display = "none";
      return true;
    }else{
    //   document.getElementById("dup_email_prob").style.display = "block";
      return false;
    }
}
