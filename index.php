<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: /login.php");
    exit();
}

// Welcome message
$username = htmlspecialchars($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Welcome</title>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Welcome, user!</h1>
        <p class="lead">You have successfully logged in.</p>
        <a href="logout.php" class="btn btn-danger">Logout</a>

        <!-- <h2 class="mt-5">PHP Source Code for login.php:</h2>
        <pre><code><?php
        //  highlight_string(file_get_contents('login.php')); 
         ?></code></pre> -->
    </div>
</body>
</html>
