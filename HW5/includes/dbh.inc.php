<?php
$servername = '138.68.9.254';
$dBUsername = 'engrdudes';
$dBPassword = 'CMPE172project!';
$dBName = 'project174';

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: " .mysqli_connect_error());
}