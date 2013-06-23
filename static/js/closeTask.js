
jQuery(function($){
      
      
  $('#closeTaskButton').click(function(){
  
    var send = "close=true&ID=" + ID;
    
     $.ajax({
        url: "/ajax/closeTask.php",
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
  });   
  
  
  $('#openTaskButton').click(function(){
  
    var send = "open=true&ID=" + ID;
    
     $.ajax({
        url: "/ajax/closeTask.php",
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
  });   
  
  
});

