<?php

$host = "127.0.0.1";
$username = "root";
$password = "";
$database = "moviebookingsystem";
$port = 3307;

$conn = mysqli_connect(
    $host,
    $username,
    $password,
    $database,
    $port
);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

echo "Database Connected Successfully";

?>