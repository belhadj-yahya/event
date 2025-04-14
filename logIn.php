<?php
require_once "conection/conect_to_db.php";
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST["email"]) && isset($_POST["pass"])) {
        $user = $con->prepare("SELECT * FROM users WHERE email = ?");
        $user->execute([$_POST["email"]]);
        $user = $user->fetch(PDO::FETCH_ASSOC);
        if (!empty($user)) {
            if (password_verify($_POST["pass"], $user["password"])) {
                $_SESSION["user"] = [
                    "user_id" => $user["user_id"],
                    "user_fname" => $user["first_name"],
                    "user_lname" => $user["last_name"],
                    "user_email" => $user["email"]
                ];
                echo "ok";
                exit();
            } else {
                echo "<p class='error'>uncurret password</p>";
                exit();
            }
        }else{
            echo "<p class='error'>no user was found with this email</p>";
            exit();
        }
    } else {
        echo "<p class='error'>you have to fill both fields</p>";
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main_css_files/login.css">
    <title>log In</title>
</head>
<body>
    <form method="POST">
        <div>
            <label for="email">Email :</label>
            <input type="text" name="email" class="email" require>
        </div>
        <div>
            <label for="pass">Password: </label>
            <input type="password" name="pass" class="pass" require>
        </div>
        <input type="submit" name="sign" value="sign in">
        <p>You don't have an account? <a href="sign_in.php">sign in</a></p>
    </form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="main_script_files/login.js"></script>
</body>

</html>