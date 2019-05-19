<?php
$servername = 'localhost';
$dBUsername = 'cs174';
$dBPassword = 'CS174project!';
$dBName = '174project';

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: " .mysqli_connect_error());
}
else {
    // sql to create table
    $sql = "CREATE TABLE IF NOT EXISTS users (
    idUsers int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    uidUsers TINYTEXT NOT NULL,
    emailUsers TINYTEXT NOT NULL,
    pwdUsers TINYTEXT NOT NULL
);";

    if (mysqli_query($conn, $sql)) {
        echo "Table users created successfully";
    } else {
        echo "Error creating table: " . mysqli_error($conn);
    }

    $sql2 = "CREATE TABLE IF NOT EXISTS userContent (
uploadNum int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
idUsers int(11) NOT NULL,
stringContent TINYTEXT NOT NULL,
textFile TEXT
);";
}