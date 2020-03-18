function onreceiverchanged(){
    console.log("receiverchange");
    if ($("#receivers").val() == "2")
    {
        $('#receiver_box').html('');
        $("#receiver_box").append("<div class = 'form-group row'> <div class = 'col-3 d-flex justify-content-end'> <label for = 'user_group' class = 'form-control-label font-weight-bold'> User Group </label> </div> <div class = 'col-6'> <select id = 'user_group' name = 'user_group' class = 'form-control'> <option value = '1'>Administrator</option> <option value = '2'>Tutors</option> <option value = '3'>Students</option> </select> </div> </div>"); 
    }

    else if ($("#receivers").val() == "3")
    {
        $("#receiver_box").html('');
        $("#receiver_box").append("<div class = 'form-group row'> <div class = 'col-3 d-flex justify-content-end'> <label for = 'user_filter' class = 'form-control-label font-weight-bold'> User: </label> </div> <div class = 'col-6' id = 'user_box'> <input type = 'text' id = 'user_filter' name = 'user_filter' class = 'form-control' required autocomplete = 'user_filter' autofocus onkeyup = 'onStoppedTyping(this.value);'> </input> </div> </div>");
        $('#user_box').append("<ul class = 'list-group' id = 'user_list'></ul>");
        $('#user_box').append("<div id = 'suser_list' class = 'scrollbox pl-1 pt-1 overflow-auto' ></div>");
    }
}

function onStoppedTyping(search_name)
{
    var selected_users = users.filter(function (user) {
        return (user.fname.includes(search_name) || user.lname.includes(search_name));
    });

    $('#user_list').empty();
    for(let user of selected_users)
    {
        $('#user_list').append("<li class = 'ui-autocomplete-category' onclick = 'onSelectUser(this);return false;' value = '" + user.id + "'> <a href = '#'>" + user.fname + ' ' + user.lname + 
        "</a> </li>");
    } 
    $('#user_box').append("</ul>");
}

function onSelectUser(elem)
{
    var user = users.find(function(element){
        return element.id == elem.value;
    });
    var string = user.fname + ' ' + user.lname;

    $('.scrollbox').append("<div> <input type = 'text' id = 'user[]' name = 'user[]' hidden value = '" + elem.value + "'>" + string + "</input> </div>");
    elem.parentNode.removeChild(elem);
}