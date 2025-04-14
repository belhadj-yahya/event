<?php
require_once "conection/conect_to_db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST["info"][0];
    $last_name = $_POST["info"][1];
    $email = $_POST["info"][2];
    $password = $_POST["info"][3];
    $confirem = $_POST["info"][4];
    if ($password === $confirem) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sheck = $con->prepare("SELECT * FROM users where  email = ?");
        $sheck->execute([$email]);
        $sheck = $sheck->fetch(PDO::FETCH_ASSOC);
        if(empty($sheck)){
            $add_user = $con->prepare("INSERT INTO users(first_name, last_name, email, password) VALUES(?,?,?,?)");
            $add_user->execute([$user_name, $last_name, $email, $password_hash]);
            $user_id = $con->lastInsertId();
            $_SESSION["user"] = [
                "user_id" => $user_id,
                "user_fname" => $user_name,
                "user_lname" => $last_name,
                "user_email" => $email
            ];
            echo "ok";
            exit();
        } else {
            echo "Email already exists";
            exit();
        }
    } else {
        echo "Passwords do not match";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main_css_files/sign_in.css">
    <title>sign in</title>
</head>

<body>
    <form method="POST">
        <p class="message"></p>
        <div>
            <label for="username">first name:</label>
            <input type="text" id="username" class="user_name" required>
        </div>
        <div>
            <label for="last_name">Last name:</label>
            <input type="text" class="last_name" required>
        </div>
        <div>
            <label for="password">Email:</label>
            <input type="email" class="email" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" class="password" required>
        </div>
        <div>
            <label for="password">Confirem Password:</label>
            <input type="password" class="confirem" required>
        </div>
        <div class="sign">
            <input type="submit" value="Submit">
            <span>allready have an accounte? <a href="logIn.php">Log in</a></span>
        </div>


    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="main_script_files/sign_in.js"></script>
</body>

</html>