<?php
define('recordTable', 'Record');

$dbHost = "localhost";
$dbUser = "root";
$dbPass = "root";
$dbName = "MusicSite";
$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

$url = "index.php?genre%5B%5D=Rap&genre%5B%5D=Rock&genre%5B%5D=Pop&genre%5B%5D=Jazz&genre%5B%5D=Electronic&genre%5B%5D=Metal&filter=Submit";

if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}