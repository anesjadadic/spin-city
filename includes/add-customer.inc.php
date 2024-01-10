<?php
// Checks if the user accessed this page by submitting info and not some other way
if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];
    require_once 'connect.inc.php';
    require_once 'functions.inc.php';

    // Checks if there are no empty inputs
    if (emptyInput($username, $password) !== false) {
        header("location: ../customerSignUp.php?error=emptyinput");
        exit();
    }
    // Checks if the username has invalid characters
    if (invalidCharacters($username) !== false) {
        header("location: ../customerSignUp.php?error=invalidusername");
        exit();
    }
    // Checks if the entered username is a duplicate
    if (customerUsernameExists($conn, $username) !== false) {
        header("location: ../customerSignUp.php?error=usernametaken");
        exit();
    }
    // Checks if password confirmation matches
    if (checkPasswordMatch($password, $confirmPassword) !== false) {
        header("location: ../customerSignUp.php?error=passwordsdontmatch");
        exit();
    }
    createUser($conn, $username, $password);
}
else {
    header("location: ../customerSignUp.php");
}