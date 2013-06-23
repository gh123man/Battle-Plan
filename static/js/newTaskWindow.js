
jQuery(function($){
      
      
  $('#newTaskButton').click(function(){
  
    $('#newTaskWindow').dialog({
      modal: true,
      width: '650',
      height: '450',
      title: 'New Task',
      resizable: false,
      position: 'center',
      close: function(ev, ui) {
                //$('#dropZoneProfile').html('drop image here');
                //$('#buttonZone').html('');
            },
    });
    return false;
  });
  
  //$('#newTaskWindow').html("drop image here");
  
  
});
  
  
function requestTask(item) {

    var tName = encodeURIComponent(item.tName.value);
    var description = encodeURIComponent(item.description.value);
    var deadline = encodeURIComponent(item.deadline.value);

    var send = "name=" + tName + "&description=" + description + "&deadline=" + deadline + "&parent=" + ID;

    $.ajax({
        url: "/ajax/createTask.php",
        type: "post",
        async: false,
        data: send,
        success: function(result) {
            var obj = jQuery.parseJSON(result);
            console.log(obj);
            if (obj['result'] == false) {
            
                $("#TaskResult").html('You Must supply a name and description');
                
            } else if (obj['result'] == true) {
                document.location.reload(true);
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
    

