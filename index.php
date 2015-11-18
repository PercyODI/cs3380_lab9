<?php

if($_SERVER['HTTPS'] != 'on') {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit();
}

session_start();

if($_SESSION['loggedin'] == 'true') {
    header("Location: hello.php");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Lab 9 Login - NOW WITH ADMINS!</title>
    <!--CSS Code-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <style>
        body {
            background-image: url("wood_bkgd.png");
            height: 0;
        }
        
        .login-input {
            width: 100%;
        }
        
        #login-card {
            background-color: white;
            /*height: 260px;*/
            width: 300px;
            text-align: center;
            margin: 75px auto;
            padding: 8px;
            position: relative;
            z-index: 2;
        }
        
        #login-card {
            font-size: 2em;
            border: 1px solid #808080;
            -webkit-box-shadow: 2px 2px 5px 0px rgba(50, 50, 50, 0.75);
            -moz-box-shadow:    2px 2px 5px 0px rgba(50, 50, 50, 0.75);
            box-shadow:         2px 2px 5px 0px rgba(50, 50, 50, 0.75);
        }
        
        #login-card > i {
            color: #b1b2ba
        }
        
        #login-form {
            width: 270px;
            margin: auto;
            padding: 8px;
        }
        
        #login-form > a {
            display: block;
            font-size: 0.65em;
            padding: 8px 0 0 0;
        }
        
        .bkgd-card {
            background-color: white;
            border: 1px solid #808080;
            -webkit-box-shadow: 2px 2px 5px 0px rgba(50, 50, 50, 0.75);
            -moz-box-shadow:    2px 2px 5px 0px rgba(50, 50, 50, 0.75);
            box-shadow:         2px 2px 5px 0px rgba(50, 50, 50, 0.75);
            z-index: 1;
            -webkit-backface-visibility: hidden;
        }
        
        #bkgd-card-1 {
            transform-origin: 22% 69%;
            -ms-transform: rotate(-9deg);
            -webkit-transform: rotate(-9deg);
            transform: rotate(-9deg);
        }
        
        #bkgd-card-2 {
            transform-origin: -9% 136%;
            -ms-transform: rotate(5deg);
            -webkit-transform: rotate(5deg);
            transform: rotate(5deg);
        }
        
        .modalMessage {
    		width: 600px;
    		padding: 2em;
    		box-shadow: 1px 1px 3px rgba(0,0,0,0.35);
    		background-color: white;
    		text-align: center;
    	}
    	
    	/*.modalMessage > h1 {*/
    	/*    text-align: center;*/
    	/*    background-color: rgba(0, 0, 0, 0.9);*/
    	/*    color: white;*/
    	/*}*/
    </style>
    
    <!--Javascript Code-->
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="scripts/easyModal.js-master/jquery.easyModal.js"></script>
    <script>
        var loggedIn = '<?= $_SESSION['loggedin'] ?>';
        var loginStatus = '<?= $_SESSION['login_status'] ?>';
        var usernameTry = '<?= $_SESSION['username_try'] ?>';
        var registerStatus = <?php echo isset($_SESSION['register']) ? json_encode($_SESSION['register']) : "{'status': 'none'}" ?>;
        
        function positionBkgdCards() {
            $(".bkgd-card").each(function() {
                var loginCard = $("#login-card");
                $(this).width(loginCard.width());
                $(this).height(loginCard.height());
                $(this).offset({
                    top: loginCard.offset().top,
                    left: loginCard.offset().left
                });
            });
        }
    
        $(document).ready(function() {
            $("body").append("<div id='bkgd-card-1' class='bkgd-card'></div>");
            $("body").append("<div id='bkgd-card-2' class='bkgd-card'></div>");
            
            $(".modalMessage").easyModal();
            
            positionBkgdCards();
            
            if(loginStatus == 'failed') {
                
                $(".modalMessage").trigger('openModal');
                // var i = 0;
                // setInterval(function() {
                //     $(".modalMessage").css("background-position", i + "% 0%");
                //     i--;
                // }, 75)
            }
            
            if(registerStatus.status == "success") {
                $(".modalMessage").empty().html("<h1>" + registerStatus.message + "</h1>");
            
                $(".modalMessage").trigger('openModal');
            }
            
            
            
        });
        
        $(window).resize(function() {
            positionBkgdCards();
        });
    </script>
</head>
<body>
    <div class="container">
        <div id="login-card">
            <i class="fa fa-sign-in fa-5x"></i>
            <form action="login_action.php" method="POST" id="login-form">
                <div class="form-group">
                    <input name="username" class="input-lg login-input" id="username-input" type="text" required placeholder="Username" <?php echo isset($_SESSION['username_try']) ? "value='".$_SESSION['username_try']."'" : "autofocus" ?> >
                </div>
                <div class="form-group">
                    <input name="password" class="input-lg login-input" id="password-input" type="password" required placeholder="Password" <?php echo isset($_SESSION['username_try']) ? "autofocus" : "" ?> >
                </div>
                <button class="btn btn-primary btn-block btn-lg" type="submit">Login</button>
                <a href="register.php" class="text-right">Register</a>
            </form>
        </div>
    </div>
    <div class="modalMessage"><h1>Login Error. Please Try Again.</h1></div>
</body>
</html>

<?php

unset($_SESSION['register']);
unset($_SESSION['login_status']);
unset($_SESSION['username_try']);

?>
