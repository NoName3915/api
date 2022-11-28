<?php

$mysqli = require __DIR__ . "/database.php";

//Check the database for any similar emails 
//If email similarities are found will execute process-signup.php to prompt "email already taken"

$sql = sprintf("SELECT * FROM user
                WHERE email = '%s'",
                $mysqli->real_escape_string($_GET["email"]));
                
$result = $mysqli->query($sql);

$is_available = $result->num_rows === 0;

header("Content-Type: application/json");

echo json_encode(["available" => $is_available]);
