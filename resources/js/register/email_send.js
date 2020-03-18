function onreceiverchanged(){
    console.log("receiverchange");
    if ($("#receivers").getVal() == "2")
    {
        $("#receiver_box").append("<div class = 'form-group row'> <select id = 'user_group'> <option value = '1'>Administrator</option> <option value = '2'>Tutors</option> <option value = '3'>Students</option>"); 
    }
}