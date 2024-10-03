<?php
session_start();

$valid_username = 'admin';
$salt = 'verysecuresalt';

$hashedPassword = "c23f56db3756b1d4e855583e3572bea27787615b81bd7b6e7555ed97446b3d95";

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $inputPassword = $_POST['password'];
    echo $password;
    // Simple authentication check
    if ($username === $valid_username && hash('sha256', $salt . $inputPassword) == $hashedPassword) {
        $_SESSION['username'] = $username;
        header('Location: admin.php'); // Redirect to admin page
        exit();
    } else if ($username === 'user' && $inputPassword === 'password') {
        $_SESSION['username'] = $username;
        header('Location: index.php'); // Redirect to index page
        exit();
    } else {
        $error_message = 'Invalid username or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-body">
                        <h2 class="card-title text-center">Login</h2>
                        <?php if ($error_message): ?>
                            <div class="alert alert-danger"><?php echo $error_message; ?></div>
                        <?php endif; ?>
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
