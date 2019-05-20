<?php
require_once "database_inc.php";

session_start();
session_unset();
session_destroy();
$conn -> close();

header("Location: ./index.php");