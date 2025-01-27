<?php
$configfile = 'config.php';
if (!file_exists($configfile)) {
    echo '<meta http-equiv="refresh" content="0; url=install" />';
    exit();
}

include "config.php";

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['sec-username'])) {
    echo '<meta http-equiv="refresh" content="0; url=dashboard.php" />';
    exit;
}

$_GET  = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

$error = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="hackerhub8">
    <meta name="generator" content="Qurik" />
    <meta name="robots" content="noindex, nofollow">
    <title>Qurik &rsaquo; Admin Panel</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.7.1/css/all.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/img/favicon.png">
    <style>
        #backgroundVideo {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -1;
            transform: translate(-50%, -50%);
        }
    </style>
</head>

<body class="login-page" style="background-color:rgb(0, 0, 0);">
<video autoplay muted loop id="backgroundVideo">
    <source src="assets/img/bg.mp4" type="video/mp4">
</video>

<div class="login-box">
    <form action="" method="post">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h1 style="color:rgb(0, 0, 0);">Qurik</h1>
            </div>
            <div class="card">
                <div class="card-body text-white card-primary card-outline">
                    <?php
                    if (isset($_POST['signin'])) {
                        $ip = htmlentities($_SERVER['REMOTE_ADDR']);
                        if ($ip == "::1") {
                            $ip = "127.0.0.1";
                        }
                        $date = date("d F Y");
                        $time = date("H:i");

                        // Fetch user input
                        $username = mysqli_real_escape_string($mysqli, $_POST['username']);
                        $password = hash('sha256', $_POST['password']); // SHA-256 hashing

                        // Check credentials against the database
                        $stmt = $mysqli->prepare("SELECT id FROM qurik_admin WHERE username = ? AND password = ?");
                        $stmt->bind_param("ss", $username, $password);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows === 1) {
                            // Successful login
                            $stmt->close();

                            // Log successful login attempt
                            $log = $mysqli->prepare("INSERT INTO qurik_logins (username, ip, date, time, successful) VALUES (?, ?, ?, ?, '1')");
                            $log->bind_param("ssss", $username, $ip, $date, $time);
                            $log->execute();
                            $log->close();

                            $_SESSION['sec-username'] = $username;
                            echo '<meta http-equiv="refresh" content="0; url=dashboard.php">';
                        } else {
                            // Failed login
                            $stmt->close();

                            // Log failed login attempt
                            $log = $mysqli->prepare("INSERT INTO qurik_logins (username, ip, date, time, successful) VALUES (?, ?, ?, ?, '0')");
                            $log->bind_param("ssss", $username, $ip, $date, $time);
                            $log->execute();
                            $log->close();

                            echo '
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle"></i> The entered <strong>Username</strong> or <strong>Password</strong> is incorrect.
                            </div>';
                            $error = 1;
                        }
                    }
                    ?>
                    <div class="form-group has-feedback <?php if ($error == 1) echo 'has-danger'; ?>">
                        <div class="input-group mb-3">
                            <input type="text" name="username" class="form-control <?php if ($error == 1) echo 'is-invalid'; ?>" placeholder="Username" <?php if ($error == 1) echo 'autofocus'; ?> required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" name="signin" class="btn btn-md btn-success btn-block btn-flat"><i class="fas fa-sign-in-alt"></i>&nbsp;Sign In</button>
                        </div>
                    </div>
                </div>
            </div>
    </form>
</div>
</body>
</html>
