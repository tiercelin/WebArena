
$.document.ready(function(e){
    document.write("pret");
});

function action(key){
    $.ajax({
        type: "POST",
        url:key,
        data: key,
        success: function(){
            
        }
    });
}

$.document.keydown(function(e){
    var key;
    if(e.which == 38){
        key = $("#top");
    }
    if(e.which == 37){
        key = $("#left");
    }
    if(e.which == 39){
        key = $("#right");
    }
    if(e.which == 40){
        key = $("#bottom");
    }
    
    action(key);
});
