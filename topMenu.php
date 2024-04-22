<?php 
   if (!isset($_SESSION) || session_id() == "" || session_status() === PHP_SESSION_NONE) {
    session_start();
}?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>

<body>
    <div class="top-menu bg-primary py-4 ">
        <div class="menubar d-flex justify-content-center gap-5 ">

            <?php 
            if (isset($_SESSION['name'])) { ?>
            <span class="">Welcome, <?= $_SESSION['name'] ?> </span>
            <a href='logout.php'>Logout</a>
            <?php } 
            else { ?>
            <a href='index.php'>Home</a>
            <a href='register.php'>Register</a>
            <a href='login.php'>Login</a>
            <?php } ?>
        </div>
        }
    </div>