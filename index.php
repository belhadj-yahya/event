<?php
require "conection/conect_to_db.php";
session_start();
date_default_timezone_set("Africa/Casablanca");

$events = $con->query("SELECT evente.*, category.category_name, salle.salle_quentity,salle.salle_name FROM evente INNER JOIN category on evente.category_id = category.category_id INNER JOIN salle on evente.salle_id = salle.salle_id");
$events = $events->fetchAll(PDO::FETCH_ASSOC);
$categorys = $con->query("SELECT category_name FROM category");
$categorys = $categorys->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["event"])) {

        $_SESSION["event"] = [
            "event_id" => $_POST["event_id"],
            "event_salle_id" => $_POST["sell_id"],
            "event_place_to_set" => $_POST["place_to_set"],
            "places" => $_POST["places"],
            "event_img" => $_POST["event_img"],
            "event_info" => $_POST["info"],
            "event_name" => $_POST["event_name"],
            "normal_tarif" => $_POST["normal"],
            "spicail_tarif" => $_POST["spicail"],
            "start_date" => $_POST["start_date"],
            "salle_name" => $_POST["salle_name"]
        ];
        header("Location: details.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main_css_files/home.css">
    <title>home</title>
</head>

<body>
    <?php include_once "includes/header.php" ?>
    <form method="post" class="categorys">
        <p class="error">please enter a date</p>
        <label for="categorys">Select A category of your shoosing:</label>
        <select name="categorys" id="">
            <option value="">All</option>
            <?php
            foreach ($categorys as $category) {
                echo "<option value='" . $category["category_name"] . "'>" . $category["category_name"] . "</option>";
            }
            ?>
        </select>
        <div class="times">
            <div class="from">
                <label for="time">From:</label>
                <input type="date" name="time" class="time" id="">
            </div>
            <div class="to">
                <label for="time2">To:</label>
                <input type="date" name="time2" class="time2" id="">
            </div>
        </div>
        <input type="submit" class="filter" value="Search">
    </form>

    <div class="content">
        <?php
        foreach ($events as $event) {
            echo <<<HTML
                <div class="event">
                <img src="{$event['event_image']}" alt="">
                <p class="event_name">{$event["event_name"]}</p>
                <p class="end">to: {$event['start_date']}</p>
                <p class="category">category: {$event['category_name']}</p>
            HTML;
            echo <<<HTML
                <form method="POST">
                    <input type="hidden" name="event_id" value="{$event['event_id']}">
                    <input type="hidden" name="event_name" value="{$event['event_name']}">
                    <input type="hidden" name="event_img" value="{$event['event_image']}">
                    <input type="hidden" name="start_date" value="{$event['start_date']}">
                    <input type="hidden" name="sell_id" value="{$event['salle_id']}">
                    <input type="hidden" name="place_to_set" value="{$event['event_salle_quantity']}">
                    <input type="hidden" name="places" value="{$event['salle_quentity']}">
                    <input type="hidden" name="info" value="{$event['event_description']}">
                    <input type="hidden" name="normal" value="{$event['normal_tarif']}">
                    <input type="hidden" name="spicail" value="{$event['spicail_tarif']}">
                    <input type="hidden" name="salle_name" value ="{$event['salle_name']}">
            HTML;
            $start_date = time();
            $end_date = strtotime($event["start_date"]);
            if ($end_date > $start_date) {
                $seats = (($event["salle_quentity"] - $event["event_salle_quantity"]) / $event["salle_quentity"]) * 100;
                if ($seats <= 20 && $seats > 0) {
                    echo "<p class='seats'>" . round($seats, 2, PHP_ROUND_HALF_UP) . "%" . "seats are left" . "</p>";
                }
                echo "<input type='submit' value='see more' class='can_get_it' name='event'>";
            } elseif ($end_date < $start_date || $end_date === $start_date || $event["event_salle_quantity"] == $event["salle_quentity"]) {
                echo "<input type='submit' value='out of date' class='out_of_date'>";
            }
            echo <<<HTML
                </form>

            </div>
            HTML;
        }
        ?>
    </div>
    <?php include_once "includes/footer.php" ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="main_script_files/hoom.js"></script>

</body>

</html>