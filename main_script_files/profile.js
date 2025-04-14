$(document).ready(function(){
  $(".change").on("click",function(){
     document.querySelector("dialog").showModal()
  })
  $(".close").on("click",function(){
    document.querySelector("dialog").close()
  })

  $(".send").on("click",function(event){
    event.preventDefault()
 
    let new_name = $(".n_name").val().trim()
    let new_last_name = $(".l_name").val().trim()
    let new_email = $(".n_email").val().trim()
    let new_password = $(".n_pass").val()
    let new_confirm_password = $(".n_c_pass").val()
    if(new_name != "" && new_last_name != "" && new_email != "" && new_password != "" && new_confirm_password != ""){
        if($(".insure").prop("checked")){
             if(new_password === new_confirm_password){
                $.ajax({
                    method: "POST",
                    url: "profile.php",
                    data: {fname: new_name,lname:new_last_name,nemail:new_email,npassword:new_password},
                    success: function(message){
                        $(".ok").text(message)

                    },
                    error: function(one,two,three){
                      console.log(three)
                    }

                })
             }else{
                $(".error3").css("display","block")
             }
        }else{
            $(".error1").css("display","block")
        }
    }else{
        $(".error2").css("display","block")
    }
  })
})