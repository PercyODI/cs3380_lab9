<?php

ini_set('display_errors', 1);

session_start();

$_SESSION = array();

if(empty($_POST['username']) or empty($_POST['password']) or empty($_POST['confirmPassword'])) {
    $_SESSION['register']['username'] = $_POST['username'];
    $_SESSION['register']['status'] = 'error';
    $_SESSION['register']['error']['message'] = 'Missing values. Please try again.';
    header("Location: register.php");
    exit();
}

if($_POST['password'] != $_POST['confirmPassword']) {
    $_SESSION['register']['status'] = 'error';
    $_SESSION['register']['error']['message'] = "Passwords don't match. Please try again.";
    header("Location: register.php");
    exit();
}

try {
    include_once("database_access.php");
    
    $stmt = $mylink->prepare("INSERT INTO user (username, salt, hashed_password) VALUES (:username, :salt, :hashedPassword)");
    
    $salt = mt_rand();
    $insertSuccess = $stmt->execute(
        array(
            "username" => $_POST['username'], 
            "salt" => $salt,
            "hashedPassword" => password_hash($salt . $_POST['password'], PASSWORD_BCRYPT)
        )
    );
    
    if($insertSuccess == true) {
        $_SESSION['register']['status'] = 'success';
        $_SESSION['register']['message'] = "Registration Successful. Please Log In!";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['register']['status'] = 'error';
        
        // Check if username is already taken
        $stmt = $mylink->prepare("SELECT username FROM user WHERE username = :username");
        $stmt->execute(array("username" => $_POST['username']));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($result) > 0) {
            $_SESSION['register']['error']['message'] = "Username already taken. Please try a different username.";
        } else {
            $_SESSION['register']['error']['message'] = "Registration failed. Try again.";
        }
        
        header("Location: register.php");
        exit();
    }
// } catch(PDOException $e) {
} catch(Exception $e) {
    $_SESSION['register']['status'] = 'error';
    $_SESSION['register']['error']['message'] = "Could not contact database.";
}

?>