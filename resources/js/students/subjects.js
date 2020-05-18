
//update subjects field according to grade_id
function getSubjects(gradeId) {

    for (let grade of grades) {
        if (grade['id'] == gradeId) {
            console.log("Grade: ", grade);

            //clear subjects_box
            $("#subjects_box").html('');
            let className="even";

            for (let subject of grade['subjects']) {
                let checked =" ";
                for (let i=0; i<subjects.length; i++) {
                    if (subjects[i].id==subject['id']) {
                        checked = " checked ";
                        break;
                    }
                }

                $("#subjects_box").append("<div class='"+className+"'><input type='checkbox' name='subjects[]' value='"
                +subject['id'] + " '" + checked + ">&nbsp;"+subject['name']+"</div>");
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

window.addEventListener('load', function() {
    // select initial subjects: after loading pages
   
    getSubjects(grade_id);
   
});
