<?php

session_start();

//check if the user exist on the database

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Index</title>
        <meta charset="UTF-8">
        
        <!-- style from front team -->
        <link rel="stylesheet" href="ui.css">
    </head>
    <body>
        <!-- Main Landing Page goes here -->
        <h1>Data Management System</h1>
        
        <?php if (isset($user)): ?>        
        
            <p>Hello <?= htmlspecialchars($user["name"]) ?></p>
            
            <p><a href="logout.php">Log out</a></p>            
        
        <?php else: ?>
            
            <p><a href="login.php">Log in</a> or <a href="signup.html">sign up</a></p>
            
        <?php endif; ?>
        
    </body>
</html>
