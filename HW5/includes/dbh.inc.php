<?php
$servername = 'localhost';
$dBUsername = 'root';
$dBPassword = 'hw4password!';
$dBName = 'project';

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: " .mysqli_connect_error());
}