<?php
if (isset($_POST['signup-submit'])) { # To make sure user can't get to this page by entering url.
    require_once 'database_inc.php';

    // Fetching fields from signup
    $username = $_POST['uid'];
    $email = $_POST['mail'];
    $password = $_POST['pwd'];
    $passwordRepeat = $_POST['pwd-repeat'];


    // Error Checking

    // Empty Fields
    if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat)) {
        header("Location: ./signup.php?error=emptyfields&uid=".$username."&mail=".$email);
        exit();
    }
    // Invalid Email & Username
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ./signup.php?error=invalidmailuid=");
        exit();
    }
    // Invalid Email
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ./signup.php?error=invalidmail&uid=".$username);
        exit();
    }
    // Invalid Username
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {     # I Love REGEX!
        header("Location: ./signup.php?error=invaliduid&mail=".email);
        exit();
    }
    // Passwords don't match!
    else if ($password !== $passwordRepeat) {
        header("Location: ./signup.php?error=passwordcheck&uid=".$username."&mail=".$email);
        exit();
    }

    // SQL Statement
    else {
        $sql = "SELECT uidUsers FROM users WHERE uidUsers=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ./signup.php?error=sqlerror");
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            if ($resultCheck > 0) {
                header("Location: ./signup.php?error=usertaken&mail=".$email);
                exit();
            }
            else {
                $sql = "INSERT INTO users (uidUsers, emailUsers, pwdUsers) VALUES (?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ./signup.php?error=sqlerror");
                    exit();
                }
                else {
                    //hashing password
                    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
                    mysqli_stmt_execute($stmt);
                    header("Location: ./signup.php?signup=success");
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

else {
    header("Location: ./signup.php");
    exit();
}