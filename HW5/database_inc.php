<?php
$servername = 'localhost';
$dBUsername = 'cs174';
$dBPassword = 'CS174project!';
$dBName = '174project';

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: " .mysqli_connect_error());
}