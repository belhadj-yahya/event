$(document).ready(function(){
 
    $(".out_of_date").on("click", function(e){
        e.preventDefault()
    })
    $("select").on("change", function(){
        let category = $(this).val();
        $(".category").each(function(){
            if($(this).text().includes(category)){  
                $(this).parent().css("display", "flex");
            } else {
                $(this).parent().css("display", "none");
            } 
        });
    });
    $(".filter").on("click",function(e){
        e.preventDefault()
        let time = $(".time").val();
        let time2 = $(".time2").val();
        console.log(time)
        console.log(time2)
        if(!time || !time2){
            $(".error").css("display","block");
            return false;
        }else{
           $(".error").css("display","none");
           let time_stamp = new Date(time).getTime();
           let time_stamp2 = new Date(time2).getTime();
           console.log("we are in the event each")
           $(".event").each(function(){
               let event_time_stamp = new Date($(this).find("form").find("input[name='start_date']").val()).getTime();
               let selected_value = $("select").val()
               let event_category = $(this).find(".category")
                if(event_time_stamp >= time_stamp && event_time_stamp <= time_stamp2 && event_category.text().includes(selected_value)){
                    $(this).css("display", "flex");
                } else {
                    $(this).css("display", "none");
                }
           })
        }
    
    })
});
