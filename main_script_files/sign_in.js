$(document).ready(function () {
    $("input[type='submit']").on("click", function(e){
        e.preventDefault();
        let email = $(".email").val();
        let pass = $(".password").val();
        let repass = $(".confirem").val();
        let name = $(".user_name").val();
        let last_name = $(".last_name").val();
        $.ajax({
            type: "POST",
            url: "sign_in.php",
            data: {info:[name, last_name, email, pass,repass]},
            success: function (response) {
                console.log(response)
                if (response === "ok") {
                    // Redirect to the new location after success
                    window.location.href = 'index.php';
                }else{
                    $(".message").text(response)
                }                
            }
        });
    })
});