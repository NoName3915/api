<?php
// this will end the session and would direct the user to the main page for login/signup
session_start();

session_destroy();

header("Location: index.php");
exit;
