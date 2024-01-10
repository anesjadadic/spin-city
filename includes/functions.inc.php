<?php

function emptyInput($username, $password) 
{
    $result;
    if (empty($username) || empty($password)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidCharacters($name) 
{
    $result;
    if (!preg_match("/^[a-zA-Z0-9\s\-']+$/", $name)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function customerUsernameExists($conn, $username) 
{
    $sql = "SELECT * FROM Customer WHERE cUsername = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../customerSignUp.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function employeeUsernameExists($conn, $username) 
{
    $sql = "SELECT * FROM Employee WHERE eUsername = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../employeeLogin.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        return false;
    }

    mysqli_stmt_close($stmt);
}

function checkPasswordMatch($password, $confirmPassword) 
{
    $result;
    if ($password != $confirmPassword) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function createUser($conn, $username, $password) 
{
    $sql = "INSERT INTO Customer (cUsername, cPassword) VALUES (?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../customerSignUp.php?error=stmtfailed");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ss", $username, $hashedPassword);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../customerSignUp.php?error=none");
    exit();
}

function notNumeric($num) 
{
    $result;
    if (!is_numeric($num)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function getGenre() {
    global $conn;
    $data =[];
    $query = "SELECT distinct rGenre FROM ".recordTable;
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $data = $result->fetch_all(MYSQLI_ASSOC);
    }
    return $data;
}