<?php
//prompt an alert if not filled in properly*
if (empty($_POST["name"])) {
    echo '<script>alert("Name is required")</script>';
}

if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    echo '<script>alert("Valid email is required")</script>';
}

if (strlen($_POST["password"]) < 8) {
    echo '<script>alert("Password must be at least 8 characters")</script>';
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    echo '<script>alert("Password must contain at least one letter")</script>';
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    echo '<script>alert("Password must contain at least one number")</script>';
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    echo '<script>alert("Passwords must match")</script>';
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

//push the user input data into database
$sql = "INSERT INTO user (name, email, password_hash)
        VALUES (?, ?, ?)";
        
$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sss",
                  $_POST["name"],
                  $_POST["email"],
                  $password_hash);
                  
if ($stmt->execute()) {

    header("Location: signup-success.html");
    exit;
    
} else {
    
    //will prompt if found similar emails on the database
    if ($mysqli->errno === 1062) {
        die("email already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}
