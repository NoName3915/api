<?php

// connection details for the database
$host = "localhost";
$dbname = "login_db";
$username = "root";
$password = "";

// create a database table to store it in
$mysqli = new mysqli(hostname: $host,
                     username: $username,
                     password: $password,
                     database: $dbname);
                     
if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;
