<?php

//for main db
//$host = "sql578.main-hosting.eu //localhost";
//$dbname = "u475920781_Dts4d";
//$username = "u475920781_Dts4e";
//$password = "Dts4e2022";

// connection details for the database
//tempo db
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
