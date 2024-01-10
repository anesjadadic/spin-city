<?php
// Check if the user accessed this page by submitting info and not some other way
if (isset($_POST["submitEmployeeAddition"])) 
{
    $firstName = $_POST["first-name"];
    $lastName = $_POST["last-name"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm-password"];

    require_once 'connect.inc.php';
    require_once 'functions.inc.php';

    // Check for invalid characters (anything that isn't a letter, number, or whitespace)
    if (invalidCharacters($username) !== false || invalidCharacters($firstName) !== false
        || invalidCharacters($lastName) !== false)
    {
        header("location: ../employeePage.php?error=invalidentry");
        exit();
    }

    // Checks if the entered username is a duplicate
    if (employeeUsernameExists($conn, $username) !== false) 
    {
        header("location: ../employeePage.php?error=usernametaken");
        exit();
    }

    // Checks if password confirmation matches
    if (checkPasswordMatch($password, $confirmPassword) !== false) 
    {
        header("location: ../employeePage.php?error=passwordsdontmatch");
        exit();
    }

    $sql = "INSERT INTO Employee (eFirstName, eLastName, eUsername, ePassword) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../employeePage.php?error=stmtfailed");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $firstName, $lastName, $username, $hashedPassword);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../employeePage.php?error=no-employee-error");
    exit();
}
else {
    // The user does not have correct access, send them back to the login page
    header("location: ../employeeLogin.php");
}
?>
