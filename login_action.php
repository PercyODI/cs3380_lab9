<?php

ini_set('display_errors', 1);

try {
    include_once("database_access.php");
    // $_SESSION = array();

    $stmt = $mylink->prepare("SELECT * FROM user WHERE username = :username");
    $stmt->execute(array("username" => $_POST['username']));
    
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if(count($data) == 1 and password_verify($data[0]['salt'] . $_POST['password'], $data[0]['hashed_password'])) {
        $_SESSION['loggedin'] = 'true';
        $_SESSION['username'] = $data[0]['username'];
        $_SESSION['role'] = $data[0]['role'];
        header("Location: hello.php");
        exit();
    } else {
        $_SESSION['loggedin'] = 'false';
        $_SESSION['login_status'] = "failed";
        $_SESSION['username_try'] = $_POST['username'];
        header("Location: index.php");
        exit();
    }
// } catch(PDOException $e) {
} catch(Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}

?>