<?php
if (isset($_POST["submit"])) 
{
    $username = $_POST["username"];
    $password = $_POST["password"]; 

    require_once 'connect.inc.php';
    require_once 'functions.inc.php';

    if (emptyInput($username, $password) !== false) 
    {
        header("location: ../customerLogin.php?error=emptyinput");
        exit();
    }

    $usernameExists = customerUsernameExists($conn, $username);
    if ($usernameExists === false) 
    {
        header("location: ../customerLogin.php?error=usernamenotfound");
        exit();
    }

    $passwordHashed = $usernameExists["cPassword"];
    $checkPassword = password_verify($password, $passwordHashed);

    if ($checkPassword === false) 
    {
        header("location: ../customerLogin.php?error=wrongpassword");
        exit();
    }
    
    else if ($checkPassword === true) 
    {
        session_start();
        $_SESSION["username"] = $usernameExists["cUsername"];
        header("location: ../".$url);
        exit();
    }
}
else 
{
    header("location: ../customerLogin.php");
    exit();
}