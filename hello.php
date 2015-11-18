<?php
if($_SERVER['HTTPS'] != 'on') {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit();
}

ini_set('display_errors', 1);

session_start();

if(!isset($_SESSION['loggedin']) or $_SESSION['loggedin'] == 'false') {
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Lab 9 Login - Hello!</title>
    <!--CSS Code-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <style>
        body {
            background-image: url("wood_bkgd.png");
            padding-top: 20px;
        }
        
        p {
            font-size: 2em;
        }
        
        hr {
            border: 0;
            height: 1px;
            background-image: linear-gradient(to right, rgba(177, 178, 186, 0), rgba(177, 178, 186, 0.75), rgba(177, 178, 186, 0));
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="well well-lg">
                <?php
                    if($_SESSION['role'] == 'admin') {
                ?>
                <h1 class="text-center">Welcome Admin!</h1>
                <h3 class="text-center">You have super privileges.</h3>
                <?php
                    } else {
                ?>
                <h1 class="text-center">Welcome <?= $_SESSION['username'] ?>!</h1>
                <?php
                    }
                ?>
                <hr>
                <p class="text-center"><a href="logout_action.php">Logout</a></p>
            </div>
        </div>
    </div>
    
    <br>
    
</body>
</html>