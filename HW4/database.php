<?php
require_once 'login.php';
session_start();

$usernameEntry = "";
$emailEntry    = "";
$errors = array();

$_SESSION['success'] = ""; # Empty session...

// MySQL DB Connection...
$mysqlDB = new mysqli($servername, $username, $password, $database);
if ($mysqlDB->connect_error) {
    die('There is a Connection Error: ' . $mysqlDB->connect_error);
}


// REGISTER USER
if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $usernameEntry = mysqli_real_escape_string($mysqlDB, $_POST['username']);
    $emailEntry = mysqli_real_escape_string($mysqlDB, $_POST['email']);
    $password_1 = $_POST['password_1'];
    $password_2 = $_POST['password_2'];

    // form validation: ensure that the form is correctly filled
    if (empty($usernameEntry)) { array_push($errors, "Username is required"); }
    if (empty($emailEntry)) { array_push($errors, "Email is required"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }

    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    // register user if there are no errors in the form
    if (count($errors) == 0) {

        $user_salt = generateSalt(); // Generates a salt from the function above
        $combo = $user_salt . $password_1; // Appending user password to the salt
        $password = hash('sha512',$combo); // Using SHA512 to hash the salt+password combo string
        $query = "INSERT INTO users VALUES(NULL,'$usernameEntry', '$emailEntry', '$password','$user_salt')";
        mysqli_query($mysqlDB, $query);

        $_SESSION['username'] = $usernameEntry;
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php');
    }

}

// ...

// LOGIN USER
if (isset($_POST['login_user'])) {
    $usernameEntry = mysqli_real_escape_string($mysqlDB, $_POST['username']);
    $password = mysqli_real_escape_string($mysqlDB, $_POST['password']);

    if (empty($usernameEntry)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        $query = "SELECT password, salt FROM users WHERE username='$usernameEntry'";
        $result = mysqli_query($mysqlDB, $query);
        $row = mysqli_fetch_assoc($result);

        $stored_hash = $row['password'];
        $stored_salt = $row['salt'];

        $check_pass = $stored_salt . $password;
        $check_hash = hash('sha512',$check_pass);

        if ($check_hash == $stored_hash) {
            $_SESSION['username'] = $usernameEntry;
            $_SESSION['success'] = "You are now logged in";
            $query = "CREATE TABLE IF NOT EXISTS fileupload (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,userName VARCHAR(100) NOT NULL, Name VARCHAR(100) NOT NULL,Content LONGTEXT)";
            $result = $mysqlDB->query($query);
            if (!$result) die ("Database access failed: " . $mysqlDB->error);
            header('location: index.php');
        }else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}


//UPLOAD FILE
if(isset($_POST["submit"])) {

    $userString = $_POST['fileName'];
    $name = mysql_entities_fix_string($mysqlDB,$userString);
    $usernameEntry = $_SESSION["username"];

    if ($_FILES['fileSelected']['type'] == 'text/plain'){

        $theFile = file_get_contents($_FILES['fileSelected']['tmp_name']);
        $content = mysql_entities_fix_string($mysqlDB,$theFile);
        $query = "INSERT INTO fileupload VALUES(NULL,'$usernameEntry','$name','$content')";
        $result = $mysqlDB->query($query);
    }
    else {
        echo "This file is not a txt file. Please try uploading again...";
    }
}

function generateSalt($max = 64) {
    $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*?";
    $i = 0;
    $salt = "";
    while ($i < $max) {
        $salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
        $i++;
    }
    return $salt;
}

function mysql_entities_fix_string($conn, $string){
    return htmlentities(mysql_fix_string($conn, $string));
}

function mysql_fix_string($conn, $string){
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $conn->real_escape_string($string);
}
