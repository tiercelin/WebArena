
$(document).ready(function(){
    console.log( "ready!" );
});


function action(key){
    $.ajax({
        type: "POST",
        url: "webarena/arenas/sight",
        data: key,
        success: function(result){
            $("#map").html(result);
        }
    });
}

$(document).keydown(function(e){
    console.log(e.which);
    var key;
    if(e.which == 38){
        key = "top";
    }
    if(e.which == 37){
        key = "left";
    }
    if(e.which == 39){
        key = "right";
    }
    if(e.which == 40){
        key = "bottom";
    }
    
    action(key);
});
