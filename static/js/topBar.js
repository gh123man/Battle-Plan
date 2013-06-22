$(document).ready(function() {

    $('.accountName').textfill();
    
    var height = $('.accountName').children().height();
    var dif = ((36 - height)/2)+3;
    
    $('.accountName').css('padding-top', dif)
    alignPage();
});



var pageScale = "";
var scaleWidth = 1000;


$(window).resize(function() {
     alignPage();
});


function alignPage() {

    if (pageScale != "left" && $(window).width() < scaleWidth) {
        pageScale = "left"
        $('.topBar').css("width", scaleWidth);
        $('.topBar').css("padding-right", "18px");
    }
    
    if (pageScale != "right" && $(window).width() > scaleWidth) {
        pageScale = "right"
        $('.topBar').css("width", "100%");
        $('.topBar').css("padding-right", "0px");
        
        
    }
    
    
    
}

