function moveRight(){
    $.ajax({
            url:"ArenasController.php", //the page containing php script
            type: "post", //request type,
            dataType: 'json',
            success:function(result){

             console.log(result.abc);
           }
         });
}