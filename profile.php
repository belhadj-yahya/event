<?php
require_once "conection/conect_to_db.php";
session_start();
if (!isset($_SESSION["user"])) {
    header('Location: logIn.php');
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["out"])) {
        unset($_SESSION["user"]);
        header('Location: index.php');
        exit();
    }
}
$id = $_SESSION["user"]["user_id"];
$history_events = $con->query("SELECT * FROM evente JOIN resrvtion on resrvtion.event_id = evente.event_id where user_id = $id");
$history_events = $history_events->fetchAll(PDO::FETCH_ASSOC);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["fname"])){
        $password = password_hash($_POST["npassword"],PASSWORD_DEFAULT);
        $id = $_SESSION["user"]["user_id"];
        $change = $con->prepare("UPDATE users set first_name = ?, last_name = ?, password = ?,email = ? WHERE user_id = $id");
        $change->execute([$_POST["fname"],$_POST["lname"],$password,$_POST["nemail"]]);
        echo "your information has been changed";
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main_css_files/profile.css">
    <title>Document</title>
</head>

<body>
    <?php include_once "includes/header.php" ?>
    <div class="intro">
        <h1>Welcome, <?php echo $_SESSION["user"]["user_fname"] ?>!</h1>
        <div class="intro_div">
            <button class="change"><img src="icons/gear-solid.svg" alt="settings"></button>
            <dialog>
                <div class="content">
                    <button class="close">X</button>
                    <form method="post">
                        <div class="d">
                            <label for="new_name">New Name:</label>
                            <input type="text" class="n_name" name="new_name" require>
                        </div>
                        <div class="d">
                            <label for="new_last_name">New Last Name:</label>
                            <input type="text" class="l_name" name="new_last_name" require>
                        </div>
                        <div class="d">
                            <label for="new_email">New Email:</label>
                            <input type="email" class="n_email" name="new_email" require>
                        </div>
                        <div class="d">
                            <label for="new_password">New Password:</label>
                            <input type="password" class="n_pass" name="new_password" require>
                        </div>
                        <div class="d">
                            <label for="con_new_password">Confirm New Password:</label>
                            <input type="password" class="n_c_pass" name="con_new_password" require>
                        </div>
                        <div class="check">
                            <input type="checkbox" name="insure" class="insure"  id="" require>
                            <label for="insure">I am Aware That I Will Change My Informations</label>
                        </div>
                        <input type="submit" class="send" value="submit changese">
                        <div class="messages">
                            <p class="error1">you have to click the checkbox above</p>
                            <p class="error2">you have to fill all inputs</p>
                            <p class="error3">passwords are not matching</p>
                            <p class="ok"></p>
                        </div>
                    </form>
                </div>
            </dialog>
            <form method="post">
                <input type="submit" name="out" value="Sign Out">
            </form>
        </div>
        
    </div>
    <div class="history">
        <h2>Your Previous Events:</h2>
        <div class="line">
            <?php
            foreach ($history_events as $event) {
                echo <<<HTML
              <div class="event">
                 <img src="{$event['event_image']}" alt="event img">
                 <h3>{$event['event_name']}</h3>
                 <p>Date: {$event['start_date']}</p>
                 <p>teckets took at : {$event["date_now"]}</p>
                 <p>event discrption: {$event['event_description']}</p>
              </div>
            HTML;
            }
            ?>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="main_script_files/profile.js"></script>
    <?php include_once "includes/footer.php" ?>
</body>

</html>