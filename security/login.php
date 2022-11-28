<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: index.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    
    <!--intended for front end-->
    <link rel="stylesheet" href="ui.css">
</head>
<body>
    
    <h1 align="center">Login</h1>
    
    <!-- Conditional to check the credentials -->
    <?php if ($is_invalid): ?>
        <em>Invalid login</em>
    <?php endif; ?>
    
    <form method="post">

    <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
            
          </div>

          <label for="password" class="form-label">Password</label>
          <input type="password" id="password" class="form-control" name="password" aria-describedby="passwordHelpBlock" placeholder="Enter Password">
          </div>
        <!-- <label for="email">email</label>
        <input type="email" name="email" id="email"
               value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
        
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
    -->
        
    <center> <button type="submit" class="btn btn-primary">Log in</button></center>
    </form>

    <style>
        form{
            width: 500px;
            padding: 20px;
            margin:auto;
        }
    </style>
    
</body>
</html>
