<?php
$dsn = "mysql:host=localhost;dbname=events_mangment";
$user = "root";
$pass = "";

try {
     $con = new PDO($dsn,$user,$pass);
     $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (PDOException $th) {
    echo "error" . $th->getMessage();
}
?>