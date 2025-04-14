$(document).ready(function () {
    $("input[name='sign']").on("click",function(e){
        
      e.preventDefault()
      $.ajax({
        method: "POST",
        url: "logIn.php",
        data: {email: $(".email").val(),pass: $(".pass").val()},
        success: function(response){
          console.log(response)
           if(response == "ok"){
             window.history.back();
           }else{
            $("form").prepend(response)
           }
        }
      })
    })

});