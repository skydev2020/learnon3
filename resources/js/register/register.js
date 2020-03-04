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

    if(errors.duplicateEmail == false){
    //   document.getElementById("dup_email_prob").style.display = "none";
      return true;
    } else{
    //   document.getElementById("dup_email_prob").style.display = "block";
      return false;
    }
}


//update subjects field according to grade_id
function getSubjects(gradeId) {

    for (let grade of grades) {
        if (grade['id'] == gradeId) {
            console.log("Grade: ", grade);

            //clear subjects_box
            $("#subjects_box").html('');
            let className="even";

            for (let subject of grade['subjects']) {
                $("#subjects_box").append("<div class='"+className+"'><input type='checkbox' name='subjects' value='"
                +subject['id']+"'>&nbsp;"+subject['name']+"</div>");
                if (className=='even') {
                    className = 'odd';
                }
                else {
                    className = 'even';
                }
            }

        }
    }
}

window.addEventListener(function() {
    // select initial subjects: after loading pages
   if (grades.length>0) {
       getSubjects(grades[0].id);
   }

});
