<?php

session_start();

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
    <title>Main Page Index</title>
    <meta charset="UTF-8">
	
    <!--front end can link their css file here-->	
    <link rel="stylesheet" href="ui.css">
</head>
<body>
    
    <h1>Data Management System</h1>
	
    <!--supposed main page or landing page, 
	will be provided ba the other team--> 
	
    <!--if users signed up or logged-in-->	
    <?php if (isset($user)): ?>
	
    <!--you can remove the temporary page and link the supposed main page here-->
        <p>Hello <?= htmlspecialchars($user["name"]) ?></p>
        
        <p><a href="logout.php">Log out</a></p>
		
    <!--if users are not don't have an account or not logged-in yet-->  
    <?php else: ?>
        
        <p><a href="login.php">Log in</a> or <a href="signup.html">sign up</a></p>
        
    <?php endif; ?>
    
</body>
</html>
    
    
    
    
    
    
    
    
    
    
    
