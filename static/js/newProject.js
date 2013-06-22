
var hold = "";

function newProject(item) {
    hold = $(item).html();
    $(item).html('<form method="post" name="newProject" id="newProject"> \
    Name: <input type="text" name="pName" id="pName"> \
    Description: <input type="text" name="description" id="description"> \
    Deadline: <input type="text" name="deadline" id="deadline"> \
    <input TYPE="button" Value="Create" onClick="requestProject(this.parentNode)" /> \
    </form> \
    <input TYPE="button" Value="close" onClick="cancelNewProject(this.parentNode)" />');
    
}

function cancelNewProject(item) {
    $(item).html(hold);
}

function requestProject(item) {
    
    var pName = encodeURIComponent(item.pName.value);
    var description = encodeURIComponent(item.description.value);
    var deadline = encodeURIComponent(item.deadline.value);
    
    var send = "name=" + pName + "&description=" + description + "&deadline=" + deadline;
   
    $.ajax({
            url: "/ajax/createProject.php",
            type: "post",
            async: false,
            data: send,
            success: function(result) {
                var obj = jQuery.parseJSON(result);
                console.log(obj);
                if (obj['result'] == false) {
                
                    $(item).html(newProject);
                    $("#result").html('You Must supply at least a first name');
                    
                } else if (obj['result'] == true) {
                    window.location = "/";
                }
                    
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(
                    "The following error occured: "+
                    textStatus, errorThrown
                );
            }
        });
}        
    


