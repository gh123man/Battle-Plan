
$(document).ready(function(){
    $("#username").focus();
});

function handleKey(e,data){
    if (document.getElementById("username").value.length > 0 && document.getElementById("password").value.length > 0) {
        var key=e.keyCode || e.which;
            if (key==13){
            checkCreds();
        }
    } else  if (data.id == "username") {
        var key=e.keyCode || e.which;
            if (key==13){
            $("#password").focus();
        }
    } else  if (data.id == "password") {
        var key=e.keyCode || e.which;
            if (key==13){
            checkCreds();
        }
    }
}

function checkCreds() {
    var send = "username=" + encodeURIComponent(document.getElementById("username").value) + "&password=" + encodeURIComponent(document.getElementById("password").value) + "&autoLogin=" + encodeURIComponent(document.getElementById("autoLogin").checked);
    
    $.ajax({
        url: "/ajax/checkLogin.php?login=true",
        type: "post",
        async: false,
        data: send,
        success: function(result){
            if (result == 1) {
                document.location.reload(true);
            } else if (result == 0) {
                $("#credsOut").html("You must fill out both fields");
            } else if (result == 2) {
                $("#credsOut").html("Account does not exist");
                $("#username").select();
            } else if (result == 3) {
                $("#credsOut").html("Incorrect Password");
                $("#password").select();
            } else {
                console.log("error");
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

function checkRegister() {

    var send = "username=" + encodeURIComponent(document.getElementById("newusername").value) + "&password=" + encodeURIComponent(document.getElementById("newpassword").value)  + "&password1=" + encodeURIComponent(document.getElementById("renewpassword").value) + "&fname=" + encodeURIComponent(document.getElementById("fname").value) + "&lname=" + encodeURIComponent(document.getElementById("lname").value) + "&regautoLogin=" + encodeURIComponent(document.getElementById("autoLoginReg").checked);
    
    $.ajax({
        url: "/ajax/checkLogin.php?register=true",
        type: "post",
        async: false,
        data: send,
        success: function(result){
            console.log(result);
           if (result == 1) {
                document.location.reload(true);
            } else {
                document.getElementById("regOut").innerHTML=result;
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



