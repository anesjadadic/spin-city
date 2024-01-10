<?php
if (isset($_POST["submit"])) 
{
    $username = $_POST["username"];
    $password = $_POST["password"]; 

    require_once 'connect.inc.php';
    require_once 'functions.inc.php';

    if (emptyInput($username, $password) !== false) 
    {
        header("location: ../employeeLogin.php?error=emptyinput");
        exit();
    }

    $usernameExists = employeeUsernameExists($conn, $username);
    if ($usernameExists === false) 
    {
        header("location: ../employeeLogin.php?error=usernamenotfound");
        exit();
    }

    $passwordHashed = $usernameExists["ePassword"];
    $checkPassword = password_verify($password, $passwordHashed);

    if ($checkPassword === false) 
    {
        header("location: ../employeeLogin.php?error=wrongpassword");
        exit();
    }
    
    else if ($checkPassword === true) 
    {
        session_start();
        $_SESSION["username"] = $usernameExists["eUsername"];
        $_SESSION["role"] = $usernameExists["eRole"];
        header("location: ../".$url);
        exit();
    }
}
else 
{
    header("location: ../employeeLogin.php");
    exit();
}