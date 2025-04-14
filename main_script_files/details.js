let data;
let normal = 0;
let spicail = 0;
$(document).ready(function () {
    $(".pdf_stuff").css("display","none");
    $.ajax({
        method: "POST",
        url: "details.php",
        dataType: "json",
        success: function (response) {
            data = response;
            console.log(data)
            let targetDate = new Date(data.start_date);
   
            function updatedate(){
                let currentDate = new Date();
                let time = targetDate - currentDate;
        
                if(time <= 0){
                    $(".count_down").text("00 : 00 : 00 : 00")
                    $(".get").removeClass("get").addClass("not_get").text("you cant perches").prop("disabled", true);;
                    console.log("we arze in if time end")

                 clearInterval(int);

                }else{
                    let day = Math.floor(time / (1000 * 60 * 60 * 24));
                    let hour = Math.floor((time % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
                    let minute = Math.floor((time % (1000 * 60 * 60)) / (1000 * 60))
                    let sec = Math.floor((time % (1000 * 60)) / (1000))
            
                    $(".count_down").text(`${day}D : ${hour}H : ${minute}M : ${sec}S`)
                }
                
        
            }
            updatedate()
            let int = setInterval(updatedate,1000);
            $(".more1").on('click',function(){
                 $("input[name='number_one']").val(++normal);
            })
            $(".less1").on('click',function(){
                 if($("input[name='number_one']").val() > 0){
                    $("input[name='number_one']").val(--normal);
                }
            })
            $(".more2").on('click',function(){
                 $("input[name='number_two']").val(++spicail);
            })
            $(".less2").on('click',function(){
                if($("input[name='number_two']").val() > 0){
                    $("input[name='number_two']").val(--spicail);
                }
            })
            $(".get").on("click", function(e) {
                e.preventDefault();  
                //do this after ied     
                // $.ajax({
                //     method: "POST",
                //     url: "details.php",
                //     data: {user_id: data.user_id, normal: normal, spicail: spicail},
                //     dataType: "json",
                //     success: function(response) {
                //         console.log(response);
                //         $(".pdf_stuff").css("display","block");
                //         $(".pdf_stuff").html(`<iframe src="generate_pdf.php?id=${response.id}" style="width:100%; height:600px;"></iframe>`)
                //     },
                //     error: function(error) {
                //         console.log(error);
                //     }
                // })
                if(data.user_id == ""){
                    console.log("we are in the user id if")
                    window.location.href = "logIn.php";
                }else{
                    if($("input[name='number_two']").val() > 0 || $("input[name='number_one']").val() > 0){
                        $(".error1").css("display","none");
                        console.log(Number(data.avilibl_seats))
                        console.log(Number($("input[name='number_one']").val()))
                        console.log(Number($("input[name='number_two']").val()))
                        console.log(Number(data.seats))
                        if(Number(data.avilibl_seats) + Number($("input[name='number_one']").val()) + Number($("input[name='number_two']").val()) <= Number(data.seats)){
                            $(".error2").css("display","none");
                            data["normal"] = normal;
                            data["spicail"] = spicail;
                            data_to_add =  JSON.stringify(data);
                            $.ajax({
                                method: "POST",
                                url: "details.php",
                                data: data_to_add,
                                dataType: "json",
                                success: function(second_response){
                                    console.log("ajax has successed")
                                    console.log(second_response);
                                    let total_price = (data.normal * data.normal_tarif) + Number(data.spicail * data.spicail)
                                    $(".total_tickets").text("Total tickets:" + (Number(data.normal) + Number(data.spicail)))
                                    $(".normal").text("normal tickets:" + data.normal);
                                    $(".spicail").text("spicail tickets:" + data.spicail);
                                    $(".total_price").text("Total price:" + total_price)
                                    console.log(data.salle_name)
                                    for (let i = 0; i < data.normal; i++) {
                                        $(".tickets").append(` <div class="ticket">
                                                        <p class="black_two">funTime</p>
                                                        <div>
                                                            <h3>ID: ${data.avilibl_seats}${data.event_id}${data.user_id}</h3>
                                                            <h3>event : ${data.event_name}</h3>
                                                            <p>Salle : ${data.salle_name}</p>
                                                        </div>
                                                        <div>
                                                            <p>seate:  ${data.avilibl_seats++}</p>
                                                            <p>price:  ${data.normal_tarif}</p>
                                                        </div>
                                                        <p class='type'>type : normal tarif</p>                           
                                                    </div>`)
                                                
                                    }
                                    for (let i = 0; i < data.spicail; i++) {
                                        $(".tickets").append(` <div class="ticket">
                                                        <p class="black_two">funTime</p>
                                                        <div>
                                                            <h3>event : ${data.event_name}</h3>
                                                            <p>Salle : ${data.salle_name}</p>
                                                        </div>
                                                        <div>
                                                            <p>seate:  ${data.avilibl_seats++}</p>
                                                            <p>price:  ${data.spicail_tarif}</p>
                                                        </div>
                                                        <p>type : spicail tarif</p>
                                                    </div>`)
                                        
                                    }
                                    $(".get").prop("disabled", true);
                                    $(".get").val("wait a sec please")
                                    setTimeout(function() {
                                        $(".get").prop("disabled", false);
                                        $(".get").val("get tickets")
                                    }, 3000);
                                        $(".pdf_stuff").css("display","flex");
                                        $(".pdf_stuff").fadeOut(5000);
                                
                                    $(".seats").text(`${data.avilibl_seats}/${data.seats}`);
                                    let ticket = document.querySelector(".tickets");
                                    $("input[name='number_one']").val(0)
                                    $("input[name='number_two']").val(0)
                                    normal = 0
                                    spicail = 0
                                    let reset = document.querySelector(".reset");
                                    html2pdf().from(reset).save();
                                    html2pdf().from(ticket).save();        
                                },
                                error: function(error,two,three) {
                                    console.log("Error during AJAX request");
                                    console.log(error);
                                    console.log(two)
                                    console.log(three)
                                }
                            });
                        }else{
                            console.log("we are in if of the number issue if it bigger then number of seates")
                            $(".error2").css("display","block");
                            $(".error1").css("display","none");
                        }
                    }else{
                        console.log("we are saying if the number of ticktes less then for both of them 0")
                        $(".error1").css("display","block");
                        $(".error2").css("display","none");
                    } 
                }                
            });
        },
        error: function(error,status,gg){
            console.log(error)
            console.log(status)
            console.log(gg)
            console.log("there was an error")
        }
    });
});

