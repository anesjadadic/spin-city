<?php
require_once 'connect.inc.php';

$id = $_GET['id'];
$sql = "DELETE FROM Employee WHERE eID = $id"; 

if (mysqli_query($conn, $sql)) {
    header("location: ../employeePage.php?error=deletion-success");
    mysqli_close($conn);
    exit;
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}