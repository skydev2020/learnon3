//update subjects field according to grade_id
function getSubjects(gradeId) {

    for (let grade of grades) {
        if (grade['id'] == gradeId) {
            console.log("Grade: ", grade);

            //clear subjects_box
            $("#subjects_box").html('');
            let className="even";

            for (let subject of grade['subjects']) {
                $("#subjects_box").append("<div><input type='checkbox' name='subjects[]' value='"
                +subject['id']+"'>"+subject['name']+"</div>");
            }

        }
    }
}