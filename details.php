<?php
require "conection/conect_to_db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data) && !empty($data)){
        $reservation = $con->prepare("INSERT INTO resrvtion(date_now,event_id,user_id,normal_tarif,spicail_tarif) values(NOW(),?,?,?,?)");
        $reservation->execute([$data["event_id"],$_SESSION["user"]["user_id"],$data["normal"],$data["spicail"]]);
        $num_of_seates_to_add = $data["normal"]+$data["spicail"];
        $event_id=$data["event_id"];
        $change_number_of_seats = $con->exec("UPDATE evente set event_salle_quantity = event_salle_quantity + $num_of_seates_to_add WHERE event_id = $event_id");
        echo json_encode(["message"=>"your order has been added"]);
        exit();
    } else {
        header('Content-Type: application/json');
        $array_to_use = [
            "event_id" => $_SESSION["event"]["event_id"],
            "event_name" => $_SESSION["event"]["event_name"],
            "event_salle_id" => $_SESSION["event"]["event_salle_id"],
            "normal_tarif" => $_SESSION["event"]["normal_tarif"],
            "spicail_tarif" => $_SESSION["event"]["spicail_tarif"],
            "start_date" => $_SESSION["event"]["start_date"],
            "salle_name" => $_SESSION["event"]["salle_name"],
            "avilibl_seats" => $_SESSION["event"]["event_place_to_set"],
            "seats" => $_SESSION["event"]["places"],
            "user_id" => "",
        ];
        if (isset($_SESSION["user"])) {
            $array_to_use["user_id"] = $_SESSION["user"]["user_id"];
        }
        echo json_encode($array_to_use);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main_css_files/details.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <title>details</title>
</head>

<body>
    <?php include_once "includes/header.php" ?>
    <div class="pdf_stuff">
        <div class="reset">
            <?php
            echo <<<HTML
              <strong class="black_header">funTime</strong>
               <p>{$_SESSION["user"]["user_fname"]} receipt</p>
               <p>Event : {$_SESSION["event"]["event_name"]}</p>
               <p>Date : {$_SESSION["event"]["start_date"]}</p>
               <p class="total_tickets">Total tickets : </p>
               <p class="normal"></p>
               <p class="spicail"></p>
               <p class="total_price">Total price : 0MAD</p>
               <strong class="black_footer">we hope you injoy the show</strong>
            HTML;
            ?>
        </div>
        <div class="tickets">
        </div>
    </div>
    <main>
        <img src="<?php echo $_SESSION["event"]["event_img"] ?>" alt="" class="event_image">
        <div class="settings">
            <h2 class="event name"><?php echo $_SESSION["event"]["event_name"] ?></h2>
            <p class="info"><?php echo $_SESSION["event"]["event_info"] ?></p>
            <p class="count_down"></p>
            <?php
            $seats = (($_SESSION["event"]["places"] - $_SESSION["event"]["event_place_to_set"]) / $_SESSION["event"]["places"]) * 100;
            if($seats <= 20 && $seats > 0){
                echo "<p class='seats'>". round($seats,2,PHP_ROUND_HALF_UP)."%"." seats are left"."</p>";
            }
            ?>
            <div class="first_tarif">
                <p>normal tarif : <?php echo $_SESSION["event"]["normal_tarif"] ?>MAD</p>
                <div>
                    <button class="more1">+</button>
                    <form method="post">
                        <input type="text" value="0" name="number_one" id="" readonly>
                    </form>
                    <button class="less1">-</button>
                </div>
            </div>
            <div class="second_tarif">
                <p>spicail tarif : <?php echo $_SESSION["event"]["spicail_tarif"] ?>MAD</p>
                <div>
                    <button class="more2">+</button>
                    <form method="post">
                        <input type="text" value="0" name="number_two" id="" readonly>
                    </form>
                    <button class="less2">-</button>
                </div>
            </div>
            <p class="error1">you have to at list get one ticket</p>
            <p class="error2">Unfortunately, the number of seats required exceeds the number of available seats.</p>
            <form method="post" class="main_button">
                <input type="submite" value="get ticket" class="get" readonly>
            </form>
            
        </div>
    </main>
    <form method="post">
    </form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="main_script_files/details.js"></script>
    <?php include_once "includes/footer.php" ?>
</body>

</html>